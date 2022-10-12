<?php

session_start();


//$file = "articles_menu.php";
//$lines = count(file($file));


//$table="infotrack_projects";
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

$active_file=$_SERVER['SCRIPT_NAME'];
$active_file_request=$_SERVER['REQUEST_URI'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$infotrack_location=$_SESSION['budget']['select'];
$infotrack_center=$_SESSION['budget']['centerSess'];


$system_entry_date=date("Ymd");
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
//echo $system_entry_date;exit;
//print_r($_SESSION);echo "</pre>";exit;


if($project_category==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}
if($project_name==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}
if($project_note==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}
//if($web_address==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}

include("../../../include/connectBUDGET.inc");// database connection parameters
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");

$table1="infotrack_projects";
$table2="infotrack_projects_community";




//$date=$_POST['date'];
//$project_category=$_POST['project_category'];
//$project_name=$_POST['project_name'];
//$project_note=$_POST['project_note'];
//$weblink=$_POST['weblink'];
$date=date("Ymd");
//$project_start_date=$_POST['project_start_date'];
//$project_end_date=$_POST['project_end_date'];
//$project_status=$_POST['project_status'];

if($submit=='Add_Note' and $folder=='personal')

{
$query1="insert ignore into $table1
(user,system_entry_date,project_category,project_name,project_note,note_group) 
values ('$myusername','$system_entry_date','$project_category','$project_name',
'$project_note','note')";

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query");
}

//echo "ok";exit;
if($submit=='Add_Note' and $folder=='community')

{

$query2a="insert ignore into $table1
(user,system_entry_date,project_category,project_name,project_note,note_group) 
values ('$tempID','$system_entry_date','$project_category','$project_name',
'$project_note','note')";

mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a.  $query2a");

$query2b="insert ignore into $table2
(user,system_entry_date,project_category,project_name,project_note,note_group) 
values ('$tempID','$system_entry_date','$project_category','$project_name',
'$project_note','note')";

mysqli_query($connection, $query2b) or die ("Couldn't execute query 2b.  $query2b");
}




// frees the connection to MySQL
//////mysql_close();

//echo "Update Successful";

//echo "<br /><br />";

//echo "<A href=welcome.php>Return HOME </A>";

header("location: project1_menu.php?folder=$folder&project_category=$project_category&category_selected=y&project_name=$project_name&note_group=$note_group&name_selected=y&add_record=y");


?>