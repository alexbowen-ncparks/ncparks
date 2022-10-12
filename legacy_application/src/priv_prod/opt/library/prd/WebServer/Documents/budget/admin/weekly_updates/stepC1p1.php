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
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

//echo "fiscal_year=$fiscal_year";  exit;



$query2="insert into exp_rev_dncr_temp_part2_dpr(eff_date,eff_date2,f_year,comp,account,valid_account_dpr,cash_type,account_description,center,fund,valid_dpr_center,doc_id,line,inv_date,pay_entity,txn_description,check_num,ctrld,grp,sign,amount,debit,credit,sys,vendor_num,buy_entity,po_number,source)
select 
eff_date,eff_date2,f_year,comp,account,valid_account_dpr,cash_type,account_description,center,mid(center,1,4),valid_dpr_center,doc_id,line,inv_date,pay_entity,txn_description,check_num,ctrld,grp,sign,amount,debit,credit,sys,vendor_num,buy_entity,po_number,'manual'
from exp_rev_dncr_temp_part2_dpr_adjust3
where 1 and f_year='$fiscal_year'
and valid_adjust='y'
 ";

		 
mysqli_query($connection, $query2) or die ("Couldn't execute query2.  $query2");

$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");




{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&report_type=form");}

 ?>