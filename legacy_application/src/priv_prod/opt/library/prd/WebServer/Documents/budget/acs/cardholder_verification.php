<?php

session_start();

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
$concession_center_L3=substr($concession_center,-3);
$first_fyear_deposit=$concession_center_L3.'001';
//echo "concession_center_L3=$concession_center_L3<br />";//exit;
//echo "first_fyear_deposit=$first_fyear_deposit";//exit;


extract($_REQUEST);

//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;


/*

$rc_total=array_sum($rc_amount);
*/


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters


$entered_by=$tempid;

$sed=date("Ymd");
if($cardholder_approved==""){echo "<font color='brown' size='5'><b>Cardholder Approval missing<br /><br />Click the BACK button on your Browser to enter Cardholder Approval</b></font><br />";exit;}


if($cardholder_approved=='y')
{
$query1="update pcard_users set pcard_holder='$entered_by',pcard_holder_date='$sed'
         where id='$id' ";  

  
		 
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");	


}


{header("location: pcard_request4_cardholder_verify.php ");}



?>