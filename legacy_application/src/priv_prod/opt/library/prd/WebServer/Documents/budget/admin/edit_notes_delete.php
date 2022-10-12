<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);


$project_note_id=$_POST['project_note_id'];

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

$table="project_notes";


////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query="delete from $table 
where project_note_id='$project_note_id' ";

mysqli_query($connection, $query) or die ('Error updating Database');
echo "Update Successful-project_note_ID# $project_note_id was deleted";

echo "</br> </br>";

echo

"<A href=welcome.php>Return HOME </A>";


//header("location: welcome.php");

?>
