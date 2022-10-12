<?php 
extract($_REQUEST);
ini_set('display_errors',1);
//include("menu.php");

include("../../include/connectROOT.inc");// database connection parameters

$database="phone_bill";
  $db = mysql_select_db($database,$connection)
	   or die ("Couldn't select database");
   
if(@$submit=="Add")
	{
	$sql="INSERT INTO agreement_park set park_code='$park_code'"; //echo "$sql"; exit;
	$result=mysql_query($sql);
	header("Location: agreement_park.php");
	exit;
	}


?>