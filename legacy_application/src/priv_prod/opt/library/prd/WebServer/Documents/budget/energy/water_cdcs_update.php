<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

$query1="update energy1 SET";
for($j=0;$j<$num3;$j++)
{
if($valid_account_number[$j] ==""){continue;}
$query2=$query1;
	$query2.=" account_number='$valid_account_number[$j]'";	
	$query2.=" where id='$id[$j]'";
//echo "<br />query2=$query2<br />";	//exit;	

$result=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");
}	

$query3="update energy1,energy_report_water_accounts
set energy1.valid_account='y'
where energy1.ncas_account='532230'
and energy1.ncas_center=energy_report_water_accounts.ncas_center
and energy1.account_number=energy_report_water_accounts.water_account_number
and energy1.f_year='$f_year'
and energy_report_water_accounts.f_year='$f_year'
and energy1.valid_account='n' ;";

//echo "query3=$query3<br /><br />"; //exit;


$result3=mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");



$query4="update energy1,energy_report_water_accounts
set energy1.valid_account='y'
where energy1.ncas_account='532230'
and energy1.ncas_center=energy_report_water_accounts.ncas_center_new
and energy1.account_number=energy_report_water_accounts.water_account_number
and energy1.f_year='$f_year'
and energy_report_water_accounts.f_year='$f_year'
and energy1.valid_account='n' ;";

//echo "query4=$query4<br /><br />"; //exit;


$result4=mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");


//exit;



{header("location: energy_reporting.php?f_year=$f_year&egroup=water&report=cdcs&valid_account=n");}

 
 ?>