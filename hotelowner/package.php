<?php
include("database.php");
include("hotelowner.php");

$directory = 'temimages/';
$error="";
$msg="";

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$itemsPerPage = 1;
$offset = ($page - 1) * $itemsPerPage;
$em=$_SESSION['hotelowneremail'];
  $query = "SELECT * FROM temp_package WHERE email='$em' LIMIT ? OFFSET ?";
  $stmt = mysqli_prepare($con, $query);
  mysqli_stmt_bind_param($stmt, 'ii', $itemsPerPage, $offset);
  mysqli_stmt_execute($stmt);
  $allimg = mysqli_stmt_get_result($stmt);
?>
<?php
  if (isset($_POST['toggle_status'])) {
     $packages_id = $_POST['packages_id'];
     $new_status = $_POST['toggle_status'];

     $info=mysqli_query($con,"SELECT * FROM temp_package WHERE packages_id='$packages_id'");
     $fetch=mysqli_fetch_array($info);
     $image=$fetch['image'];
    
     mysqli_begin_transaction($con);
    
     try {
         $query1 = "UPDATE temp_package SET packstatus = ? WHERE image = ?";
         $stmt1 = mysqli_prepare($con, $query1);
         mysqli_stmt_bind_param($stmt1, 'ss', $new_status, $image);
         mysqli_stmt_execute($stmt1);
    
         $query2 = "UPDATE package SET packstatus = ? WHERE image = ?";
         $stmt2 = mysqli_prepare($con, $query2);
         mysqli_stmt_bind_param($stmt2, 'ss', $new_status, $image);
         mysqli_stmt_execute($stmt2);
    
         mysqli_commit($con);
    
         $msg = "package status updated successfully.";
    
     } catch (Exception $e) {
         mysqli_rollback($con);
    
         $error = "Failed to update package status: " . $e->getMessage();
     }
    

 }
?>
<?php
if (isset($_POST["submit"])) {
        $name = mysqli_real_escape_string($con, $_POST['name']);
        date_default_timezone_set("Asia/Kathmandu");
        $create_date = date('Y-m-d');
        $price = (int)$_POST['price'];
        $email=$_SESSION['hotelowneremail'];    
        $query1 = mysqli_query($con,"SELECT * FROM hotels WHERE email ='$email'");
        if($query1)
        {
            if(mysqli_num_rows($query1)==1)
            {
                $row=mysqli_fetch_array($query1);
                $hname=$row['name'];
                $hotel_id =$row['hotel_id'];
                $duration = (int)$_POST['duration'];
                $status = $_POST['status'];
                $map1 = $_POST['map'];
                $map = $row['map'];
                $action="pending";
                $description =mysqli_real_escape_string($con,$_POST['description']);
                $location = mysqli_real_escape_string($con,$row['location'] );
                $location1 = mysqli_real_escape_string($con,$_POST['location'] );
            
                $target_dir = "temimages/";
                $filename = basename($_FILES["fileToUpload"]["name"]);
                $target_file = $target_dir . $filename;
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if ($check === false) {
                    $error = "File is not an image.";
                    $uploadOk = 0;
                }            
                if ($uploadOk) {
                    if ($map !== $map1) {
                        $error = "Package Map link does not match with your Hotel Map Link.";
                        $uploadOk = 0;
                    } elseif ($location !== $location1) {
                        $error = "Package location does not match with your Hotel Location.";
                        $uploadOk = 0;
                    }
                }
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif") {
                    $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                }
                if ($uploadOk) {
                    mysqli_begin_transaction($con);
                    
                    try {
                        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                                $insertQuery = "INSERT INTO `temp_package`(`name`, `hotel_id`, `description`, `price`, `location`, `packstatus`, `image`, `duration`, `map`, `action`, `email`, `created_at`)
                                VALUES ('$name', '$hotel_id', '$description', '$price', '$location', '$status', '$target_file', '$duration', '$map', '$action', '$email', '$create_date')";
                                $insertQuery2="INSERT INTO `notification`(`nFrom`, `ntype`, `message`, `date`) VALUES ('$name','Packages','Request For Adding New Package FROM $hname ','$create_date')";
                            if(mysqli_query($con, $insertQuery)&& mysqli_query($con,$insertQuery2)){
                                    $msg = "Package information uploaded successfully.";
                                } else {
                                $error = "Error: " . mysqli_error($con);
                                }   
                
                            } else {
                                $error = "Sorry, there was an error uploading your file.";
                            }
                            mysqli_commit($con);
                        $msg = "Package updated successfully.";
                        
                        } catch (Exception $e) {
                            mysqli_rollback($con);
                        
                            $error = "Failed to update Package : " . $e->getMessage();
                        }
                }
            }
            else{
                $error = "Hotel isnot Found..";
            }
        }
        else{
            $error = "Cannot Run Query..";
        }
}
?>

<!DOCTYPE html>
<html>
    <head>
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

#packageinput {
    display: none;
    width: 90%;
    padding: 20px;
    background-color: #f0f0f0;
    border-radius: 10px;
    z-index: 1000;
}
#packagedinput{
    display: flex;
    width: 90%;
    padding: 20px;
    background-color: #f0f0f0;
    border-radius: 10px;
}

.packageinputform {
    display: flex;
    flex-wrap: wrap;
    flex-direction: column;
    margin-right: 45px;
    width: 100%;
    float: left;
    gap: 10px;
    justify-content: space-between;
}
.packageinputform h1{
    color: blue;
}
.packageinputform .topicpack{
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
.infopackage{
    display: flex;
    width: 100%;
    margin:30px 10px;
    font-size: 0.85em;
    font-weight: 300;
    font-size: larger;
}
.infopackaged{
    display: flex;
    width: 100%;
    margin:10px 10px;
    font-size: 0.75em;
    font-weight: 300;
    font-size: larger;
}
.infopackaged .field{
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
.infopackaged h5,
.infopackage h5{
    width: 20%;
}
.infopackage .fieldfile{
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
.infopackage .field{
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
.infopackage_btn {
    display: flex;
    justify-content: flex-start;
    gap: 15px;
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
    border: 1px solid green;
    padding: 5px;
    border-radius:5px;
    cursor: pointer;
}
#prevNext button:hover{
    background-color:black;
    border:none;
    color:white;
}

</style>
</head>
<body>
    <section class="pack">
        
		 <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
        <div class="float-right mb-3" id="addbtn">
            <button class="btn btn-dark" onclick="packageinputpop('packageinput')">Add</button>
        </div>
        <div id="packageinput">          
            <div class="packageinputform">
                <h1>Create Package</h1>
                <form action="" method="post" enctype="multipart/form-data">                    
                <hr>
                    <div class="infopackage">
                    <h5>Package Name:</h5>
                    <input type="text" class="field" name="name" id="name" placeholder="Package Name" required>
                    </div>
                    <div class="infopackage">
                    <h5>Package Location:</h5>
                    <input type="text" class="field" name="location" id="location" placeholder="Package Location" required>
                    </div>
                    <div class="infopackage">
                    <h5>Package Price :</h5>
                    <input type="text" class="field" name="price" id="price" placeholder="Package Price In Rs" required>
                    </div>
                    <div class="infopackage">
                    <h5>Package Duration :</h5>
                    <input type="text" class="field" name="duration" id="duration" placeholder="Package Duration" required>
                    </div>
                    <div class="infopackage">
                    <h5>Package map:</h5>
                    <input type="text" class="field" name="map" id="map" placeholder="Package Map Link" required>
                    </div>
                    <div class="infopackage">
                        <h5>Package Status:</h5>
                        <select name="status" class="field" id="status"required>
                            <option value="">status</option>
                            <option value="on">ON</option>
                            <option value="off">OFF</option>
                        </select>
                    </div>
                    <div class="infopackaged" style="width:100%;">
                    <h5>Package Description:</h5>
                    <textarea name="description" class="field" id="description" rows="5" placeholder="Packages Details"  required></textarea>
                    </div>
                    <div class="infopackage">
                        <h5>Package Image :</h5>
                        <input type="file" class="fieldfile" name="fileToUpload" id="fileToUpload"><br>
                    </div>
                    <hr>
                    <div class="infopackage_btn">
                        <button type="reset" value="cancel" class="btn btn-danger btn-sm-shadow" name="cancel" onclick="packageinputpop('packageinput')">cancel</button>
                        <button class="btn btn-success btn-sm-shadow" type="submit" value="submit" name="submit">Submit</button>
                    </div>
                </form> 
            </div>                   
        </div>
        <?php
            $sn = ($page - 1) * $itemsPerPage + 1;
             while ($row = mysqli_fetch_array($allimg))
        { ?>
        <div id="packagedinput">          
            <div class="packageinputform">
                <div class="topicpack">
                <img src="<?php echo $row['image'];?>" alt="">
                <h1><?php echo $row['name'];?></h1>
                <?php if ($row["packstatus"] == 'on') { ?>
                    <form method="POST" class="statusbtn" action="">
                            <?php if ($row["action"] == 'pending') { ?>
                                <input type="hidden" name="packages_id" value="<?php echo $row['packages_id']; ?>">
                                <button  class="btn btn-danger btn-sm-shadow" name="cancel">Pending</button>
                            <?php } else if($row["action"] =="Cancelled") { ?>
                                <input type="hidden" name="packages_id" value="<?php echo $row['packages_id']; ?>">
                                <button  class="btn btn-danger btn-sm-shadow">Cancelled</button>
                            <?php } else { ?>
                                <input type="hidden" name="packages_id" value="<?php echo $row['packages_id']; ?>">
                                <button  class="btn btn-success btn-sm-shadow">Approved</button>
                            <?php }?>
                        <ul>
                            <li>Status</li>
                            <button type="submit" name="toggle_status" value="off" class="btn btn-success">On</button>
                        </ul>
                    </form>
                <?php } else { ?>
                    <form method="POST" class="statusbtn" action="">
                            <?php if ($row["action"] == 'pending') { ?>
                                <input type="hidden" name="packages_id" value="<?php echo $row['packages_id']; ?>">
                                <button  class="btn btn-danger btn-sm-shadow" name="cancel">Pending</button>
                            <?php } else if($row["action"] =="Cancelled") { ?>
                                <input type="hidden" name="packages_id" value="<?php echo $row['packages_id']; ?>">
                                <button  class="btn btn-danger btn-sm-shadow">Cancelled</button>
                            <?php } else { ?>
                                <input type="hidden" name="packages_id" value="<?php echo $row['packages_id']; ?>">
                                <button  class="btn btn-success btn-sm-shadow">Approved</button>
                            <?php }?>
                        <ul>
                            <li>Status</li>
                            <button type="submit" name="toggle_status" value="on" class="btn btn-danger">Off</button>
                        </ul>
                    </form>
                <?php } ?>
                </div>
                <form action="updatepackage.php" method="post">                    
                <hr>
                <div class="infopackage">
                    <h5>Package SN:</h5>
                    <input type="text" class="field" name="sn" id="sn" placeholder="Package sn"value="<?php echo $sn; ?>"  readonly>
                    </div>                    
                    <div class="infopackage">
                    <h5>Package Name:</h5>
                    <input type="text" class="field" name="name" id="name" placeholder="Package Name"value="<?php echo $row['name']; ?>"  readonly>
                    </div>
                    <div class="infopackage">
                    <h5>Package Location:</h5>
                    <input type="text" class="field" name="location" id="location" placeholder="Package Location"value="<?php echo $row['location']; ?>"  readonly>
                    </div>
                    <div class="infopackage">
                    <h5>Package Price :</h5>
                    <input type="text" class="field" name="price" id="price" placeholder="Package Price In Rs"value="<?php echo $row['price']; ?>"  readonly>
                    </div>
                    <div class="infopackage">
                    <h5>Package Duration :</h5>
                    <input type="text" class="field" name="duration" id="duration" placeholder="Package Duration"value="<?php echo $row['duration']; ?>" readonly>
                    </div>
                    <div class="infopackaged" style="width:100%;">
                    <h5>Package Description:</h5>
                    <textarea name="description" class="field" id="description" rows="5" placeholder="Packages Details" readonly><?php echo $row['description']; ?></textarea>
                    </div>
                    <hr>
                    <div class="infopackage_btn">
                    <input type="hidden" name="packages_id" value="<?php echo $row['packages_id']; ?>" readonly>
                    <?php if ($row["action"] == 'pending') { ?>
                        <button type="submit" value="cancel" class="btn btn-danger btn-sm-shadow" name="cancelled">Cancel</button>
                        <?php } else { ?>
                        <button type="submit"  class="btn btn-danger btn-sm-shadow" name="delete">Delete</button>
                        <button class="btn btn-success btn-sm-shadow" type="submit" value="update" name="update">Update</button>
                        <?php } ?>
                    </div>
                </form> 
            </div>                   
        </div>
        <?php 
            $sn++;
         } ?>
   
    </section> 
   <?php if(mysqli_num_rows($allimg)>0){?>
    <div id="prevNext">
        <button id="prevBtn">Prev</button>
        <button id="nextBtn">Next</button>
    </div>
    <?php } ?>
    <script>        
        function packageinputpop(packageinput) {
                var get_packageinputpop = document.getElementById(packageinput);
                var get_packagedinputpop = document.getElementById('packagedinput');
                var prevNext = document.getElementById('prevNext');
                if (get_packageinputpop.style.display === "flex") {
                    get_packageinputpop.style.display = "none";
                    get_packagedinputpop.style.display = "flex";
                    prevNext.style.display = "flex";
                } else {
                    get_packageinputpop.style.display = "flex";
                    get_packagedinputpop.style.display = "none";
                    prevNext.style.display = "none";
                }
            }
            $(document).ready(function(){
            var page = <?php echo $page; ?>;
            
            var totalPages = <?php echo ceil(mysqli_num_rows(mysqli_query($con,"SELECT * FROM temp_package WHERE email='$_SESSION[hotelowneremail]'")) / 1); ?>;

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




