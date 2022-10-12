<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);

$project_category=$_REQUEST['project_category'];
$project_name=$_REQUEST['project_name'];
$user_id=$_REQUEST['user_id'];

//echo 'project';
//echo $project_category; 
//exit;

echo "<html>";

echo "<form method=post action=unshare_project2.php>";
echo "<input type='hidden' name='project_category' value='$project_category'>";
echo "<input type='hidden' name='project_name' value='$project_name'>";
echo "<input type='hidden' name='user_id' value='$user_id'>";



echo "<font color='red' size='3'><b>CAUTION! Are you sure you want to Un-Share Project: $project_category $project_name ?</b></font>";
echo "<br /><br />";	   
echo "<input type='submit' name='submit' value='YES-Un-Share Project: $project_category $project_name'>";
echo "</form>";
//echo "<br />";

echo "<form method=post action=welcome.php>";
//echo "<input type='hidden' name='project_note_id' value='$project_note_id'>";
//echo "<input type='hidden' name='project_category' value='$project_category'>";
//echo "<input type='hidden' name='project_name' value='$project_name'>";
	   
echo "<input type='submit' name='submit' value='NO-Return to Home Page'>";

echo "</form>";
echo "</html>";
?>