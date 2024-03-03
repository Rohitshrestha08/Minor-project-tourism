<?php
session_start();

if (!isset($_SESSION['hotelownerid'])) {
    header("Location: hotelownerlogin.php"); 
    exit();
}
include("database.php");
include("../admin/function.php");
$id=$_SESSION['hotelownerid'];
$query=mysqli_query($con,"SELECT * FROM hotelowner WHERE id='$id'");
$row=mysqli_fetch_array($query);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Hotel Owner</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

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
            <div class="sidebar-heading border-bottom bg-dark ">Hotel Owner</div>
            <div class="list-group list-group-flush">
                <a href="dashboard.php" class="list-group-item list-group-item-action text-white" id="dashboard-link">Dashboard</a>
                <a href="hotel.php" class="list-group-item list-group-item-action text-white" id="hotel-link">My Hotel</a>
                <a href="booking.php" class="list-group-item list-group-item-action text-white" id="booking-link">Booking</a>
                <a href="package.php" class="list-group-item list-group-item-action text-white" id="package-link">Package</a>

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
                                <?php echo $row['name']; ?>
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
                <form method="post" action="hotelowner.php">
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
                <form method="POST" action="" >
                    <!-- Include your form fields here -->
                    <div class="form-group">
                        <label for="fullName">Full Name</label>
                        <input type="text" class="form-control"name="fname" id="fullName" value="<?php echo $row['name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="e_mail" id="email"value="<?php echo $row['hotelowner_email']; ?>" required>
                    </div>
                    <!-- Add more fields as needed -->
                    <button type="submit" name="savechange" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if(isset($_POST['savechange'])){
    $name = $_POST['fname'];
    $email = $_POST['e_mail'];

    if($name !== $_SESSION['hotelownername'] || $email !== $_SESSION['hotelowneremail']) {
        mysqli_begin_transaction($con);
        try{
            $id = mysqli_real_escape_string($con, $_SESSION['hotelownerid']);
            $email = mysqli_real_escape_string($con, $email);
            $name = mysqli_real_escape_string($con, $name);

            $query1 = mysqli_prepare($con, "UPDATE hotelowner SET hotelowner_email=?, name=? WHERE id=?");
            mysqli_stmt_bind_param($query1, "ssi", $email, $name, $id);
            mysqli_stmt_execute($query1);
            mysqli_stmt_close($query1);

            $query2 = mysqli_prepare($con, "UPDATE hotels SET email=? WHERE email=?");
            mysqli_stmt_bind_param($query2, "ss", $email, $_SESSION['hotelowneremail']);
            mysqli_stmt_execute($query2);
            mysqli_stmt_close($query2);

            $query3 = mysqli_prepare($con, "UPDATE temp_hotel SET email=? WHERE email=?");
            mysqli_stmt_bind_param($query3, "ss", $email, $_SESSION['hotelowneremail']);
            mysqli_stmt_execute($query3);
            mysqli_stmt_close($query3);

            $query4 = mysqli_prepare($con, "UPDATE package SET email=? WHERE email=?");
            mysqli_stmt_bind_param($query4, "ss", $email, $_SESSION['hotelowneremail']);
            mysqli_stmt_execute($query4);
            mysqli_stmt_close($query4);

            $query5 = mysqli_prepare($con, "UPDATE temp_package SET email=? WHERE email=?");
            mysqli_stmt_bind_param($query5, "ss", $email, $_SESSION['hotelowneremail']);
            mysqli_stmt_execute($query5);
            mysqli_stmt_close($query5);

            $_SESSION['hotelowneremail']=$email;
            $_SESSION['hotelownername'] = $name;
            mysqli_commit($con);
            echo "<script> alert('Profile Updated successfully....');</script>";
            redirect('dashboard.php');
        } catch(Exception $e) {
            mysqli_rollback($con);
            echo "<script> alert('Failed to update hotel Details: " . $e->getMessage() . "');</script>";
            redirect('dashboard.php');
        }
    } else {
        echo "<script> alert('Same Fullname and Email Address..');</script>";
        redirect('dashboard.php');
    }
}

if(isset($_POST['changepassword']) && isset($_SESSION['hotelownerid']))
{
include("database.php");
$inputpass=$_POST['currentPassword'];
$newpass=$_POST['newPassword'];
$cpass=$_POST['confirmPassword'];
$id=(int)$_SESSION['hotelownerid'];


$result=mysqli_query($con,"SELECT * FROM hotelowner where id='$id'");
    $check=mysqli_fetch_array($result);
    $hashedPasswordFromDatabase = $check['pass'];

    if(password_verify($inputpass,$hashedPasswordFromDatabase))
    {
        if($cpass===$newpass)
        {   
             $p=password_hash($newpass,PASSWORD_DEFAULT);
            $input="UPDATE hotelowner SET pass='$p' WHERE id='$id' ";
            mysqli_query($con,$input);
            echo"<script> alert('Password Changed successfully..');</script>";
            redirect('dashboard.php');
        }
        else
        {
            echo"<script> alert('Password doesnot match');</script>";
            redirect('dashboard.php');
        }
    }
    else
    {
        echo"<script> alert('Invalid Password');</script>";
        redirect('dashboard.php');
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