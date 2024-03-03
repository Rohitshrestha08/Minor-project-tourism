<?php
include("db.php");

$query="select * from trending where trestatus='on' order by trending_id limit 3";
$result=mysqli_query($con,$query);
?>
<head>
  <style>
   
.trending {
    background-color: #efefef;
    padding: 50px 0;
  }

  .trending-box {
    box-shadow: 0 0 10px 1px rgba(40, 73, 214, 0.2);
    padding-bottom: 15px;
    height:500px;
    margin-bottom:10px;
    text-align: center;
  }
  .trending-box:hover {
    transform: scale(1.04);
  }
  
  .trending-box img {
    width: 100%;
    height:50%;
    border-radius: 10px;
    transition: 1s;
    cursor: pointer;
  }
  

  .trending-box h3 {
    margin-bottom: 20px;
  }
  
  .trending-box .price {
    font-size: 20px;
    font-weight: bold;
    color: #333;
    margin-top: 10px;
  }
  
  .trending-box .rating {
    color: orange;
    margin-top: -20px;
  }
  .trending-box .trending h1{
      text-align: center;
      margin-top: 40px;
      margin-bottom: 40px;
  }
  .trending-box .rating {
      float: right;
      margin-top: -25px;
      padding-right:10px;
  }
  .trending-box .info p{
    padding:0 5px;
  } 
  </style>
</head>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
 
<section class="trending" id="trending">
            <div class="container">
              <h1 class="text-center mb-5">Trendings</h1>
              <div class="row">
                <?php

                  while($row=mysqli_fetch_array($result)){
                    ?>
                <div class="col-lg-4 mb-4">
                  <div class="trending-box">
                    <img src="admin/<?php echo $row['image'];  ?> " alt="Siraichuli-Hill">
                    <div class="price">Rs.<?php echo $row['price'];  ?></div>
                    <div class="rating">
                    <?php $rate=$row['rating']; 
                    for($i= 0;$i<$rate;$i++){
                      echo "<i>★</i>";
                    }
                      ?>
                    </div>
                    <div class="info">
                      <h3><?php echo $row['name'];  ?></h3>
                      <p><?php echo $row['description'];?></p>
                    </div>
                  </div>
                </div>
                <?php
                  }
                ?>
              
            </div>
         </section>
         