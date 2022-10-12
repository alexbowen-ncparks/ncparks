<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);

$project_category=$_POST['project_category'];
$project_name=$_POST['project_name'];
$project_category_new=$_POST['project_category_new'];
$project_name_new=$_POST['project_name_new'];


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

$table1="projects";
$table2="project_notes";

////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query1="update $table2 set project_category='$project_category_new',project_name='$project_name_new' where
project_category='$project_category' and project_name='$project_name' and user='$myusername' ";

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$query2="delete from $table1 where project_category='$project_category_new' and project_name='$project_name_new' and user_id='$myusername' ";

mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$query3= "insert into $table1(user_id,project_category,project_name) 
values ('$myusername','$project_category_new','$project_name_new')";

mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");


$query4="delete from $table1 where project_category='$project_category' and project_name='$project_name' and user_id='$myusername' ";

mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");



// frees the connection to MySQL
////mysql_close();

//echo "Update Successful";

//echo "<br /><br />";

//echo "<A href=welcome.php>Return HOME </A>";

header("location: welcome.php");


?>