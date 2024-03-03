<?php
include("database.php");
function redirect($url)
{
    echo"
    <script>
    window.location.href='$url';
    </script>";
}

function alerting($msg)
{
    echo"
    <script>
    alert('$msg');
    </script>";
}
?>
<!-- //     function deletefun($id,$table) {
//         $con=$GLOBALS['con'];
//             $query = mysqli_query($con, "SELECT * FROM $table WHERE id='$id'");
            
//             if ($query) {
//                 $imageData = mysqli_fetch_assoc($query);              
//                 if ($imageData) {
//                         $deleteQuery = mysqli_query($con, "DELETE FROM $table WHERE id='$id'");
//                         if ($deleteQuery) {
//                             echo "<script>alert('$table with ID $id has been deleted.');</script>";
//                         } else {
//                             echo "<script>alert('Failed to delete record from database.');</script>";
//                         }
//                 } else {
//                     echo "<script>alert('No $table found with ID: $id.');</script>";
//                 }
//             } else {
//                 echo "<script>alert('Failed to execute database query.');</script>";
//             }
//     }
// 
 <script>
    
    function confirmDelete(temp_id) {
                var confirmDelete = confirm("Are you sure you want to delete Your hotel From Website?");
                if (confirmDelete) {
                    document.querySelector('input[name="delete_id"]').value = temp_id;
                    document.querySelector('form[name="delete_form"]').submit();
                }
            }
</script> --> 