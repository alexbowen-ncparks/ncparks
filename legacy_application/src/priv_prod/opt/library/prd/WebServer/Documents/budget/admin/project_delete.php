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
$user=$myusername;

//echo $project_category;
//echo $project_name;
//echo $user;
//exit;


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database


$database="mamajone_cookiejar";
$table1="projects";
$table2="project_notes";


////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query1="delete from $table1 where project_category ='' and project_name= '' ";

mysqli_query($connection, $query1) or die ("couldn't execute query 1. $query1");

$query2="delete from $table2 where project_category ='' and project_name= '' ";

mysqli_query($connection, $query2) or die ("couldn't execute query 2. $query2");

$query3="delete from $table1 where project_category ='$project_category' and project_name= '$project_name' and user_id='$user' ";

mysqli_query($connection, $query3) or die ("couldn't execute query 3. $query3");

$query4="delete from $table2 where project_category ='$project_category' and project_name= '$project_name' and user='$user' ";

mysqli_query($connection, $query4) or die ("couldn't execute query 4. $query4");





////mysql_close();

echo "Project: $project_category $project_name has been successfully deleted";

echo "</br> </br>";

echo "<A href=welcome.php>Return HOME </A>";

?>
