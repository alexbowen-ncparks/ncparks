<?php

session_start();

if(!$_SESSION["conference"]["tempID"]){echo "access denied";exit;}


//$active_file=$_SERVER['SCRIPT_NAME'];
//$active_file_request=$_SERVER['REQUEST_URI'];

$level=$_SESSION['conference']['level'];
//$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['conference']['tempID'];
$beacnum=$_SESSION['conference']['beacon_num'];
$team=$_SESSION['conference']['select'];
//$playstation_center=$_SESSION['budget']['centerSess'];
//$pcode=$_SESSION['budget']['select'];
extract($_REQUEST);

//echo "<br />Line 20: Welcome to conference_list.php</br>"; exit;
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>"; //exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
echo "<br />Line 24: tempid=$tempid";
echo "<br />Line 25: level=$level";
//include("../../budget/menu1314.php");
$database="conference";
$db="conference";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database


include("sspd_header1.php"); // connection parameters
include("sspd_style1.php"); // connection parameters

?>