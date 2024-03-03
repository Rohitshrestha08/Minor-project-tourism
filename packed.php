<?php
session_start();
include("db.php");
if(isset($_POST['bookedpackages']))
{
    $payment=$_POST['paymentpackages'];
    $pacid=$_POST['packname'];
    $numguest=$_POST['packguest'];
    $stat=0;
    if($payment=='cash'){
        $stat=1;
    }
    $inncheck=$_POST['incheck'];
    $duration=$_POST['packdu'];
    $hotel_id=$_POST['hotelid'];
    $room=$_POST['room'];
    date_default_timezone_set("Asia/Kathmandu");
    $bookinDate = date("Y-m-d");
    $checkinTimestamp = strtotime($inncheck);
    $futureTimestamp = $checkinTimestamp + ($duration * 24 * 60 * 60); 
    
    $checkout = date("Y-m-d", $futureTimestamp);
     if (isset($_SESSION['searchplaced']))  
     {
        $price=$_POST['tolprice'];
        $totalRoomsQuery = "SELECT * FROM hotels WHERE hotel_id='$hotel_id'";
        $totalRoomsResult = mysqli_query($con, $totalRoomsQuery);
        if($totalRoomsResult) {
            $totalRoomsRow = mysqli_fetch_assoc($totalRoomsResult);
            $total_rooms = $totalRoomsRow['room'];
            
            $checkAvailabilityQuery = "SELECT SUM(room) AS total_rooms_booked FROM booking WHERE hotel_id='$hotel_id' AND action='booked' AND ((checkin_date < '$checkout' AND checkout_date > '$inncheck') OR (checkin_date = '$inncheck' AND checkout_date = '$checkout'))";
            $availabilityResult = mysqli_query($con, $checkAvailabilityQuery);
            if($availabilityResult) {
                $row = mysqli_fetch_assoc($availabilityResult);
                $total_rooms_booked = $row['total_rooms_booked'];
                // echo "Total room  in hotel :$total_rooms <br>";
                // echo "Total room booked in hotel :$total_rooms_booked <br>";
                $available_rooms = $total_rooms - $total_rooms_booked;
                // echo "available room :$available_rooms";
                if($available_rooms >= $room) {
                    if(isset($_SESSION['user_id']))
                    {
                        $user_id=$_SESSION['user_id'];
                        $query="INSERT INTO `booking`(`user_id`,`hotel_id`,`room`, `packages_id`, `booking_date`, `checkin_date`, `checkout_date`, `total_guest`, `totalprice`, `payment`,`action`,`stat`)
                        VALUES ('$user_id','$hotel_id','$room','$pacid','$bookinDate','$inncheck','$checkout','$numguest','$price','$payment','booked','$stat')";
                        $result=mysqli_query($con,$query);
                        if($result)
                        {
                            echo "
                            <script>alert('Booked successfully..');</script>";
                            redirect('packages.php');
                            exit();
                        }
                        else
                        {
                            echo "
                            <script>alert('Booked Failed try after few minutes.');</script>";
                            redirect('packages.php');
                            exit();
                        }
                    }
                    else{
                        echo "
                        <script>alert('Please Login First..');</script>";
                            redirect('packages.php');
                            exit();
                    }
                }
                else {
                echo "<script>alert('No rooms available for the specified dates.Available rooms :$available_rooms');</script>";
                redirect('packages.php');
                exit();
            }
            } else {
                echo "<script>alert('Error checking room availability: " . mysqli_error($con) . "');</script>";
                redirect('packages.php');
                exit();
            }
        } else {
            echo "<script>alert('Error retrieving total rooms: " . mysqli_error($con) . "');</script>";
            redirect('packages.php');
            exit();
        }
    }  
    else
    {
        $price=$_POST['tppackages'];
        
        if(isset($_SESSION['user_id']))
        {
            $user_id=$_SESSION['user_id'];
            $totalRoomsQuery = "SELECT * FROM hotels WHERE hotel_id='$hotel_id'";
            $totalRoomsResult = mysqli_query($con, $totalRoomsQuery);
            if($totalRoomsResult) {
                $totalRoomsRow = mysqli_fetch_assoc($totalRoomsResult);
                $total_rooms = $totalRoomsRow['room'];
                
                $checkAvailabilityQuery = "SELECT SUM(room) AS total_rooms_booked FROM booking WHERE hotel_id='$hotel_id'AND action='booked' AND ((checkin_date < '$checkout' AND checkout_date > '$inncheck') OR (checkin_date = '$inncheck' AND checkout_date = '$checkout'))";
                $availabilityResult = mysqli_query($con, $checkAvailabilityQuery);
                if($availabilityResult) {
                    $row = mysqli_fetch_assoc($availabilityResult);
                    $total_rooms_booked = $row['total_rooms_booked'];
                    // echo "Total room  in hotel :$total_rooms <br>";
                    // echo "Total room booked in hotel :$total_rooms_booked <br>";
                    $available_rooms = $total_rooms - $total_rooms_booked;
                    // echo "available room :$available_rooms";
                    if($available_rooms >= $room) {
                        $query="INSERT INTO `booking`(`user_id`,`hotel_id`,`room`, `packages_id`, `booking_date`, `checkin_date`, `checkout_date`, `total_guest`, `totalprice`, `payment`,`action`,`stat`)
                        VALUES ('$user_id','$hotel_id','$room','$pacid','$bookinDate','$inncheck','$checkout','$numguest','$price','$payment','booked','$stat')";
                        $result=mysqli_query($con,$query);
                        if($result)
                        {
                            echo "
                            <script>alert('Booked successfully..');</script>";
                            redirect('packages.php');
                            exit();
                        }
                        else
                        {
                            echo "
                            <script>alert('Booked Failed try after few minutes.');</script>";
                            redirect('packages.php');
                            exit();
                        }
                    }
                    else {
                    echo "<script>alert('No rooms available for the specified dates.Available rooms :$available_rooms');</script>";
                    redirect('packages.php');
                    exit();
                    }
                } else {
                    echo "<script>alert('Error checking room availability: " . mysqli_error($con) . "');</script>";
                    redirect('packages.php');
                    exit();
                }
            } else {
                echo "<script>alert('Error retrieving total rooms: " . mysqli_error($con) . "');</script>";
                redirect('packages.php');
                exit();
            }
        }
        else{
            echo "
            <script>alert('Please Login First..');</script>";
                redirect('packages.php');
                exit();
        }
    }
}
?>
