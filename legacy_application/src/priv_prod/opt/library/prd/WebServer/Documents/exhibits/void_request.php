<?php
ini_set('display_errors', 1);
extract($_REQUEST);
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  exit;
	// check for malicious redirect
		$findThis="http:";
		$testThis=strtolower($_SERVER['REQUEST_URI']);
		$ip_address=strtolower($_SERVER['REMOTE_ADDR']);
	$pos=strpos($testThis,$findThis);
		if($pos>-1){
		header("Location: http://www.fbi.gov");
		exit;}

$db="exhibits";
if(empty($connection))
	{
	include("../../include/iConnect.inc"); // database connection parameters
	}

extract($_REQUEST);
$sql="INSERT INTO void_request select * from work_order where work_order_id='$pass_id'"; //echo "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql<br />".mysqli_error($connection));

$sql="DELETE from work_order where work_order_number='$work_order_number'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1.");

$sql="DELETE from work_order_workers where work_order_number='$work_order_number'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1.");

		@mysqli_free_result($result);
		mysqli_close($connection);
?>