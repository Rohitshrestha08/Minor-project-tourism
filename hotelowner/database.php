<?php
$hostname = 'localhost';
$username = 'root';
$password = ''; 
$database = 'tourism';

$con = mysqli_connect($hostname, $username, $password, $database);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>