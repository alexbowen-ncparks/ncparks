<?php

session_start();

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
$system_entry_date=date("Ymd");
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
//echo $system_entry_date;exit;
//print_r($_SESSION);echo "</pre>";exit;

if($project_group==""){echo "<font color='red' size='5'>Error Message:</font> <font color='blue'>Form is missing Values. Please enter Values for all Form boxes</font><br />Click the BACK button on your Browser to return to the Form";exit;}
if($project_category==""){echo "<font color='red' size='5'>Error Message:</font> <font color='blue'>Form is missing Values. Please enter Values for all Form boxes</font><br />Click the BACK button on your Browser to return to the Form";exit;}
if($project_note==""){echo "<font color='red' size='5'>Error Message:</font> <font color='blue'>Form is missing Values. Please enter Values for all Form boxes</font><br />Click the BACK button on your Browser to return to the Form";exit;}
if($report_level==""){echo "<font color='red' size='5'>Error Message:</font> <font color='blue'>Form is missing Values. Please enter Values for all Form boxes</font><br />Click the BACK button on your Browser to return to the Form";exit;}
if($weblink==""){echo "<font color='red' size='5'>Error Message:</font> <font color='blue'>Form is missing Values. Please enter Values for all Form boxes</font><br />Click the BACK button on your Browser to return to the Form";exit;}



//$date=$_POST['date'];
//$project_category=$_POST['project_category'];
//$project_name=$_POST['project_name'];
//$project_note=$_POST['project_note'];
//$weblink=$_POST['weblink'];
$date=date("Ymd");
//$project_start_date=$_POST['project_start_date'];
//$project_end_date=$_POST['project_end_date'];
//$project_status=$_POST['project_status'];

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters

$table1="concessions_reports";



$query1="update $table1
     set system_entry_date='$date',project_group='$project_group',project_category='$project_category',
	 project_note='$project_note',report_level='$report_level',weblink='$weblink',display='$display'
     where project_note_id='$project_note_id' ";	 


mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query");



header("location: administrator_menu.php");


?>
