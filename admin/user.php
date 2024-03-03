<?php
include("admin.php");
include("database.php");

// Function to delete a user by ID
function deleteUser($userId, $con) {
    $query = "DELETE FROM users WHERE id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'i', $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$itemsPerPage = 7;
$offset = ($page - 1) * $itemsPerPage;

// Fetch users for the current page
$query = "SELECT * FROM users LIMIT ? OFFSET ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, 'ii', $itemsPerPage, $offset);
mysqli_stmt_execute($stmt);
$allimg = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <style>
        table {
            margin-top: 10px;
            width: 100%;
            border-collapse: collapse;
        }
         tr:nth-child(even){
            background-color: #e8f5fe;
         }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: black;
            color: white;
            height: 50px;
        }
        #prevNext {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #prevNext button {
            margin: 10px;
            outline: none;
            height: 40px;
            width: 60px;
            background-color: black;
            color: white;
            border: none;
            padding: 5px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <table>
            <tr>
                <th>User ID</th>
                <th>Full Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            <?php
            $sn = ($page - 1) * $itemsPerPage + 1;
             while ($row = mysqli_fetch_array($allimg)) { ?>
            <tr>
                <td><?php echo $sn; ?></td>
                <td><?php echo $row["fullname"]; ?></td>
                <td><?php echo $row["phone"]; ?></td>
                <td><?php echo $row["email"]; ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
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

    <script>
            $(document).ready(function(){
        var page = <?php echo $page; ?>;
        var totalPages = <?php echo ceil(mysqli_num_rows(mysqli_query($con, 'SELECT * FROM users')) / 7); ?>;

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
    <?php
    // Handle deletion
    if (isset($_POST['delete'])) {
        $delete_id = $_POST['delete_id'];
        deleteUser($delete_id, $con);
        redirect('user.php');

    }
    ?>
</body>
</html>
