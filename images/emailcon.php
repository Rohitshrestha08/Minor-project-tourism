<?php
include("navbar.php");
include_once("mailfunct.php");
?>
<html>
    <head>
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
        section .hotelownemail {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            width: 100%;
        }
        .hotelowner_loginemail {
            display: flex;
            width: 400px;
            margin-top: 6%;
            margin-bottom: 6%;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0 0 5px 0 rgb(0, 0,0.1);
            flex-direction: column;
        }
        .hotelowner_loginemail .title{
            display: flex;
            flex-direction: row;
            justify-content: center;
            padding: 10px;
            color: white;
            background-color: #114bb0;
        }

        .hotelowner_loginemail form {
            display: flex;
            margin-top: 10px;
            margin-bottom: 20px;
            flex-direction: column;
            align-items: center;
        }

        .hotelowner_loginemail .input_hotelowner {
            margin: 10px;
            padding: 5px;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .hotelowner_loginemail .input_hotelowner i {
            position: absolute;
            left: 10px;
            top: 50%; 
            transform: translateY(-40%);
        }

        .hotelowner_loginemail .input_hotelowner input {
            height: 30px;
            padding: 5px;
            padding-left: 30px; 
        }

        .hotelowner_loginemail button {
            width:220px;
            font-size: large;
            margin-bottom: 10px;
            background-color: #007BFF;
            color: white;  
            border: none;
            border-radius: 2px;       
            height: 30px;
            margin:0;
        }
        .hotelowner_loginemail button:hover{
            background-color: #fcb900;
        }
        .hotelowner_loginemail .extra {
            display: flex;
            flex-direction:column;
            justify-content: center;
            align-items: center;
        }

        .hotelowner_loginemail .extra a {
            color: #007BFF;
            text-decoration: none;
            margin: 10px;
        }

        .hotelowner_loginemail .extra a:hover {
            text-decoration: underline;
        }
        </style>
    </head>
    <section class="hotelownemail">
            <div class="hotelowner_loginemail" id="hotelowner_loginemail">
                <div class="title">
                    <h1>Reset password</h1>
                </div>
                <form method="post" action="">
                    <div class="input_hotelowner">
                        <i class="fas fa-user"></i>
                        <input type="email" name="hotelowner_email" id="hotelowner_email" placeholder="Enter E-mail" required>
                    </div>
                    <button type="submit"name="sendotp">Send Otp</button>
                </form>
            </div>
        </section>
        <?php
        if(isset($_POST['sendotp'])){
            $e_mail = $_POST['hotelowner_email'];
            $otp = rand(100000, 999999);
            date_default_timezone_set("Asia/Kathmandu");
            $date = date("Y-m-d");
            
            $query = "SELECT * FROM hotelowner WHERE hotelowner_email='$e_mail'";
            $result = mysqli_query($con, $query);
        
            if($result && mysqli_num_rows($result) == 1) {
                $up = "UPDATE `hotelowner` SET `otp`='$otp',`expires`='$date',`otpstatus`=0 WHERE `hotelowner_email`='$e_mail'";
                if(mysqli_query($con, $up) && sendMail($_POST['hotelowner_email'], $date, $otp)) {
                    $_SESSION['hotelownere'] =$e_mail;
                    $_SESSION['hotelownerotp'] =$otp;
                    echo "<script>alert('otp code has been send to your email');</script>";
                    redirect('otpconfirm.php');
                }else{}
        }else{
            
            echo "<script>alert('email address doenot found.');</script>";
        }
    }
        ?>
<?php
include("footer.php");
?>