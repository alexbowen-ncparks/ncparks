<?php

// echo "<pre>"; print_r($_REQUEST); echo "</pre>"; exit;

$database="facilities";
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");

$sql="SELECT link FROM facility_attachment where file_id='$pass_id' and gis_id='$gis_id'";
$result = @mysqli_QUERY($connection,$sql); //ECHO "$sql";
$row=mysqli_fetch_assoc($result);
extract($row);

if($link)
	{
	unlink($link);
	//rmdir($link);
	
	$sql="DELETE from facility_attachment where file_id='$pass_id'";
	$result=mysqli_QUERY($connection,$sql);
	
	header("Location: edit_fac.php?gis_id=$gis_id");
	exit;
	}


?>