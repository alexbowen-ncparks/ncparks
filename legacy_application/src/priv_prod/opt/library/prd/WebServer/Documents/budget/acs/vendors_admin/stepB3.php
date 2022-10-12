<?php

//echo "PHP File table1_backup.php";  //exit;

//ini_set('display_errors',1);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//$end_date=str_replace("-","",$end_date);
//echo $end_date; exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

$system_entry_date=date("Ymd");

echo "<br />system_entry_date=$system_entry_date<br />"; //exit;

$sed_first4=substr($system_entry_date,0,4);
$sed_first4_lastY=$sed_first4-1;
$sed_last4=substr($system_entry_date,4,4);

echo "<br />sed_first4=$sed_first4<br />";
echo "<br />sed_first4_lastY=$sed_first4_lastY<br />";
echo "<br />sed_last4=$sed_last4<br />"; 

$range_start=$sed_first4_lastY.$sed_last4;
$range_end=$system_entry_date;

echo "<br />range_start=$range_start<br />"; 
echo "<br />range_end=$range_end<br />"; 


// Updating TABLE=cid_vendor_invoice_payments for Field=gn.   By creating an 'n' value for Field-=gn, it gives Budget Office (Rebecca Owen) a  "searchable value" in the PORTAL 
$query4="update cid_vendor_invoice_payments set gn='n' where group_number='' and system_entry_date >= '$range_start' and system_entry_date <= '$range_end' ";
		 
		 
//echo "<br />query4=$query4<br />";  exit;		 
		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");	



 

{header("location: /budget/portal.php?dbTable=cid_vendor_invoice_payments&gn=n&ncas_account=53&system_entry_date=$range_start*$range_end&submit=Find");}









?>