<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);
$today_date=date("Ymd");
echo "start_date=$start_date";
echo "<br />"; 
echo "end_date=$end_date";//exit;
echo "<br />"; 
echo "today_date=$today_date";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

$query1="insert into budget.pcard_report_dates(xtnd_start,xtnd_end,report_date)
         values('$xtnd_start_new','$xtnd_end_new','$report_date_new')";
mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");
echo "ok";





?>

























