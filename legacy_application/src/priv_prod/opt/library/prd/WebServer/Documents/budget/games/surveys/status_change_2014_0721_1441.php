<?php
session_start();

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
$player=$_SESSION['budget']['tempID'];


extract($_REQUEST);

//echo "$report_date<br />";exit;


//echo $concession_location;
/*
if($level=='5' and $tempID !='Dodd3454')
{
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
}
*/
echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
echo "<pre>";print_r($_SESSION);"</pre>";exit;
if($status=='show'){$status_change='hide';}
if($status=='hide'){$status_change='show';}
//echo "status_change=$status_change";//exit;
//echo "<br />";
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters


if($level=='5')
{


$query3a="update survey_games set status='$status_change' where gid='$gid' ; ";
//echo "query3a=$query3a";exit;
}

$result3a = mysql_query($query3a) or die ("Couldn't execute query3a. $query3a");

header("location: games.php");

//exit;


?>