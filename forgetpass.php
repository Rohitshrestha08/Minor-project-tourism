<?php

include("db.php");
include("navbar.php");
include_once("mailfunct.php");
include_once("admin/function.php");


if(isset($_POST["forget_pas"])) {
    $e_mail = $_POST['con_email'];
    $otp = rand(100000, 999999);
    date_default_timezone_set("Asia/Kathmandu");
    $date = date("Y-m-d");

    $query = "SELECT * FROM users WHERE email='$e_mail'";
    $result = mysqli_query($con, $query);

    if($result && mysqli_num_rows($result) == 1) {
        $up = "UPDATE `users` SET `otp`='$otp',`expires`='$date',`otpstatus`=0 WHERE `email`='$e_mail'";
        if(mysqli_query($con, $up) && sendMail($_POST['con_email'], $date, $otp)) {
            $_SESSION['e'] =$e_mail;
            $_SESSION['otp'] =$otp;
            echo "<script>alert('otp code has been send to your email');</script>";
            redirect('forgetpass.php');
            ?>
        <?php
            exit();
        } else {
            echo "<script>alert('could not send code');</script>";
            redirect('main.php');
        }
    } else {
        echo "<script>alert('Email address does not exist');</script>";
        redirect('main.php');
    }
}


if(isset($_POST["otpcodeword"])){
    date_default_timezone_set("Asia/Kathmandu");
    $date = date("Y-m-d");
    $email=$_SESSION['e'];
    $otp=$_POST['otpcode'];
    $query="SELECT * FROM `users` WHERE `email`='$email' AND `otpstatus`=0 AND `expires`='$date' AND `otp`='$otp' ";
    $result=mysqli_query($con,$query);
    if($result){
        if(mysqli_num_rows($result) ==1){
            $sql= "UPDATE users SET `otpstatus`=1 WHERE `email`='$email' ";
            $result=mysqli_query($con,$sql);
            if($result){

                redirect('updateresetpass.php');
            }
            else{
                echo "<script>alert('Invalid or expire OTP');</script>";
                redirect('forgetpass.php');

            }

        }else{
            echo "<script>alert('Invalid or expire OTP');</script>";
            redirect('forgetpass.php');
        }
    }
    else{
        echo "<script>alert('Couldnot run query');</script>";
        redirect('forgetpass.php');
    }
}

?>
<head>
    <style>
        .otpcode{
            display: flex;
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            height: 100vh; /* Use the full viewport height */
        } 
        .otpcode form{
            background-color: #f0f0f0;
            width: 350px;
            border-radius: 5px;
            padding: 20px 25px 30px 25px;
        }

        form h3 {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
            color: #30475e;
        }

        form input {
            width: 100%;
            margin-bottom: 20px;
            background-color: transparent;
            border: none;
            color: black;
            border-bottom: 2px solid black;
            border-radius: 0;
            padding: 5px 0;
            font-weight: 550;
            font-size: 14px;
            outline: none;
        }
        form .otpcodeword {
            font-weight: 550;
            padding: 4px 10px;
            font-size: 15px;
            background-color: #30475e;
            color: white;
            border: none;
            border-radius: 5px;
            outline: none;
            margin-top: 5px;
        }
        form .otpcodeword:hover {
            background-color: var(--bs-green);
        }
    </style>
</head>
<div class="otpcode" id="otpcode">
                <form action="" method="post">
                    <h3>Confirm OTP</h3>
                    <input type="password" name="otpcode" id="otpcode" placeholder="OTP Code">
                    <button type="submit" class="otpcodeword" name="otpcodeword" >Submit</button>
                </form>
            </div>
            <?php
include("footer.php");
?>
 