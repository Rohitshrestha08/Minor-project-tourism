<?php
include("database.php");
include("admin.php");

$error="";
$msg="";
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$itemsPerPage = 7;
$offset = ($page - 1) * $itemsPerPage;

// Fetch hotel for the current page
$query = "SELECT * FROM notification ORDER BY notice_id DESC LIMIT ? OFFSET ?";
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
.c .container-fluid {
    width: 100%;
    display: flex;
    justify-content: center;
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
th, td {
    padding: 4px;
    text-align: left;
    height: 50px;
}
tr:nth-child(even){
            background-color: #e8f5fe;
         }
th {
    background-color: black;
    color: white;
    height: 50px;
}
img{
    width:200px;
    height:150px;
}


</style>
</head>
<body>
    <section class="c">
        
		 <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
        <div class="container-fluid">
        <table>
            <tr>
                <th>SN</th>
                <th >FROM</th>
                <th >TYPE</th>
                <th>MESSAGE</th>
                <th >Date</th>
            </tr>
            <?php
            $sn = ($page - 1) * $itemsPerPage + 1;
             while ($row = mysqli_fetch_array($allimg)) { ?>
            <tr>
                <td><?php  echo $sn; ?></td>
                <td><?php  echo $row["nFrom"]; ?></td>
                <td><?php  echo $row["ntype"]; ?></td>
                <td><?php  echo $row["message"]; ?></td>
                <td><?php  echo $row["date"]; ?></td>
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
        $(document).ready(function(){
            var page = <?php echo $page; ?>;
            var totalPages = <?php echo ceil(mysqli_num_rows(mysqli_query($con, 'SELECT * FROM notification')) / 7); ?>;

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