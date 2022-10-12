<?php

//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; exit;

//These are placed outside of the webserver directory for security
//include("../../include/authDIVPER.inc"); // used to authenticate users
$database="divper";
include("../../include/iConnect.inc"); // database connection parameters
//  if($connection==""){echo "Failed to connect to database.";exit;}

mysqli_select_db($connection,$database);

if ($link)
{
unlink($link);
//rmdir($link);

$sql="DELETE FROM  application_uploads where beacon_num='$beacon_num' and form_name='$form_name'";
$result=mysqli_QUERY($connection,$sql);

    
header("Location: recommend.php?beacon_num=$beacon_num");
exit;
}


?>