<?php
include("database.php");
include('../admin/function.php');
session_start();
if (!isset($_SESSION['hotelownere']) && !isset($_SESSION['hotelownerotp'])) {
    redirect('hotelownerlogin.php');
}

?>
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
        .resetpass {
            display: flex;
            justify-content: center; 
        }
        .resetpass form {
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

        form .resetpassword{
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

        form .resetpassword:hover {
            background-color: var(--bs-green);
        }
    </style>
</head>
  
<div class="back">
            <a href="otpconfirm.php"><i class="bi bi-arrow-left-circle-fill"> </i>Back to home</a>
        </div>
<div class="resetpass" id="resetpass">
    <form action="" method="post">
        <h3>Create New Password</h3>
        <input type="password" name="resetpass" id="resetpass" placeholder="Create an New Password">
        <button type="submit" class="resetpassword" name="resetpassword" >Submit</button>
    </form>
</div>
<?php
if(isset($_POST['resetpassword']))
{
    $email=$_SESSION['hotelownere'];
    $password=password_hash($_POST['resetpass'], PASSWORD_DEFAULT);
    $sql= "UPDATE hotelowner SET `pass`='$password',`otp`=NULL WHERE `hotelowner_email`='$email' ";
    $result=mysqli_query($con,$sql);
    if($result)
    {
        echo "<script>alert('Password reset successfully..');</script>";
        unset($_SESSION["hotelownere"]);
        unset($_SESSION["hotelownerotp"]);
        redirect('hotelownerlogin.php');
    }
    else{
        echo "<script>alert('Couldnot reset password try again');</script>";
        redirect('hotelownerlogin.php');
    }

}
?>

