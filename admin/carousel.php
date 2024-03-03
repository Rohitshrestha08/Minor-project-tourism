<?php
include("admin.php");
include("database.php");

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * 3; 

$query = "SELECT * FROM carousel LIMIT 3 OFFSET $offset";
$allimg = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        section .c {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            position: relative;
            height: 100%;
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

        #carousel {
            display: none;
            position: absolute;
            top: 0;
            right: 0;
            margin-bottom: 30px;
            z-index: 1000;
        }

        #carouselform {
            padding: 20px;
            background-color: #f0f0f0;
            border-radius: 10px;
            box-shadow: 2px 2px 5px rgb(0, 0, 0.2);
        }

        .c .container-fluid {
            width: 100%;
            display: flex;
            justify-content: flex-end;
        }

        form {
            margin: 30px 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
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
        section .c {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 10px 0;

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
        .imagess {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            margin: 10px 50px;
            gap: 20px;
            width: 100%; 
        }
        .imagess .image-container {
            position: relative;
        }
        .imagess img {
            width: 300px; 
            height: 300px; 
            object-fit: cover;
        }
        .delete-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: red;
            color: white;
            border: none;
            padding: 5px;
            border-radius:5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<section class="c">
<div class="float-right mb-3" id="addbtn">
        <button class="btn btn-dark" onclick="carouselpop('carousel')">Add</button>
    </div>

<div id="carousel">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8" id="carouselform">
                    ADD Images
                    <hr>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="info">
                            <h5>Picture</h5>
                            <input type="file" name="fileToUpload" id="fileToUpload"><br>
                        </div>
                        <hr>
                        <div class="info_btn">
                            <button type="reset" value="cancel" class="btn btn-danger btn-sm-shadow" name="cancel" onclick="carouselpop('carousel')">cancel</button>
                            <button class="btn btn-success btn-sm-shadow" type="submit" value="submit" name="submit">Submit</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-2"></div>
            </div>
        </div>
    </div>
    <div class="imagess">
        <?php
        while ($row = mysqli_fetch_array($allimg)) {
            echo "<div class='image-container'>";
            echo "<img src='" . $row['image'] . "' alt='Image' class='img-fluid'>";
            echo "<form method='post' action=''>";
            echo "<input type='hidden' name='image_id' value='" . $row['carousel_id'] . "'>";
            echo "<button class='delete-btn' name='delete' type='submit'>Delete</button>";
            echo "</form>";
            echo "</div>";
        }
        ?>
    </div>

    <div id="prevNext">
        <button id="prevBtn">Prev</button>
        <button id="nextBtn">Next</button>
    </div>
    <script>
            function carouselpop(carousel) {
                var get_carouselpop = document.getElementById(carousel);
                if (get_carouselpop.style.display === "flex") {
                    get_carouselpop.style.display = "none";
                } else {
                    get_carouselpop.style.display = "flex";
                }
            }
    $(document).ready(function(){
        var page = <?php echo $page; ?>;
        var totalPages = <?php echo ceil(mysqli_num_rows(mysqli_query($con, 'SELECT * FROM carousel')) / 3); ?>;

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
</section>
<?php
if(isset($_POST['delete']))
{
    $id = $_POST['image_id'];
    $query = mysqli_query($con,"SELECT * FROM carousel WHERE carousel_id='$id'");
    if ($query) {
        $imageData = mysqli_fetch_assoc($query);
        if ($imageData) {
            $filePath = $imageData['image'];
            
            if (file_exists($filePath)) {
                if (unlink($filePath)) {
                    $deleteQuery = mysqli_query($con,"DELETE FROM carousel WHERE carousel_id='$id'");
                    if($deleteQuery) {
                        echo "<script>alert('carousel image with ID $id has been deleted.');</script>";
                    } else {
                        echo "<script>alert('Failed to delete record from database.');</script>";
                    }
                } else {
                    echo "<script>alert('Failed to delete file: $filePath');</script>";
                }
            } else {
                echo "<script>alert('File does not exist: $filePath');</script>";
            }
        } else {
            echo "<script>alert('Failed to fetch image data from database.');</script>";
        }
    } else {
        echo "<script>alert('Failed to execute database query.');</script>";
    }
}

if (isset($_POST["submit"])) {
    $target_dir = "image/";
    $filename = basename($_FILES["fileToUpload"]["name"]);
    $target_file = $target_dir . $filename;

    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    $insertQuery = "INSERT INTO carousel (image) VALUES ('$target_file')";

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file) && mysqli_query($con, $insertQuery)) {
            echo "<script>alert('The file " . htmlspecialchars($filename) . " has been uploaded.');</script>";
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
        }
        
    }
}
?>
</body>
</html>
