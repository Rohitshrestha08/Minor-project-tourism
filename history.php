<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("db.php");
include("navbar.php");
$error="";
$msg="";
if(isset($_POST['cancelbooking'])){
    $bkid=$_POST['bkid'];
    $action='cancel';
    $stat=0;
    $updatebooking=mysqli_prepare($con,"UPDATE booking SET action=? ,stat=? WHERE booking_id=?");
    mysqli_stmt_bind_param($updatebooking,"sii",$action,$stat,$bkid);
    mysqli_stmt_execute($updatebooking);
    mysqli_stmt_close($updatebooking);
    if($updatebooking){
        $msg="Booking Id :BK-$bkid Has been cancelled..";
    }else{
        $error="Booking Id :BK-$bkid cannot be cancelled right now please try after few minutes..";
    }

}
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$itemsPerPage = 6;
$offset = ($page - 1) * $itemsPerPage;

$userid=$_SESSION['user_id'];
$query=mysqli_query($con,"SELECT hotels.name,hotels.location,booking.payment,
booking.booking_id,booking.packages_id,booking.hotel_id,booking.booking_date,booking.checkin_date,booking.checkout_date,
booking.total_guest,booking.totalprice,booking.room,booking.action FROM booking  JOIN 
users ON booking.user_id=users.id JOIN hotels ON booking.hotel_id=hotels.hotel_id WHERE booking.user_id=$userid ORDER BY booking.booking_id DESC  LIMIT $itemsPerPage OFFSET $offset");
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>History</title>
    <style>
        .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #dd3d36;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
        .succWrap{
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
        .history{
            width: 100%;
            display: flex;
            margin-top: 50px;
            margin-bottom: 50px;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .userhistory{
            width: 90%;
            height: 380px;
        }
        .historybooking{
            color: blue;
            font-weight: 400;
        }
        .history table{
            width: 100%;
        }
        .history table th{
            background-color: red;
            text-align: center;
            color: white;
            padding-left:5px;
            height: 50px;
        }
        .b{
            width: 7%;
        }
        .bphp{
            width: 9%;
        }
        .d{
            width: 8%;
        }
        .pri{
            width: 9%;
        }
        .rp{
            width: 5%;
        }
        .sa{
            width: 8%;
        }
        .history table tr td{
            text-align: center;
            margin-bottom: 3px;
            height: 45px;
        }
        .ac button{
            outline: none;
            text-decoration: none;
            border: none;
            padding-top: 3px;
            color: blue;
            font-weight: 400;
            font-size: larger;
            position: relative;
            background-color: transparent;
        }
        .ac button::after{
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            height: 3px;
            width: 0%;
            background-color: blue;
            transition: all ease 1s;
        }
        .ac button:hover::after{
            width: 95%;
        }
        .history table tr:nth-child(even){
            background-color: #e8f5fe;
        }
        #next {
            margin-top: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #next button {
            margin: 10px;
            outline:none;
            height:40px;
            width:60px;
            border: 1px solid green;
            padding: 5px;
            border-radius:5px;
            cursor: pointer;
        }
        #next button:hover{
            background-color:red;
            border:none;
            color:white;
        }
    </style>
</head>
<body>
    <section class="history">   
        <div class="userhistory">   <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
      
         <h3 class="historybooking">My Tour History</h3>
            <table>
                <tr>
                    <th class="b">Booking Id</th>
                    <th class="bphp">Place</th>
                    <th class="bphp">Hotel Name</th>
                    <th class="d">From</th>
                    <th class="d">TO</th>
                    <th class="pri">Price</th>
                    <th class="rp">Room</th>
                    <th class="rp">Person</th>
                    <th class="d">Booking Date</th>
                    <th class="rp">Payment</th>
                    <th class="sa">Status</th>
                    <th class="sa">Action</th>
                </tr>
                <?php
                while($fetch=mysqli_fetch_array($query)){
                ?>
                <tr>
                    <td>BK-<?php echo $fetch['booking_id'];?></td>
                    <td><?php echo $fetch['location'];?></td>
                    <td><?php echo $fetch['name'];?></td>
                    <td><?php echo $fetch['checkin_date'];?></td>
                    <td><?php echo $fetch['checkout_date'];?></td>
                    <td>Rs <?php echo (int)$fetch['totalprice'];?></td>
                    <td><?php echo $fetch['room'];?></td>
                    <td><?php echo $fetch['total_guest'];?></td>
                    <td><?php echo $fetch['booking_date'];?></td>
                    <td><?php echo $fetch['payment'];?></td>
                    <td><?php echo $fetch['action'];?></td>
                    <td class="ac">
                        <form action="" method="post">
                            <input type="hidden" name="bkid" value="<?php echo $fetch['booking_id'];?>">
                        <?php
                            date_default_timezone_set("Asia/Kathmandu");
                            $today = date("Y-m-d");
                            $now = strtotime($today);
                            $yesterday = $now + ( 24 * 60 * 60); 
                            $finalyesterday=date("Y-m-d",$yesterday);
                            $enter=$fetch['checkin_date'];
                            if($fetch['action']=='cancel'){
                                echo "Cancelled";
                            }else if($enter > $finalyesterday){
                                echo "<button type='submit' name='cancelbooking'>Cancel</button>";
                            }else{
                                echo "Confirmed";
                            }
                        ?>
                        </form>
                    </td>
                </tr>
                <?php
                }
                ?>
            </table>
        </div>
        <div id="next">
            <button id="prevBtn">Prev</button>
            <button id="nextBtn">Next</button>
        </div>
    </section>   
    <script>
        $(document).ready(function(){
            var page = <?php echo $page; ?>;
            var totalPages = <?php echo ceil(mysqli_num_rows(mysqli_query($con,"SELECT * FROM booking WHERE user_id='$userid'")) / $itemsPerPage); ?>;
            
        console.log("Total Pages:", totalPages);

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
    </script>
    <?php
    include("footer.php");
    ?> 
</body>
</html>