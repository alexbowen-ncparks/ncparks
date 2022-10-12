<?php

session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}
$system_entry_date=date("Ymd");
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";
//print_r($_SESSION);echo "</pre>";exit;

if($project_category==""){echo "<font color='red' size='5'>Error Message:</font> <font color='blue'>Form is missing Values. Please enter Values for all Form boxes</font><br />Click the BACK button on your Browser to return to the Form";exit;}
if($project_name==""){echo "<font color='red' size='5'>Error Message:</font> <font color='blue'>Form is missing Values. Please enter Values for all Form boxes</font><br />Click the BACK button on your Browser to return to the Form";exit;}
if($project_note==""){echo "<font color='red' size='5'>Error Message:</font> <font color='blue'>Form is missing Values. Please enter Values for all Form boxes</font><br />Click the BACK button on your Browser to return to the Form";exit;}
if($web_address==""){echo "<font color='red' size='5'>Error Message:</font> <font color='blue'>Form is missing Values. Please enter Values for all Form boxes</font><br />Click the BACK button on your Browser to return to the Form";exit;}



//$date=$_POST['date'];
//$project_category=$_POST['project_category'];
//$project_name=$_POST['project_name'];
//$project_note=$_POST['project_note'];
//$weblink=$_POST['weblink'];
$date=date("Ymd");
//$project_start_date=$_POST['project_start_date'];
//$project_end_date=$_POST['project_end_date'];
//$project_status=$_POST['project_status'];


include("../../include/connect.php");
$database="mamajone_cookiejar";
$table="project_notes";


////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query="insert ignore into $table(user,system_entry_date,project_category,project_name,project_note,weblink) 
values ('$myusername','$system_entry_date','$project_category','$project_name','$project_note','$web_address')";

mysqli_query($connection, $query) or die ("Couldn't execute query 1.  $query");



// frees the connection to MySQL
////mysql_close();

//echo "Update Successful";

//echo "<br /><br />";

//echo "<A href=welcome.php>Return HOME </A>";

header("location: pages_menu.php?&project_category=$project_category&category_selected=y");


?>
