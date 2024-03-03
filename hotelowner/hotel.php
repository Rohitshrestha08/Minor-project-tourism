<?php
include("database.php");
include("hotelowner.php");

$directory = 'temimages/';
$error="";
$msg="";

if (!is_dir($directory)) {
    if (!mkdir($directory, 0777, true)) {
        die('Failed to create directory.');
    }
}


$query = "SELECT * FROM temp_hotel WHERE email='" . $_SESSION['hotelowneremail'] . "'";
$allimg = mysqli_query($con, $query);
?>
<?php
if (isset($_POST["submit"])) {
     //Escape user inputs to prevent SQL injection
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $price = (int)$_POST['price'];
    $rating = (int)$_POST['rating'];
    $room = (int)$_POST['room'];
    $status = $_POST['status'];
    $map = $_POST['map'];
    $action="pending";
    $email=$_SESSION['hotelowneremail'];
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $location = mysqli_real_escape_string($con, $_POST['location']);
    date_default_timezone_set("Asia/Kathmandu");
    $create_date = date('Y-m-d');

    // File upload handling
    $target_dir = "temimages/";
    $filename = basename($_FILES["fileToUpload"]["name"]);
    $target_file = $target_dir . $filename;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is an actual image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check === false) {
        $error = "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size (you can adjust the size as needed)
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        $error = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow only certain file formats (you can add more if needed)
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check for valid rating (upto 5)
    if ($rating > 5) {
        $error = "Sorry, rating should be up to 5.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $error = "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // If all checks pass, insert into database and move uploaded file
    if ($uploadOk) {
            // Start a transaction
        mysqli_begin_transaction($con);
        
        try {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $insertQuery =mysqli_query($con, "INSERT INTO `temp_hotel`(`name`,`email`, `rating`, `room`, `hotel_map`, `hotel_location`, `image`, `description`, `price`,`status`,`h_action`) 
                    VALUES ('$name','$email', '$rating', '$room', '$map', '$location', '$target_file', '$description', '$price', '$status','$action')");
                                $insertQuery2=mysqli_query($con,"INSERT INTO `notification`(`nFrom`, `ntype`, `message`, `date`)
                                 VALUES ('$name','Hotel','Request For Adding New Hotel','$create_date')");
                if ($insertQuery && $insertQuery2) {
                    $msg = "Hotel information uploaded successfully.";
                } else {
                    $error = "Error: " . mysqli_error($con);
                }
            } else {
                $error = "Sorry, there was an error uploading your file.";
            }      
          mysqli_commit($con);
    
        $msg = "Hotel updated successfully.";
    
    } catch (Exception $e) {
        mysqli_rollback($con);
    
        $error = "Failed to update hotel : " . $e->getMessage();
    }
    }
}
?>
<?php
if (isset($_POST['toggle_status'])) {
    $temp_id = $_POST['temp_id'];
    $new_status = $_POST['toggle_status'];

    $info=mysqli_query($con,"SELECT * FROM temp_hotel WHERE temp_id='$temp_id'");
    $fetch=mysqli_fetch_array($info);
    $image=$fetch['image'];
    
    // Start a transaction
    mysqli_begin_transaction($con);
    
    try {
        $query1 = "UPDATE temp_hotel SET status = ? WHERE temp_id = ?";
        $stmt1 = mysqli_prepare($con, $query1);
        mysqli_stmt_bind_param($stmt1, 'si', $new_status, $temp_id);
        mysqli_stmt_execute($stmt1);
    
        $query2 = "UPDATE hotels SET status = ? WHERE image = ?";
        $stmt2 = mysqli_prepare($con, $query2);
        mysqli_stmt_bind_param($stmt2, 'ss', $new_status, $image);
        mysqli_stmt_execute($stmt2);
    
        mysqli_commit($con);
    
        $msg = "Hotel status updated successfully.";
    
    } catch (Exception $e) {
        mysqli_rollback($con);
    
        $error = "Failed to update hotel status: " . $e->getMessage();
    }
    

}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Hotel</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


    <style>
section .pack {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    position: relative;
    margin: 0;
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
#addbtn{
    width:100%;
    margin:5px 0;
}
#addbtn button{
    float:right;
    display: flex;
    align-items: flex-end;
}

#hotelinput {
    display: none;
    width: 90%;
    padding: 20px;
    background-color: #f0f0f0;
    border-radius: 10px;
    z-index: 1000;
}
#hoteldinput{
    display: flex;
    width: 90%;
    padding: 20px;
    background-color: #f0f0f0;
    border-radius: 10px;
}

.hotelinputform {
    display: flex;
    flex-wrap: wrap;
    flex-direction: column;
    margin-right: 45px;
    width: 100%;
    float: left;
    gap: 10px;
    justify-content: space-between;
}
.hotelinputform h1{
    color: blue;
}
.hotelinputform .topicpack{
    display: flex;
    flex-direction: row;
    justify-content: space-between;
}
.topicpack img{
    width: 200px;
    height:200px;
    object-fit: cover
}
.statusbtn{
    display: flex;
    flex-direction: column;
    align-items: center;
}
.statusbtn ul{
    display: flex;
    margin-top: 6px;
    flex-direction: row;
    gap: 3px;
}
.statusbtn li{
    list-style: none;
    font-size: larger;
    font-weight: 300;
}
.infohotel{
    display: flex;
    width: 100%;
    margin:30px 10px;
    font-size: 0.85em;
    font-weight: 300;
    font-size: larger;
}
.infohoteld{
    display: flex;
    width: 100%;
    margin:10px 10px;
    font-size: 0.75em;
    font-weight: 300;
    font-size: larger;
}
.infohoteld .field{
    border: 3px solid #edecec;
    padding: 5px 8px;
    color: #616161;
    width: 75%;
    font-size: 0.85em;
    font-weight: 300;
    height: 100px;
    outline: none;
    box-shadow: none !important;
}
.infohoteld h5,
.infohotel h5{
    width: 20%;
}
.infohotel .fieldfile{
    border: 3px solid #edecec;
    padding: 5px 8px;
    color: #616161;
    width: 80%;
    font-size: 0.85em;
    font-weight: 300;
    height: 40px;
    outline: none;
    box-shadow: none !important;
}
.infohotel .field{
    border: 3px solid #edecec;
    padding: 5px 8px;
    color: #616161;
    width: 75%;
    font-size: 0.85em;
    font-weight: 300;
    height: 40px;
    outline: none;
    box-shadow: none !important;
}
form hr {
    width: 100%;
    margin-top: 10px;
    margin-bottom: 10px;
    height:10px;
}
.infohotel_btn {
    display: flex;
    justify-content: flex-start;
    gap: 15px;
}

</style>
</head>
<body>
    <section class="c">
        
		 <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
                <?php
        if(mysqli_num_rows($allimg) == 0){ ?>
        <div class="float-right mb-3" id="addbtn">
            <button class="btn btn-dark" onclick="hotelinputpop('hotelinput')">Add</button>
        </div>
        <?php } ?>
        <div id="hotelinput">          
            <div class="hotelinputform">
                <h1>ADD Hotel</h1>
                <form action="" method="post" enctype="multipart/form-data">                    
                <hr>
                    <div class="infohotel">
                    <h5>Hotel Name:</h5>
                    <input type="text" class="field" name="name" id="name" placeholder="hotel Name" required>
                    </div>
                    <div class="infohotel">
                    <h5>Hotel Location:</h5>
                    <input type="text" class="field" name="location" id="location" placeholder="hotel Location" required>
                    </div>
                    <div class="infohotel">
                    <h5>Hotel Price :</h5>
                    <input type="text" class="field" name="price" id="price" placeholder="hotel Price In Rs" required>
                    </div>
                    <div class="infohotel">
                    <h5>Hotel Rating :</h5>
                    <input type="text" class="field" name="rating" id="rating" placeholder="hotel Rating" required>
                    </div>
                    <div class="infohotel">
                    <h5>Room :</h5>
                    <input type="text" class="field" name="room" id="room" placeholder="Number Of Room " required>
                    </div>
                    <div class="infohotel">
                    <h5>Hotel map:</h5>
                    <input type="text" class="field" name="map" id="map" placeholder="hotel Map Link" required>
                    </div>
                    <div class="infohotel">
                        <h5>hotel Status:</h5>
                        <select name="status" class="field" id="status"required>
                            <option value="">status</option>
                            <option value="on">ON</option>
                            <option value="off">OFF</option>
                        </select>
                    </div>
                    <div class="infohoteld" style="width:100%;">
                    <h5>Hotel Description:</h5>
                    <textarea name="description" class="field" id="description" rows="5" placeholder="Hotels Details"  required></textarea>
                    </div>
                    <div class="infohotel">
                        <h5>Hotel Image :</h5>
                        <input type="file" class="fieldfile" name="fileToUpload" id="fileToUpload"><br>
                    </div>
                    <hr>
                    <div class="infohotel_btn">
                        <button type="reset" value="cancel" class="btn btn-danger btn-sm-shadow" name="cancel" onclick="hotelinputpop('hotelinput')">cancel</button>
                        <button class="btn btn-success btn-sm-shadow" type="submit" value="submit" name="submit">Submit</button>
                    </div>
                </form> 
            </div>                   
        </div>
        <?php
        if(mysqli_num_rows($allimg) == 1){ 
             while ($row = mysqli_fetch_array($allimg))
        { ?>
        <div id="hoteldinput" class="mt-4">          
            <div class="hotelinputform">
                <div class="topicpack">
                <img src="<?php echo $row['image'];?>" alt="">
                <h1><?php echo $row['name'];?></h1>
                <?php if ($row["status"] == 'on') { ?>
                    <form method="POST" class="statusbtn" action="">
                            <?php if ($row["h_action"] == 'pending') { ?>
                                <input type="hidden" name="temp_id" value="<?php echo $row['temp_id']; ?>">
                                <button  class="btn btn-danger btn-sm-shadow" name="cancel">Pending</button>
                                <?php } else if($row["h_action"] == 'Cancelled'){ ?>
                                <input type="hidden" name="temp_id" value="<?php echo $row['temp_id']; ?>">
                                <button  class="btn btn-danger btn-sm-shadow">Cancelled</button>
                            <?php } else { ?>
                                <input type="hidden" name="temp_id" value="<?php echo $row['temp_id']; ?>">
                                <button  class="btn btn-success btn-sm-shadow">Approved</button>
                            <?php }?>
                        <ul>
                            <li>Status</li>
                            <button type="submit" name="toggle_status" value="off" class="btn btn-success">On</button>
                        </ul>
                    </form>
                <?php } else { ?>
                    <form method="POST" class="statusbtn" action="">
                            <?php if ($row["h_action"] == 'pending') { ?>
                                <input type="hidden" name="temp_id" value="<?php echo $row['temp_id']; ?>">
                                <button  class="btn btn-danger btn-sm-shadow" name="cancel">Pending</button>
                            <?php } else if($row["h_action"] == 'Cancelled'){ ?>
                                <input type="hidden" name="temp_id" value="<?php echo $row['temp_id']; ?>">
                                <button  class="btn btn-danger btn-sm-shadow">Cancelled</button>
                            <?php 
                        } else { ?>
                                <input type="hidden" name="temp_id" value="<?php echo $row['temp_id']; ?>">
                                <button  class="btn btn-success btn-sm-shadow">Approved</button>
                            <?php }?>
                        <ul>
                            <li>Status</li>
                            <button type="submit" name="toggle_status" value="on" class="btn btn-danger">Off</button>
                        </ul>
                    </form>
                <?php } ?>
                </div>
                <form action="updatehotel.php" method="post" name="delete_form">                    
                <hr>                   
                    <div class="infohotel">
                    <h5>Hotel Name:</h5>
                    <input type="text" class="field" name="name" id="name" placeholder="Hotel Name"value="<?php echo $row['name']; ?>"  readonly>
                    </div>
                    <div class="infohotel">
                    <h5>Hotel Location:</h5>
                    <input type="text" class="field" name="location" id="location" placeholder="Hotel Location"value="<?php echo $row['hotel_location']; ?>"  readonly>
                    </div>
                    <div class="infohotel">
                    <h5>Hotel Price :</h5>
                    <input type="text" class="field" name="price" id="price" placeholder="Price "value="<?php echo $row['price']; ?>"  readonly>
                    </div>
                    <div class="infohotel">
                    <h5>Hotel Rating :</h5>
                    <input type="text" class="field" name="rating" id="rating" placeholder="Hotel rating"value="<?php echo $row['rating']; ?>" readonly>
                    </div>
                    <div class="infohotel">
                    <h5>Room :</h5>
                    <input type="text" class="field" name="room" id="room" placeholder="Hotel room"value="<?php echo $row['room']; ?>" readonly>
                    </div>
                    <div class="infohoteld" style="width:100%;">
                    <h5>Hotel Description:</h5>
                    <textarea name="description" class="field" id="description" rows="5" placeholder="Hotels Details" readonly><?php echo $row['description']; ?></textarea>
                    </div>
                    <hr>
                    <div class="infohotel_btn">
                    <?php if ($row["h_action"] == 'pending') { ?>
                        <button type="reset" value="cancel" class="btn btn-danger btn-sm-shadow" name="cancel">cancel</button>
                        <?php } else { ?>
                        <input type="hidden" name="delete_id" value="<?php echo $row['temp_id']; ?>">
                        <button class="btn btn-danger" type="submit" name="delete">Delete</button>
                        <button class="btn btn-success btn-sm-shadow" type="submit" value="update" name="update">Update</button>
                        <?php } ?>
                    </div>
                </form> 
            </div>                   
        </div>
        <?php 
         }
         }else
         {
            $error="There isnot any Hotel Owned By You..";
         } ?>
        </section>
    <script>
            function hotelinputpop(hotelinput) {
                var get_hotelinputpop = document.getElementById(hotelinput);
                var hoteldinput = document.getElementById('hoteldinput');
                if (get_hotelinputpop.style.display === "flex") {
                    get_hotelinputpop.style.display = "none";
                    hoteldinput.style.display = "flex";
                } else {
                    get_hotelinputpop.style.display = "flex";
                    hoteldinput.style.display = "none";
                }
            }
            // function confirmDelete(temp_id) {
            //     var confirmDelete = confirm("Are you sure you want to delete Your hotel From Website?");
            //     if (confirmDelete) {
            //         document.querySelector('input[name="delete_id"]').value = temp_id;
            //         document.querySelector('form[name="delete_form"]').submit();
            //     }
            // }

   </script>
   <?php
//    if(isset($_POST['delete']))
// {
//     $id = $_POST['delete_id'];
//     $query = mysqli_query($con,"SELECT * FROM temp_hotel WHERE temp_id='$id'");
//     if ($query) {
//         $imageData = mysqli_fetch_assoc($query);
//         if ($imageData) {
//             $filePath = $imageData['image'];
//             $map = $imageData['hotel_map'];
//             $name = $imageData['name'];
//              mysqli_begin_transaction($con);
//              try{            
//                 if (file_exists($filePath)) {
//                     if (unlink($filePath)) {
//                         $deleteQuery = mysqli_query($con,"DELETE FROM temp_hotel WHERE temp_id='$id'");
//                         $deleteQuery2 = mysqli_query($con,"DELETE FROM hotels WHERE map='$map' AND image='$filePath'");
//                         if($deleteQuery && $deleteQuery2) {
//                             echo "<script>alert('hotel  $name has been deleted.');</script>";
//                         } else {
//                             echo "<script>alert('Failed to delete record from database.');</script>";
//                         }
//                     } else {
//                         echo "<script>alert('Failed to delete file: $filePath');</script>";
//                     }
//                 } else {
//                     echo "<script>alert('File does not exist: $filePath');</script>";
//                 }

//                 mysqli_commit($con);
            
//                 $msg = "Hotel deleted successfully.";
//             } catch (Exception $e) {
//                 mysqli_rollback($con);
            
//                 $error = "Failed to update hotel status: " . $e->getMessage();
//             }
//         } else {
//             echo "<script>alert('Failed to fetch  data from database.');</script>";
//         }
//     } else {
//         echo "<script>alert('Failed to execute database query.');</script>";
//     }
// }  
    ?>

    </body>
</html>




