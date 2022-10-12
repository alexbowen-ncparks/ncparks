<?php


session_start();
if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}

//if($tempID=='Turner2317' and $concession_location=='MEMI'){$posTitle='park superintendent';}
//echo "$tempID=$posTitle=$concession_location";

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];

if($concession_location=='ADM'){$concession_location='ADMI';}

//$system_entry_date=date("Ymd");

extract($_REQUEST);
$menu='RCard';
$system_entry_date=date("Ymd");
$today_date=$system_entry_date;
$today_date2=date('m-d-y', strtotime($today_date));
//$edit='y';
//$deposit_id='104885853';

//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

//echo "<pre>";print_r($_SESSION);"</pre>";  //exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database


include ("../../budget/menu1415_v1.php");





echo "<br />";


echo "<br />";
include("../../budget/infotrack/slide_toggle_procedures_module2_pid94.php");



?>