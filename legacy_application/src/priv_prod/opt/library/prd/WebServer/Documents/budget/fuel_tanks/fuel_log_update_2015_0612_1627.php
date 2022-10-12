<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
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
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
$system_entry_date=date("Ymd");




$query1="update fuel_tank_usage_detail SET";
for($j=0;$j<$num14;$j++){
$query2=$query1;
//$checknum2=addslashes($checknum[$j]);
//if($checknum2==''){continue;}
//$payor2=addslashes($payor[$j]);
//$payor_bank2=addslashes($payor_bank[$j]);
//$description2=addslashes($description[$j]);
//$amount2=$amount[$j];
//$amount2=str_replace(",","",$amount2);
//$amount2=str_replace("$","",$amount2);
	$query2.=" usage_day='$dayofmonth[$j]',";
	$query2.=" tag_num='$taglist[$j]',";
	//$query2.=" vehicle_num='$vehicle_num[$j]',";
	$query2.=" gallons='$gallons[$j]',";
	$query2.=" driver_name='$driver_name[$j]'";
	$query2.=" where id='$id[$j]'";
		

$result=mysql_query($query2) or die ("Couldn't execute query 2. $query2");
}	
$query3="delete from fuel_tank_usage_detail
         where tag_num='' and gallons='0.00' and driver_name=''
         and park='$parkcode' and cash_month_calyear='$cash_month_calyear' and cash_month='$cash_month'		 ";
$result3=mysql_query($query3) or die ("Couldn't execute query 3. $query3");


//echo "Update Successful<br />";



header("location: page2_form.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear");

 
 ?>




















