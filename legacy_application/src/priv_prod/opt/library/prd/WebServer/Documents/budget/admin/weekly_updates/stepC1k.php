<?php
//ini_set('display_errors',1);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
$end_date=str_replace("-","",$end_date);
//echo $end_date; exit;
echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters



$query="truncate table exp_rev_dncr_temp; ";

//echo "line 24: query=$query<br />"; exit;
			 
mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");


$query1="insert into exp_rev_dncr_temp(`eff_date`, `comp`, `account`, `account_description`, `center`, `doc_id`, `line`, `inv_date`, `pay_entity`, `txn_description`, `check_num`, `ctrld`, `grp`, `sign`, `amount`, `sys`, `vendor_num`, `buy_entity`, `po_number`)
         select `eff_date`, `comp`, `account`, `account_description`, `center`, `doc_id`, `line`, `inv_date`, `pay_entity`, `txn_description`, `check_num`, `ctrld`, `grp`, `sign`, `amount`, `sys`, `vendor_num`, `buy_entity`, `po_number` from exp_rev_dncr_temp1 ";

//echo "line 24: query=$query<br />"; exit;
			 
mysqli_query($connection, $query1) or die ("Couldn't execute query1.  $query1");


$query2="insert into exp_rev_dncr_temp(`eff_date`, `comp`, `account`, `account_description`, `center`, `doc_id`, `line`, `inv_date`, `pay_entity`, `txn_description`, `check_num`, `ctrld`, `grp`, `sign`, `amount`, `sys`, `vendor_num`, `buy_entity`, `po_number`)
         select `eff_date`, `comp`, `account`, `account_description`, `center`, `doc_id`, `line`, `inv_date`, `pay_entity`, `txn_description`, `check_num`, `ctrld`, `grp`, `sign`, `amount`, `sys`, `vendor_num`, `buy_entity`, `po_number` from exp_rev_dncr_temp2 ";

//echo "line 24: query=$query<br />"; exit;
			 
mysqli_query($connection, $query2) or die ("Couldn't execute query2.  $query2");



$query3="insert into exp_rev_dncr_temp(`eff_date`, `comp`, `account`, `account_description`, `center`, `doc_id`, `line`, `inv_date`, `pay_entity`, `txn_description`, `check_num`, `ctrld`, `grp`, `sign`, `amount`, `sys`, `vendor_num`, `buy_entity`, `po_number`)
         select `eff_date`, `comp`, `account`, `account_description`, `center`, `doc_id`, `line`, `inv_date`, `pay_entity`, `txn_description`, `check_num`, `ctrld`, `grp`, `sign`, `amount`, `sys`, `vendor_num`, `buy_entity`, `po_number` from exp_rev_dncr_temp3 ";

//echo "line 24: query=$query<br />"; exit;
			 
mysqli_query($connection, $query3) or die ("Couldn't execute query3.  $query3");


$query4="insert into exp_rev_dncr_temp(`eff_date`, `comp`, `account`, `account_description`, `center`, `doc_id`, `line`, `inv_date`, `pay_entity`, `txn_description`, `check_num`, `ctrld`, `grp`, `sign`, `amount`, `sys`, `vendor_num`, `buy_entity`, `po_number`)
         select `eff_date`, `comp`, `account`, `account_description`, `center`, `doc_id`, `line`, `inv_date`, `pay_entity`, `txn_description`, `check_num`, `ctrld`, `grp`, `sign`, `amount`, `sys`, `vendor_num`, `buy_entity`, `po_number` from exp_rev_dncr_temp4 ";

//echo "line 24: query=$query<br />"; exit;
			 
mysqli_query($connection, $query4) or die ("Couldn't execute query4.  $query4");






$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");





////mysql_close();



{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&report_type=form");}

 ?>




















