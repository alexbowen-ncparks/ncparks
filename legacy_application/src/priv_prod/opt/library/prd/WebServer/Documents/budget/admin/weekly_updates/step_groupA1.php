<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;

//$fiscal_year=$_POST['fiscal_year'];
//$start_date=$_POST['start_date'];
//$end_date=$_POST['end_date'];

//$project_start_date=$_POST['project_start_date'];
//$project_end_date=$_POST['project_end_date'];
//$project_status=$_POST['project_status'];

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

//update weekly_updates_steps for date fields and status field
$query1="update weekly_updates_steps set fiscal_year='$fiscal_year',start_date='$start_date',
         end_date='$end_date',status='pending' where 1"; 

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

//update weekly_updates_steps for status field (set status field for step_group=a to complete)
$query2="update weekly_updates_steps set status='complete' where step_group='A'"; 

mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

//update weekly_updates_steps for date fields and status field
$query3="update weekly_updates_steps_detail set fiscal_year='$fiscal_year',start_date='$start_date',
         end_date='$end_date',status='pending' where 1"; 

mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");


header("location: main.php?project_category=fms&project_name=weekly_updates");


?>
