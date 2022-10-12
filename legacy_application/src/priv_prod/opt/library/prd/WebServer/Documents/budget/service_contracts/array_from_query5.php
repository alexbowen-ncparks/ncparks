<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);

$database="budget";
$db="budget";
//include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database
include("../../../include/activity_new.php");// database connection parameters
include("../../budget/~f_year.php");
//mysqli_select_db($connection, $database); // database
//include("../../../include/activity.php");// database connection parameters


$query="select payline_num,payline_amount from service_contracts_invoices_paylines where scid='294' and invoice_num='678' order by payline_num ";
echo "query=$query";	
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");

$paylines = array();

while($row =  mysqli_fetch_assoc($result))
	{
	$invoice_pay[$row['payline_num']]=$row['payline_amount'];	 	  
    }

echo "<pre>";print_r($invoice_pay);echo "</pre>";//exit;

echo "line1 invoice pay amount: $invoice_pay[1]";
echo "<br />";
echo "line2 invoice pay amount: $invoice_pay[2]";
?>