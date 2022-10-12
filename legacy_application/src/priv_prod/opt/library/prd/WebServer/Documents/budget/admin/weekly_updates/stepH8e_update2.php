<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

foreach($Match as $key=>$value){
$query1="update cvip_unmatched SET post2ncas='$value' where cvip_id='$key'";
//echo "<br />query1=$query1<br />";
$result1=mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");
}

$query2="update ere_unmatched SET cvip_id='nm'
         where center='$centerO' and ncasnum='$ncasnumO' and amount='$amountO'";
		 
$result2=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");		 
//echo "<br />query2=$query2<br />";		 
//echo "Line 30 exit"; exit;		 
         
{header("location: stepH8e.php");}

 
 ?>




















