<?php

echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
if($post2ncas=='y'){$post2ncas2='n';}
if($post2ncas=='n'){$post2ncas2='y';}
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters

$query1="update cid_vendor_invoice_payments
         set post2ncas='$post2ncas2'
		 where id='$id' ";
		 
//echo "query1=$query1<br />"; exit;		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

echo "CVIP ID# $id post2ncas changed to $post2ncas2<br />";

//header("location: acsFind.php?findCenter=$findCenter&ncas_invoice_amount=$ncas_invoice_amount&submit_acs=Find");

?>

























