<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

$project_note_id=$_POST['project_note_id'];


$table="project_notes";


////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query="update $table set link='' where project_note_id='$project_note_id' ";

mysqli_query($connection, $query) or die ('Error updating Database');

////mysql_close();

echo "Update Successful-Document for project_note_ID# $project_note_id was deleted";

echo "</br> </br>";

echo "<A href=welcome.php>Return HOME </A>";

?>
