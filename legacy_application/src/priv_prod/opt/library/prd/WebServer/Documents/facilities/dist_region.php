<?php
//These are placed outside of the webserver directory for security
ini_set('display_errors',1);
$database="facilities";
include("../../include/auth.inc"); // used to authenticate users
$multi_park=explode(",",$_SESSION[$database]['accessPark']);

include("../../include/get_parkcodes_reg.php");

echo "<pre>"; print_r($region); echo "</pre>";  exit;

$database="facilities";
mysqli_select_db($connection,$database); // database

foreach($region as $park_code=>$region)
	{
	$sql="UPDATE housing set region='$region' where park_abbr='$park_code'";
	$result=mysqli_query($connection,$sql);
	}
?>