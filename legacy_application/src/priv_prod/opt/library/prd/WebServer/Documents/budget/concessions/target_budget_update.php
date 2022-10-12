<?php

session_start();

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];



extract($_REQUEST);
//$fee_amount=str_replace(",","",$fee_amount);
//$fee_amount=str_replace("$","",$fee_amount);
//$ncas_center=str_replace("-","",$ncas_center);



//echo "tempid=$tempid";

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>"; exit;
echo "<pre>";print_r($_REQUEST);"</pre>"; exit;


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");



$entered_by=substr($tempid,0,-4);


$system_entry_date=date("Ymd");



$query1="";

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query");


header("location: park_inc_stmts_by_fyear_v2.php?scope=all&report_type=pfr&fyear=$fyear");


?>