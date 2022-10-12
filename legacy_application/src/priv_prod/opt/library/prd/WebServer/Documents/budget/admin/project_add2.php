<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);

$date=$_POST['date'];
$project_category=$_POST['project_category'];
$project_name=$_POST['project_name'];
$project_note=$_POST['project_note'];
$weblink=$_POST['weblink'];
$date=date("Ymd");
//$project_start_date=$_POST['project_start_date'];
//$project_end_date=$_POST['project_end_date'];
//$project_status=$_POST['project_status'];

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

$table="projects";
$table2="project_notes";

////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query="insert into $table(user_id,project_category,project_name,created,share_provider) 
values ('$tempid','$project_category','$project_name','$date','$myusername')";

mysqli_query($connection, $query) or die ("Couldn't execute query 1.  $query");

$query2="insert into $table2(user,system_entry_date,project_category,project_name,project_note,weblink,author) 
values ('$tempid','$date','$project_category','$project_name','$project_note','$weblink','$tempid')";

mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


// frees the connection to MySQL
////mysql_close();

//echo "Update Successful";

//echo "<br /><br />";

//echo "<A href=welcome.php>Return HOME </A>";

header("location: welcome.php");


?>
