<?php
include("db.php");

$query = "SELECT * FROM carousel";
$result = mysqli_query($con, $query);

// Fetch all rows into an array
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Counter variable to keep track of the iteration count
$counter = 0;
?>

<!-- Bootstrap and other styles/scripts -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
    .carousel {
    position: relative;
    z-index: 1; /* Set a lower z-index */
}
.carousel-inner img{
    width: 100%;
    height: 700px;
}
</style>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Carousel -->
<div id="demo" class="carousel slide" data-bs-ride="carousel">
    <!-- Indicators/dots -->
    <div class="carousel-indicators">
        <?php foreach ($rows as $index => $row) { ?>
            <button type="button" data-bs-target="#demo" data-bs-slide-to="<?php echo $index; ?>" <?php echo ($index == 0) ? 'class="active"' : ''; ?>></button>
        <?php } ?>
    </div>

    <!-- The slideshow/carousel -->
    <div class="carousel-inner">
        <?php foreach ($rows as $index => $row) { ?>
            <div class="carousel-item <?php echo ($index == 0) ? 'active' : ''; ?>">
                <img src="admin/<?php echo $row['image']; ?>" alt="Carousel Image" class="d-block w-100">
            </div>
        <?php } ?>
    </div>

    <!-- Left and right controls/icons -->
    <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </button>
</div>
