<?php
$database="state_lakes";
include("../../include/connectROOT.inc");// database connection parameters
$db = mysql_select_db($database,$connection)
       or die ("Couldn't select database $database");
extract($_REQUEST);
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;


if($contact_id==""){exit;}

	$sql="UPDATE piers set pier_payment='$payment_date', check_number='$check' where contacts_id='$contact_id' and year='$year'";
//	echo "$sql";exit;
	$result = mysql_query($sql);

	$sql="UPDATE buoy set buoy_receipt='$payment_date', check_number='$check' where contacts_id='$contact_id' and year='$year'";
//	echo "$sql";exit;
	$result = mysql_query($sql);
	
	$sql="UPDATE ramp set ramp_receipt='$payment_date', check_number='$check' where contacts_id='$contact_id' and year='$year'";
//	echo "$sql";exit;
	$result = mysql_query($sql);

	$sql="UPDATE swim_line set swim_line_receipt='$payment_date', check_number='$check' where contacts_id='$contact_id' and year='$year'";
//	echo "$sql";exit;
	$result = mysql_query($sql);
	
	if(@$individ_receipt=="x")
		{
		header("Location: individ_receipt.php?year=$year&id=$contact_id");
		exit;
		}
	
header("Location: record_payment.php?year=$year&contact_id=$contact_id&pay=Payment");

?>