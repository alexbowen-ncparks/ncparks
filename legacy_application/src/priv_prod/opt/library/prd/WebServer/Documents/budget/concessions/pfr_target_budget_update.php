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
$receipt_target=str_replace(",","",$receipt_target);
$target_markup=str_replace("$","",$target_markup);
//$ncas_center=str_replace("-","",$ncas_center);
$markup_factor=1+($target_markup/100);
echo "<br />markup_factor=$markup_factor<br />";
$disburse_target=$receipt_target/$markup_factor;
echo "<br />disburse_target=$disburse_target<br />";


//echo "tempid=$tempid";

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>"; exit;
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");



$entered_by=$tempid;
$system_entry_date=date("Ymd");

//echo "<br />entered_by=$entered_by<br />";
//echo "<br />system_entry_date=$system_entry_date<br />";

$query1="insert ignore into pfr_budgets set center='$center',parkcode='$parkcode',scope='park',pfr_center='y',f_year='$fyear' ";

//echo "<br />query1=$query1<br />";

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query");


$query2="update pfr_budgets
         set total_receipts_target2='$receipt_target',total_disburse_target2='$disburse_target',total_markup2='$target_markup',last_update='$system_entry_date',update_by='$entered_by'
         where center='$center' and parkcode='$parkcode' and f_year='$fyear'		 ";

//echo "<br />query2=$query2<br />";

mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$query1u="update report_budget_history_inc_stmt_by_fyear_pfr as t1 ,pfr_budgets as t2 
          set t1.receipt_target=t2.total_receipts_target2,t1.disburse_target=t2.total_disburse_target2,t1.total_markup2=t2.total_markup2,t1.last_update=t2.last_update,t1.update_by=t2.update_by
		  where t1.center=t2.center and t1.f_year='$fyear' and t2.f_year='$fyear' ";
		  
//echo "<br />query1u=$query1u<br />";  exit;


mysqli_query($connection, $query1u) or die ("Couldn't execute query 1u. $query1u");




//echo "<br />Line 64<br />";
//exit;

header("location: park_inc_stmts_by_fyear_v2.php?scope=all&report_type=pfr&fyear=$fyear");


?>