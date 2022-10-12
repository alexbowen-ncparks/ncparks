<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

echo "<pre>";print_r($_SESSION);echo "</pre>"; //exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;
$system_entry_date=date("Ymd");




$query8="update fuel_tank_usage
      	 set cashier='$tempid',cashier_date='$system_entry_date'
		 where park='$parkcode' and cash_month_calyear='$cash_month_calyear' and cash_month='$cash_month' 	
          ";
		  
		  
//echo "query8=$query8<br />"; exit;

		  
$result8=mysql_query($query8) or die ("Couldn't execute query 8. $query8");




header("location: page2_form.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear&fyear=$fyear&step=3");


 
 ?>




















