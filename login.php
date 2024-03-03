<?php
include("db.php");
session_start();
if(isset($_POST['login']))
{
    $username=$_POST['username'];
    $password=$_POST['password'];
    $query="select * from users where username='$username' or email='$username'";
    $result=mysqli_query($con,$query);
    if($result)
    {
        if(mysqli_num_rows($result)==1)
        {
            $fetch=mysqli_fetch_array($result);
            if(password_verify($password,$fetch['user_password']))
            {
                $_SESSION['logged_in']=true;
                $_SESSION['user_id']=$fetch['id'];
                $_SESSION['username']=$fetch['username'];
                $_SESSION['phone']=$fetch['phone'];
                $_SESSION['email']=$fetch['email'];
                header("location:main.php");
            }
            else
            {
                echo"
                <script>alert('Incorrect Password.');
                window.location.href='main.php';
                </script>
                ";
            }
        }
        else
        {
            echo"
            <script>alert('Email or username not registered..');
            window.location.href='main.php';
            </script>
            ";
        }
    }
    else
    {
        echo"
        <script>alert('Cannot run query');
        window.location.href='main.php';
        </script>
        ";
    }
}

if(isset($_POST['register']))
{
    $username=$_POST['uname'];
    $fullname=$_POST['fullname'];
    $email=$_POST['newemail'];
    $phone=(int)$_POST['newphone']; 

   if (preg_match("/^\d{10}$/", $phone))
   {

    $password=password_hash($_POST['password'],PASSWORD_DEFAULT);
    $info="select * from users where username='$username' or email='$email'";
    $result=mysqli_query($con,$info);
    if($result)
    {
        if(mysqli_num_rows($result)>=1)
        {
            $user=mysqli_fetch_array($result);
            $uname=$user['username'];
            $uphone=$user['phone'];
            $useremail=$user['email'];
                
            switch (true) {
                case $uname == $username:
                    echo "<script>alert('$uname - Username already taken.');
                     window.location.href='main.php';</script>";
                    break;
                case $uphone == $phone:
                    echo "<script>alert('$uphone - Phone number already taken.'); 
                    window.location.href='main.php';</script>";
                    break;
                default:
                    echo "<script>alert('Email already registered.'); 
                    window.location.href='main.php';</script>";
                    break;
            }
            
        }
        else
        {
            $query="INSERT INTO `users`( `fullname`, `username`, `email`, `phone`, `user_password`) 
            VALUES ('$fullname','$username','$email','$phone','$password')";
            if(mysqli_query($con,$query))
            {
                echo"
                <script>alert('Register successful.');
                window.location.href='main.php';
                </script>
                ";
            } 
            else{
                echo"
                <script>alert('Cannot run query');
                window.location.href='index.php';
                </script>
                ";
            }
        }
   
    } 
     else 
     {
        echo"
        <script>alert('sorry cannot run query');
        window.location.href='main.php';
        </script>
        ";
    }
   }
   else
   {
    echo"
    <script>alert('enter valid phone number');
    window.location.href='main.php';
    </script>
    ";

   }
}
?>