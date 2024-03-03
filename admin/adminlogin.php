<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include ('database.php');
include("function.php");
?>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Include Font Awesome CSS (Replace the version number with the desired version) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
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
        .admin_login {
            display: flex;
            width: 400px;
            margin-top: 100px;
            box-shadow: 0 0 15px 0 black;
            flex-direction: column;
        }

        .admin_login .title {
            display: flex;
            flex-direction: row;
            justify-content: center;
            padding: 10px;
            color: white;
            background-color: #114bb0;
        }

        .admin_login form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .admin_login .input_admin {
            margin: 8px;
            padding: 5px;
            display: flex;
            width: 250px;
            flex-direction: column;
            position: relative;
        }

        .admin_login .input_admin i {
            position: absolute;
            left: 10px; 
            top: 50%; 
            transform: translateY(-40%);
                }

        .admin_login .input_admin input {
            height: 30px;
            padding: 5px;
            padding-left: 30px;
        }

        .admin_login button {
            width:250px;
            font-size: large;
            background-color: #007BFF;
            color: white;  
            border: none;
            border-radius: 2px;       
            height: 30px;
            margin: 10px;
        }
        .admin_login button:hover{
            background-color: #fcb900;
        }
        .admin_login .extra {
            margin: 10px;
        }

        .admin_login .extra a {
            color: #007BFF;
            text-decoration: none;
        }

        .admin_login .extra a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>   
        <div class="back">
            <a href="../main.php"><i class="bi bi-arrow-left-circle-fill"> </i>Back to home</a>
        </div>
    <div class="admin_login">
        <div class="title">
            <h1>Admin Login Panel</h1>
        </div>
        <form method="post" action="">
            <div class="input_admin">
                <i class="fas fa-user"></i>
                <input type="text" name="admin_name" id="adminName" placeholder="Enter Admin username">
            </div>
            <div class="input_admin">
                <i class="fas fa-lock"></i>
                <input type="password"name="admin_password" id="password" placeholder="Enter Password">
            </div>
            <button type="submit"name="signin">Sign In</button>
            <div class="extra">
                <a href="emailcon.php">Forgot Password</a>
            </div>
        </form>
    </div>
<?php
    if(isset($_POST['signin'])){
        $adminname=$_POST['admin_name'];
        $adminpass=$_POST['admin_password'];
        $check=mysqli_query($con,"SELECT * FROM admin WHERE admin_name='$adminname'");
        if($check && mysqli_num_rows($check) > 0){
            $fetch=mysqli_fetch_array($check); 
               if(password_verify($adminpass,$fetch['adminpassword'])){
                $id=$fetch['adminid'];
                $name=$fetch['name'];
                $email=$fetch['email'];
                $adminphone=$fetch['phone'];
                $_SESSION['admin']=$_POST['admin_name'];
                $_SESSION['adminname']=$name;
                $_SESSION['adminemail']=$email;
                $_SESSION['adminphone']=$adminphone;
                $_SESSION['adminid']=$id;
                redirect('dashboard.php');
                exit();

            }else{
                alerting('Password doesnot match.');
            }
        }else{
            alerting('admin id not found..');
        }
}
    ?>
</body>
</html>
