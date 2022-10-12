<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);
$today_date=date("Ymd");
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date";exit;
//echo "<br />"; 
//echo "today_date=$today_date";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

$query1="update pcard_extract_worksheet
         set pcu_id='$pcu_id' where id='$id'";
mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");


{header("location: stepG8d.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&step_num=$step_num&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}




?>

























