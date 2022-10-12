<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//$end_date=str_replace("-","",$end_date);

//echo "<pre>";print_r($_REQUEST);echo "</pre>";  exit;
//echo "end_date=$end_date"; exit;
//Tables used:
//budget.cab_dpr,budget.coa,budget.authorized_budget,budget.valid_fund_accounts,
//budget.project_steps_detail,budget.project_steps

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//include("../../../../include/activity.php");// database connection parameters


$project_category='fms';
$project_name='weekly_updates';
$step_group='C';
$step_num='1j3b';

$query0="select back_date_yn,fiscal_year,start_date,end_date
         from project_steps_mode
		 where project_category='$project_category' and project_name='$project_name' "; 



$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");

$row0=mysqli_fetch_array($result0);
extract($row0);


//$end_date=str_replace("-","",$end_date);



$query11="update bd725_dpr,bd725_dpr_temp_unique2
          set bd725_dpr.dpr='y'
          where bd725_dpr.fund=bd725_dpr_temp_unique2.fund
		  and bd725_dpr.fund_descript2=bd725_dpr_temp_unique2.fund_descript2
          and bd725_dpr.f_year='$fiscal_year'
          and bd725_dpr_temp_unique2.dpr='y'	 ";
		  
		  
//echo "Line 34 query11=$query11"; exit;		  
			 
mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11");

//echo "Line 38 query11=$query11"; exit;		



$query12="truncate table xtnd_ci_monthly;
";
			 
mysqli_query($connection, $query12) or die ("Couldn't execute query 12.  $query12");

$query13="insert into xtnd_ci_monthly(
bc,
fund,
fund_des,
ncasnum,
ncasnum_des,
budget_amt,
unalloted,
alloted,
current_exp,
ytd_exp,
ptd_exp,
allotment_bal)
select
bc,
fund,
fund_descript,
account,
account_descript,
total_budget,
unallotted,
total_allotments,
current,
ytd,
ptd,
allotment_balance
from bd725_dpr
where 1
and f_year='$fiscal_year' and dpr='y' ";
			 
mysqli_query($connection, $query13) or die ("Couldn't execute query 13.  $query13");

$query14="truncate table valid_fund_accounts;
";
			 
mysqli_query($connection, $query14) or die ("Couldn't execute query 14.  $query14");

$query15="insert ignore into valid_fund_accounts(fund,account)
select distinct(fund),acct
from cab_dpr
where 1
and fund='1680'
and f_year=
'$fiscal_year'
;
";
			 
mysqli_query($connection, $query15) or die ("Couldn't execute query 15.  $query15");

$query16="insert ignore into valid_fund_accounts(fund,account)
select distinct(fund),account
from bd725_dpr
where 1
and f_year=
'$fiscal_year'
;
";
			 
mysqli_query($connection, $query16) or die ("Couldn't execute query 16.  $query16");

$query17="update valid_fund_accounts,coa
set valid_fund_accounts.account_description=coa.park_acct_desc
where valid_fund_accounts.account=coa.ncasnum;
";
			 
mysqli_query($connection, $query17) or die ("Couldn't execute query 17.  $query17");

$query18="update valid_fund_accounts,coa
set valid_fund_accounts.account_category=coa.acct_cat
where valid_fund_accounts.account=coa.ncasnum;
";
			 
mysqli_query($connection, $query18) or die ("Couldn't execute query 18.  $query18");

$query19="update valid_fund_accounts
set series=mid(account,1,3)
where 1;
";
			 
mysqli_query($connection, $query19) or die ("Couldn't execute query 19.  $query19");

$query20="update valid_fund_accounts,coa
set valid_fund_accounts.valid_cdcs=coa.valid_cdcs
where valid_fund_accounts.account=coa.ncasnum;
";
			 
mysqli_query($connection, $query20) or die ("Couldn't execute query 20.  $query20");

$query21="update valid_fund_accounts,coa
set valid_fund_accounts.valid_div=coa.valid_div
where valid_fund_accounts.account=coa.ncasnum;
";
			 
mysqli_query($connection, $query21) or die ("Couldn't execute query 21.  $query21");

$query22="update valid_fund_accounts,coa
set valid_fund_accounts.cash_type=coa.cash_type
where valid_fund_accounts.account=coa.ncasnum;
";
			 
mysqli_query($connection, $query22) or die ("Couldn't execute query 22.  $query22");

$query22a="update valid_fund_accounts,coa
set valid_fund_accounts.budget_group=coa.budget_group
where valid_fund_accounts.account=coa.ncasnum;
";
			 
mysqli_query($connection, $query22a) or die ("Couldn't execute query 22a.  $query22a");

$query22b="update valid_fund_accounts
set account_series='receipt'
where cash_type='receipt';
";
			 
mysqli_query($connection, $query22b) or die ("Couldn't execute query 22b.  $query22b");

$query22c="update valid_fund_accounts
set account_series='payroll'
where cash_type='disburse'
and account like '531%';
";
			 
mysqli_query($connection, $query22c) or die ("Couldn't execute query 22c.  $query22c");

$query22d="update valid_fund_accounts
set account_series='services'
where cash_type='disburse'
and account like '532%';
";
			 
mysqli_query($connection, $query22d) or die ("Couldn't execute query 22d.  $query22d");

$query22e="update valid_fund_accounts
set account_series='supplies'
where cash_type='disburse'
and account like '533%';
";
			 
mysqli_query($connection, $query22e) or die ("Couldn't execute query 22e.  $query22e");

$query22f="update valid_fund_accounts
set account_series='equipment'
where cash_type='disburse'
and account like '534%';
";
			 
mysqli_query($connection, $query22f) or die ("Couldn't execute query 22f.  $query22f");

$query22g="update valid_fund_accounts
set account_series='services'
where cash_type='disburse'
and account like '535%';
";
			 
mysqli_query($connection, $query22g) or die ("Couldn't execute query 22g.  $query22g");


$query22h="update valid_fund_accounts
set account_series='other'
where cash_type='disburse'
and account like '536%';
";
			 
mysqli_query($connection, $query22h) or die ("Couldn't execute query 22h.  $query22h");

$query22i="update valid_fund_accounts
set account_series='other'
where cash_type='disburse'
and account like '537%';
";
			 
mysqli_query($connection, $query22i) or die ("Couldn't execute query 22i.  $query22i");

$query22j="update valid_fund_accounts
set account_series='other'
where cash_type='disburse'
and account like '538%';
";
			 
mysqli_query($connection, $query22j) or die ("Couldn't execute query 22j.  $query22j");

$query22k="update valid_fund_accounts,coa
set valid_fund_accounts.account_description=coa.park_acct_desc
where valid_fund_accounts.account=coa.ncasnum;
";
			 
mysqli_query($connection, $query22k) or die ("Couldn't execute query 22k.  $query22k");



$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&report_type=form");}
	  
  

 ?>