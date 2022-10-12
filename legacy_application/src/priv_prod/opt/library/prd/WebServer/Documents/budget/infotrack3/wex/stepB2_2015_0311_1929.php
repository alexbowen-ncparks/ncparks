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


$query4a="update budget.wex_detail,budget.wex_detail_adjust
set budget.wex_detail.center_code=budget.wex_detail_adjust.center_code,
budget.wex_detail.center=budget.wex_detail_adjust.center
where budget.wex_detail.vin=budget.wex_detail_adjust.vin
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

//echo "query7<br />";


//echo "update successful<br />"; exit;

$query7a="select count(id) as 'incomplete_records' 
          from wex_detail
		  where valid='n'
		  and center='' ";


$result7a = mysql_query($query7a) or die ("Couldn't execute query 7a.  $query7a");

$row7a=mysql_fetch_array($result7a);
extract($row7a);

if($incomplete_records > 0)

 {
 
 echo "Form to update (table=wex_detail_adjust) goes here"; exit;
 
 
 }
		  
		  

		  

/*

$query8="insert into wex_report(center,center_code,ncas_account,amount,month,calyear)
select center,center_code,ncas_account,sum(net_cost),month,calyear
from wex_detail
where valid='n'
group by center,ncas_account
order by center,ncas_account; ";
			 
mysql_query($query8) or die ("Couldn't execute query 8.  $query8");
*/

$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
		 
		 
//echo "query23a=$query23a<br />"; exit;		 
			 
mysql_query($query23a) or die ("Couldn't execute query 23a.  $query23a");







mysql_close();

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&report=y&report_type=form ");}


 ?>




















