<?php
include("db.php");
include 'navbar.php';
$query="select * from gallery";
$result=mysqli_query($con,$query);


?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        #gallery {
            display: flex;
            justify-content: center;
            margin: 40px 0;
        }

        .gallery {
            max-width: 1200px;
            width: 100%;
        }

        .gallery_container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); /* Adjust width */
            grid-auto-rows: 250px; /* Set fixed height */
            grid-gap: 20px; /* Adjust gap between images */
            justify-items: flex-start; /* Align items to the start of each grid cell */
            align-items: flex-start;
        }

        .images {
        width: 100%;
        height: 250px;
            display: flex;
            align-items: flex-start;        
            justify-content: flex-start;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.6);
            cursor: pointer;
        }

        .images:hover {
            transform: scale(1.02);
        }

        .images img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>
<body>


    <section id="gallery">
        <div class="gallery">
            <div class="gallery_container">
                <?php
                while($row = mysqli_fetch_array($result)) {
                ?>
                    <div class="images">
                        <img src="admin/<?php echo $row['gallery_path'] ?>" alt="<?php echo $row['information'] ?>">
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

</body>
</html>
