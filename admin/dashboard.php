<?php
include("admin.php");
include("database.php");
?>

<head>
    <style>
        .container-fluid{
            width: 100%;
            margin: 5px 10px 40px 5px;
            text-align: center;
        }
        .row{
        display: flex;
        justify-content: space-around;
        margin-top: 10px;
        align-items: center;
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
            justify-content: center;
            align-items: center;
            font-family: Georgia, 'Times New Roman', Times, serif;
        }
        
        .container-fluid p {
            display: flex;
            font-size:40px;
            text-shadow: 5px 5px 5px rgba(0, 0, 0, 0.5);
            align-items: center; /* Center vertically */
            justify-content: center; /* Center horizontally */
            font-family: Georgia, 'Times New Roman', Times, serif;
        }
        
        .container-fluid h5{
            font-family: Georgia, 'Times New Roman', Times, serif;
            align-items: center; /* Center vertically */
            justify-content: center; /* Center horizontally */
            text-align: center; 

        }
        .r1{
            background-color: red;
            color: white;
            display: flex;
            justify-content: center;
        }
        .r2{
            background-color: #22beef;
            color: white;
            display: flex;
            justify-content: center;
        }
        .r3{
            background-color: #a2d200;
            color: white;
            display: flex;
            justify-content: center;
        } 
       .r4{
            background-color: blue;
            color: white;
            display: flex;
            justify-content: center;
        }
        .r5{
            background-color: brown;
            color: white;
            display: flex;
            justify-content: center;
        }
        .r6{
            background-color: blueviolet;
            color: white;
            display: flex;
            justify-content: center;
        }
    </style>
</head>
    <div class="container-fluid">
        <h1>Welcome to admin panel - <?php echo $_SESSION['adminname']; ?></h1>

        <div class="row">
            <div class="r1 col-lg-3">
                <?php
                   $u=mysqli_query($con,'SELECT COUNT(id) AS usercount FROM users');
                   if($u){
                    $row = mysqli_fetch_array($u)
                ?>
                <p class="text-white"><?php echo $row['usercount']; ?></p>
                
                <h2>User</h2>
                <?php
                    }else{
                        echo "<script>alert('cannot run query..');</script>";
                    }
                ?>
            </div>
            <div class="r2 col-lg-3">
                <?php
                $ub=mysqli_query($con,'SELECT COUNT(hotel_id) AS totalhotel FROM hotels ');
                if($ub){
                 $row = mysqli_fetch_array($ub)
                ?>
                <p class="text-white"><?php echo $row['totalhotel']; ?></p>
                <h2>Hotels </h2>
                <?php
                    }else{
                        echo "<script>alert('cannot run query..');</script>";
                    }                    
                ?>
            </div>
            <div class="r3 col-lg-3"> 
                <?php
                $ub1=mysqli_query($con,'SELECT COUNT(packages_id) AS totalpackage FROM package ');
                if($ub1){
                 $row = mysqli_fetch_array($ub1)
                ?>
                <p class="text-white"><?php echo $row['totalpackage']; ?></p>
                <h2>Packages</h2>
                <?php
                    }else{
                        echo "<script>alert('cannot run query..');</script>";
                    }
                ?>           
            </div>
        </div>
    </div>


    <div class="container-fluid">
        <div class="row">
            <div class="r4 col-lg-3">
                <?php
                   $u4=mysqli_query($con,"SELECT COUNT(booking_id) AS totalbooking  FROM booking  ");
                   $u3=mysqli_query($con,"SELECT COUNT(action) AS cancel FROM booking WHERE action='cancel'");
                   $u2=mysqli_query($con,"SELECT SUM(totalprice) AS revenue FROM booking WHERE action='booked'");
                   if($u4){
                    $row4 = mysqli_fetch_array($u4)
                ?>
                <h2>Total Booking</h2>
                <p class="text-white"><?php echo $row4['totalbooking']; ?></p>
                <?php
                    }else{
                        echo "<script>alert('cannot run query..');</script>";
                    }
                    if($u3){
                        $row3 = mysqli_fetch_array($u3)
                       
                   ?>
                   <h5 class="text-white">Cancel:<?php echo $row3['cancel']; ?></h5>
                   <?php
                       }else{
                           echo "<script>alert('cannot run query..');</script>";
                       }
                    if($u2){
                        $row2 = mysqli_fetch_array($u2)
                ?>
                <h5 class="text-white">Rs <?php
                    if($row2['revenue']==NULL){
                            echo  0;
                        }else{
                        echo $row2['revenue'];
                        } ?></h5>
                <?php
                    }else{
                        echo "<script>alert('cannot run query..');</script>";
                    }
                ?>
            </div>
            <div class="r5 col-lg-3">
                <?php
                $hb=mysqli_query($con,"SELECT COUNT(hotel_id) AS book FROM booking WHERE packages_id IS  NULL ");
                $hb1=mysqli_query($con,"SELECT COUNT(action) AS cancel FROM booking WHERE  action='cancel' AND packages_id IS  NULL ");
                $hb2=mysqli_query($con,"SELECT SUM(totalprice) AS revenue FROM booking WHERE action='booked' AND packages_id IS  NULL ");
                if($hb){
                 $rowhb = mysqli_fetch_array($hb)
                ?>
                <h2>Hotel Booking</h2>
                <p class="text-white"><?php echo $rowhb['book']; ?></p>
                <?php
                    }else{
                        echo "<script>alert('cannot run query..');</script>";
                    }
                    if($hb1){
                     $rowhb1 = mysqli_fetch_array($hb1)
                    
                ?>
                <h5 class="text-white">Cancel:<?php echo $rowhb1['cancel']; ?></h5>
                <?php
                    }else{
                        echo "<script>alert('cannot run query..');</script>";
                    }
                    if($hb2){
                     $rowhb2 = mysqli_fetch_array($hb2)
                ?>
                <h5 class="text-white">Rs <?php
                    if($rowhb2['revenue']==NULL){
                            echo  0;
                        }else{
                        echo $rowhb2['revenue'];
                        } ?></h5>
                <?php
            }else{
                echo "<script>alert('cannot run query..');</script>";
            }
        ?>
            </div>
            <div class="r6 col-lg-3"> 
                <?php
                $pk=mysqli_query($con,"SELECT COUNT(packages_id) AS book FROM booking WHERE packages_id IS NOT NULL  ");
                $pk1=mysqli_query($con,"SELECT COUNT(action) AS cancel FROM booking WHERE  action='cancel' AND packages_id IS NOT NULL ");
                $pk2=mysqli_query($con,"SELECT SUM(totalprice) AS revenue FROM booking WHERE action='booked' AND packages_id IS NOT NULL ");
                if($pk){
                 $rowpk = mysqli_fetch_array($pk)
                ?>
                <h2>Packages Booking</h2>
                <p class="text-white"><?php echo $rowpk['book']; ?></p>
                <?php
                    }else{
                        echo "<script>alert('cannot run query..');</script>";
                    }
                    if($pk1){
                     $rowpk1 = mysqli_fetch_array($pk1)
                    
                ?>
                <h5 class="text-white">Cancel:<?php echo $rowpk1['cancel']; ?></h5>
                <?php
                    }else{
                        echo "<script>alert('cannot run query..');</script>";
                    }
                    if($pk2){
                     $rowpk2 = mysqli_fetch_array($pk2)
                ?>
                <h5 class="text-white">Rs <?php echo $rowpk2['revenue']; ?></h5>
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
