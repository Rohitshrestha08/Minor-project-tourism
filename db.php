<?php
$databaseHost='localhost';
$databaseName='tourism';
$databaseusername='root';
$databasePassword='';



$con=mysqli_connect($databaseHost, $databaseusername, $databasePassword, $databaseName);
if(!$con){
	die("connection failed ....." .mysqli_connect_error());
}
else
{
	//echo "connection successfully...";
}
?>