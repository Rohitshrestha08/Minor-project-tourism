<?php
include("db.php");
include("navbar.php");
$error="";
$msg="";
if( !isset($_SESSION['user_id']) && $_SESSION['logged_in'] !== true )
{
    redirect('main.php');
    exit();
}

if(isset($_POST["updateprofile"])) 
{

    $newname=$_POST['name'];
    $newphone=$_POST['phone'];
    $id=$_SESSION['user_id'];

    $info=mysqli_query($con,"select * from users where id='$id' ");
    if($info)
    {

            $row=mysqli_fetch_array($info);
            date_default_timezone_set("Asia/Kathmandu");
            $today=date('y-m-d');
            $currentname=$row['fullname'];
            $currentphone=$row['phone'];

                if($newname !== $currentname || $newphone !== $currentphone )
                {
                    
                    if (preg_match("/^\d{10}$/", $newphone)){
                        $query="UPDATE users SET fullname='$newname' , phone='$newphone' , lastup='$today' WHERE id='$id' ";
                        $result=mysqli_query($con,$query);
                        if($result)
                        {                          
                            $_SESSION['username']=$newname;
                            $_SESSION['phone']=$newphone;
                            $msg="Profile Updated successfully..";
                        }
                        else
                        {
                            $error="Failed to Update Profile Please try again..";
                        }
                    }else{
                        $error="Enter a Valid Phone number.";
                    }
                }
                else
                {
                    $error="No Any Changes In Profile.";
                }
    }
    else
    {
        $error="Failed to Update Profile Please try later..";
    }
}
$uid=$_SESSION['user_id'];
$query=mysqli_query($con,"SELECT * FROM `users` WHERE id='$uid'");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Profile</title>
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
.errorWrap {
    padding: 10px;
    margin: 20px 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 20px 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.head{
    color: #0e844d;
    font-size: 2em;
    font-family: serif;
    font-weight: 600;
    letter-spacing: 1px;
    margin-top: 20px;
    margin-bottom: 10px;
}
.formpassword{
    margin-bottom: 80px;
}
.formpassword.changeprofile{
    display: flex;
    flex-direction: column;
}
.formpassword label{
    color: var(--text-light);
    font-size: 1em;
    font-family: serif;
    font-weight: 500;
    letter-spacing: 1px;
    margin-bottom: 5px;
}
.formpassword button.btnchange{
    border: none;
    outline: none;
    background-color:#337ab7;
    color:  white;
    padding: 3px 6px 4px 6px;
    font-size: large;
    font-weight: 400;
    border-radius: 4px;
}
.formpassword button.btnchange:hover{
    background-color: var(--bs-success);
}
.forminput{   
    border: 1px solid #e0e0e0;
    padding: 5px 8px;
    width: 100%;
    font-size: 1em;
    font-weight: 350;
    border-radius: 3px;
    height: 40px;
	outline: none;
	background: none;
}
.formprofile{
    border: 1px solid #e0e0e0;
    padding: 5px 8px;
    width: 100%;
    font-size: 1em;
    font-weight: 350;
    border-radius: 3px;
    height: 40px;
	outline: none;
    background-color: #f1f8e9;
}
.formprofile:focus{
    border-color:#95d8dc!important;
}
.forminput:focus{
    background-color: #f1f8e9;
    border: 1px solid;
    border-color: cadetblue !important;
}
    </style>
</head>
<body>
    
</body>
</html>

<section>

            <div class="container">
                <div class="row">
                    <div class="col-lg-4 sm-12">
                        
        <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
            else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
                        <h1 class="head">My Profile</h1>
                        <?php
                        $row=mysqli_fetch_array($query); 
                        ?>
                        <form action="" method="post" class="formpassword">
                            <div class="changeprofile">
                                <label for="name">Name</label>
                                <input type="text" class="forminput mb-4" name="name" id="name" value="<?php echo $row['fullname'];?>">
                                <label for="phone">Phone Number</label>
                                <input type="text" class="forminput mb-4" name="phone" id="phone" value="<?php echo $row['phone'];?>">
                                <label for="email">Email</label>
                                <input type="email" class="formprofile mb-4" name="email" id="email" value="<?php echo $row['email'];?>" readonly>
                                <label for="lastup">Last Update Date:<?php echo $row['lastup'];?></label>
                            </div>
                            <button type="submit" name="updateprofile" class="btnchange">Update</button>
                        </form>
                    </div>
                    <div class="col-lg-8"></div>
                </div>
            </div>
</section>
<?php
include("footer.php");
?>