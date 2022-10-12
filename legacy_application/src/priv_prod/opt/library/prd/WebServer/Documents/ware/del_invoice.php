<?php
$database="ware";
if(empty($connection))
	{
	include("../../include/iConnect.inc");// database connection parameters
	mysqli_select_db($connection, $database)
	   or die ("Couldn't select database $database");
	}

$sql="select * from invoices where invoice_number='$inv_num'";
// echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
if(mysqli_num_rows($result)>0)
	{
	while ($row=mysqli_fetch_array($result))
		{
		extract($row);
		}
		
// 	echo "<pre>"; print_r($row); echo "</pre>";
// 	exit;
	
	if(!empty($link))
		{
		unlink($link);
		}
	}



$sql="DELETE From invoices where invoice_number='$inv_num'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");	

if(empty($del_order))
	{
	HEADER("Location: invoices.php?invoice_number=$inv_num");
	}

?>