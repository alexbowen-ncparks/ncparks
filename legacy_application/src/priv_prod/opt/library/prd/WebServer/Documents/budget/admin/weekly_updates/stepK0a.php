<?php

session_start();

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//include("../../../../include/activity.php");

////mysql_connect($host,$username,$password);
mysqli_select_db($connection,$database) or die( "Unable to select database");


$query="select cy,py1 from fiscal_year where energy_update_year='y' ";
//echo "<br />line 21: query=$query<br />";

$result = mysqli_query($connection, $query) or die ("Couldn't execute query .  $query");

$row=mysqli_fetch_array($result);
extract($row);

//echo "<br />cy=$cy<br />";
//echo "<br />py1=$py1<br />";


// Establish initial Electricity Accounts for NEW Reporting Year into TABLE=energy_report_electricity_accounts


$query="truncate table energy_report_electricity_accounts_temp";
//echo "<br />line 34: query=$query<br />";
mysqli_query($connection, $query) or die ("Couldn't execute query .  $query");

$query="insert into energy_report_electricity_accounts_temp(`f_year`, `division`, `park`, `electricity_account_number`, `electricity_account_number2`, `building_name`, `address`, `city`, `vendor_name`, `ncas_center`, `ncas_center_new`, `valid_account`,`view`)
        select '$cy', `division`, `park`, `electricity_account_number`, `electricity_account_number2`, `building_name`, `address`, `city`, `vendor_name`, `ncas_center`, `ncas_center_new`, `valid_account`, `energy1_match`, `record_match`, `view`
		from energy_report_electricity_accounts where f_year='$py1'";
		
//echo "<br />line 41: query=$query<br />";

mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");


$query="insert ignore into energy_report_electricity_accounts(`f_year`, `division`, `park`, `electricity_account_number`, `electricity_account_number2`, `building_name`, `address`, `city`, `vendor_name`, `ncas_center`, `ncas_center_new`, `valid_account`, `view`)
        select `f_year`, `division`, `park`, `electricity_account_number`, `electricity_account_number2`, `building_name`, `address`, `city`, `vendor_name`, `ncas_center`, `ncas_center_new`, `valid_account`, `energy1_match`, `record_match`, `view`
		from energy_report_electricity_accounts_temp where 1 ";
		
//echo "<br />line 41: query=$query<br />";

mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");




// Establish initial Water Accounts for NEW Reporting Year into TABLE=energy_report_water_accounts

$query="truncate table energy_report_water_accounts_temp";
//echo "<br />line 62: query=$query<br />";
mysqli_query($connection, $query) or die ("Couldn't execute query .  $query");

$query="insert into energy_report_water_accounts_temp(`f_year`, `division`, `park`, `water_account_number`, `building_name`, `address`, `city`, `vendor_name`, `ncas_center`, `ncas_center_new`, `valid_account`)
        select '$cy', `division`, `park`, `water_account_number`, `building_name`, `address`, `city`, `vendor_name`, `ncas_center`, `ncas_center_new`, `valid_account`
		from energy_report_water_accounts where f_year='$py1'";
		
//echo "<br />line 69: query=$query<br />";

mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");


$query="insert ignore into energy_report_water_accounts(`f_year`, `division`, `park`, `water_account_number`, `building_name`, `address`, `city`, `vendor_name`, `ncas_center`, `ncas_center_new`, `valid_account`)
        select `f_year`, `division`, `park`, `water_account_number`, `building_name`, `address`, `city`, `vendor_name`, `ncas_center`, `ncas_center_new`, `valid_account`
		from energy_report_water_accounts_temp where 1 ";
		
//echo "<br />line 78: query=$query<br />";

mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");


// Establish initial Propane Accounts for NEW Reporting Year into TABLE=energy_report_propane_accounts

$query="truncate table energy_report_propane_accounts_temp";
//echo "<br />line 62: query=$query<br />";
mysqli_query($connection, $query) or die ("Couldn't execute query .  $query");

$query="insert into energy_report_propane_accounts_temp(`f_year`, `division`, `park`, `propane_account_number`, `building_name`, `address`, `city`, `vendor_name`, `cdcs_uom`, `ncas_center`, `ncas_center_new`, `valid_account`)
        select '$cy', `division`, `park`, `propane_account_number`, `building_name`, `address`, `city`, `vendor_name`, `cdcs_uom`, `ncas_center`, `ncas_center_new`, `valid_account` 
		from energy_report_propane_accounts where f_year='$py1'";
		
//echo "<br />line 69: query=$query<br />";

mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");


$query="insert ignore into energy_report_propane_accounts(`f_year`, `division`, `park`, `propane_account_number`, `building_name`, `address`, `city`, `vendor_name`, `cdcs_uom`, `ncas_center`, `ncas_center_new`, `valid_account`)
        select `f_year`, `division`, `park`, `propane_account_number`, `building_name`, `address`, `city`, `vendor_name`, `cdcs_uom`, `ncas_center`, `ncas_center_new`, `valid_account`
		from energy_report_propane_accounts_temp where 1 ";
		
//echo "<br />line 78: query=$query<br />";

mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");



//exit;

$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

$query24="select * from budget.project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result24=mysqli_query($connection, $query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysqli_num_rows($result24);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num24==0)

{$query25="update budget.project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");}
////mysql_close();

if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}


////mysql_close();
header("location:step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");


 ?>



 