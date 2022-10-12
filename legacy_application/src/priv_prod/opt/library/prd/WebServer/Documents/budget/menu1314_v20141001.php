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
$tempid1=substr($tempid,0,-2);
/*
if($beacnum=='60033242')
{echo "<table align='center'><tr><th>Hello Lisa and Welcome to NC State Parks</th></tr><tr><tr><th>ALL Features are now working.<br /> Tony P Bass (February 3, 2014)</th></tr></table>";
}
*/

extract($_REQUEST);
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../include/activity.php");

$p=strtoupper($concession_location);
	include("../../include/get_parkcodes.php");
	if(!isset($concession_center)){$concession_center="";}
	$pc="<br /><font color='brown'>".$parkCodeName[$p]." - $concession_center</font>";
	echo "<table><tr><td colspan='8' align='center'><font size='+1'><b>NC State Parks MoneyCounts</b>$pc</font></td></tr><tr></table>";


?>