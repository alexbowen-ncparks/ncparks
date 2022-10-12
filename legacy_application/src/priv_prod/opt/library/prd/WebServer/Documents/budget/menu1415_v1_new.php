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
$tempid1=substr($tempid,0,-2);

extract($_REQUEST);

echo "<html>";
echo "<head>";
echo "<title>MoneyTracker</title>";
include ("menu1415_v1_style_new.php");

echo "</head>";

echo "<body>";
include ("menu1415_v1_header_new2.php");

echo "</body>";
echo "</html>";


?>