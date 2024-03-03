<?php
include("hotelowner.php");
include("database.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <style>
        .container-fluid{
            width: 100%;
            margin: 5px 10px 0 5px;
        }
        .row{
        display: flex;
        justify-content: space-around;
        margin-top: 10px;
        align-items: center;
        }
        .r1{
            background-color:#22beef ;
            color: white;
        }
        .r2{
            background-color:blueviolet ;
            color: white;
        }
        .r3{
            background-color: #a2d200;
            color: white;
        }
        .col-lg-3{
            display:flex;
            box-shadow: 2px 2px 5px rgb(0,0,0.1);
            flex-direction: column;
            height: 200px;
        }
        
        .container-fluid h1{
            margin:30px 0;
            font-family: serif;
        }
        
        .container-fluid h2{
            display: flex;
            font-family: Georgia, 'Times New Roman', Times, serif;
        }
        
        .container-fluid p {
            display: flex;
            font-size:50px;
            text-shadow: 5px 5px 5px rgba(0, 0, 0, 0.5);
            align-items: center; /* Center vertically */
            justify-content: center; /* Center horizontally */
            text-align: center; 
            font-family: Georgia, 'Times New Roman', Times, serif;
        }
        
        .container-fluid h5{
            font-family: Georgia, 'Times New Roman', Times, serif;
            align-items: center; /* Center vertically */
            justify-content: center; /* Center horizontally */
            text-align: center; 

        }
    </style>
</head>
<body>
    <div class="container-fluid mt-4">
        <h1>Welcome <?php echo $_SESSION['hotelownername']; ?></h1>
        <div class="row">
            <div class="r1 col-lg-3">
                <?php
                   $owneremail=$_SESSION['hotelowneremail']; 
                   $q=mysqli_query($con,"SELECT * FROM hotels WHERE email='$owneremail' ");
                   if(mysqli_num_rows($q)>0){
                   $fq=mysqli_fetch_array($q);
                    $id=$fq['hotel_id'];   
                }else{
                    $id=0;
                }           
                   $u=mysqli_query($con,"SELECT COUNT(booking_id) AS totalbooking  FROM booking WHERE hotel_id='$id' ");
                   $u1=mysqli_query($con,"SELECT COUNT(action) AS cancel FROM booking WHERE hotel_id='$id' AND action='cancel'");
                   $u2=mysqli_query($con,"SELECT SUM(totalprice) AS revenue FROM booking WHERE hotel_id='$id' AND action='booked'");
 
                    // Check if the query executed successfully and returned rows
                    if ($u && mysqli_num_rows($u) > 0) {
                        $row = mysqli_fetch_array($u);
                        ?>
                        <h2>Total Booking</h2>
                        <p class="text-white"><?php echo $row['totalbooking']; ?></p>
                        <?php
                    } else {
                        ?>
                        <h2>Total Booking</h2>
                        <p class="text-white">0</p>
                        <?php
                    }
                    if($u1 && mysqli_num_rows($u1) > 0){
                        $row = mysqli_fetch_array($u1)
                       
                   ?>
                   <h5 class="text-white">Cancel:<?php echo $row['cancel']; ?></h5>
                   <?php
                       }else{
                           echo "<script>alert('cannot run query..');</script>";
                       }
                    if($u2 && mysqli_num_rows($u2) > 0){
                        $row = mysqli_fetch_array($u2)
                ?>
                <h5 class="text-white">Rs <?php
                    if($row['revenue']==NULL){
                            echo  0;
                        }else{
                        echo (int)$row['revenue'];
                        } ?></h5>
                <?php
                    }else{
                        echo "<script>alert('cannot run query..');</script>";
                    }
                ?>
            </div>
            <div class="r2 col-lg-3">
                <?php
                $ub=mysqli_query($con,"SELECT COUNT(hotel_id) AS book FROM booking WHERE hotel_id='$id' AND packages_id IS  NULL ");
                $ub1=mysqli_query($con,"SELECT COUNT(action) AS cancel FROM booking WHERE hotel_id='$id' AND action='cancel' AND packages_id IS  NULL ");
                $ub2=mysqli_query($con,"SELECT SUM(totalprice) AS revenue FROM booking WHERE hotel_id='$id'AND action='booked' AND packages_id IS  NULL ");
                if($ub && mysqli_num_rows($ub) > 0){
                 $row = mysqli_fetch_array($ub)
                ?>
                <h2>Hotel Booking</h2>
                <p class="text-white"><?php echo $row['book']; ?></p>
                <?php
                    }else{
                        echo "<script>alert('cannot run query..');</script>";
                    }
                    if($ub1 && mysqli_num_rows($ub1) > 0){
                     $row = mysqli_fetch_array($ub1)
                    
                ?>
                <h5 class="text-white">Cancel:<?php echo $row['cancel']; ?></h5>
                <?php
                    }else{
                        echo "<script>alert('cannot run query..');</script>";
                    }
                    if($ub2 && mysqli_num_rows($ub2) > 0){
                     $row = mysqli_fetch_array($ub2)
                ?>
                <h5 class="text-white">Rs <?php
                    if($row['revenue']==NULL){
                            echo  0;
                        }else{
                        echo (int)$row['revenue'];
                        } ?></h5>
                <?php
                    }else{
                        echo "<script>alert('cannot run query..');</script>";
                    }
                ?>
            </div>
            <div class="r3 col-lg-3"> 
                <?php
                $ub3=mysqli_query($con,"SELECT COUNT(packages_id) AS book FROM booking WHERE hotel_id='$id'");
                $ub4=mysqli_query($con,"SELECT COUNT(action) AS cancel FROM booking WHERE hotel_id='$id' AND action='cancel' AND packages_id IS NOT NULL ");
                $ub5=mysqli_query($con,"SELECT SUM(totalprice) AS revenue FROM booking WHERE hotel_id='$id' AND action='booked' AND packages_id IS NOT NULL ");
                if($ub3 && mysqli_num_rows($ub3) > 0){
                    $row = mysqli_fetch_array($ub3)
                   ?>
                   <h2>Packages Booking</h2>
                   <p class="text-white"><?php echo $row['book']; ?></p>
                   <?php
                       }else{
                           echo "<script>alert('cannot run query..');</script>";
                       }
                       if($ub4 && mysqli_num_rows($ub4) > 0){
                        $row = mysqli_fetch_array($ub4)
                       
                   ?>
                <h5 class="text-white">Cancel:<?php echo $row['cancel']; ?></h5>
                <?php
                    }else{
                        echo "<script>alert('cannot run query..');</script>";
                    }
                    if($ub5 && mysqli_num_rows($ub5) > 0){
                     $row = mysqli_fetch_array($ub5)
                ?>
                <h5 class="text-white">Rs <?php
                    if($row['revenue']==NULL){
                            echo  0;
                        }else{
                        echo (int)$row['revenue'];
                        } ?></h5>
                <?php
                    }else{
                        echo "<script>alert('cannot run query..');</script>";
                    }
                ?>
           
            </div>
        </div>
    </div>
</body>
</html>
