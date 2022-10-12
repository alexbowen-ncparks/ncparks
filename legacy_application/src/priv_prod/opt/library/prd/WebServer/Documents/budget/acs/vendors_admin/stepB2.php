<?php

//echo "PHP File table1_backup.php";  //exit;

//ini_set('display_errors',1);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//$end_date=str_replace("-","",$end_date);
//echo $end_date; exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters


$start_date=$_REQUEST['start_date'];
$end_date=$_REQUEST['end_date'];

$start_date=str_replace("-","",$start_date);
$end_date=str_replace('-','',$end_date);
$today_date=date("Ymd");
//$db="budget_$today_date";

//echo "<br />today_date=$today_date<br />";
$year = substr($today_date, 0, 4);
$month_day = substr($today_date, -4);
//echo "<br />year=$year<br />";
//echo "<br />month_day=$month_day<br />";
$year_previous2=$year-2;
//echo "<br />year_previous2=$year_previous2<br />";
$activity_start=$year_previous2.$month_day;
//echo "<br />activity_start=$activity_start<br />";

$query="update vendors set activity_since = '$activity_start' where 1";
//echo "<br />query=$query<br />"; //exit;
$result=mysqli_query($connection, $query) or die ("Couldn't execute query . $query");

$query="update vendors set activity_yn='n' where 1";
//echo "<br />query=$query<br />"; //exit;
$result=mysqli_query($connection, $query) or die ("Couldn't execute query . $query");


$query="update vendors,cid_vendor_invoice_payments
        set vendors.activity_yn='y' where vendors.parkcode=cid_vendor_invoice_payments.parkcode and vendors.vendor_number=cid_vendor_invoice_payments.vendor_number
		and cid_vendor_invoice_payments.system_entry_date >= '$activity_start' ";
//echo "<br />query=$query<br />"; //exit;
$result=mysqli_query($connection, $query) or die ("Couldn't execute query . $query");

/*
$query="update vendors,cid_vendor_invoice_payments
        set vendors.activity_since_begin='y' where vendors.parkcode=cid_vendor_invoice_payments.parkcode and vendors.vendor_number=cid_vendor_invoice_payments.vendor_number ";
//echo "<br />query=$query<br />"; //exit;
$result=mysqli_query($connection, $query) or die ("Couldn't execute query . $query");
*/


$query="update vendors set last_update = '$today_date' where 1";
//echo "<br />query=$query<br />"; //exit;
$result=mysqli_query($connection, $query) or die ("Couldn't execute query . $query");

$query="insert ignore into vendors_archive(`vendor_name`, `vendor_number`, `vendor_number2`, `cdcs_match`, `vendor_address`, `group_number`, `pay_entity`, `parkcode`, `remit_code`, `account_vendor`, `comments`, `account_optional`, `activity_since`, `activity_yn`, `last_update`)
select `vendor_name`, `vendor_number`, `vendor_number2`, `cdcs_match`, `vendor_address`, `group_number`, `pay_entity`, `parkcode`, `remit_code`, `account_vendor`, `comments`, `account_optional`, `activity_since`, `activity_yn`, `last_update` from vendors where `activity_yn`='n' and sed <= '20190721'


";
//echo "<br />query=$query<br />"; //exit;
$result=mysqli_query($connection, $query) or die ("Couldn't execute query . $query");

$query="delete from vendors where activity_yn='n' and sed <= '20190721' ";
//echo "<br />query=$query<br />"; //exit;
$result=mysqli_query($connection, $query) or die ("Couldn't execute query . $query");


$query="select count(id) as 'deleted_records' from vendors_archive where last_update='$today_date' ";
//echo "<br />query=$query<br />"; //exit;
$result=mysqli_query($connection, $query) or die ("Couldn't execute query . $query");
$row=mysqli_fetch_array($result);
extract($row);//brings back max (end_date) as $end_date

$query="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");


//echo "<br />Successful2<br />"; //exit;
$array = array("/budget/infotrack/icon_photos/mission_icon_success_1.png", "/budget/infotrack/icon_photos/mission_icon_success_5.png", "/budget/infotrack/icon_photos/mission_icon_success_8.png", "/budget/infotrack/icon_photos/mission_icon_success_10.png");
	$k=array_rand($array);
	$photo_location=$array[$k];
	$photo_location2="<img src='$photo_location' height='100' width='100'>";
echo "<table align='center'><tr><td>$photo_location2</td><td><font size='10' color='brown'>$deleted_records Records removed from Vendors Table on $today_date. Thanks!</font></td></tr></table>";
echo "<table align='center'><tr><td><font size='10'><a href='step_group_vendors_admin.php'>Return to Vendors Admin Module</a></font></td></tr></table>";

exit;







?>