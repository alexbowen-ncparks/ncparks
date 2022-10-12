<?php
// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;

$database="dpr_tests"; 
$dbName="dpr_tests";
include("_base_top.php");

ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
include("../../include/iConnect.inc"); // include iConnect.inc with includes no_inject.php
mysqli_select_db($connection,$dbName);

$sql = "DELETE 
	FROM scores
	where tempID='$tempID' and test_id='$test_id' and test_date='$test_date'"; 
// 	echo "$sql<br />"; //exit;
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

$sql = "DELETE 
	FROM completed_tests
	where tempID='$tempID' and test_id='$test_id' and test_date='$test_date'"; 
// 	echo "$sql"; //exit;// 	
	
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

echo "Test for $tempID on $test_date has been deleted. They will now be able to retake this test.";
?>