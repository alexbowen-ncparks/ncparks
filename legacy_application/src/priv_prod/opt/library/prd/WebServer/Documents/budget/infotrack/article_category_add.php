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

$system_entry_date=date(Ymd);


//echo "<pre>";print_r($_SERVER);"</pre>";

//echo "active_file=$active_file<br />";
//echo "active_file_request=$active_file_request<br />";


extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//if($level=='5' and $tempID !='Dodd3454')

//{echo "<pre>";print_r($_SESSION);"</pre>";}//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

if($project_category==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}
if($project_name==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}
//if($project_note==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to return to the Form</font><br />";exit;}
//if($web_address==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to return to the Form</font><br />";exit;}






include("../../../include/connectBUDGET.inc");// database connection parameters
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");


if($folder=='personal')

{$query1="delete from infotrack_projects where note_group='' ";
$result1=mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");
}

if($folder=='community')

{$query1="delete from infotrack_projects_community where note_group='' ";
$result1=mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");
}

if($folder=='personal')
{

$query4="insert into infotrack_projects(user,system_entry_date,project_category,project_name,note_group)
         values('$tempID','$system_entry_date','$project_category','$project_name','project')";
		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
}

if($folder=='community')
{

$query4="insert into infotrack_projects_community(user,system_entry_date,project_category,project_name,note_group)
         values('$tempID','$system_entry_date','$project_category','$project_name','project')";
		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
}


header("location: project1_menu.php?folder=$folder&project_category=$project_category&category_selected=y&project_name=$project_name&name_selected=y&note_group=web");
?>



















	














