<?php
// echo "test<pre>"; print_r($ARRAY); echo "</pre>";  exit;
$database="ware";
	include("../../include/iConnect.inc");// database connection parameters
	mysqli_select_db($connection, $database)
	   or die ("Couldn't select database $database");

$sql="SELECT invoice_number as inv_num from park_order where park_code='$park_code' and processed_date='$processed_date' and ordered='x'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");

if(mysqli_num_rows($result)>0)
	{
	$row=mysqli_fetch_assoc($result);
	extract($row);
	$del_order=1;
	include("del_invoice.php");
	$sql="DELETE from park_order where park_code='$park_code' and processed_date='$processed_date' and ordered='x'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	echo "Completed Park Order for Invoice Number $in_num has been deleted. You may close this tab.";
	}
	else
	{
	echo "No competed order was found for unit=$park_code, processed date=$processed_date, and ordered=complete";
	}

?>