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

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
echo "<pre>";print_r($_REQUEST);"</pre>";   //exit;

//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
if($submit2=='YES'){$document_reload='n';}
if($submit2=='NO'){$document_reload='y';}
//echo "status_change=$status_change";//exit;
//echo "<br />";
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters


$query3a="update crs_tdrr_division_deposits
          set document_reload='$document_reload'
          where id='$id'		  ; ";
//echo "query3a=$query3a"; exit;


$result3a = mysqli_query($connection, $query3a) or die ("Couldn't execute query3a. $query3a");

header("location: bank_deposit_slip.php?id=$id");


//exit;


?>