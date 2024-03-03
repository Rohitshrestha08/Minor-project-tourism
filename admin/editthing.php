<?php
include("admin.php");
include("database.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_POST['redo']))
{
    redirect('thingstodo.php');
    exit();
}
   
if(isset($_POST['delete']))
{
    $id = $_POST['delete_id'];
    $query = mysqli_query($con,"SELECT * FROM thingstodo WHERE thingstodo_id='$id'");
    if ($query) {
        $imageData = mysqli_fetch_assoc($query);
        if ($imageData) {
            $filePath = $imageData['image'];
            
            if (file_exists($filePath)) {
                if (unlink($filePath)) {
                    $deleteQuery = mysqli_query($con,"DELETE FROM thingstodo WHERE thingstodo_id='$id'");
                    if($deleteQuery) {
                        echo "<script>alert('thingstodo  with ID $id has been deleted.');</script>";
                        redirect('thingstodo.php');
                        exit();
                    } else {
                        echo "<script>alert('Failed to delete record from database.');</script>";
                        redirect('thingstodo.php');
                        exit();
                    }
                } else {
                    echo "<script>alert('Failed to delete file: $filePath');</script>";
                    redirect('thingstodo.php');
                    exit();
                }
            } else {
                echo "<script>alert('File does not exist: $filePath');</script>";
                redirect('thingstodo.php');
                exit();
            }
        } else {
            echo "<script>alert('Failed to fetch  data from database.');</script>";
            redirect('thingstodo.php');
            exit();
        }
    } else {
        echo "<script>alert('Failed to execute database query.');</script>";
        redirect('thingstodo.php');
        exit();
    }
}
    

if(isset($_POST['edit'])){
    $tempid=$_POST['delete_id'];
    $result=mysqli_query($con,"SELECT * FROM thingstodo WHERE thingstodo_id='$tempid'");
    $row=mysqli_fetch_array($result);
    ?>
    <html lang="en">
<head>
    <title>Edit thingstodo</title>
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
                    <img id="hotelImage" src="<?php echo $row['image'];?>" alt="thingstodo Image">
                    <button id="changeImageButton">Change Image</button>
                </div>
                <h1><?php echo $row['name'];?></h1>
            </div>
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="file" name="newImage" id="newImage" style="display: none;" accept="image/*">                   
                <hr>
                    <div class="infohotel">
                    <h5>Thingstodo Name:</h5>
                    <input type="text" class="field" name="name" id="name" placeholder="thingstodo Name"value="<?php echo $row['name']; ?>"  required>
                    </div>
                    <div class="infohotel">
                    <h5>Thingstodo link :</h5>
                    <input type="text" class="field" name="link" id="link" placeholder="link "value="<?php echo $row['link']; ?>"  required>
                    </div>
                    <div class="infohotel">
                    <h5>Thingstodo Status :</h5>
                    <select class="field" name="status" id="status"required>
                        <option value="">select status</option>
                        <option value="event">Event</option>
                        <option value="other">Other</option>
                    </select>
                    </div>
                    <div class="infohotel">
                    <h5>Thingstodo location :</h5>
                    <input type="text" class="field" name="location" id="location" placeholder="location "value="<?php echo $row['location']; ?>"  required>
                    </div>
                    <div class="infohoteld" style="width:100%;">
                    <h5>Thingstodo Description:</h5>
                    <textarea name="description" class="field" id="description" rows="5" placeholder="thingstodo Details" required><?php echo $row['description']; ?></textarea>
                    </div>
                    <hr>
                    <div class="infohotel_btn">
                        <input type="hidden" name="thingstodo_id" value="<?php echo $row['thingstodo_id']; ?>">
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

<?php
if(isset($_POST['update'])) {
    $id = $_POST['thingstodo_id'];
    $name = $_POST['name'];
    $link = $_POST['link'];
    $location = $_POST['location'];
    $status = $_POST['status'];
    $description = $_POST['description'];
    
    // Start transaction
    mysqli_begin_transaction($con);

    try {
        if(isset($_FILES['newImage']) && $_FILES['newImage']['error'] === UPLOAD_ERR_OK) {
            $newImage = $_FILES['newImage'];
            $imagePath = "image/" . basename($newImage['name']);
            if(move_uploaded_file($newImage['tmp_name'], $imagePath)) {
                $query = "UPDATE thingstodo SET name='$name', link='$link', location='$location', status='$status', description='$description', image='$imagePath' WHERE thingstodo_id='$id'";
            } else {
                throw new Exception("Failed to upload image.");
            }
        } else {
            $query = "UPDATE thingstodo SET name='$name', link='$link', location='$location', status='$status', description='$description' WHERE thingstodo_id='$id'";
        }
        $result = mysqli_query($con, $query);

        if($result) {
            mysqli_commit($con);
            alerting('thingstodo updated successfully.');
            redirect('thingstodo.php');
            exit();
        } else {
            throw new Exception("Failed to update thingstodo.");
        }
    } catch (Exception $e) {
        mysqli_rollback($con);
        alerting($e->getMessage());
        redirect('thingstodo.php');
    }
}

?>
</body>
</html>

