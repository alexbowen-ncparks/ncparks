<?php

session_start();

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];



extract($_REQUEST);

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;

$monthly_cost=str_replace(",","",$monthly_cost);
$monthly_cost=str_replace("$","",$monthly_cost);

$yearly_cost=str_replace(",","",$yearly_cost);
$yearly_cost=str_replace("$","",$yearly_cost);

$po_original_total=str_replace(",","",$po_original_total);
$po_original_total=str_replace("$","",$po_original_total);


$database="budget";
$db="budget";
//include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
//mysqli_select_db($connection, $database); // database
mysqli_select_db($connection,$database); // database
//include("../../../include/activity.php");// database connection parameters
include("../../../include/activity_new.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");

$entered_by=substr($tempid,0,-4);

$system_entry_date=date("Ymd");



$park=strtolower($park);
$contract_admin_tempid2=strtolower($contract_admin_tempid);
//if($park=='admn'){$contract_admin_tempid2=$contract_admin_tempid;}


$query1="update `budget_service_contracts`.`contracts`
set park='$park',contract_admin_tempid='$contract_admin_tempid2',contract_type='$contract_type',service_type='$service_type',vendor='$vendor',remit_name='$remit_name',contract_num='$contract_num',po_num='$po_num',po_original_total='$po_original_total',buy_entity='$buy_entity',monthly_cost='$monthly_cost',yearly_cost='$yearly_cost',original_contract_start_date='$original_contract_start_date',original_contract_end_date='$original_contract_end_date',comments='$comments',active='$active',record_complete='$record_complete',entered_by='$entered_by',entered_by_full='$tempid',center='$center',ncas_account='$ncas_account',company='$company',remit_address='$remit_address',fid_num='$fid_num',group_num='$group_num' where id='$id'
";


//echo "query1=$query1<br /><br />";
//echo "Line 58 exit"; exit;

$result1=mysqli_query($connection,$query1) or die ("Couldn't execute query 1. $query1");



header("location: service_contracts2.php?park=$park&active=$active");


?>