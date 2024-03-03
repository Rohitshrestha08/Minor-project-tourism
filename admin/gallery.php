<?php
include("admin.php");
include("database.php");


$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * 3; 

$query = "SELECT * FROM gallery LIMIT 3 OFFSET $offset";
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

        #gallery {
            display: none;
            position: absolute;
            top: 0;
            right: 0;
            margin-bottom: 30px;
            z-index: 1000;
        }

        #galleryform {
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
        <button class="btn btn-dark" onclick="gallerypop('gallery')">Add</button>
    </div>

<div id="gallery">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8" id="galleryform">
                    ADD Images
                    <hr>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="info">
                            <h5>Picture</h5>
                            <input type="file" name="fileToUpload" id="fileToUpload"><br>
                        </div>
                        <hr>
                        <div class="info_btn">
                            <button type="reset" value="cancel" class="btn btn-danger btn-sm-shadow" name="cancel" onclick="gallerypop('gallery')">cancel</button>
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
            echo "<img src='" . $row['gallery_path'] . "' alt='Image' class='img-fluid'>";
            echo "<form method='post' action=''>";
            echo "<input type='hidden' name='image_id' value='" . $row['id'] . "'>";
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
            function gallerypop(gallery) {
                var get_gallerypop = document.getElementById(gallery);
                if (get_gallerypop.style.display === "flex") {
                    get_gallerypop.style.display = "none";
                } else {
                    get_gallerypop.style.display = "flex";
                }
            }
    $(document).ready(function(){
        var page = <?php echo $page; ?>;
        var totalPages = <?php echo ceil(mysqli_num_rows(mysqli_query($con, 'SELECT * FROM gallery')) / 3); ?>;

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
if(isset($_POST['delete'])) {
    $id = $_POST['image_id'];
    $query = mysqli_query($con, "SELECT * FROM gallery WHERE id='$id'");
    
    if ($query) {
        $imageData = mysqli_fetch_assoc($query);
        
        if ($imageData) {
            $filePath = $imageData['gallery_path'];

            if (file_exists($filePath)) {
                if (unlink($filePath)) {
                    $deleteQuery = mysqli_query($con, "DELETE FROM gallery WHERE id='$id'");
                    if ($deleteQuery) {
                        echo "<script>alert('Gallery image with ID $id has been deleted.');</script>";
                    } else {
                        echo "<script>alert('Failed to delete record from database.');</script>";
                    }
                } else {
                    echo "<script>alert('Failed to delete file from folder.');</script>";
                }
            } else {
                echo "<script>alert('File does not exist.');</script>";
            }
        } else {
            echo "<script>alert('No image found with ID: $id.');</script>";
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

    $insertQuery = "INSERT INTO gallery (gallery_path) VALUES ('$target_file')";

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file) && mysqli_query($con, $insertQuery)) {
            echo "The file " . htmlspecialchars($filename) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
