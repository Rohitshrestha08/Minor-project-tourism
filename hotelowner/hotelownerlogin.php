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

        section .hotelown {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            width: 100%;
        }
        .hotelowner_login {
            display: flex;
            width: 400px;
            margin-top: 6%;
            margin-bottom: 6%;
            margin-left: auto;
            margin-right: auto;
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
            margin-top: 10px;
            flex-direction: column;
            align-items: center;
        }

        .hotelowner_login .input_hotelowner {
            margin-top: 10px;
            padding: 5px;
            width: 250px;
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

        .hotelowner_login form button {
            width:250px;
            font-size: large;
            background-color: #007BFF;
            color: white;  
            border: none;
            border-radius: 2px;       
            height: 30px;
            margin-top:8px;
        }
        .hotelowner_login button {
            width:250px;
            font-size: large;
            background-color: #007BFF;
            color: white;  
            border: none;
            border-radius: 2px;       
            height: 30px;
            margin: 0;
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
        div.popnav_container div.nav_pop h2{
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 18px;
            color: #30475e;
        }  
        div.popnav_container div.nav_pop h2 button{
            border: none;
            background-color: transparent;
            outline: none;
            font-size: 18px;
            font-weight: 550;
            color:var(--bs-gray-dark);
        }
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
        .nav_pop .register_btn:hover{
            background-color:var(--bs-green);
        }
        </style>
    </head>
    <body>    
        <div class="back">
            <a href="../main.php"><i class="bi bi-arrow-left-circle-fill"> </i>Back to home</a>
        </div>
        <section class="hotelown">
            <div class="hotelowner_login" id="hotelowner_login">
                <div class="title">
                    <h1>Hotel Owner Login</h1>
                </div>
                <form method="post" action="">
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
                        <button onclick="nav_pop('hotelowner_nav_pop');">Register</button>
                        <a href="emailcon.php">Forgot Password</a>
                    </div>
            </div>

            <!-- Register hotelowner nav_pop -->
            <div class="popnav_container" id="hotelowner_nav_pop">
                <div class="nav_pop">
                    <form action="hotelownerlogin.php" method="post">
                        <h2>
                            <span>Hotel Owner REGISTER</span>
                            <button type="reset" onclick="nav_pop('hotelowner_nav_pop')">X</button>
                        </h2>
                        <input type="text" name="fullname" id="fullname" placeholder="fullname" required>
                        <input type="email" name="newemail" id="newemail" placeholder="E-mail" required>
                        <input type="text" name="newphone" id="newphone" placeholder="Phone Number" required>
                        <input type="password" name="reg_password" id="reg_password" placeholder="password" required>
                        <button type="submit" name="register" class="register_btn">Register</button>
                    </form>
                </div>
            </div>
            <script>
                    function nav_pop(nav_pop_name) {
                        var get_nav_pop = document.getElementById(nav_pop_name);
                        if(get_nav_pop.style.display === "flex"){
                            get_nav_pop.style.display = "none";
                        }else{
                            get_nav_pop.style.display = "flex";
                        }

                    }
            </script>
             
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
        </section>
