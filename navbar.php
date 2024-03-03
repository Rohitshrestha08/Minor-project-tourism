<?php
include("db.php");
session_start();
include("admin/function.php");

?>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
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

        section .navbaaaaaar {
            width: 100%;
            display: flex;
            flex-direction: column; /* Adjusted to column */
            align-items: center; /* Center content vertically */
        }

        section .top_header {
            display: flex;
            background-color: #3f84b1;
            height: 40px;
            width: 100%;
        }

        .top_header_content {
            display: flex;
            justify-content: space-between;
            max-width: var(--max-width); /* Added max-width */
            width: 100%; /* Adjusted width to 100% */
            margin: 0 auto; /* Adjusted padding */
            align-items: center;
        }
        .left-ul{
            display: flex;
            gap: 15px;
            line-height: 35px;
            font-size:14px;
            padding-top: 10px;
            list-style: none;
        }
        .right-ul{
            display: flex;
            gap: 7px;
            font-size:14px;
            line-height: 35px;
            padding-top: 10px;
            list-style: none;
        } 
        
        .right-ul li{
            color: white;
        }
        .left-ul a{
            text-decoration: none;
            letter-spacing: 0.1px;
            font-size: 1em;
            margin-right:10px;
            font-weight: 400;
            color: white;
        }
        .right-ul button{
            font-size: 1em;
            font-weight: 400;
            color: white;
            outline:none;   
            background-color: transparent;
            border:none;
        }
        .fas{
            font-size: 20px;
        }
        .navbar-title{
            height: 60px;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            background-color: white;
            max-width: 1200px;
            width: 100%; /* Adjusted width to 100% */
            margin: 0 auto; /* Adjusted padding */
            align-items: center;
        }        
        .navbar-title img{
            height: 80px;
            object-fit: cover;
        }
        .secondnav{
            display: flex;
            gap: 5px;
        }
        .secondnav li{
            list-style: none;
        }
        .secondnav li a{
            text-decoration: none;
        }
        .secondnav li button{
            font-size: 1em;
            font-weight: 400;
            color: black;
            outline:none;   
            background-color: transparent;
            border:none;
        }
        nav {
            width: 100%;
            display: flex;
            height: 50px;
            flex-direction: column;
            background-color: #4CB320;
            align-items: center;
        }
        .navbar-items {
            display: flex;
            justify-content: center; /* Horizontally center the navbar items */
            align-items: center; /* Vertically center the navbar items */
            max-width: var(--max-width); /* Limiting the maximum width */
            height: 100%; /* Set height to 100% */
        }

        .navbar-items ul {
            display: flex;
            gap: 10px;
            list-style: none;
            padding: 0;
            margin: 0;
            height: 100%;
            align-items: center;
        }

        .navbar-items li {
            display: flex;
            align-items: center;
            height: 100%; /* Set the height of each navbar item */
        }

        .navbar-items li:hover {
            background: #ffc107; /* Background color on hover */
        }

        .navbar-items li a {
            text-decoration: none;
            color: white;
            line-height: 100%;
            letter-spacing: 1px;
            padding: 8px 12px; /* Add padding to create clickable area */
            border-radius: 4px; /* Optional: add rounded corners */
        }
        .navbar-toggle{
            display:none;
        }
        .hamburger {
            display: none; /* Hide hamburger menu by default */
            cursor: pointer;
            margin-right: 10px; /* Adjust as needed */
            padding-right: 10px;
        }
                
        div.popnav_container{
            position: fixed;
            top: 5%;
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
            border-radius: 5px;
            padding: 20px 25px 30px 25px;
            z-index: 1600;
        }        
        div.popnav_container div.nav_popfor{
            background-color:white;
            width: 300px;
            height:250px;
            border-radius: 5px;
            padding: 20px 25px 30px 25px;
            z-index: 1600;
        }       
        div.popnav_container div.nav_poplog{
            background-color:white;
            width: 300px;
            height:250px;
            border-radius: 5px;
            padding: 20px 25px 30px 25px;
            z-index: 1600;
        }
        div.popnav_container div.nav_popreg{
            background-color:white;
            width: 300px;
            height:350px;
            border-radius: 5px;
            padding: 20px 25px 30px 25px;
            z-index: 1600;
        }

        div.popnav_container div.nav_poplog h2
        div.popnav_container div.nav_pop h2,
        div.popnav_container div.nav_popreg h2,
        div.popnav_container div.nav_popfor h2 {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            color: #30475e;
        }      
        div.popnav_container div.nav_poplog h2 button{
            border: none;
            background-color: transparent;
            outline: none;
            float:right;
            font-size: 18px;
            font-weight: 550;
            color:var(--bs-gray-dark);
        }

        div.popnav_container div.nav_pop h2 button,      
        div.popnav_container div.nav_popreg h2 button,      
        div.popnav_container div.nav_popfor h2 button{
            border: none;
            background-color: transparent;
            outline: none;
            font-size: 18px;
            font-weight: 550;
            color:var(--bs-gray-dark);
        }

        div.popnav_container div.nav_pop input,
        div.popnav_container div.nav_poplog input,
        div.popnav_container div.nav_popreg input,
        div.popnav_container div.nav_popfor input{
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

        .nav_poplog .login_btn,
        .nav_popreg .register_btn,
        .nav_popfor .confirm_forget{
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
        .nav_poplog .login_btn:hover,
        .nav_popreg .register_btn:hover,
        .nav_popfor .confirm_forget:hover{
            background-color:var(--bs-green);
        }
        div.popnav_container div.nav_poplog .forget_btn{
            float:right;
            font-weight: 550;
            font-size: 15px;
            background-color: transparent;
            color:blue;
            border: none;
            text-decoration: underline;
            border-radius: 5px;
            outline: none;
            margin-top: -28px;
        }
        div.popnav_container div.nav_poplog .forget_btn:hover{
            color:#ffc107;
        }
        @media screen and (min-width:700px) and (max-width:1330px) {
            .top_header_content,
            .navbar-title{
                max-width: 1000px;
                padding: 0 12px;
            }
            
        }
        @media screen and  (max-width:1050px) {
            .top_header_content,
            .navbar-title{
                max-width: 800px;
                font-size: small;
                padding: 0 8px;
            }
            
        }
        @media screen and  (max-width:500px) {
            .top_header_content,
            .navbar-title{
                max-width: 800px;
                font-size: x-small;
                padding: 0 8px;
            }
            
        }
        @media screen and (max-width: 600px) {
            .navbar-items {
                display: none; /* Hide navbar items on small screens */
            }

            .navbar-toggle {
                display: flex; /* Display hamburger menu */
                width: 100%;
                justify-content: flex-end; /* Move hamburger menu to the right */
                float: right;
                position: relative;
                align-items: center; /* Vertically center the icon */
                padding: 0 15px;
            }

            .hambar_content {
                display: none; /* Hide the hamburger menu content by default */
                position: absolute;
                background-color: #f9f9f9;
                min-width: 160px;
                box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
                z-index: 1000;
            }

            .hambar_content a {
                color: black;
                padding: 8px 14px;
                text-decoration: none;
                display: block;
            }

            .hambar_content a:hover {
                background-color: #969393;
                color: white;
            }

            .navbar-toggle:hover .hambar_content {
                display: block; /* Display hamburger menu content on hover */
                margin-top: 230px;
            }

            .navbar-toggle .hamburgerbtn {
                font-weight: 400;
                font-size: 20px;
                margin-right: 4px;
                padding: 7px 7px;
                border: 2px solid white;
                background-color: transparent;
                transform: rotate(90deg);
                border-radius: 5px;
                color: black;
            }
        }

    </style>
</head>
<body>
    <section class="navbaaaaaar">
        <div class="top_header">
            <div class="top_header_content">
        <?php
        if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true) {
            ?>
                <ul class='left-ul'>                    
                    <li><a href='main.php'><i class='fas fa-home'></i></a></li>
                    <li><a href='admin/admin.php'>Admin Login</a></li>
                </ul>
                <ul class='right-ul'>
                    <li>Tel Number : 123-4568790</li>
                    <li><button onclick="nav_pop('register_nav_pop')">Sign Up</button></li> 
                    <li>/<button onclick="nav_pop('login_nav_pop')">Sign In</button></li>
                </ul>
                <?php
        }else{    
            $profile=$_SESSION['email'];   
            ?>            
                <ul class='left-ul'>                    
                    <li><a href='main.php'><i class='fas fa-home'></i></a></li>
                    <li><a href='profile.php'>My Profile</a></li>
                    <li><a href='changepass.php'>Change Password</a></li>
                    <li><a href='history.php'>Booking History</a></li>
                </ul>
                <ul class='right-ul'>
                    <li>Welcome :  <?php echo $profile ?></li>
                    <li>/<a href="logout.php"><button>Log Out</button></a></li>
                </ul>
        <?php
        }
        ?>
            </div>
        </div>
        <div class="navbar-title">
            <img src="images/logo.png" alt="Logo">                
            <ul class="secondnav">
                <li><a href="main.php"><i class="fas fa-home"></i></a></li>
                <li><a href="hotelowner/hotelownerlogin.php" >HotelOwnerLogin</a></li>
            </ul>
        </div>
        <nav>
            <div class="navbar-items">
                <ul>
                   <li><a href="main.php">Home</a></li>
                   <li><a href="booking.php">Booking</a></li>
                   <li><a href="packages.php">Packages</a></li>
                   <li><a href="aboutus.php">About us</a></li>
                   <li><a href="gallery.php">Gallery</a></li>
                </ul>
            </div>
            <div class="navbar-toggle" >
                <button class="hamburgerbtn" id="hambarDropdownButton">|||                    
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
                </button>
                <div class="hambar_content">
                    <a href="main.php">Home</a>
                    <a href="booking.php">Booking</a>
                    <a href="packages.php">Packages</a>
                    <a href="aboutus.php">About us</a>
                    <a href="gallery.php">Gallery</a>
                </div>
           </div>
        </nav>
    </section>   
       
<!-- Login nav_pop -->
<div class="popnav_container" id="login_nav_pop">
    <div class="nav_poplog">
        <form action="login.php" method="post">
            <h2>
                <span>USER LOGIN</span>
                <button type="reset" onclick="nav_pop('login_nav_pop')">X</button>
            </h2>
            <input type="text" name="username" id="username" placeholder="email address">
            <input type="password" name="password" id="password" placeholder="password">
            <button type="submit" name="login" class="login_btn">Login</button>
        </form>        
        <button type="submit" name="forget"class="forget_btn"  onclick="forgetnav_pop('forget_nav_pop')">ForgetPassword</button>
    </div>
</div>
<!-- forget  nav_pop -->
<div class="popnav_container" id="forget_nav_pop">
    <div class="nav_popfor">
            <form action="forgetpass.php" method="post">
                <h2>
                    <span>Forget Password</span>
                <button type="reset" onclick="forgetnav_pop('forget_nav_pop')">X</button>
                </h2>
                <input type="email" name="con_email"  placeholder="E-mail">
                <button type="submit" name="forget_pas" class="confirm_forget">Confirm</button>
            </form>   
    </div>
</div>

<!-- Register nav_pop -->
<div class="popnav_container" id="register_nav_pop">
    <div class="nav_popreg">
        <form action="login.php" method="post">
            <h2>
                <span>USER REGISTER</span>
                <button type="reset" onclick="nav_pop('register_nav_pop')">X</button>
            </h2>
            <input type="text" name="fullname" id="fullname" placeholder="fullname">
            <!-- <input type="text" name="uname" id="uname" placeholder="username"> -->
            <input type="email" name="newemail" id="newemail" placeholder="E-mail">
            <input type="text" name="newphone" id="newphone" placeholder="Phone Number">
            <input type="password" name="reg_password" id="reg_password" placeholder="password">
            <button type="submit" name="register" class="register_btn">Register</button>
        </form>
    </div>
</div>


<script>
    function nav_pop(nav_pop_name) {
        var get_nav_pop = document.getElementById(nav_pop_name);
        var login_nav_pop = document.getElementById('login_nav_pop');
        var register_nav_pop = document.getElementById('register_nav_pop');
        var forget_nav_pop = document.getElementById('forget_nav_pop'); 
        
        if (nav_pop_name === 'login_nav_pop' && login_nav_pop.style.display === "flex") {
            login_nav_pop.style.display = "none";
        } else if (nav_pop_name === 'register_nav_pop' && register_nav_pop.style.display === "flex") {
            register_nav_pop.style.display = "none";
        // } else if (nav_pop_name === 'hotelowner_nav_pop' && hotelowner_nav_pop.style.display === "flex") {
        //     hotelowner_nav_pop.style.display = "none";
        } else {
            // Hide the other pop-up if it is visible
            if (login_nav_pop.style.display === "flex") {
                login_nav_pop.style.display = "none";
            }
            if (register_nav_pop.style.display === "flex") {
                register_nav_pop.style.display = "none";
            }
            if (forget_nav_pop.style.display === "flex") {
                forget_nav_pop.style.display = "none";
            }
            // if(hotelowner_nav_pop.style.display === "flex"){
            //     hotelowner_nav_pop.style.display === "none";
            // }
            // Display the selected pop-up
            get_nav_pop.style.display = "flex";
        }
    }

    function forgetnav_pop(nav_pop_name) {
        // Check if the clicked popup is already open
        var get_nav_pop = document.getElementById(nav_pop_name);
        if (get_nav_pop.style.display === "flex") {
            get_nav_pop.style.display = "none";
        } else {
            // Close any other open popups
            document.getElementById('login_nav_pop').style.display = "none";
            document.getElementById('register_nav_pop').style.display = "none";
            
            // Open the clicked popup
            get_nav_pop.style.display = "flex";
        }
    }

</script>



