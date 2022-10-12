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

$project_id=$_POST['project_id'];
$copy_project_for=$_POST['copy_project_for'];
$project_category=$_POST['project_category'];
$project_name=$_POST['project_name'];



////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query1="update projects set shared_users=concat(shared_users,',$copy_project_for') 
where project_id=$project_id";

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$query2="update projects set project_type='share' 
where project_id=$project_id";

mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");






//$query2="insert into project_notes(user,system_entry_date,project_category,project_name,project_note,link,weblink)
//select '$copy_project_for',system_entry_date,project_category,project_name,project_note,link,weblink
//from project_notes where user='$myusername' and project_category='$project_category' and project_name='$project_name' order by project_note_id ";

//mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

// frees the connection to MySQL
////mysql_close();


header("location: welcome.php");



?>
