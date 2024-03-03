	<?php
include("db.php");
$query="select * from destination WHERE destatus='on' limit 6 ";
$result=mysqli_query($con,$query);
?>
  <link rel="stylesheet" type="text/css" href="destination.css">

    <section class="section__container destination__container" id="destination">
      <div class="section__header">
        <h2 class="section__title">Top Destinations</h2>
        <div class="section__nav">
          <span><i class="ri-arrow-left-s-line"></i></span>
          <span><i class="ri-arrow-right-s-line"></i></span>
        </div>
      </div>
      <div class="destination__grid">
<?php while($row=mysqli_fetch_array($result)){?>
        <div class="destination__card">
          <img src="admin/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" />
          <div class="badge"><?php echo $row['rating']; ?></div>
          <div class="destination__details">
            <h4><?php echo $row['name']; ?></h4>
            <p><?php echo $row['description']; ?></p>
          </div>
        </div>
        <?php
          }
        ?>
      </div>
    </section>