<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

//$project_note_id=$_POST['project_note_id'];
//$project_category=$_POST['project_category'];
//$project_name=$_POST['project_name'];


echo "<html>";

echo "<form method=post action=document_delete.php>";


echo "<font color='red' size='3'><b>CAUTION! Are you sure you want to delete Document for record $project_name-$step_group ?</b></font>";
echo "<br /><br />";

echo "<input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='hidden' name='step_group' value='$step_group'>	   
	   <input type='hidden' name='step' value='$step'>";	
	   
echo "<input type='submit' name='submit' value='YES-DELETE Document for $project_name-$step_group'>";
echo "</form>";
//echo "<br />";

echo "<form method=post action=main.php>";
 echo "<input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='hidden' name='step_group' value='$step_group'>	   
	   <input type='hidden' name='step' value='$step'>";	
	   
echo "<input type='submit' name='submit' value='NO-Return to Home Page'>";

echo "</form>";
echo "</html>";



?>