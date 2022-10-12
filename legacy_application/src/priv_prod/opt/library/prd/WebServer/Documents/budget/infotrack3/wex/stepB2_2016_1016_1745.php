<?php
//ini_set('display_errors',1);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
$end_date=str_replace("-","",$end_date);
//echo $end_date; exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
//echo "tempid=$tempid<br />";

/*
$database="divper";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database

$sql = "SELECT Nname,Fname,Lname,phone From empinfo where tempID='$tempid'";

$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
$row=mysql_fetch_array($result);
extract($row);

$prepared_by=$Fname." ".$Lname;

$received_by=$prepared_by;
*/


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters



$query1="insert into wex_detail(custom_vehicle_asset_id,units,net_cost,product_description,vin,driver_last_name,driver_first_name)
         select custom_vehicle_asset_id,units,net_cost,product_description,vin,driver_last_name,driver_first_name
		 from wex_import where 1 and transaction_date != 'Transaction Date' ";
			 
mysql_query($query1) or die ("Couldn't execute query 1.  $query1");

//echo "query1<br />";

$query2="update wex_detail
set ncas_account='533320'
where product_description='diesel 1'
and valid='n' ";
			 
mysql_query($query2) or die ("Couldn't execute query 2.  $query2");

//echo "query2<br />";



$query3="update wex_detail
set ncas_account='533310'
where product_description !='diesel 1'
and valid='n' ";
			 
mysql_query($query3) or die ("Couldn't execute query 3.  $query3");

//echo "query3<br />";


$query4="update budget.wex_detail,fuel.vehicle
set budget.wex_detail.center_code=fuel.vehicle.center_code
where budget.wex_detail.vin=fuel.vehicle.vin
and valid='n' ";
			 
mysql_query($query4) or die ("Couldn't execute query 4.  $query4");

//echo "query4<br />";


$query4a="update budget.wex_detail,budget.wex_detail_adjust2
set budget.wex_detail.center_code=budget.wex_detail_adjust2.center_code
where budget.wex_detail.vin=budget.wex_detail_adjust2.vin
and budget.wex_detail.valid='n' ";
			 
mysql_query($query4a) or die ("Couldn't execute query 4a.  $query4a");


//echo "query4a<br />";

$query5="update budget.wex_detail
set center_code='none'
where center_code='' ";
			 
mysql_query($query5) or die ("Couldn't execute query 5.  $query5");

//echo "query5<br />";




$query6="update wex_detail,center
set wex_detail.center=center.center
where wex_detail.center_code=center.parkcode; ";
			 
mysql_query($query6) or die ("Couldn't execute query 6.  $query6");


//echo "query6<br />";


$query7="update wex_detail
set center='none'
where center='' ";
			 
mysql_query($query7) or die ("Couldn't execute query 7.  $query7");



$query7a="select count(id) as 'incomplete_records' 
          from wex_detail
		  where valid='n'
		  and center='none' ";

		  
echo "query7a=$query7a <br />";		  

$result7a = mysql_query($query7a) or die ("Couldn't execute query 7a.  $query7a");

$row7a=mysql_fetch_array($result7a);
extract($row7a);


//echo "incomplete_records=$incomplete_records <br />";  exit;

//if($incomplete_records != '0') {$icr='y';} else {$icr='n';)
if($incomplete_records == '0') {include("stepB2a.php");} //All records have Center Values
if($incomplete_records != '0') {include("stepB2b.php");} //1+ Records are missing Center Values


 ?>




















