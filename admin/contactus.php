<?php
include("database.php");
include("admin.php");

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$itemsPerPage = 5;
$offset = ($page - 1) * $itemsPerPage;
$quer="SELECT * FROM contactus ORDER BY cid desc limit $itemsPerPage OFFSET $offset";
$allimg = mysqli_query($con, $quer);


?>

<!DOCTYPE html>
<html>
    <head>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

        <style>
            table {
                margin-top: 30px;
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
            td{
                height: 80px;
            }
            #next {
                margin-top: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            #next button {
                margin: 10px;
                outline:none;
                height:40px;
                width:60px;
                border: 1px solid green;
                padding: 5px;
                border-radius:5px;
                cursor: pointer;
            }
            #next button:hover{
                background-color:black;
                border:none;
                color:white;
            }

        </style>
    </head>
    <body>


<table>
    <tr>
        <th>SN</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Message</th>
    </tr>
<?php
$sn = ($page - 1) * $itemsPerPage + 1;
while ($row = mysqli_fetch_array($allimg)) {
    ?>
    <tr>
        <td><?php echo $sn ;?></td>
        <td> <?php echo $row["firstname"] ." ".$row['lastname'] ;?> </td>
        <td> <?php echo $row["email"]   ;?> </td>
        <td> <?php echo $row["phone"]   ;?> </td>
        <td> <?php echo $row["message"] ;?>  </td>
    </tr>
    <?php
    $sn ++;
}
?>

</table>

<div id="next">
        <button id="prevBtn">Prev</button>
        <button id="nextBtn">Next</button>
    </div>
    <script>
        $(document).ready(function(){
            var page = <?php echo $page; ?>;
            var totalPages = <?php echo ceil(mysqli_num_rows(mysqli_query($con,"SELECT * FROM contactus ")) / $itemsPerPage); ?>;
            
        console.log("Total Pages:", totalPages);

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
</html>