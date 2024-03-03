
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include ('database.php');
include('../admin/function.php');
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
        body {
            display: flex;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            margin: 0;
            position: fixed;
            width: 100%;
        }
        .back{         
            width: 100%;
            justify-content: flex-start;
            margin-left: 200px;
            margin-top: 50px;
        }

        .hotelowner_login {
            display: flex;
            width: 400px;
            margin-top: 8%;
            box-shadow: 0 0 15px 0 black;
            flex-direction: column;
        }

        .hotelowner_login .title {
            display: flex;
            flex-direction: row;
            justify-content: center;
            padding: 10px;
            color: white;
            background-color: #114bb0;
        }

        .hotelowner_login form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .hotelowner_login .input_hotelowner {
            margin: 10px;
            padding: 5px;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .hotelowner_login .input_hotelowner i {
            position: absolute;
            left: 10px;
            top: 50%; 
            transform: translateY(-40%);
        }

        .hotelowner_login .input_hotelowner input {
            height: 30px;
            padding: 5px;
            padding-left: 30px; 
        }

        .hotelowner_login button {
            width:200px;
            font-size: large;
            background-color: #007BFF;
            color: white;  
            border: none;
            border-radius: 2px;       
            height: 30px;
            margin:0;
        }
        .hotelowner_login button:hover{
            background-color: #fcb900;
        }
        .hotelowner_login .extra {
            display: flex;
            flex-direction:column;
            justify-content: center;
            align-items: center;
        }

        .hotelowner_login .extra a {
            color: #007BFF;
            text-decoration: none;
            margin: 10px;
        }

        .hotelowner_login .extra a:hover {
            text-decoration: underline;
        }
        div.popnav_container{
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: top;
            flex-direction: row;
            background-color: rgb(0, 0,0,0.2);
            z-index: 10000;
            display: none;
        }
        div.popnav_container div.nav_pop{
            background-color:white;
            width: 300px;
            height:300px;
            top:20%;
            border-radius: 5px;
            padding: 20px 25px 30px 25px;
            z-index: 1600;
        } 
        div.popnav_container div.emailotpreset{
            background-color:white;
            width: 300px;
            height:150px;
            top:20%;
            border-radius: 5px;
            padding: 20px 25px 30px 25px;
            z-index: 1600;
        }  
        div.popnav_container div.emailotpreset h2,
        div.popnav_container div.nav_pop h2{
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 18px;
            color: #30475e;
        }      
        div.popnav_container div.emailotpreset h2 button,
        div.popnav_container div.nav_pop h2 button{
            border: none;
            background-color: transparent;
            outline: none;
            font-size: 18px;
            font-weight: 550;
            color:var(--bs-gray-dark);
        }
        div.popnav_container div.emailotpreset input,
        div.popnav_container div.nav_pop input{
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
        .emailotpreset .emailcon_btn,
        .emailotpreset .otpcodeword_btn,
        .emailotpreset .restpassword_btn,
        .nav_pop .register_btn{
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
        .emailotpreset .emailcon_btn:hover,
        .emailotpreset .otpcodeword_btn:hover,
        .emailotpreset .restpassword_btn:hover,
        .nav_pop .register_btn:hover{
            background-color:var(--bs-green);
        }

    </style>
</head>
<body>
    <div class="back">
		<a href="../main.php">Back to home</a>
	</div>
    <div class="hotelowner_login" id="hotelowner_login">
        <div class="title">
            <h1>hotel Owner Login</h1>
        </div>
        <form method="post" action="hotelownerlogin.php">
            <div class="input_hotelowner">
                <i class="fas fa-user"></i>
                <input type="email" name="hotelowner_email" id="hotelowner_email" placeholder="Enter E-mail" required>
            </div>
            <div class="input_hotelowner">
                <i class="fas fa-lock"></i>
                <input type="password"name="hotelowner_password" id="password" placeholder="Enter Password" required>
            </div>
            <button type="submit"name="signin">Sign In</button>
        </form>
            <div class="extra">
                <button onclick="popup('hotelowner_nav_pop');">Register</button>
                <a href="#"onclick="nav_pop('emailcon');">Forgot Password</a>
            </div>
    </div>	
    
<!-- Register hotelowner nav_pop -->
<div class="popnav_container" id="hotelowner_nav_pop">
    <div class="nav_pop">
        <form action="hotelownerlogin.php" method="post">
            <h2>
                <span>Hotel Owner REGISTER</span>
                <button type="reset" onclick="popups('hotelowner_nav_pop')">X</button>
            </h2>
            <input type="text" name="fullname" id="fullname" placeholder="fullname" required>
            <input type="email" name="newemail" id="newemail" placeholder="E-mail" required>
            <input type="text" name="newphone" id="newphone" placeholder="Phone Number" required>
            <input type="password" name="reg_password" id="reg_password" placeholder="password" required>
            <button type="submit" name="register" class="register_btn">Register</button>
        </form>
    </div>
</div>

    <!-- email confirm hotelowner nav_pop -->
    <div class="popnav_container" id="emailcon">
    <div class="emailotpreset">
        <form action="hotelownerlogin.php" method="post">
            <h2>
                <span>Email confirm</span>
                <button type="reset" onclick="popups('emailcon')">X</button>
            </h2>
            <input type="email" name="emailcon" placeholder="Email address">
            <button type="submit" class="emailcon_btn" name="emailcon" onclick="nav_pop('otpcode');" >Send OTP</button>
        </form>
    </div>
</div>
    <!-- otpcode hotelowner nav_pop -->
    <div class="popnav_container" id="otpcode">
    <div class="emailotpreset">
        <form action="hotelownerlogin.php" method="post">
            <h2>
                <span>Confirm OTP</span>
                <button type="reset" onclick="popups('otpcode')">X</button>
            </h2>
            <input type="password" name="otpcode" id="otpcodea" placeholder="OTP Code">
            <button type="submit" class="otpcodeword_btn" name="otpcodeword" onclick="nav_pop('restpassword');">Confirm</button>
        </form>
    </div>
</div>   
  <!-- confirm otp hotelowner nav_pop -->
<div class="popnav_container" id="restpassword">
    <div class="emailotpreset">
        <form action="hotelownerlogin.php" method="post">
            <h2>
                <span>Reset Password</span>
                <button type="reset" onclick="popups('restpassword')">X</button>
            </h2>
            <input type="password" name="restpass" id="restpass" placeholder="Enter New Password">
            <button type="submit" class="restpassword_btn" name="restpassword" >Reset</button>
        </form>
    </div>
</div>  
     
<script>
    function nav_pop(nav_pop_name) {
        var get_nav_pop = document.getElementById(nav_pop_name);
        var emailcon = document.getElementById('emailcon');
        var restpassword = document.getElementById('restpassword');
        var otpcode = document.getElementById('otpcode'); 

            // Hide the other pop-up if it is visible
            if (emailcon.style.display === "flex") {
                emailcon.style.display = "none";
            }
            if (restpassword.style.display === "flex") {
                restpassword.style.display = "none";
            }
            if (otpcode.style.display === "flex") {
                otpcode.style.display = "none";
            }
            get_nav_pop.style.display = "flex";
  
    }

    function forgetnav_pop(nav_pop_name) {
        // Check if the clicked popup is already open
        var get_nav_pop = document.getElementById(nav_pop_name);
        if (get_nav_pop.style.display === "flex") {
            get_nav_pop.style.display = "none";
        } else {
            // Close any other open popups
            document.getElementById('otpcode').style.display = "none";
            document.getElementById('emailcon').style.display = "none";           
            // Open the clicked popup
            get_nav_pop.style.display = "flex";
        }
    }

</script>
<script>hotelowner_login
function otp(id){
    var get_nav_pop = document.getElementById(nav_pop_name);
        var otpcode = document.getElementById('otpcode');
        var emailcon = document.getElementById('emailcon');
        var register = document.getElementById('hotelowner_nav_pop');
        var restpass = document.getElementById('restpassword');

}
    function popup(nav_pop_name) {
    console.log("Opening pop-up: " + nav_pop_name); 
        var get_nav_pop = document.getElementById(nav_pop_name);
        var otpcode = document.getElementById('otpcode');
        var emailcon = document.getElementById('emailcon');
        var register = document.getElementById('hotelowner_nav_pop');
        var restpass = document.getElementById('restpassword');

        // Display the specified popup
        switch(nav_pop_name) {
            case 'hotelowner_nav_pop':
                register.style.display = "flex";
                emailcon.style.display = "none";
                otpcode.style.display = "none";
                restpass.style.display = "none";
                break;
            case 'emailcon':
                emailcon.style.display = "flex";
                register.style.display = "none";
                otpcode.style.display = "none";
                restpass.style.display = "none";
                break;
            case 'otpcode':
                otpcode.style.display = "flex";
                register.style.display = "none";
                emailcon.style.display = "none";
                restpass.style.display = "none";
                break;
            case 'restpassword':
                restpass.style.display = "flex";
                register.style.display = "none";
                emailcon.style.display = "none";
                otpcode.style.display = "none";
                break;
        }
    }

    function popups(nav_pop_name) {
          alert("Closing pop-up: " + nav_pop_name); // Log statement to check if the function is called
   
        var get_nav_pop = document.getElementById(nav_pop_name);
        get_nav_pop.style.display = "none";
    }
</script>

 <?php

// include("db.php");
// include("navbar.php");
// include_once("mailfunct.php");
// include_once("admin/function.php");


// if(isset($_POST["forget_pas"])) {
//     $e_mail = $_POST['con_email'];
//     $otp = rand(100000, 999999);
//     date_default_timezone_set("Asia/Kathmandu");
//     $date = date("Y-m-d");

//     $query = "SELECT * FROM users WHERE email='$e_mail'";
//     $result = mysqli_query($con, $query);

//     if($result && mysqli_num_rows($result) == 1) {
//         $up = "UPDATE `users` SET `otp`='$otp',`expires`='$date',`otpstatus`=0 WHERE `email`='$e_mail'";
//         if(mysqli_query($con, $up) && sendMail($_POST['con_email'], $date, $otp)) {
//             $_SESSION['e'] =$e_mail;
//             $_SESSION['otp'] =$otp;
//             echo "<script>alert('otp code has been send to your email');</script>";
//             redirect('forgetpass.php');
//             ?>
//         <?php
//             exit();
//         } else {
//             echo "<script>alert('could not send code');</script>";
//             redirect('main.php');
//         }
//     } else {
//         echo "<script>alert('Email address does not exist');</script>";
//         redirect('main.php');
//     }
// }


// if(isset($_POST["otpcodeword"])){
//     date_default_timezone_set("Asia/Kathmandu");
//     $date = date("Y-m-d");
//     $email=$_SESSION['e'];
//     $otp=$_POST['otpcode'];
//     $query="SELECT * FROM `users` WHERE `email`='$email' AND `otpstatus`=0 AND `expires`='$date' AND `otp`='$otp' ";
//     $result=mysqli_query($con,$query);
//     if($result){
//         if(mysqli_num_rows($result) ==1){
//             $sql= "UPDATE users SET `otpstatus`=1 WHERE `email`='$email' ";
//             $result=mysqli_query($con,$sql);
//             if($result){

//                 redirect('updateresetpass.php');
//             }
//             else{
//                 echo "<script>alert('Invalid or expire OTP');</script>";
//                 redirect('forgetpass.php');

//             }

//         }else{
//             echo "<script>alert('Invalid or expire OTP');</script>";
//             redirect('forgetpass.php');
//         }
//     }
//     else{
//         echo "<script>alert('Couldnot run query');</script>";
//         redirect('forgetpass.php');
//     }
// }

?>

 
<?php
if(isset($_POST['register']))
{
    $fullname = $_POST['fullname'];
    $email = $_POST['newemail'];
    $phone = $_POST['newphone'];
    $pass = $_POST['reg_password'];
    $hashpass = password_hash($pass, PASSWORD_DEFAULT);
    
   if (preg_match("/^\d{10}$/", $phone))
   {
        $query1=mysqli_query($con,"SELECT * FROM hotelowner WHERE hotelowner_email='$email' OR phone_no='$phone'");
        if(mysqli_num_rows($query1) ==0){
            $query = "INSERT INTO `hotelowner`(`hotelowner_email`, `name`, `phone_no`, `pass`) 
            VALUES ('$email', '$fullname', '$phone', '$hashpass')";
            $result = mysqli_query($con, $query);
            if($result)
            {
                alerting('Hotel owner registration successful.');
                redirect('hotelownerlogin.php');
            }
            else
            {
                alerting('Hotel owner registration failed.');
                redirect('hotelownerlogin.php');
            }
        }
        else{
            alerting('Email addres or phone no already exist');
            redirect('hotelownerlogin.php');
        }
    }else{
        alerting('Enter a valid phone number');
        redirect('hotelownerlogin.php');
    }
}

if(isset($_POST['signin']))
{
    $hotelownername = trim($_POST['hotelowner_email']);
    $hotelownerpass = trim($_POST['hotelowner_password']);
    

    $check = "SELECT * FROM hotelowner WHERE hotelowner_email='$hotelownername'";
    $result =mysqli_query($con,$check);
    if($result)
    {    
        if(mysqli_num_rows($result) == 1)
        {
            $sess=mysqli_fetch_array($result);
            if(password_verify($hotelownerpass,$sess['pass']))
            {
                $id = $sess['id'];
                $name = $sess['name'];
                $_SESSION['hotelowneremail'] = $hotelownername;
                $_SESSION['hotelownername'] = $name;
                $_SESSION['hotelownerid'] = $id;
                redirect('dashboard.php');
                exit();
            }
            else
            {
                alerting('Incorrect password');
                redirect('hotelownerlogin.php');
            }
        }
        else
        {
            alerting('No hotel owner found');
            redirect('hotelownerlogin.php');
        }
    }
    else{
        alerting('Cannot run query');
        redirect('hotelownerlogin.php');
    }

}
?>


</body>
</html> 
