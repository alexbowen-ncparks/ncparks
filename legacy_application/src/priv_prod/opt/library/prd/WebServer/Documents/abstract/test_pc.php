<?php
//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  exit;
ini_set('display_errors',1);
$database="divper";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db( $connection,$database); // database 

extract($_REQUEST);
// echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;

$sql="SELECT Nname, Fname, Lname, phone FROM empinfo where tempID='Owen7422'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql".mysqli_error($connection));
while ($row=mysqli_fetch_array($result))
	{
	$ARRAY[]=$row;
	}
	
echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
?>
