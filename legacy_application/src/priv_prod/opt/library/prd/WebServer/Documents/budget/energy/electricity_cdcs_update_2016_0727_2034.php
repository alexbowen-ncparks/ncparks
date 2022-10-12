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
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

$query1="update energy1 SET";
for($j=0;$j<$num3;$j++)
{
if($valid_account_number[$j] ==""){continue;}
$query2=$query1;
	$query2.=" account_number='$valid_account_number[$j]'";	
	$query2.=" where id='$id[$j]'";
		

$result=mysql_query($query2) or die ("Couldn't execute query 2. $query2");
}	

$query3="update energy1,energy_report_electricity_accounts
set energy1.valid_account='y'
where energy1.ncas_account='532210'
and energy1.ncas_center=energy_report_electricity_accounts.ncas_center
and energy1.account_number=energy_report_electricity_accounts.electricity_account_number
and energy1.f_year='$f_year'
and energy_report_electricity_accounts.f_year='$f_year' ;";

$result3=mysql_query($query3) or die ("Couldn't execute query 3. $query3");


{header("location: energy_reporting.php?f_year=$f_year&egroup=electricity&report=cdcs&valid_account=n");}

 
 ?>




















