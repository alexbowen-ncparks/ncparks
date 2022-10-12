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
//echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;
//echo "<pre>";print_r($_SESSION);"</pre>"; //exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

$sed=date("Ymd");

if($level>'0')
{
$query3a="update scores set posted='y',posted_by='$tempID',post_date='$sed' where sid='$sid' and pid='$pid' ; ";
//echo "<br />query3a=$query3a<br />"; //exit;

$result3a = mysqli_query($connection, $query3a) or die ("Couldn't execute query3a. $query3a");

if($gid=='116')
{

$query3b="update pcard_users set student_score='$score',student_test_date='$sed' where student_id='$tempID' ; ";
//echo "<br />query3b=$query3b<br />"; exit;

$result3b = mysqli_query($connection, $query3b) or die ("Couldn't execute query3b. $query3b");



}

}

//$result3a = mysqli_query($connection, $query3a) or die ("Couldn't execute query3a. $query3a");
//echo "<br />Line62 OK<br />"; exit;
header("location: scores.php?one_game_score=$one_game_score&gidS=$gidS");
//exit;


?>