<?php
include("database.php");
include("admin.php");

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$itemsPerPage = 3;
$offset = ($page - 1) * $itemsPerPage;

// Fetch destination for the current page
$query = "SELECT * FROM destination LIMIT ? OFFSET ?";
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

#destinationinput {
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

#destinationinput form {
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

#destinationcrud{
    display: flex;    
    flex-direction: column;
}
#destinationcrud button{
    width:70px;
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
    width:100px;
    height:100px;
}


</style>
</head>
<body>
    <section class="c">
        <div class="float-right mb-3" id="addbtn">
            <button class="btn btn-dark" onclick="destinationinputpop('destinationinput')">Add</button>
        </div>

        <div id="destinationinput">
            
        <div class="destinationinputform">
            ADD destination
            <hr>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="info">
                    <h5>Picture</h5>
                    <input type="file" name="fileToUpload" id="fileToUpload"><br>
                </div>
            <div class="info">
            <h5>Name:</h5>
            <input type="text" name="name" id="name" required>
            </div>
            <div class="info">
            <h5>Price:</h5>
            <input type="text" name="price" id="price" required>
            </div>
            <div class="info">
            <h5>location:</h5>
            <input type="text" name="location" id="location" required>
            </div>
            <div class="info">
            <h5>Rating:</h5>
            <input type="text" name="rating" id="rating" required>
            </div>
                <div class="info">
                    <select name="status" id="status" required>
                        <option value="">status</option>
                        <option value="on">ON</option>
                        <option value="off">OFF</option>
                    </select>
                </div>
                <div class="infod" style="width:100%;">
                <h5>Description:</h5>
                <textarea name="description" id="description" rows="5"required></textarea>
                </div>
                <hr>
                <div class="info_btn">
                    <button type="reset" value="cancel" class="btn btn-danger btn-sm-shadow" name="cancel" onclick="destinationinputpop('destinationinput')">cancel</button>
                    <button class="btn btn-success btn-sm-shadow" type="submit" value="submit" name="submit">Submit</button>
                </div>
            </form> 
            </div>                   
        </div>

        <div class="container-fluid">
        <table>
            <tr>
                <th>SN</th>
                <th style="width:80px;">Name</th>
                <th>Image</th>
                <th>price</th>
                <th>location</th>
                <th>rating</th>
                <th style="width:400px;">Description</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php
            $sn = ($page - 1) * $itemsPerPage + 1;
             while ($row = mysqli_fetch_array($allimg)) { ?>
            <tr>
                <td><?php echo $sn; ?></td>
                <td><?php echo $row["name"]; ?></td>
                <td><img src="<?php echo $row['image']; ?>" alt=""></td>
                <td><?php echo $row["price"]; ?></td>
                <td><?php echo $row["location"]; ?></td>
                <td><?php echo $row["rating"]; ?></td>
                <td><?php echo $row["description"]; ?></td>
                <td>
    <?php if ($row["destatus"] == 'on') { ?>
        <form method="POST" class="statusbtn" action="">
            <input type="hidden" name="destination_id" value="<?php echo $row['destination_id']; ?>">
            <button type="submit" name="toggle_status" value="off" class="btn btn-success">On</button>
        </form>
    <?php } else { ?>
        <form method="POST" class="statusbtn" action="">
            <input type="hidden" name="destination_id" value="<?php echo $row['destination_id']; ?>">
            <button type="submit" name="toggle_status" value="on" class="btn btn-danger">Off</button>
        </form>
    <?php } ?>
                </td>
                <td>
                    <form method="POST" id="destinationcrud" action="editdestination.php">
                        <input type="hidden" name="delete_id" value="<?php echo $row['destination_id']; ?>">
                        <button class="btn btn-primary mb-2" type="submit" name="edit">Edit</button>
                        <button class="btn btn-danger" type="submit" name="delete">Delete</button>
                    </form>
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
            function destinationinputpop(destinationinput) {
                var get_destinationinputpop = document.getElementById(destinationinput);
                if (get_destinationinputpop.style.display === "flex") {
                    get_destinationinputpop.style.display = "none";
                } else {
                    get_destinationinputpop.style.display = "flex";
                }
            }
        $(document).ready(function(){
            var page = <?php echo $page; ?>;
            var totalPages = <?php echo ceil(mysqli_num_rows(mysqli_query($con, 'SELECT * FROM destination')) / 3); ?>;

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
if (isset($_POST["submit"])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $price = (int)$_POST['price'];
    $rating =(int) $_POST['rating'];
    $destatus =$_POST['status'];
    $location =$_POST['location'];
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $target_dir = "image/";
    $filename = basename($_FILES["fileToUpload"]["name"]);
    $target_file = $target_dir . $filename;

    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is an actual image or fake image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    if($rating >5) 
    {
        echo "Sorry, rating is upto 5.";
        $uploadOk = 0;
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    $insertQuery = "INSERT INTO destination (name, description,image,price,rating,destatus,location) VALUES ( '$name', '$description','$target_file', '$price', '$rating','$destatus','$location')";

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // Move uploaded file and insert into database
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file) && mysqli_query($con, $insertQuery)) {
            echo "The file " . htmlspecialchars($filename) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
<?php
// Check if the toggle status form is submitted
if (isset($_POST['toggle_status'])) {
    $destination_id = $_POST['destination_id'];
    $new_status = $_POST['toggle_status'];
    
    // Update the status of the destination in the database
    $query = "UPDATE destination SET destatus = ? WHERE destination_id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'si', $new_status, $destination_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    // Redirect back to the page to reflect the changes
    redirect('destination.php');
    exit;
}
?>

