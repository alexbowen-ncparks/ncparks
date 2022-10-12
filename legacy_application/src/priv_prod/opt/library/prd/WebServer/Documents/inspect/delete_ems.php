<?php
$database="inspect";
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);

$sql="SELECT * FROM $table where id='$id'";
$result = @mysqli_query($connection,$sql);
$row=mysqli_fetch_assoc($result);
unlink($row['link']);


$sql="DELETE from $table where id='$id'";
$result = @mysqli_query($connection,$sql);
header("Location: home.php"); exit;

?>