<?php
if($level>4)
	{
	ini_set('display_errors',1);
	}

$database="public_contact"; 
$dbName=$database;
include("../../include/iConnect.inc"); // include iConnect.inc with includes no_inject.php
mysqli_select_db($connection,$dbName);
$sql="UPDATE records set void='x' where id='$id'"; 
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_error($connection));

include("contact.php");
?>