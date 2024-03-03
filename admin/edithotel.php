<?php
include("admin.php");
include("database.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_POST['deletehotel']))
{  
    $temp_id=$_POST['delete_id'];
    $result=mysqli_query($con,"SELECT * FROM temp_hotel WHERE temp_id='$temp_id'");
    $row=mysqli_fetch_array($result);
    $ema=$row['email'];
    mysqli_begin_transaction($con);
    try{
        $del2=mysqli_query($con,"DELETE FROM hotels WHERE email='$ema'");
        $del3=mysqli_query($con,"DELETE FROM temp_hotel WHERE email='$ema'");
        $del1=mysqli_query($con,"DELETE FROM temp_package WHERE email='$ema'");
        $del4=mysqli_query($con,"DELETE FROM package WHERE email='$ema'");
        if($del1 && $del2 && $del3 && $del4)
        {
            $msg="Hotel Deleted successfully..";
        }else
        {
            $error="Cannot delete hotel try later ..";
        }
        mysqli_commit($con);
        $msg="Hotel Deleted successfully..";
        alerting($msg);
        redirect('hotel.php');
        exit();
    }catch(Exception $e){
        mysqli_rollback($con);
        $error="Cannot delete hotel try later .."; 
        alerting($error);  
         redirect('hotel.php');        
         exit();


    }
    
}

if(isset($_POST['redo']))
{
    redirect('hotel.php');
    exit();
}


if (isset($_POST['update'])) {
    $email = $_POST['uphoteledit'];
    $query = mysqli_query($con, "SELECT * FROM hotels WHERE email='$email' ");
    $fetch = mysqli_fetch_array($query);

    // Capture current values
    $current_name = $fetch['name'];
    $current_price = $fetch['price'];
    $current_room = $fetch['room'];
    $current_description = $fetch['description'];
    $current_rating = $fetch['rating'];
    $current_location = $fetch['location'];
    date_default_timezone_set("Asia/Kathmandu");
    $updated_at = date('Y-m-d');

    // Capture submitted values
    $submitted_name = $_POST['name'];
    $submitted_price = (int)$_POST['price'];
    $submitted_room = (int)$_POST['room'];
    $submitted_description = $_POST['description'];
    $submitted_location = $_POST['location'];
    $submitted_rating = (int)$_POST['rating'];

    // Validate rating
    if ($submitted_rating > 5) {
        $error = 'Rating should be within 5.';
        alerting($error);
        redirect('hotel.php');
        exit();
    }

         mysqli_begin_transaction($con);
        try {
            if(isset($_FILES['newImage']) && $_FILES['newImage']['error'] === UPLOAD_ERR_OK) {
                $newImage = $_FILES['newImage'];
                $imagePath = "../hotelowner/temimages/" . basename($newImage['name']);
                if(move_uploaded_file($newImage['tmp_name'], $imagePath)) {
                    $uploadimg1 = "UPDATE temp_hotel SET image='$imagePath' WHERE email='$email'";
                    $uploadimg2 = "UPDATE hotels SET image='$imagePath' WHERE email='$email'";
                            
                    $result = mysqli_query($con, $uploadimg1);
                    $result2 = mysqli_query($con, $uploadimg2);
                } else {
                    throw new Exception("Failed to upload image.");
                }
            }
            $stmt = $con->prepare("UPDATE `temp_hotel` SET `name`=?, `description`=?, `price`=?, `hotel_location`=?, `rating`=?, `room`=?, `updated_at`=? WHERE email=? ");
            $stmt->bind_param("ssssssss", $submitted_name, $submitted_description, $submitted_price, $submitted_location, $submitted_rating, $submitted_room, $updated_at, $email);
            $stmt->execute();
            $stmt->close();

            // Update hotels table
            $stmt2 = $con->prepare("UPDATE `hotels` SET `name`=?, `description`=?, `price`=?, `location`=?, `rating`=?, `room`=? WHERE email=? ");
            $stmt2->bind_param("sssssss", $submitted_name, $submitted_description, $submitted_price, $submitted_location, $submitted_rating, $submitted_room, $email);
            $stmt2->execute();
            $stmt2->close();

            // Update package table
            $up = $con->prepare("UPDATE `package` SET `location`=?, `updated_at`=? WHERE email=? ");
            $up->bind_param("sss", $submitted_location, $updated_at, $email);
            $up->execute();
            $up->close();

            // Update temp_package table
            $up1 = $con->prepare("UPDATE `temp_package` SET `location`=?, `updated_at`=? WHERE email=? ");
            $up1->bind_param("sss", $submitted_location, $updated_at, $email);
            $up1->execute();
            $up1->close();

            
                mysqli_commit($con);
                alerting('Updated Hotels successfully.');
                redirect('hotel.php');
                exit();
        } catch (Exception $e) {
            mysqli_rollback($con);
            alerting($e->getMessage());
            redirect('hotel.php');
            exit();
        }

}



if(isset($_POST['edithotel'])){
    $tempid=$_POST['delete_id'];
    $result=mysqli_query($con,"SELECT * FROM temp_hotel WHERE temp_id='$tempid'");
    $row1=mysqli_fetch_array($result);
    $ema=$row1['email'];
    $result1=mysqli_query($con,"SELECT * FROM hotels WHERE email='$ema'");
    $row=mysqli_fetch_array($result1);

?>
<html lang="en">
<head>
    <title>Edit hotel</title>
    <style>
        
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
#imageContainer {
    position: relative;
    display: inline-block;
}
#hotelImage {
    display: block;
    width: 200px; 
    height: 200px; 
}
#changeImageButton {
    position: absolute;
    bottom: 10px;
    right: 10px; 
    padding: 5px 10px;
    background-color: #007bff;
    color: #fff; 
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
    </style>
</head>
<body>
<div id="hoteldinput" class="mt-4">          
            <div class="hotelinputform">
            <div class="topicpack">
                <div id="imageContainer">
                    <img id="hotelImage" src="../hotelowner/<?php echo $row['image'];?>" alt="Destination Image">
                    <button id="changeImageButton">Change Image</button>
                </div>
                <h1><?php echo $row['name'];?></h1>
            </div>
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="file" name="newImage" id="newImage" style="display: none;" accept="image/*">                   
                <hr>
                    <div class="infohotel">
                    <h5>Hotel Name:</h5>
                    <input type="text" class="field" name="name" id="name" placeholder="Hotel Name"value="<?php echo $row['name']; ?>"  required>
                    </div>
                    <div class="infohotel">
                    <h5>Hotel Price :</h5>
                    <input type="text" class="field" name="price" id="price" placeholder="Price "value="<?php echo $row['price']; ?>"  required>
                    </div>
                    <div class="infohotel">
                    <h5>Hotel location :</h5>
                    <input type="text" class="field" name="location" id="location" placeholder="location "value="<?php echo $row['location']; ?>"  required>
                    </div>
                    <div class="infohotel">
                    <h5>Hotel Rating :</h5>
                    <input type="text" class="field" name="rating" id="rating" placeholder="Hotel rating"value="<?php echo $row['rating']; ?>" required>
                    </div>
                    <div class="infohotel">
                    <h5>Room :</h5>
                    <input type="text" class="field" name="room" id="room" placeholder="Hotel room"value="<?php echo $row['room']; ?>" required>
                    </div>
                    <div class="infohoteld" style="width:100%;">
                    <h5>Hotel Description:</h5>
                    <textarea name="description" class="field" id="description" rows="5" placeholder="Hotels Details" required><?php echo $row['description']; ?></textarea>
                    </div>
                    <hr>
                    <div class="infohotel_btn">
                        <input type="hidden" name="uphoteledit" value="<?php echo $row['email']; ?>">
                        <button class="btn btn-danger" type="submit" name="redo" >Cancel</button>
                        <button class="btn btn-success btn-sm-shadow" type="submit" value="update" name="update">Update</button>
                    </div>
                </form> 
            </div>                   
        </div>
      <?php }  ?>
      <script>
        document.getElementById("changeImageButton").addEventListener("click", function() {
            document.getElementById("newImage").click();
        });

        document.getElementById("newImage").addEventListener("change", function(event) {
            var imageContainer = document.getElementById("imageContainer");
            var file = event.target.files[0];
            var reader = new FileReader();
            
            reader.onload = function(e) {
                imageContainer.querySelector("img").src = e.target.result;
            };
            reader.readAsDataURL(file);
        });
    </script>
</body>
</html>

