<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);
$today_date=date("Ymd");
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date";//exit;
//echo "<br />"; 
//echo "today_date=$today_date";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters


$query1="update ere_unmatched set cvip_id='$cvip_id' where id='$id'";
mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

$query2="update cvip_unmatched set post2ncas='y' where cvip_id='$cvip_id'";
mysqli_query($connection, $query2) or die ("Couldn't execute query 1. $query2");

header("location: stepH8e.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&step=$step&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");




?>

























