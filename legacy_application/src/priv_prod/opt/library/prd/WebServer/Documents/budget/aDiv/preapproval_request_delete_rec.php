<?php
session_start();
if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}

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

//echo "<pre>";print_r($_REQUEST);"</pre>";  exit;
//echo "<pre>";print_r($_SESSION);"</pre>"; exit;



$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
/*
if($center_del=='y')
{
$query3a="update purchase_request_3
          set center_approved='n' 
		  where id='$id' ";
}

if($region_del=='y')
{
$query3a="update purchase_request_3
          set district_approved='n' 
		  where id='$id' ";
}

*/

$query3="select district,center_code,section from purchase_request_3 where id='$id' ";
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$row3=mysqli_fetch_array($result3);
extract($row3);

$district2=$district.'_cancel';
$center_code2=$center_code.'_cancel';
$section2=$section.'_cancel';

//echo "<br />district2=$district2<br />";
//echo "<br />center_code2=$center_code2<br />";
//echo "<br />section2=$section2<br />";



$query3a="update purchase_request_3 set district='$district2',center_code='$center_code2',section='$section2' where id='$id' ";


		  
		  
//echo "<br />query3a=$query3a<br />";		  
//exit;

$result3a = mysqli_query($connection, $query3a) or die ("Couldn't execute query3a. $query3a");

header("location: preapproval_weekly.php?report_date=$report_date&center_code=$center_code&report=y");



?>