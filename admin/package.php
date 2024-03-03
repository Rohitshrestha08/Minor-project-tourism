<?php
include("database.php");
include("admin.php");

$error="";
$msg="";
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$itemsPerPage = 3;
$offset = ($page - 1) * $itemsPerPage;
// Check if the toggle status form is submitted
if (isset($_POST['toggle_status'])) {
    try {
        $packages_id = $_POST['packages_id'];
        $new_status = $_POST['toggle_status'];
        
        $result="SELECT * FROM temp_package WHERE packages_id='$packages_id'";
        $connection=mysqli_query($con,$result);

        if($connection)
        {
            $row=mysqli_fetch_array($connection);
            
            $name = mysqli_real_escape_string($con,$row['name']);
            $price = (int)$row['price'];
            $created_at =$row['created_at'];
            $updated_at =$row['updated_at'];
            $hotel_id =$row['hotel_id'];
            $duration = (int)$row['duration'];
            $map = $row['map'];
            $description =$row['description'];
            $location = mysqli_real_escape_string($con,$row['location'] );
            $email=$row['email'];
            $status =$row['packstatus'];
            $image =$row['image'];

            $query1=mysqli_query($con,"SELECT * FROM package WHERE map='$map'AND image='$image' AND name='$name'");
            if($query1)
            {
                if(mysqli_num_rows($query1)>0){
                    $query="UPDATE `package` SET `hotel_id`='$hotel_id',`description`='$description',`price`='$price',`location`='$location',
                    `packstatus`='$status',`image`='$image',`duration`='$duration',`created_at`='$created_at',`updated_at`='$updated_at' WHERE map='$map' AND name='$name'";
                    $process=mysqli_query($con,$query);
                   if($process)
                   {
                       $query = mysqli_query($con,"UPDATE temp_package SET action='Approved' WHERE packages_id='$packages_id'");
                       if ($query) {
                           $msg="package is Approved..";           
                       } else {
                           $error="Cannot run query..";
                       }
                   }
                   else{
                       $error="Cannot run query..";
                   }

                }
                else{
                    $query="INSERT INTO `package`(`name`, `hotel_id`, `description`, `price`, `location`, `packstatus`, `image`, `duration`, `map`,`email`, `created_at`, `updated_at`)
                    VALUES ('$name','$hotel_id','$description','$price','$location','$status','$image','$duration','$map','$email','$created_at','$updated_at')";
                   $process=mysqli_query($con,$query);
                   if($process)
                   {
                       $query = mysqli_query($con,"UPDATE temp_package SET action='Approved' WHERE packages_id='$packages_id'");
                       if ($query) {
                           $msg="package is Approved..";           
                       } else {
                           $error="Cannot run query..";
                       }
                   }
                   else{
                       $error="Cannot run query..";
                   }
                }
            }


        }
        else
        {
            $error="Cannot run query..";
        }
    } catch (mysqli_sql_exception $e) {
        $error = "Database error: " . $e->getMessage();
    }
    
}
// Fetch package for the current page
$query = "SELECT * FROM temp_package WHERE action <> 'Cancelled' ORDER BY (action <> 'approved') DESC LIMIT ? OFFSET ?";

$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, 'ii', $itemsPerPage, $offset);
mysqli_stmt_execute($stmt);
$allimg = mysqli_stmt_get_result($stmt);
?>
   <?php
   if(isset($_POST['delete']))
{
    $id = $_POST['packages_id'];
    $query = mysqli_query($con,"UPDATE temp_package SET action='Cancelled' WHERE packages_id='$id'");
    if ($query) {
        $msg="package is Cancelled..";
    } else {
        $error="Cannot run query..";
    }
}
    
    ?>

<!DOCTYPE html>
<html>
    <head>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" />

<style>
section .c {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    height: 100vh;
    margin: 0;
}
#addbtn{
    width:100%;
    margin:5px 0;
}
#addbtn button{
    float:right;
    display: flex;
    align-items: flex-end;

}

#packageinput {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 500px;
    max-width: 90%; /* Adjust maximum width as needed */
    padding: 20px;
    background-color: #f0f0f0;
    border-radius: 10px;
    box-shadow: 2px 2px 5px rgb(0, 0, 0.2);
    z-index: 1000;
}

#packageinput form {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: space-between;
}

.info {
    width: 40%;
    margin:2px 10px;
}
.info select{
    height:40px;
}
.infod textarea {
    width: 100%; /* Set the width to 100% */
    max-width: 100%; /* Set the maximum width to 100% */
    resize: vertical; /* Allow vertical resizing */
    font-size:15px;
}

.c .container-fluid {
    width: 100%;
    display: flex;
    justify-content: center;
}

form hr {
    width: 100%;
    margin-top: 10px;
    margin-bottom: 10px;
}

.info_btn {
    display: flex;
    justify-content: flex-end;
    gap: 5px;
}
form .statusbtn{
    width:70px;
}

#packagecrud{
    display: flex;    
    flex-direction: column;
}
#packagecrud button{
    width:90px;
}
#prevNext {
    margin-top: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}
#prevNext button {
    margin: 10px;
    outline:none;
    height:40px;
    width:60px;
    background-color:black;
    color:white;
    border:none;
    padding: 5px;
    border-radius:5px;
    cursor: pointer;
}

table {
    margin-top: 10px;
    width: 100%;
    border-collapse: collapse;
}
tr:nth-child(even){
            background-color: #e8f5fe;
         }
th, td {
    padding: 4px;
    text-align: left;
}
th {
    background-color: black;
    color: white;
    height: 50px;
}
img{
    width:200px;
    height:150px;
}


</style>
</head>
<body>
    <section class="c">
        
		 <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
        <div class="container-fluid">
        <table>
            <tr>
                <th>SN</th>
                <th >Name</th>
                <th>Image</th>
                <th >Location</th>
                <th >price</th>
                <th style="width:400px;">Description</th>
                <th>Action</th>
            </tr>
            <?php
            $sn = ($page - 1) * $itemsPerPage + 1;
             while ($row = mysqli_fetch_array($allimg)) { ?>
            <tr>
            <td><?php  echo $sn; ?></td>
                <td><?php  echo $row["name"]; ?></td>
                <td><img src="../hotelowner/<?php  echo $row['image']; ?>" alt=""></td>
                <td><?php  echo $row["location"]; ?></td>
                <td><?php  echo $row["price"]; ?></td>
                <td><?php $ro=mysqli_real_escape_string($con,$row['description'] );
                echo $ro; ?></td>
                <td>
                    <?php
                    if($row["action"] === 'pending'){
                        ?>                        
                    <form method="POST" method="" id="packagecrud">
                        <input type="hidden" name="packages_id" value="<?php echo $row['packages_id'];?>">                      
                        <button class="btn btn-primary mb-4" type="submit" name="toggle_status" value="Approved"><?php echo $row['action'];?></button>
                        <button class="btn btn-danger" type="submit" name="delete">Cancel</button>
                    </form>
    <!-- <?php
                    // }else if($row["action"] === 'Cancelled'){
                    ?>
                    <form method="POST" id="packagecrud">
                        <input type="hidden" name="delete_id" value="<?php echo $row['packages_id']; ?>">
                        <button class="btn btn-danger "><?php echo $row['action'];?></button>
                    </form> -->
                    <?php }else{?>
                    <form method="POST" id="packagecrud">
                        <input type="hidden" name="delete_id" value="<?php echo $row['packages_id']; ?>">
                        <button class="btn btn-primary"><?php echo $row['action'];?></button>
                    </form>
                    <?php } ?>
                </td>
            </tr>
            <?php 
            $sn++;
         } ?>
        </table>
    </div>
    <div id="prevNext">
        <button id="prevBtn">Prev</button>
        <button id="nextBtn">Next</button>
    </div>
        </section>
    <script>
            function packageinputpop(packageinput) {
                var get_packageinputpop = document.getElementById(packageinput);
                if (get_packageinputpop.style.display === "flex") {
                    get_packageinputpop.style.display = "none";
                } else {
                    get_packageinputpop.style.display = "flex";
                }
            }
        $(document).ready(function(){
            var page = <?php echo $page; ?>;
            var totalPages = <?php echo ceil(mysqli_num_rows(mysqli_query($con, 'SELECT * FROM package')) / 3); ?>;

            $('#prevBtn').on('click', function(){
                if (page > 1) {
                    window.location.href = '?page=' + (page - 1);
                }
            });

            $('#nextBtn').on('click', function(){
                if (page < totalPages) {
                    window.location.href = '?page=' + (page + 1);
                }
            });
         });
   </script>


    </body>
</html>

<?php

?>
