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
$user=$myusername;

//echo $project_category;
//echo $project_name;
//echo $user;
//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

$table1="projects";
$table2="project_notes";


////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query1="update $table1 set project_type='private',shared_users='' where project_category ='$project_category'
 and project_name= '$project_name' and user_id='$user_id' ";

mysqli_query($connection, $query1) or die ("couldn't execute query 1. $query1");



////mysql_close();

echo "Project: $project_category $project_name for ProjectManager: $user_id has been Un-Shared" ;

echo "</br> </br>";

echo "<A href=welcome.php>Return HOME </A>";

?>
