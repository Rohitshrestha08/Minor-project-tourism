<?php
session_start();
include("../mailfunct.php");
include("database.php");
include('function.php');
?>
<html>
    <head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">

            <!-- Include Font Awesome CSS (Replace the version number with the desired version) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap");

        :root {
            --primary-color: #f13033;
            --primary-color-dark: #c3282b;
            --secondary-color: #f9f9f9;
            --text-dark: #0f172a;
            --text-light: #64748b;
            --white: #ffffff;
            --bs-blue: #0d6efd;
            --bs-indigo: #6610f2;
            --bs-purple: #6f42c1;
            --bs-pink: #d63384;
            --bs-red: #dc3545;
            --bs-orange: #fd7e14;
            --bs-yellow: #ffc107;
            --bs-green: #198754;
            --bs-teal: #20c997;
            --bs-cyan: #0dcaf0;
            --bs-white: #fff;
            --bs-gray: #6c757d;
            --bs-gray-dark: #343a40;
            --bs-primary: #0d6efd;
            --bs-secondary: #6c757d;
            --bs-success: #198754;
            --bs-info: #0dcaf0;
            --bs-warning: #ffc107;
            --bs-danger: #dc3545;
            --bs-light: #f8f9fa;
            --bs-dark: #212529;
            --max-width: 1300px;
        }
        .back{         
            width: 100%;
            justify-content: flex-start;
            margin-left: 200px;
            margin-top: 50px;
        }
        section .hotelownemail {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            width: 100%;
        }
        .admin_loginemail {
            display: flex;
            width: 350px;
            margin-top: 6%;
            margin-bottom: 6%;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0 0 5px 0 rgb(0, 0,0.1);
            flex-direction: column;
        }
        .admin_loginemail .title{
            display: flex;
            flex-direction: row;
            justify-content: center;
            padding: 10px;
            color: white;
            background-color: #114bb0;
        }

        .admin_loginemail form {
            display: flex;
            margin-top: 10px;
            margin-bottom: 20px;
            flex-direction: column;
            align-items: center;
        }

        .admin_loginemail .input_admin {
            margin: 10px;
            padding: 5px;
            display: flex;
            width: 250px;
            flex-direction: column;
            position: relative;
        }

        .admin_loginemail .input_admin i {
            position: absolute;
            left: 10px;
            top: 50%; 
            transform: translateY(-40%);
        }

        .admin_loginemail .input_admin input {
            height: 30px;
            padding: 5px;
            padding-left: 30px; 
        }

        .admin_loginemail button {
            width:250px;
            font-size: large;
            margin-bottom: 10px;
            background-color: #007BFF;
            color: white;  
            border: none;
            border-radius: 2px;       
            height: 30px;
            margin:0;
        }
        .admin_loginemail button:hover{
            background-color: #fcb900;
        }
        .admin_loginemail .extra {
            display: flex;
            flex-direction:column;
            justify-content: center;
            align-items: center;
        }

        .admin_loginemail .extra a {
            color: #007BFF;
            text-decoration: none;
            margin: 10px;
        }

        .admin_loginemail .extra a:hover {
            text-decoration: underline;
        }
        </style>
    </head>
      
    <div class="back">
            <a href="adminlogin.php"><i class="bi bi-arrow-left-circle-fill"> </i>Back to home</a>
        </div>
    <section class="hotelownemail">
            <div class="admin_loginemail" id="admin_loginemail">
                <div class="title">
                    <h1>Admin Reset password</h1>
                </div>
                <form method="post" action="">
                    <div class="input_admin">
                        <i class="fas fa-user"></i>
                        <input type="email" name="admin_email" id="admin_email" placeholder="Enter E-mail" required>
                    </div>
                    <button type="submit"name="sendotp">Send Otp</button>
                </form>
            </div>
        </section>
        <?php
        if(isset($_POST['sendotp'])){
            $e_mail = $_POST['admin_email'];
            $otp = rand(100000, 999999);
            date_default_timezone_set("Asia/Kathmandu");
            $date = date("Y-m-d");
            
            $query = "SELECT * FROM admin WHERE email='$e_mail'";
            $result = mysqli_query($con, $query);
        
            if($result && mysqli_num_rows($result) == 1) {
                $up = "UPDATE `admin` SET `otp`='$otp',`expires`='$date',`otpstatus`=0 WHERE `email`='$e_mail'";
                if(mysqli_query($con, $up) && sendMail($_POST['admin_email'], $date, $otp)) {
                    $_SESSION['admine'] =$e_mail;
                    $_SESSION['adminotp'] =$otp;
                    echo "<script>alert('otp code has been send to your email');</script>";
                    redirect('otpconfirm.php');
                }else{}
        }else{
            echo "<script>alert('email address doenot found.');</script>";
        }
    }
        ?>
