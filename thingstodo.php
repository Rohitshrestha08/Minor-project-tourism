<?php
include("db.php");
include("navbar.php");
$query="select * from thingstodo WHERE status='event' ";
$result=mysqli_query($con,$query);

?>
    <link rel="stylesheet" type="text/css" href="thingsto.css">

     
   <div id="portfolio">
   <div class="container-thingto">
    <h1 class="sub-title">Things to do</h1>
    <div class="work-list">
        <?php
        while($row=mysqli_fetch_array($result)){
        ?>
        <div class="work">
        <img src="admin/<?php echo $row['image']; ?>">
        <div class="layer">
            <!-- <h3><?php echo $row['name']; ?></h3> -->
            <p><?php echo $row['description']; ?></p>
                <a href="<?php echo $row['link']; ?>"><i class="fa-solid fa-up-right-from-square">Vist</i></a>
        </div>
        </div>
    <?php
        }
    ?>
            
        </div>
    </div>
    </div>
   </div>
   <?php
   include("footer.php");
   ?>
