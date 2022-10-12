<?php
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
$database="fixed_assets";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, $database)
       or die ("Couldn't select database $database");
       
if($_REQUEST['op']!="")
	{
	$sql="REPLACE lock_inventory set lock_date=NOW()";
	$result=mysqli_query($connection,$sql);
	}
	else
	{
	$sql="TRUNCATE TABLE lock_inventory";
	$result=mysqli_query($connection,$sql);
	}
mysqli_close($connection);
header("location: inventory.php?action=inventory");
?>