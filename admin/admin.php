<?php
session_start();
include("function.php");

// Check if the user is logged in, otherwise redirect to the login page
if (!isset($_SESSION['adminid'])) {
    header("Location: adminlogin.php"); // Redirect to your login page
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Arial', sans-serif;
            overflow-x: hidden;

        }

        #wrapper {
            display: flex;
        }

        #sidebar-wrapper {
            min-height: 100vh;
            width: 250px;
            background-color: #343a40;
            color: white;
            padding-top: 56px;
        }

        #page-content-wrapper {
            flex: 1;
            padding: 15px;
        }

        .navbar {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        .navbar-toggler-icon {
            background-color: #343a40;
        }

        .navbar-nav .nav-link {
            color: #343a40;
        }
  .list-group-item {
    background-color: #343a40 !important;
    color: white !important;
    border: 1px solid #343a40 !important;
}

.list-group-item:hover,
.list-group-item:focus {
    background-color: #495057 !important;
    color: white !important;
}

.list-group-item.active,
.list-group-item.active:hover,
.list-group-item.active:focus {
    background-color: #343a40 !important;
}
.errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}



    </style>
</head>

<body>

    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
        <div class="border-end bg-dark text-white" id="sidebar-wrapper">
            <div class="sidebar-heading border-bottom bg-dark">Admin Panel</div>
            <div class="list-group list-group-flush">
                <a href="dashboard.php" class="list-group-item list-group-item-action text-white" id="dashboard-link">Dashboard</a>
                <a href="user.php" class="list-group-item list-group-item-action text-white" id="users-link">Users</a>
                <a href="hotel.php" class="list-group-item list-group-item-action text-white" id="hotels-link">Hotels</a>
                <a href="booking.php" class="list-group-item list-group-item-action text-white" id="booking-link">Booking</a>
                <a href="notification.php" class="list-group-item list-group-item-action text-white" id="notification-link">Notification</a>
                <a href="package.php" class="list-group-item list-group-item-action text-white" id="packages-link">Packages</a>
                <a href="gallery.php" class="list-group-item list-group-item-action text-white" id="gallery-link">Gallery</a>
                <a href="contactus.php" class="list-group-item list-group-item-action text-white" id="contactus-link">Contact us</a>
                <a href="destination.php" class="list-group-item list-group-item-action text-white" id="destination-link">Destination</a>
                <a href="carousel.php" class="list-group-item list-group-item-action text-white" id="carousel-link">Carousel</a>
                <a href="trending.php" class="list-group-item list-group-item-action text-white" id="trending-link">Trending</a>
                <a href="thingstodo.php" class="list-group-item list-group-item-action text-white" id="thingstodo-link">Thingstodo</a>

            </div>
        </div>
        <script>
    $(document).ready(function() {
        $(".list-group-item").click(function() {
            $(".list-group-item").removeClass("active");
            $(this).addClass("active");
        });
    });
</script>


        <!-- Page Content -->
        <div id="page-content-wrapper">
            <!-- Top Navigation -->
            <nav class="navbar navbar-expand-lg navbar-light">

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Welcome Administrative
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#profileModal">Profile</a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#changePasswordModal">Change Password</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php">Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
           
          
<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog"
    aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Your custom Change Password form goes here -->
                <form method="post" action="admin.php">
                    <!-- Include your form fields here -->
                    <div class="form-group">
                        <label for="currentPassword">Current Password</label>
                        <input type="password"name="currentPassword" class="form-control" id="currentPassword" required>
                        
                    </div>
                    <div class="form-group">
                        <label for="newPassword">New Password</label>
                        <input type="password"name="newPassword" class="form-control" id="newPassword" required>
                        
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password</label>
                        <input type="password"name="confirmPassword" class="form-control" id="confirmPassword" required>
                     
                    </div>
                    <button type="submit" name="changepassword" class="btn btn-primary">Change Password</button>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Profile Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileModalLabel">Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Your custom Profile form goes here -->
                <form method="post" action="">
                    <!-- Include your form fields here -->
                    <div class="form-group">
                        <label for="adminname">Full Name</label>
                        <input type="text" class="form-control"name="adminname" value="<?php echo $_SESSION['adminname'] ;?>"  id="fullName" required>
                    </div>
                    <div class="form-group">
                        <label for="adminphone">Phone Number</label>
                        <input type="text" class="form-control"name="adminphone"value="<?php echo $_SESSION['adminphone'] ;?>"  id="adminphone"required>
                    </div>
                    <div class="form-group">
                        <label for="adminemail">Email</label>
                        <input type="email" class="form-control"name="adminemail"value="<?php echo $_SESSION['adminemail'] ;?>"  id="email" required>
                    </div>
                    <!-- Add more fields as needed -->
                    <button type="submit" class="btn btn-primary" name="profileadmin">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_POST['profileadmin'])&& isset($_SESSION['adminid']))
{
    $fname=$_POST['adminname'];
    $adminemail=$_POST['adminemail'];
    $adminphone=(int)$_POST['adminphone'];
    if (preg_match("/^\d{10}$/", $adminphone))
    {
        if($fname !==$_SESSION['adminname'] || $adminemail !==$_SESSION['adminemail'] || $adminphone!==$_SESSION['adminphone'] ){
            mysqli_begin_transaction($con);
            try{
                $adminid=$_SESSION['adminid'];
                $mainquery=mysqli_query($con,"UPDATE `admin` SET `name`='$fname',`email`='$adminemail',`phone`='$adminphone' WHERE adminid='$adminid'");
                $_SESSION['adminname']=$fname;
                $_SESSION['adminemail']=$adminemail;
                $_SESSION['adminphone']=$adminphone;
                mysqli_commit($con);
                alerting('Profile Updated Successfully.');
                redirect('dashboard.php');
            }catch(Exception $e){
                mysqli_rollback($con);
                alerting('Cannot Update Profile Try later.');
                redirect('dashboard.php');
            }
        }
    }else{
        alerting('Enter an valid phone no.');
        redirect('dashboard.php');
    }

}
if(isset($_POST['changepassword']) && isset($_SESSION['adminid']))
{
include("database.php");
$inputpass=$_POST['currentPassword'];
$newpass=$_POST['newPassword'];
$cpass=$_POST['confirmPassword'];
$id=(int)$_SESSION['adminid'];


$result=mysqli_query($con,"SELECT * FROM admin where adminid='$id'");
    $check=mysqli_fetch_array($result);
    $username=$check['admin_name'];
    $hashedPasswordFromDatabase = $check['adminpassword'];

    if($inputpass===$hashedPasswordFromDatabase)
    {
        if($cpass===$newpass)
        {    
            $input="UPDATE admin SET adminpassword='$newpass'where adminid='$id' ";
            mysqli_query($con,$input);
            redirect('dashboard.php');
            exit();
        }
        else
        {
            echo"<script> alert('Password doesnot match');</script>";
            redirect('dashboard.php');
            exit();
        }
    }
    else
    {
        echo"<script> alert('Invalid Password');</script>";
            redirect('dashboard.php');
        exit();
    }

}
?>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script>
    $("#sidebarToggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>

</body>

</html>