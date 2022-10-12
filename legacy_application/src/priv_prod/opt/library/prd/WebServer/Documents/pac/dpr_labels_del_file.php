<?php
//These are placed outside of the webserver directory for security
$database="pac";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,'divper'); // database
extract($_REQUEST);

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
	
	header("Location: add_new.php?id=$id&submit_label=Find&park_code=$pass");
	exit;
	}
?>