<?php
include("database.php");
include("admin.php");

$error="";
$msg="";
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$itemsPerPage = 3;
$offset = ($page - 1) * $itemsPerPage;

if(isset($_POST['cancel']))
{
 $id = $_POST['temp_id'];
 $query = mysqli_query($con,"UPDATE temp_hotel SET h_action='Cancelled' WHERE temp_id='$id'");
 if ($query) {
     $msg="Hotel is Cancelled..";
 } else {
     $error="Cannot run query..";
 }
}

// Check if the toggle status form is submitted
if (isset($_POST['toggle_status'])) {

     $temp_id = $_POST['temp_id'];
     $new_status = $_POST['toggle_status'];
     
     $result="SELECT * FROM temp_hotel WHERE temp_id='$temp_id'";
     $connection=mysqli_query($con,$result);

     if($connection)
     {
         $row=mysqli_fetch_array($connection);
         
         $name = mysqli_real_escape_string($con,$row['name']);
         $price = (int)$row['price'];
         $rating =(int) $row['rating'];
         $room = (int)$row['room'];
         $email=$row['email'];
         $status =$row['status'];
         $image =$row['image'];
         $map =$row['hotel_map'];
         $description = mysqli_real_escape_string($con,$row['description']);
         $location = mysqli_real_escape_string($con, $row['hotel_location']);

         $query1 = mysqli_query($con, "SELECT * FROM hotels WHERE email='$email'");

         if(mysqli_num_rows($query1) > 0) {
             mysqli_begin_transaction($con);
             try{
                 $query = "UPDATE `hotels` SET `location`='$location', `image`='$image', `description`='$description', `price`='$price', `status`='$status', `name`='$name', `room`='$room', `map`='$map', `rating`='$rating' WHERE email='$email'";
                 $process = mysqli_query($con, $query);
                 if($process) {
                     $query = mysqli_query($con, "UPDATE temp_hotel SET h_action='Approved' WHERE temp_id='$temp_id'");
                     if ($query) {
                         $msg = "Hotel is Approved..";
                     } else {
                         $error = "Cannot run query..";
                     }
                 } else {
                     $error = "Cannot run query..";
                 }
                 mysqli_commit($con);
                 $msg = "Hotel is Approved..";

             }catch(Exception $e){
                 mysqli_rollback($con);
                 $error = "Cannot Update hotel try later.";
             }
         } else {
             mysqli_begin_transaction($con);
             try{
                 // Hotel doesn't exist, insert a new entry
                 $query = "INSERT INTO `hotels` (`location`, `image`, `description`, `price`, `status`, `email`, `name`, `rating`, `room`, `map`) VALUES ('$location', '$image', '$description', '$price', '$status', '$email', '$name', '$rating', '$room', '$map')";
                 $process = mysqli_query($con, $query);
                 if($process) {
                     $query = mysqli_query($con, "UPDATE temp_hotel SET h_action='Approved' WHERE temp_id='$temp_id'");
                     if ($query) {
                         $msg = "Hotel is Approved..";
                     } else {
                         $error = "Cannot run query..";
                     }
                 } else {
                     $error = "Cannot run query..";
                 }
                 mysqli_commit($con);
                 
                 $msg = "Hotel is Approved..";
             }catch(Exception $e){ 
                    mysqli_rollback($con);

                 $error = "Cannot Update hotel try later.";
             }

         }

     }
     else
     {
         $error="Cannot run query..";
     }    
}


$query = "SELECT * FROM temp_hotel WHERE h_action  <> 'Cancelled' ORDER BY (h_action <> 'approved') DESC  LIMIT ? OFFSET ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, 'ii', $itemsPerPage, $offset);
mysqli_stmt_execute($stmt);
$allimg = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html>
    <head>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

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
#hotelcrud{
    display: flex;    
    flex-direction: column;
}
#hotelcrud button{
    width:70px;
}
.c .container-fluid {
    width: 100%;
    display: flex;
    justify-content: center;
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
                <th style="width:80px;">Name</th>
                <th style="width:80px;">Location</th>
                <th>Image</th>
                <th style="width:50px;">price</th>
                <th style="width:50px;">Email</th>
                <th style="width:300px;">Description</th>
                <th style="width:50px;">rating</th>
                <th style="width:50px;">Room</th>
                <th>Action</th>
            </tr>
            <?php
            $sn = ($page - 1) * $itemsPerPage + 1;
             while ($row = mysqli_fetch_array($allimg)) { ?>
            <tr>
            <td><?php  echo $sn; ?></td>
                <td><?php  echo $row["name"]; ?></td>
                <td><?php  echo $row["hotel_location"]; ?></td>
                <td><img src="../hotelowner/<?php  echo $row['image']; ?>" alt=""></td>
                <td><?php  echo $row["price"]; ?></td>
                <td><?php  echo $row["email"]; ?></td>
                <td><?php  echo $row["description"]; ?></td>
                <td><?php  echo $row["rating"]; ?></td>
                <td><?php  echo $row["room"]; ?></td>
                <td>
                    <?php
                    if($row["h_action"] === 'pending'){
                        ?>                        
                    <form method="POST" id="hotelcrud" action="">
                        <input type="hidden" name="temp_id" value="<?php echo $row['temp_id']; ?>">                      
                        <button class="btn btn-primary mb-2" type="submit" name="toggle_status" value="Approved"><?php echo $row['h_action'];?></button>
                        <button class="btn btn-danger" type="submit" name="cancel">Cancel</button>
                    </form>
    <?php
                    }else{
                    ?>
                        <form method="POST" id="hotelcrud" action="edithotel.php">
                            <input type="hidden" name="delete_id" value="<?php echo $row['temp_id']; ?>">
                            <button class="btn btn-primary mb-2" type="submit" name="edithotel">Edit</button>
                            <button class="btn btn-danger" type="submit" name="deletehotel">Delete</button>
                        </form>
                    </td>

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
            function hotelinputpop(hotelinput) {
                var get_hotelinputpop = document.getElementById(hotelinput);
                if (get_hotelinputpop.style.display === "flex") {
                    get_hotelinputpop.style.display = "none";
                } else {
                    get_hotelinputpop.style.display = "flex";
                }
            }
        $(document).ready(function(){
            var page = <?php echo $page; ?>;
            var totalPages = <?php echo ceil(mysqli_num_rows(mysqli_query($con, 'SELECT * FROM hotels')) / 3); ?>;

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
