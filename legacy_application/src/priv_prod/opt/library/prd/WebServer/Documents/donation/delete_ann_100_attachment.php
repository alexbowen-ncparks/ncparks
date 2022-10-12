<?php

//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; exit;

$database="donation";
include("../../include/iConnect.inc"); // database connection parameters
$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");
       
extract($_REQUEST);

$sql="SELECT link FROM uploads where upid='$pass_id' and id='$id'";
$result = @mysqli_QUERY($connection,$sql); //ECHO "$sql";
$row=mysqli_fetch_assoc($result);
extract($row);

if($link)
	{
	unlink($link);
	//rmdir($link);
	
	$sql="DELETE from uploads where upid='$pass_id'";
	$result=mysqli_QUERY($connection,$sql);
	
	header("Location: cal_edit.php?id=$id");
	exit;
	}


?>