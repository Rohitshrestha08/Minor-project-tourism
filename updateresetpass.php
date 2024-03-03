<?php
include("db.php");
include("navbar.php");
if (!isset($_SESSION['e']) && !isset($_SESSION['otp'])) {
    redirect('main.php');
}

?>
<head>
    <style>
       
        .resetpass {
            display: flex;
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
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

<div class="resetpass" id="resetpass">
    <form action="" method="post">
        <h3>Create New Password</h3>
        <input type="password" name="resetpass" id="resetpass" placeholder=Create an New Password>
        <button type="submit" class="resetpassword" name="resetpassword" >Submit</button>
    </form>
</div>
<?php
if(isset($_POST['resetpassword']))
{
    $email=$_SESSION['e'];
    $password=password_hash($_POST['resetpass'], PASSWORD_DEFAULT);
    $sql= "UPDATE users SET `user_password`='$password',`otp`=NULL WHERE `email`='$email' ";
    $result=mysqli_query($con,$sql);
    if($result)
    {
        echo "<script>alert('Password reset successfully..');</script>";
        unset($_SESSION["e"]);
        unset($_SESSION["otp"]);
        redirect('main.php');
    }
    else{
        echo "<script>alert('Couldnot reset password try again');</script>";
        redirect('main.php');
    }

}
?>
<?php
include("footer.php");
?>

