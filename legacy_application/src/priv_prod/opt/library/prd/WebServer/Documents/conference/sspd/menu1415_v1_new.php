<?php
if(empty($_SESSION)){session_start();}
if (!$_SESSION["conference"]["tempID"]) {echo "Access denied";exit;}
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['conference']['level'];
$posTitle=$_SESSION['conference']['position'];
$tempid=$_SESSION['conference']['tempID'];
$beacnum=$_SESSION['conference']['beacon_num'];
$concession_location=$_SESSION['conference']['select'];
$concession_center=$_SESSION['conference']['centerSess'];
$concession_center_new=$_SESSION['conference']['centerSess_new'];
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