<?php
//ini_set('display_errors',1);

$database="ware";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, $database)
       or die ("Couldn't select database $database");
       
@mysqli_select_db($connection, $database) or die( "Unable to select database");
	// Retrieve data from Query String
$ware_product_title = $_GET['product_title'];
//$exp=explode("*",$ware_product_title);
//$ware_product_title = $exp[1];
	// Escape User Input to help prevent SQL Injection
$ware_product_title = mysqli_real_escape_string($connection, $ware_product_title);
	//build query
$query = "SELECT product_number FROM base_inventory WHERE product_title = '$ware_product_title'";

	//Execute query
$qry_result = mysqli_query($connection,$query) or die(mysqli_error($connection));

	// Insert a new row in the table for each person returned
while($row = mysqli_fetch_array($qry_result))
	{
//	print_r($row); exit;
	$x = "$row[product_number]";	
	}
$val=$x;
$display_string="<input id='ware_product_number' type='text' name='ware_product_number' value='$val'>";
echo $display_string;
?>