<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("db.php");
include("navbar.php");

// Unset search criteria session variables when leaving the page
if (!isset($_POST['submit']) && !isset($_GET['sort'])) {
    unset($_SESSION['userplaced']);
    unset($_SESSION['usercheckin']);
    unset($_SESSION['usercheckout']);
    unset($_SESSION['userguest']);
    unset($_SESSION['userroom']);
}

// Check if the form is submitted
if(isset($_POST['submit'])){
    $place = $_POST['place'];
    $checkInAD = $_POST['checkInAD'];
    $checkOutAD = $_POST['checkOutAD'];
    $guests = (int)$_POST['guests'];
    $room_no =(int) $_POST['hotel_room'];
    $checkInTimestamp = strtotime($checkInAD);
    $checkOutTimestamp = strtotime($checkOutAD);
    // Calculate the difference in seconds between the two timestamps
    $timeDifference = $checkOutTimestamp - $checkInTimestamp;
    
    // Convert the difference to days
    $numOfDays = ceil($timeDifference / (60 * 60 * 24));

    $_SESSION['userplaced'] = $place;
    $_SESSION['usercheckin'] = $checkInAD;
    $_SESSION['usercheckout'] = $checkOutAD;
    $_SESSION['userguest'] = $guests;
    $_SESSION['userroom'] = $room_no;
    $_SESSION['days'] = $numOfDays;
}

// Handle sorting
$sort_order = isset($_GET['sort']) ? $_GET['sort'] : ''; // Get sorting order from URL parameter

// Store sorting order in session variable
if($sort_order === 'asc' || $sort_order === 'desc') {
    $_SESSION['sort_order'] = $sort_order;
}

// Fetch hotels based on the selected criteria
if(isset($_SESSION['userplaced'])) {
    $place = $_SESSION['userplaced'];
    $rooms = $_SESSION['userroom'];
    $query = "SELECT * FROM hotels WHERE location='$place' AND status='on' AND room >='$rooms'";
    if(isset($_SESSION['sort_order'])) {
        $sort_order = $_SESSION['sort_order'];
        $query .= " ORDER BY price $sort_order";
    }
} else {
    // Fetch all hotels
    $query = "SELECT * FROM hotels WHERE status='on'";
    if(isset($_SESSION['sort_order'])) {
        $sort_order = $_SESSION['sort_order'];
        $query .= " ORDER BY price $sort_order";
    }
}

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$itemsPerPage = 6;
$offset = ($page - 1) * $itemsPerPage;
$query .=" LIMIT $itemsPerPage OFFSET $offset";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking</title>
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- External CSS -->
    <link rel="stylesheet" href="booking.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- External JS -->
    <script src="https://unpkg.com/scrollreveal"></script>
    <!-- Bootstrap JS Bundle (Popper included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        
div.hotelbook_container{
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: row;
    background-color: rgb(0, 0,0,0.2);
    z-index: 1500;
    display: none;
}
div.hotelbook_container div.hotelbook{
    background-color:white;
    width: 300px;
    border-radius: 5px;
    padding: 20px 25px 30px 25px;
    z-index: 1600;
}

div.hotelbook_container div.hotelbook h2 {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 30px;
    color: #30475e;
}
div.hotelbook_container div.hotelbook h2 span{
    font-size: 18px;
    font-weight: 550;
}

div.hotelbook_container div.hotelbook h2 button {
    border: none;
    background-color: transparent;
    outline: none;
    font-size: 18px;
    font-weight: 550;
    color:black;
}

div.hotelbook_container div.hotelbook input,
div.hotelbook_container div.hotelbook select{
    width: 100%;
    margin-bottom: 20px;
    background-color: transparent;
    border: none;
    color:black;
    border-bottom: 2px solid black;
    border-radius: 0;
    padding: 5px 0;
    font-weight: 550;
    font-size: 14px;
    outline: none;
}

div.hotelbook_container div.hotelbook button.booked_btn {
    font-weight: 550;
    padding: 4px 10px;
    font-size: 15px;
    background-color: #30475e;
    border-radius:5px;
    color: white;
    border: none;
    outline: none;
    margin-top: 5px;
}
div.hotelbook_container div.hotelbook button.booked_btn:hover{
    background-color:#198754;
    color:white;
}
#prevNext {
    margin-top: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}
#prevNext button {
    margin: 10px;
    outline:none;
    height:40px;
    width:60px;
    border: 1px solid green;
    padding: 5px;
    border-radius:5px;
    cursor: pointer;
}
#prevNext button:hover{
    background-color:black;
    border:none;
    color:white;
}  </style>
</head>

<body>

    <header class='header'>
        <div class="section__container header__container" id="home">
            <h1>Explore the beauty of nature. Discover the new you.</h1>
            <div class="header__form">
                <form action="" method="post" id="bookingForm" onsubmit="return validateForm()">
                    <div class="input__group">
                        <label for="destination">Where do you want to go?</label>
                        <select name="place" id="place" required>
                            <option value="">Select place</option>
                            <option value="sauraha">Sauraha</option>
                            <option value="cg">CG Temple</option>
                            <option value="golaghat">Golaghat</option>
                            <option value="chitwan">chitwan</option>
                            <option value="narayangarh">Narayangarh</option>
                            <option value="patihani">Patihani BHR-22</option>
                        </select>
                    </div>
                    <div class="input__group">
                        <label for="checkIn">Check In</label>
                        <input type="date" name="checkInAD" id="checkInAD" placeholder="Choose a date" required />
                    </div>
                    <div class="input__group">
                        <label for="checkOut">Check Out</label>
                        <input type="date" name="checkOutAD" id="checkOutAD" placeholder="Choose a date" required />
                    </div>
                    <div class="input__group">
                        <label for="guests">Guests</label>
                        <input type="number" name="guests" id="guests" placeholder="Number of guests" required />
                    </div>
                    <div class="input__group">
                        <label for="hotel_room">Room</label>
                        <input type="number" name="hotel_room" id="hotel_room" placeholder="Number of room" required />
                    </div>
                    <div class="input__group">
                        <button type="submit" name="submit" class="checkbtn">SEARCH</button>
                    </div>
                </form>
            </div>
        </div>
    </header>


    <section class='hotellist' id="hotellist">
        <div class="sort">
            <a href="booking.php?sort=desc#hotellist">High price <i class="fas fa-arrow-up"></i></a>
            <a href="booking.php?sort=asc#hotellist">Low price <i class="fas fa-arrow-down"></i></a>
        </div>
        <!-- Display hotels -->

        <main>
        <?php
        
        if(mysqli_num_rows($result) < 1) {
          echo '<div style="width:100%;font-size: 3rem; font-weight: bold; height:50vh; text-align:center;">Hotel not found</div>';
      } else {
          while ($row = mysqli_fetch_array($result)) {
        ?>
                <div class="hotel-list">
                    <div class="hotel-img">
                        <img src="hotelowner/<?php echo $row['image']; ?>" alt="">
                    </div>
                    <div class="rate">
                        <?php
                        $rate = $row['rating'];
                        for($i = 1; $i <= $rate; $i++) {
                            echo "<i>★</i>";
                        }
                        ?>
                        <strong>RS<?php echo $row['price'] ?> per night</strong>
                    </div>
                    <div class="hotel-detail">
                        <h5><?php echo $row['name'] ?></h5>
                        <h6>Location: <?php echo $row['location'] ?>, NEPAL</h6>
                        <h6>Facilities</h6>
                        <p><?php echo $row['description'] ?></p>
                    </div>
                    <form>
                        <button type="button" name="booking" class="book_hotel"onclick="hotelbook('bookhotel<?php echo $row['hotel_id']; ?>')">Book</button>
                    </form>
                </div>
        <div class="hotelbook_container" id="bookhotel<?php echo $row['hotel_id']; ?>">
            <div class="hotelbook">
                <form action="booked.php" method="post" onsubmit="return bookvalidate(<?php echo $row['hotel_id']; ?>)">
                    <h2>
                        <span><?php echo $row['name'];?></span>
                        <button type="reset" onclick="hotelbook('bookhotel<?php echo $row['hotel_id']; ?>')">X</button>                   
                    </h2>
                    <?php if (!isset($_SESSION['userplaced'])) {?>
                <!-- Display input fields for search information -->
                    <input type="hidden" name="hotellocation" value="<?php echo $row['location']; ?>"> 
                <label for="checkin">Checkin Date</label>
                <input type="date" name="checkin" id="checkin_<?php echo $row['hotel_id']; ?>" required onchange="updateFilled(<?php echo $row['price']; ?>, <?php echo $row['hotel_id']; ?>)">
                <label for="checkin">Checkout Date</label>
                <input type="date" name="checkout" id="checkout_<?php echo $row['hotel_id']; ?>" required onchange="updateFilled(<?php echo $row['price']; ?>, <?php echo $row['hotel_id']; ?>)">
                <input type="number" name="noguest" id="noguest_<?php echo $row['hotel_id']; ?>" placeholder="Number of guest" required onchange="updateFilled(<?php echo $row['price']; ?>, <?php echo $row['hotel_id']; ?>)">
                <input type="number" name="room" id="room_<?php echo $row['hotel_id']; ?>" placeholder="Number of room" required onchange="updateFilled(<?php echo $row['price']; ?>, <?php echo $row['hotel_id']; ?>)">
                <input type="number" name="totalprice" id="totalprice_<?php echo $row['hotel_id']; ?>" placeholder="Total Price" readonly>
        
            <?php } else { ?>
                <!-- Display input fields for total price -->
                <input type="text" name="total_price" id="total_price" value="<?php echo $row['price'] * $_SESSION['userroom'] * $_SESSION['days']; ?>" readonly>
                <?php } ?>
                        <select name="payment" id="payment_<?php echo $row['hotel_id']; ?>" aria-placeholder="select payment" required>
                        <option value="">Select payment</option>
                        <option value="cash">cash</option>
                        <option value="esewa">esewa</option>
                        <option value="card">card</option>
                    </select> 
                    <input type="hidden" name="hotelname" value="<?php echo $row['hotel_id']; ?>">  
                    <button type="submit" name="booked" class="booked_btn">Confirm</button>
                   
                </form>
            </div>
        </div>
        <script>
            function updateFilled(price, hotelId) {
                var checkIn = document.getElementById('checkin_' + hotelId).value;
                var checkOut = document.getElementById('checkout_' + hotelId).value;
                var guests = document.getElementById('noguest_' + hotelId).value;
                var rooms = document.getElementById('room_' + hotelId).value;

                // Check if all input fields are filled
                if (checkIn && checkOut && guests && rooms) {
                    updateP(price, hotelId);
                }
            }
            function bookvalidate(hotelid) {
                var checkInAD = document.getElementById('checkin_'+ hotelid).value;
                var checkOutAD = document.getElementById('checkout_'+ hotelid).value;
                var guests = parseInt(document.getElementById('noguest_'+ hotelid).value);
                var rooms = parseInt(document.getElementById('room_'+ hotelid).value);
                var payment =document.getElementById('payment_'+ hotelid).value;
                var today = new Date();
                console.log('room:', rooms);
                console.log('guest:', guests);

                if (isNaN(guests) || isNaN(rooms) || guests <= 0 || rooms <= 0) {
                    alert("Please enter a valid number of guests and rooms.");
                    return false;
                } else if (rooms < guests / 2) {
                    alert('Each room can accommodate up to 2 guests.');
                    return false;
                } else if (new Date(checkInAD) < today) {
                    alert('Check-in date must be equal to or later than today.');
                    return false;
                } else if (new Date(checkOutAD) <= new Date(checkInAD)) {
                    alert('Checkout date must be after the check-in date.');
                    return false;
                }else if(payment == ""){
                    alert('Please select payment method.');  
                    return false;
                }
                return true; // Allow form submission
            }

        </script>
                <?php
            }
          }
        
        ?>
    </main>
    <div id="prevNext">
        <button id="prevBtn">Prev</button>
        <button id="nextBtn">Next</button>
    </div>
</section>
<script>
    
    function updateP(price, hotelId) {
        var guest = parseInt(document.getElementById('totalprice_' + hotelId).value);
        var room = parseInt(document.getElementById('room_' + hotelId).value);
        var checkIn = new Date(document.getElementById('checkin_' + hotelId).value);
        var checkOut = new Date(document.getElementById('checkout_' + hotelId).value);

        // Calculate the difference in milliseconds
        var timeDifference = checkOut.getTime() - checkIn.getTime();
        
        // Convert the difference to days
        var numOfDays = Math.ceil(timeDifference / (1000 * 60 * 60 * 24));

        console.log('room:', room);

        if (!isNaN(room) && room >= 0) {
            document.getElementById('totalprice_' + hotelId).value = room * price * numOfDays;
        } else if (room < guest / 2) {
            alert('Try again, each room can accommodate up to 2 guests');
            return false;
        } else {
            alert("Please enter a valid number of rooms.");
        }
    }

$(document).ready(function(){
            var page = <?php echo $page; ?>;
            
            var totalPages = <?php echo ceil(mysqli_num_rows(mysqli_query($con,"SELECT * FROM hotels ")) / $itemsPerPage); ?>;

            $('#prevBtn').on('click', function(){
                if (page > 1) {
                    window.location.href = '?page=' + (page - 1);
                }
            });

            $('#nextBtn').on('click', function(){
                if (page < totalPages) {
                    window.location.href = '?page=' + (page + 1);
                }
            });
         });   
    function hotelbook(hotelbook_name) {
        var get_hotelbook = document.getElementById(hotelbook_name);
        if (get_hotelbook.style.display === "flex") {
            get_hotelbook.style.display = "none";
        } else {
            get_hotelbook.style.display = "flex";
        }

    }
    function validateForm() {
        var place = document.getElementById('place').value;
        var checkInAD = document.getElementById('checkInAD').value;
        var checkOutAD = document.getElementById('checkOutAD').value;
        var guests = document.getElementById('guests').value;
        var hotel_room = document.getElementById('hotel_room').value;
        var today = new Date();
    
     if (isNaN(guests) || guests <= 0 || hotel_room <=0){
        alert("Please enter a valid number of guests and room.");
    }else if (hotel_room < guests /2 ) {
            alert('Try again 1 room  can have  2guest');
            return false;
        }else if (new Date(checkInAD) < today) {
            alert('Check-in date must be equal to or later than today.');
            return false;
        } else if (new Date(checkOutAD) <= new Date(checkInAD)) {
            alert('Checkout date must be after the check-in date.');
            return false;
        } else if (guests <= 0) {
            alert('Number of guests cannot be zero or less than zero.');
            return false;
        }

        return true; // Allow form submission
    }
</script>


<!-- Include JavaScript and footer content -->
<?php include("footer.php"); ?>
