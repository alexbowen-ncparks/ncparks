<?php
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
$database="dpr_it"; 
$dbName="dpr_it";
include("../../include/auth.inc"); // include iConnect.inc with includes no_inject.php
include("../../include/iConnect.inc"); // include iConnect.inc with includes no_inject.php
mysqli_select_db($connection,$dbName);

//  echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

$level=$_SESSION[$database]['level'];
$location=$_SESSION[$database]['select'];
//echo "level=$level  location=$location";

$sql="REPLACE confirmation
	set date='$date', location='$location', item='$select_table', emid='$emid', confirmation_comments='$confirmation_comments'
	"; 
$result = mysqli_query($connection,$sql) or die("$sql");

header("Location: search_form.php?select_table=$select_table&location=$location");
?>
