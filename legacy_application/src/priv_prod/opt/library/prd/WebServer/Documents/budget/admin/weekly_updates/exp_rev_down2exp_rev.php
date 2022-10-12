<?php
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);
$today_date=date("Ymd");
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date";//exit;
//echo "<br />"; 
//echo "today_date=$today_date";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
include("../../../budget/menu1314.php");
if ($_SESSION['budget']['level'] < 3){echo "You do not have Admin privileges.";exit();}
$level=$_SESSION['budget']['level'];
echo "<table><tr><td><form action='/budget/b/exp_rev_down2exp_rev.php'><font color='red'>CAUTION: </font>EXP_REV must first be backed up.<br />
FY data from exp_rev_down TABLE to exp_rev TABLE: <input type='text' name='fy' size='5'><input type='hidden' name='segment' value='1'>
<input type='Submit' name='Submit' value='Move 1'></form></td>";
echo "</tr></table>";
?>