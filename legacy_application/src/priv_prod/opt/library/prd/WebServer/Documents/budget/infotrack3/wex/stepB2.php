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
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

$sql = "SELECT Nname,Fname,Lname,phone From empinfo where tempID='$tempid'";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$row=mysqli_fetch_array($result);
extract($row);

$prepared_by=$Fname." ".$Lname;

$received_by=$prepared_by;
*/


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters



$query1="insert into wex_detail(custom_vehicle_asset_id,units,net_cost,product_description,vin,driver_last_name,emboss_line_2,driver_first_name,transaction_date,transaction_time,card_number,fuel_type,unit_of_measure,unit_cost,total_fuel_cost,merchant_name,
           merchant_address,merchant_city,merchant_state,current_odometer,adjusted_odometer,previous_odometer,distance_driven,fuel_economy,gross_cost,exempt_tax,post_date)
         select custom_vehicle_asset_id,units,net_cost,product_description,vin,driver_last_name,emboss_line_2,driver_first_name,transaction_date,transaction_time,card_number,product,unit_of_measure,unit_cost,total_fuel_cost,merchant_name,merchant_address,merchant_city,merchant_state_province,current_odometer,adjusted_odometer,previous_odometer,distance_driven,fuel_economy,gross_cost,exempt_tax,post_date
		 from wex_import where 1 and transaction_date != 'Transaction Date' ";
			 
mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

//echo "query1<br />";

/* 2022-05-25: CCOOPER - Ticket 288 - WEX: Multiple types of 'diesel', so we need to say "like", instead of "="

$query2="update wex_detail
set ncas_account='533320'
where product_description='diesel 1'
and valid='n' "; */

$query2="update wex_detail 
set ncas_account='533320' 
where product_description like '%diesel%' 
and valid='n' ";

/* 2022-05-25: End CCOOPER */
			 
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

//echo "query2<br />";

/* 2022-05-25: CCOOPER - Ticket 288 - WEX: Multiple types of 'diesel', so we need to say "not like", instead of "!="

$query3="update wex_detail
set ncas_account='533310'
where product_description !='diesel 1'
and valid='n' "; */

$query3="update wex_detail 
set ncas_account='533310' 
where product_description not like '%diesel%' 
and valid='n' ";

/* 2022-05-25: End CCOOPER */
			 
mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

//echo "query3<br />";


$query4="update budget.wex_detail,fuel.vehicle
set budget.wex_detail.center_code=fuel.vehicle.center_code
where budget.wex_detail.vin=fuel.vehicle.vin
and valid='n' ";
			 
mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

//echo "query4<br />";


$query4a="update budget.wex_detail,budget.wex_detail_adjust2
set budget.wex_detail.center_code=budget.wex_detail_adjust2.center_code
where budget.wex_detail.vin=budget.wex_detail_adjust2.vin
and budget.wex_detail.valid='n' ";
			 
mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");


$query4b="update wex_detail
          set center_code='eadi' where center_code='core'
		  and valid='n' ";
			 
mysqli_query($connection, $query4b) or die ("Couldn't execute query 4b.  $query4b");


$query4c="update wex_detail
          set center_code='wedi' where center_code='more'
		  and valid='n' ";
			 
mysqli_query($connection, $query4c) or die ("Couldn't execute query 4c.  $query4c");


//echo "query4a<br />";

$query5="update budget.wex_detail
set center_code='none'
where center_code='' ";
			 
mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");

//echo "query5<br />";



/* 2022-05-25: CCOOPER - Ticket 286 - WEX: CACR center was not being returned
from the center table, it was not 'unique' enough

$query6="update wex_detail,center set wex_detail.center=center.center where wex_detail.center_code=center.parkcode; " */

$query6="update wex_detail,center
set wex_detail.center=center.center
where wex_detail.center_code=center.parkcode
and center.new_center like '1680%'";

/* 2022-05-25: End CCOOPER */
			 
mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");


//echo "query6<br />";


$query7="update wex_detail
set center='none'
where center='' ";
			 
mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");



$query7a="select count(id) as 'incomplete_records' 
          from wex_detail
		  where valid='n'
		  and center='none' ";

		  
echo "query7a=$query7a <br />";		  

$result7a = mysqli_query($connection, $query7a) or die ("Couldn't execute query 7a.  $query7a");

$row7a=mysqli_fetch_array($result7a);
extract($row7a);


//echo "incomplete_records=$incomplete_records <br />";  exit;

//if($incomplete_records != '0') {$icr='y';} else {$icr='n';)
if($incomplete_records == '0') {include("stepB2a.php");} //All records have Center Values
if($incomplete_records != '0') {include("stepB2b.php");} //1+ Records are missing Center Values


 ?>




















