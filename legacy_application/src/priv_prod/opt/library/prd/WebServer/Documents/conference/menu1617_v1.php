<?php
if(empty($_SESSION)){session_start();}
if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
$concession_center_new=$_SESSION['budget']['centerSess_new'];
//echo "<br />concession_center_new=$concession_center_new<br /><br />";
$tempid1=substr($tempid,0,-2);
/*
if($beacnum=='60033242')
{echo "<table align='center'><tr><th>Hello Lisa and Welcome to NC State Parks</th></tr><tr><tr><th>ALL Features are now working.<br /> Tony P Bass (February 3, 2014)</th></tr></table>";
}
*/

extract($_REQUEST);
$database="conference";
$db="conference";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database

echo "<html>";
echo "<head>";
echo "<title>MoneyTracker</title>";
//include ("menu1617_v1_style.php");

echo "</head>";

echo "<body>";
//include ("menu1617_v1_header.php");
echo "<br />Hello Line 37<br />";
echo "</body>";
echo "</html>";


?>