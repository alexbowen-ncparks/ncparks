<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

//$file = "articles_menu.php";
//$lines = count(file($file));


//$table="infotrack_projects";
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
//echo "<pre>";print_r($_SESSION);"</pre>";exit;

//$active_file=$_SERVER['SCRIPT_NAME'];
//$active_file_request=$_SERVER['REQUEST_URI'];


$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$infotrack_location=$_SESSION['budget']['select'];
$infotrack_center=$_SESSION['budget']['centerSess'];
//echo "infotrack_location=$infotrack_location";//exit;

if($infotrack_location=="ADM"){$infotrack_location="ADMI";}
//echo "<br />infotrack_location=$infotrack_location";exit;
$system_entry_date=date("Ymd");
extract($_REQUEST);

if($comment_note==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");

$date=date("Ymd");
$comment_note=addslashes($comment_note);

$query2=" insert into procedures_programmer_comments set
pid='$pid',user='$tempID',park='$infotrack_location',system_entry_date='$system_entry_date',
comment_note='$comment_note',status='ip' ";

mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");



/*
$query3="SELECT MAX(`comment_id`) as 'comment_id' 
FROM `infotrack_projects_community_com2`
where 1 and user='$tempID'";
//echo "query3=$query3";exit;
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$row3=mysqli_fetch_array($result3);
extract($row3);
*/
//echo "comment_id=$comment_id";exit;


header("location: procedures_programmer.php?comment=y&add_comment=y&folder=community&pid=$pid");



?>














?>