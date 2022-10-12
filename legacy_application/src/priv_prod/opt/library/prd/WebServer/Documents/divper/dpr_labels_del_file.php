<?php
//These are placed outside of the webserver directory for security
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,'divper'); // database


if($id)
	{
	  if($connection==""){echo "Failed to connect to database.";exit;}
	  
	unlink($link);
	
	$sql="UPDATE labels set file_link=trim(BOTH ',' from replace(file_link,'$link','')) where id='$id'";
	//ECHO "$sql";exit;
	$result=mysqli_QUERY($connection,$sql);
	
	$sql="UPDATE labels set file_link=replace(file_link,',,',',') where id='$id'";
	//ECHO "$sql";exit;
	$result=mysqli_QUERY($connection,$sql);
	
	header("Location: dpr_labels_find.php?id=$id&submit_label=Find&pass=$pass");
	exit;
	}
?>