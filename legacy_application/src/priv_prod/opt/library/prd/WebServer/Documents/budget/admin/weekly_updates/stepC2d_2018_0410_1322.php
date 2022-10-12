<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
$end_date=str_replace("-","",$end_date);

//echo "<pre>";print_r($_REQUEST);echo "</pre>";  exit;
//echo "end_date=$end_date"; exit;
//Tables used:
//budget.cab_dpr,budget.coa,budget.authorized_budget,budget.valid_fund_accounts,
//budget.project_steps_detail,budget.project_steps

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters

$query14c="update bd725_dpr_temp,center
set bd725_dpr_temp.dpr='y'
where bd725_dpr_temp.fund=center.new_center
and bd725_dpr_temp.fund != '' ";

$result14c=mysql_query($query14c) or die ("Couldn't execute query 14c.  $query14c");




$query0="delete from bd725_dpr where f_year='$fiscal_year' ";

mysql_query($query0) or die ("Couldn't execute query 0.  $query0");





$query1="insert into budget.bd725_dpr(
         bc,fund,fund_descript,account,account_descript,total_budget,unallotted,
		 total_allotments,current,ytd,ptd,allotment_balance)
		 select
		 bc,fund,fund_descript,account,account_descript,total_budget,unallotted,
		 total_allotments,current,ytd,ptd,allotment_balance
		 from budget.bd725_dpr_temp
		 where 1 and dpr='y' ; ";
		 

mysql_query($query1) or die ("Couldn't execute query 1.  $query1");


$query1a="update budget.bd725_dpr set bc=trim(bc),
fund=trim(fund),
fund_descript=trim(fund_descript),
account=trim(account),
account_descript=trim(account_descript),
total_budget=trim(total_budget),
unallotted=trim(unallotted),
total_allotments=trim(total_allotments),
current=trim(current),
ytd=trim(ytd),
ptd=trim(ptd),
allotment_balance=trim(allotment_balance),
f_year=trim(f_year),
match_center_table=trim(match_center_table),
match_coa=trim(match_coa),
cash_type=trim(cash_type),
receipt_amt=trim(receipt_amt),
disburse_amt=trim(disburse_amt)";
			 
mysql_query($query1a) or die ("Couldn't execute query 1a.  $query1a");



$query1b="update budget.bd725_dpr set fund_descript2=replace(fund_descript,' ','') where 1 ";


mysql_query($query1b) or die ("Couldn't execute query 1b.  $query1b");



$query1c="insert ignore into bd725_dpr_temp_unique2(fund,fund_descript,fund_descript2)
select fund,fund_descript,fund_descript2
from bd725_dpr
where f_year='$fiscal_year' ";


mysql_query($query1c) or die ("Couldn't execute query 1c.  $query1c");





/*
$query2="delete from budget.bd725_dpr
where f_year=''
and account not like '53%'
and account not like '43%';
";
			 
mysql_query($query2) or die ("Couldn't execute query 2.  $query2");

$query3="delete from budget.bd725_dpr
where f_year=''
and account like '%dpr%';
";
			 
mysql_query($query3) or die ("Couldn't execute query 3.  $query3");

$query4="delete from budget.bd725_dpr
where f_year=''
and account like '%denr%';
";
			 
mysql_query($query4) or die ("Couldn't execute query 4.  $query4");

$query5="delete from budget.bd725_dpr
where f_year=''
and account like '%dept%';
";
			 
mysql_query($query5) or die ("Couldn't execute query 5.  $query5");
*/

$query6="update budget.bd725_dpr,budget.coa 
set budget.bd725_dpr.match_coa='y'
where budget.bd725_dpr.account=coa.ncasnum;
";
			 
mysql_query($query6) or die ("Couldn't execute query 6.  $query6");

$query7="update budget.bd725_dpr
set f_year=
'$fiscal_year'
where f_year='';
";
			 
mysql_query($query7) or die ("Couldn't execute query 7.  $query7");

$query8="update budget.bd725_dpr,budget.coa
set bd725_dpr.cash_type=coa.cash_type
where bd725_dpr.account=coa.ncasnum
and bd725_dpr.f_year=
'$fiscal_year'
and bd725_dpr.cash_type='';
";
			 
mysql_query($query8) or die ("Couldn't execute query 8.  $query8");

$query9="update budget.bd725_dpr
set receipt_amt=ytd
where cash_type='receipt'
and f_year=
'$fiscal_year'
;
";
			 
mysql_query($query9) or die ("Couldn't execute query 9.  $query9");

$query10="update budget.bd725_dpr
set disburse_amt=ytd
where cash_type='disburse'
and f_year=
'$fiscal_year'
;
";
			 
mysql_query($query10) or die ("Couldn't execute query 10.  $query10");

$query11="update budget.bd725_dpr
set xtnd_rundate=
'$end_date'
where f_year=
'$fiscal_year'
;
";
			 
mysql_query($query11) or die ("Couldn't execute query 11.  $query11");



$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysql_query($query23a) or die ("Couldn't execute query 23a.  $query23a");

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&report_type=form");}
	  
  

 ?>