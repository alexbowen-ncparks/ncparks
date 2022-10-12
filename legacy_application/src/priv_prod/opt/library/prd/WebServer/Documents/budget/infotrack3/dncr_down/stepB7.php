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


$query1="truncate table exp_rev_dncr_temp_part2_dpr";

		 
mysqli_query($connection, $query1) or die ("Couldn't execute query1.  $query1");


$query2="insert into exp_rev_dncr_temp_part2_dpr(eff_date,eff_date2,comp,account,valid_account,account_description,center,fund,valid_dpr_center,doc_id,line,inv_date,pay_entity,txn_description,check_num,ctrld,grp,sign,amount,sys,vendor_num,buy_entity,po_number)
select 
eff_date,eff_date2,comp,account,valid_account,account_description,center,mid(center,1,4),valid_dpr_center,doc_id,line,inv_date,pay_entity,txn_description,check_num,ctrld,grp,sign,amount,sys,vendor_num,buy_entity,po_number
from exp_rev_dncr_temp_part2
where valid_dpr_center='y' ";

		 
mysqli_query($connection, $query2) or die ("Couldn't execute query2.  $query2");


$query3="update budget.exp_rev_dncr_temp_part2_dpr
set valid_account='n'
where mid(account,1,1)='3' ; ";

$result3=mysqli_query($connection, $query3) or die ("Couldn't execute query 3  $query3");


$query4="update budget.exp_rev_dncr_temp_part2_dpr
set valid_account='n'
where mid(account,1,1)='1' ; ";

$result4=mysqli_query($connection, $query4) or die ("Couldn't execute query 4  $query4");


$query5="update budget.exp_rev_dncr_temp_part2_dpr
set debit=amount
where sign != '-' ; ";

$result5=mysqli_query($connection, $query5) or die ("Couldn't execute query 5  $query5");


$query6="update budget.exp_rev_dncr_temp_part2_dpr
set credit=amount
where sign = '-' ; ";

$result6=mysqli_query($connection, $query6) or die ("Couldn't execute query 6  $query6");


$query7="update budget.exp_rev_dncr_temp_part2_dpr
set old_account=account
where account='4.32E+13' ";

$result7=mysqli_query($connection, $query7) or die ("Couldn't execute query 7  $query7");

$query7a="update budget.exp_rev_dncr_temp_part2_dpr
set account='432E11'
where old_account='4.32E+13' ";

$result7a=mysqli_query($connection, $query7a) or die ("Couldn't execute query 7a  $query7a");


$query8="update budget.exp_rev_dncr_temp_part2_dpr
set old_account=account
where account='4.32E+11' ";

$result8=mysqli_query($connection, $query8) or die ("Couldn't execute query 8  $query8");


$query8a="update budget.exp_rev_dncr_temp_part2_dpr
set account='432E09'
where old_account='4.32E+11' ";

$result8a=mysqli_query($connection, $query8a) or die ("Couldn't execute query 8a  $query8a");


$query9="update budget.exp_rev_dncr_temp_part2_dpr
set old_account=account
where account='5.36E+27' ";

$result9=mysqli_query($connection, $query9) or die ("Couldn't execute query 9  $query9");


$query9a="update budget.exp_rev_dncr_temp_part2_dpr
set account='536E25'
where old_account='5.36E+27' ";

$result9a=mysqli_query($connection, $query9a) or die ("Couldn't execute query 9a  $query9a");


$query10="update budget.exp_rev_dncr_temp_part2_dpr,coa
set exp_rev_dncr_temp_part2_dpr.valid_account_dpr='y'
where exp_rev_dncr_temp_part2_dpr.account=coa.ncasnum";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10  $query10");


$query11="update budget.exp_rev_dncr_temp_part2_dpr,coa
set exp_rev_dncr_temp_part2_dpr.cash_type=coa.cash_type
where exp_rev_dncr_temp_part2_dpr.account=coa.ncasnum
and exp_rev_dncr_temp_part2_dpr.valid_account_dpr='y' ";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11  $query11");


$query12="update budget.exp_rev_dncr_temp_part2_dpr
          set fund=mid(center,1,4)
          where 1		  ";

$result12=mysqli_query($connection, $query12) or die ("Couldn't execute query 12  $query12");


$query13="update budget.exp_rev_dncr_temp_part2_dpr
          set f_year='$fiscal_year'
          where 1		  ";

$result13=mysqli_query($connection, $query13) or die ("Couldn't execute query 13  $query13");




$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");





////mysql_close();



{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&report_type=form");}

 ?>




















