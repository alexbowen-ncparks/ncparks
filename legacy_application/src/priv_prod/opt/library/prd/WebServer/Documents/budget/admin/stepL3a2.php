<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
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
include("../../../include/activity.php");// database connection parameters

echo "<html>
    <form enctype='multipart/form-data' method='post' action='import_csv.php'>
    <input type='file' id='csv_file' name='csv_file'> 
	<input type='hidden' name='project_category' value='$project_category'>
	<input type='hidden' name='project_name' value='$project_name'>
    <input type='hidden' name='step_group' value='$step_group'>	   
	<input type='hidden' name='step_num' value='$step_num'>	   
	<input type='hidden' name='step' value='$step'>	   
	<input type='hidden' name='step_name' value='$step_name'>	
	<input type='hidden' name='substep_num' value='$substep_num'>	
	<input type='hidden' name='substep_name' value='$substep_name'>	
    <input type='submit' name='csv_submit' value='Upload CSV File'>  
    </form> 
	
</html>";

?>



