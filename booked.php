<?php
session_start();
include("db.php");

if(isset($_POST['booked'])) {
    if(isset($_SESSION['userplaced']))
    {
        $hotelid=$_POST['hotelname'];
        $checkInAD = $_SESSION['usercheckin'];
        $checkOutAD = $_SESSION['usercheckout'];
        $guests = $_SESSION['userguest'];
        $room_no = $_SESSION['userroom'];
        $pay = $_POST['payment'];
        $stat=0;
        if($pay=='cash'){
            $stat=1;
        }
        $totalprice = $_POST['total_price'];
        date_default_timezone_set("Asia/Kathmandu");
        $today = date("Y-m-d");
        $totalRoomsQuery = "SELECT * FROM hotels WHERE hotel_id='$hotelid'";
        $totalRoomsResult = mysqli_query($con, $totalRoomsQuery);
        if($totalRoomsResult) {
            $totalRoomsRow = mysqli_fetch_assoc($totalRoomsResult);
            $total_rooms = $totalRoomsRow['room'];
            $checkAvailabilityQuery = "SELECT SUM(room) AS total_rooms_booked FROM booking WHERE hotel_id='$hotelid'AND action='booked' AND ((checkin_date < '$checkOutAD' AND checkout_date > '$checkInAD') OR (checkin_date = '$checkInAD' AND checkout_date = '$checkOutAD'))";
            $availabilityResult = mysqli_query($con, $checkAvailabilityQuery);
            if($availabilityResult) {
                $row = mysqli_fetch_assoc($availabilityResult);
                $total_rooms_booked = $row['total_rooms_booked'];
                // echo "Total room  in hotel :$total_rooms <br>";
                // echo "Total room booked in hotel :$total_rooms_booked <br>";
                $available_rooms = $total_rooms - $total_rooms_booked;
                // echo "available room :$available_rooms";
                if($available_rooms >= $room_no) {
                    if(isset($_SESSION['user_id'])) {
                        $user_id = $_SESSION['user_id'];
                        $query = "INSERT INTO `booking`(`user_id`, `hotel_id`, `booking_date`, `checkin_date`, `checkout_date`, `total_guest`, `totalprice`, `payment`, `room`,`action`,`stat`)
                        VALUES ('$user_id','$hotelid','$today','$checkInAD','$checkOutAD','$guests','$totalprice','$pay','$room_no','booked','$stat')";
                        $result = mysqli_query($con, $query);
                        if($result) {
                            echo "<script>alert('Booked successfully..');</script>";
                            redirect('booking.php');
                            exit();
                        } else {
                            echo "<script>alert('Booked Failed try after few minutes.');</script>";
                            redirect('booking.php');
                            exit();
                        }
                    } else {
                        echo "<script>alert('Please Login First..');</script>";
                        redirect('booking.php');
                        exit();
                    }
                } else {
                    echo "<script>alert('No rooms available for the specified dates.Available rooms :$available_rooms');</script>";
                    redirect('booking.php');
                    exit();
                }
            } else {
                echo "<script>alert('Error checking room availability: " . mysqli_error($con) . "');</script>";
                redirect('booking.php');
                exit();
            }
        } else {
            echo "<script>alert('Error retrieving total rooms: " . mysqli_error($con) . "');</script>";
            redirect('booking.php');
            exit();
        }
    }
    else
    {
        $hotelid=$_POST['hotelname'];
        $checkInAD= $_POST['checkin'];
        $checkOutAD=$_POST['checkout'];
        $guests=$_POST['noguest'];
        $room_no=$_POST['room'];
        $pay=$_POST['payment'];
        $totalprice=$_POST['totalprice'];
        $stat=0;
        if($pay=='cash'){
            $stat=1;
        }
        date_default_timezone_set("Asia/Kathmandu");
        $today = date("Y-m-d");
        $totalRoomsQuery = "SELECT * FROM hotels WHERE hotel_id='$hotelid'";
        $totalRoomsResult = mysqli_query($con, $totalRoomsQuery);
        if($totalRoomsResult) {
            $totalRoomsRow = mysqli_fetch_assoc($totalRoomsResult);
            $total_rooms = $totalRoomsRow['room'];
            $checkAvailabilityQuery = "SELECT SUM(room) AS total_rooms_booked FROM booking WHERE hotel_id='$hotelid' AND action='booked' AND ((checkin_date < '$checkOutAD' AND checkout_date > '$checkInAD') OR (checkin_date = '$checkInAD' AND checkout_date = '$checkOutAD'))";
            $availabilityResult = mysqli_query($con, $checkAvailabilityQuery);
            if($availabilityResult) {
                $row = mysqli_fetch_assoc($availabilityResult);
                $total_rooms_booked = $row['total_rooms_booked'];
                // echo "Total room  in hotel :$total_rooms <br>";
                // echo "Total room booked in hotel :$total_rooms_booked <br>";
            //   echo "my checkin  :$checkInAD <br>";
            //   echo "my checkout :$checkOutAD <br>";
                $available_rooms = $total_rooms - $total_rooms_booked;
              //  echo "available room :$available_rooms";
                if($available_rooms >= $room_no) {
                    if(isset($_SESSION['user_id'])) {
                        $user_id = $_SESSION['user_id'];
                        $query = "INSERT INTO `booking`(`user_id`, `hotel_id`, `booking_date`, `checkin_date`, `checkout_date`, `total_guest`, `totalprice`, `payment`, `room`,`action`,`stat`)
                        VALUES ('$user_id','$hotelid','$today','$checkInAD','$checkOutAD','$guests','$totalprice','$pay','$room_no','booked','$stat')";
                        $result = mysqli_query($con, $query);
                        if($result) {
                            echo "<script>alert('Booked successfully..');</script>";
                            redirect('booking.php');
                            exit();
                        } else {
                            echo "<script>alert('Booked Failed try after few minutes.');</script>";
                            redirect('booking.php');
                            exit();
                        }
                    } else {
                        echo "<script>alert('Please Login First..');</script>";
                        redirect('booking.php');
                        exit();
                    }
                } else {
                    echo "<script>alert('No rooms available for the specified dates.Available rooms :$available_rooms');</script>";
                    redirect('booking.php');
                    exit();
                }
            } else {
                echo "<script>alert('Error checking room availability: " . mysqli_error($con) . "');</script>";
                redirect('booking.php');
                exit();
            }
        } else {
            echo "<script>alert('Error retrieving total rooms: " . mysqli_error($con) . "');</script>";
            redirect('booking.php');
            exit();
        }
    }
}
?>
