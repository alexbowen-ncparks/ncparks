<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>"; exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<br />num3=$num3<br />";  //exit;
echo "<pre>";print_r($_REQUEST);"</pre>"; exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
$num4=$num3[0];
$f_year2=$f_year[0];
//echo "<br />num4=$num4<br />"; //exit;
//echo "<br />f_year2=$f_year2<br />"; //exit;
$query1="update energy1 SET";
for($j=0;$j<$num4;$j++)
{
if($valid_account_number[$j] ==""){continue;}
$query2=$query1;
	$query2.=" account_number='$valid_account_number[$j]'";	
	$query2.=" where id='$id[$j]'";
		
echo "<br /><br />query2=$query2<br /><br />"; 
//$result=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");
}	
exit;



/*
$query3="update energy1,energy_report_electricity_accounts
set energy1.valid_account='y'
where energy1.ncas_account='532210'
and energy1.ncas_center=energy_report_electricity_accounts.ncas_center
and energy1.account_number=energy_report_electricity_accounts.electricity_account_number
and energy1.f_year='$f_year2'
and energy_report_electricity_accounts.f_year='$f_year2' ;";

//echo "<br />query3=$query3<br />";  //exit;

$result3=mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");


$query4="update energy1,energy_report_electricity_accounts
set energy1.valid_account='y'
where energy1.ncas_account='532210'
and energy1.ncas_center=energy_report_electricity_accounts.ncas_center_new
and energy1.account_number=energy_report_electricity_accounts.electricity_account_number
and energy1.f_year='$f_year2'
and energy_report_electricity_accounts.f_year='$f_year2' ;";

//echo "<br />query4=$query4<br />";  exit;




$result4=mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");









{header("location: energy_reporting.php?f_year=$f_year2&egroup=electricity&report=cdcs&valid_account=n&center_code=$center_code");}
*/
echo "<br /><br />Line 77 end of page<br /><br />"; exit; 
 ?>