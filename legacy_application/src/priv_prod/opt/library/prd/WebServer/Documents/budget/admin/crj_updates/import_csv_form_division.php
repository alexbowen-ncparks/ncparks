<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
if(!isset($_SESSION)){session_start();}
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
//echo "<pre>";print_r($_SERVER);echo "</pre>";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

if(!isset($project_category)){$project_category="";}
if(!isset($project_name)){$project_name="";}
if(!isset($step_group)){$step_group="";}
if(!isset($step_name)){$step_name="";}
if(!isset($substep_num)){$substep_num="";}
if(!isset($substep_name)){$substep_name="";}
echo "<html>
    <form enctype='multipart/form-data' method='post' action='import_csv_division.php'>
    <input type='file' id='csv_file' name='csv_file'>";
//echo "<input type='text' id='deposit_id_crj' name='deposit_id_crj'>";
echo "<input type='hidden' name='project_category' value='$project_category'>
	<input type='hidden' name='project_name' value='$project_name'>
    <input type='hidden' name='step_group' value='$step_group'>	   
	<input type='hidden' name='step_num' value='$step_num'>	   
	<input type='hidden' name='step' value='$step'>	   
	<input type='hidden' name='step_name' value='$step_name'>	
	<input type='hidden' name='substep_num' value='$substep_num'>	
	<input type='hidden' name='substep_name' value='$substep_name'>	
	<input type='hidden' name='upload_date' value='$upload_date'>	
    <input type='submit' name='csv_submit' value='Upload CSV File'>  
    </form>";
if($beacnum=='60032793' or $beacnum=='60036015')
{
echo "<br /><br /><a href='cash_summary_update.php?upload_date=$upload_date'>Update Cash Summary for $upload_date</a>";	
//echo "<br /><br /><a href='test1117_1615.php?upload_date=$upload_date'>Update Cash Summary for $upload_date</a>";	
}	
echo "</html>";

?>



