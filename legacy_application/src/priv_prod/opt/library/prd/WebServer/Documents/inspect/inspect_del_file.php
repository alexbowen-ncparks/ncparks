<?php
$database="inspect";
include("../../include/iConnect.inc"); // database connection parameters
 if($connection==""){echo "Failed to connect to database.";exit;}
extract($_REQUEST);
mysqli_select_db($connection,$database);

if ($id)
	{
//	echo "l=$link";exit;
	unlink($link);
	
	$sql="UPDATE document set file_link=trim(BOTH ',' from replace(file_link,'$link','')) where id='$id'";
	//ECHO "$sql";exit;
	$result=mysqli_query($connection,$sql);
	
	$sql="UPDATE document set file_link=replace(file_link,',,',',') where id='$id'";
	//ECHO "$sql";exit;
	$result=mysqli_query($connection,$sql);
	
	header("Location: add_park_comments.php?parkcode=$parkcode&passYear=$passYear&id=$id");

	exit;
	}
?>