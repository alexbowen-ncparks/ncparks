<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}
/*
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);

$database="budget";
$db="budget";

include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database
include("../../../include/activity_new.php");// database connection parameters
include("../../budget/~f_year.php");
*/
//echo "<br />scid=$scid<br />invoice_num=$invoice_num<br />";
$query="select `payline_num`,`payline_amount` from `budget_service_contracts`.`pay_lines` where `scid`='$scid' and `invoice_num`='$invoice_num' order by `payline_num` ";
//echo "query=$query";	
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");

//$paylines = array();

while($row =  mysqli_fetch_assoc($result))
	{
	$payline_pay[$row['payline_num']]=$row['payline_amount'];	 	  
    }

//echo "<pre>";print_r($payline_pay);echo "</pre>";//exit;

//echo "line1 payline amount: $payline_pay[1]";
//echo "<br />";
//echo "line2 payline amount: $payline_pay[2]";

//$pay_amount=$payline_pay[$po_line_num];
$pay_amount=$payline_pay[$payline_num];
?>