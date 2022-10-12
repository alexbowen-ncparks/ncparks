<?php

//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; exit;

//These are placed outside of the webserver directory for security
//include("../../include/authDIVPER.inc"); // used to authenticate users
$database="divper";
include("../../include/iConnect.inc"); // database connection parameters
 if($connection==""){echo "Failed to connect to database.";exit;}
// extract($_REQUEST);
mysqli_select_db($connection,$database);

if ($link)
	{
	unlink($link);
	//rmdir($link);
	
	$sql="DELETE FROM  permanent_uploads where file_link='$link'";
	$result=MYSQLI_QUERY($connection,$sql);
	
		
	header("Location: vacant_form_upload.php?beacon_num=$beacon_num&posTitle=$posTitle");
	exit;
	}


?>