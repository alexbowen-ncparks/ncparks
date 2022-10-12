<?php
$database="fixed_assets";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, $database)
       or die ("Couldn't select database $database");
$sql="DELETE FROM surplus_track where id='$id'";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql ".mysql_error($connection));
	
header("Location: surplus_equip_form.php?location=$single_location&act=review");
EXIT;
?>