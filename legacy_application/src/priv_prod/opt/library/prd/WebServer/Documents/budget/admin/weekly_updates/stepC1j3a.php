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
include("../../../../include/activity.php");// database connection parameters
//2018-0410
/*
$query14c="update bd725_dpr_temp,center
set bd725_dpr_temp.dpr='y'
where bd725_dpr_temp.fund=center.new_center
and bd725_dpr_temp.fund != '' ";

$result14c=mysqli_query($connection, $query14c) or die ("Couldn't execute query 14c.  $query14c");
*/


$project_category='fms';
$project_name='weekly_updates';
$step_group='C';
$step_num='1j3a';

$query0="select back_date_yn,fiscal_year,start_date,end_date
         from project_steps_mode
		 where project_category='$project_category' and project_name='$project_name' "; 



$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");

$row0=mysqli_fetch_array($result0);
extract($row0);


$end_date2=str_replace("-","",$end_date);



$query0="delete from bd725_dpr where f_year='$fiscal_year' ";

mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");



//2018-0410
/*
$query1="insert into budget.bd725_dpr(
         bc,fund,fund_descript,account,account_descript,total_budget,unallotted,
		 total_allotments,current,ytd,ptd,allotment_balance)
		 select
		 bc,fund,fund_descript,account,account_descript,total_budget,unallotted,
		 total_allotments,current,ytd,ptd,allotment_balance
		 from budget.bd725_dpr_temp
		 where 1 and dpr='y' ; ";
 */
		 
	$query1="insert into budget.bd725_dpr(
         bc,fund,fund_descript,account,account_descript,total_budget,unallotted,
		 total_allotments,current,ytd,ptd,allotment_balance)
		 select
		 bc,fund,fund_descript,account,account_descript,total_budget,unallotted,
		 total_allotments,current,ytd,ptd,allotment_balance
		 from budget.bd725_dpr_temp
		 where 1  ; ";	 
		 
		 
		 
		 
		 
		 

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


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
			 
mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");



$query1b="update budget.bd725_dpr set fund_descript2=replace(fund_descript,' ','') where 1 ";


mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");









/*
$query2="delete from budget.bd725_dpr
where f_year=''
and account not like '53%'
and account not like '43%';
";
			 
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$query3="delete from budget.bd725_dpr
where f_year=''
and account like '%dpr%';
";
			 
mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$query4="delete from budget.bd725_dpr
where f_year=''
and account like '%denr%';
";
			 
mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

$query5="delete from budget.bd725_dpr
where f_year=''
and account like '%dept%';
";
			 
mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
*/

$query6="update budget.bd725_dpr,budget.coa 
set budget.bd725_dpr.match_coa='y'
where budget.bd725_dpr.account=coa.ncasnum;
";
			 
mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$query7="update budget.bd725_dpr
set f_year=
'$fiscal_year'
where f_year='';
";
			 
mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");



$query1c="insert ignore into bd725_dpr_temp_unique2(fund,fund_descript,fund_descript2)
select fund,fund_descript,fund_descript2
from bd725_dpr
where f_year='$fiscal_year' ";

//echo "Line 107: query1c=$query1c<br />";

//exit;
mysqli_query($connection, $query1c) or die ("Couldn't execute query 1c.  $query1c");



$query8="update budget.bd725_dpr,budget.coa
set bd725_dpr.cash_type=coa.cash_type
where bd725_dpr.account=coa.ncasnum
and bd725_dpr.f_year=
'$fiscal_year'
and bd725_dpr.cash_type='';
";
			 
mysqli_query($connection, $query8) or die ("Couldn't execute query 8.  $query8");

$query9="update budget.bd725_dpr
set receipt_amt=ytd
where cash_type='receipt'
and f_year=
'$fiscal_year'
;
";
			 
mysqli_query($connection, $query9) or die ("Couldn't execute query 9.  $query9");

$query10="update budget.bd725_dpr
set disburse_amt=ytd
where cash_type='disburse'
and f_year=
'$fiscal_year'
;
";
			 
mysqli_query($connection, $query10) or die ("Couldn't execute query 10.  $query10");

$query11="update budget.bd725_dpr
set xtnd_rundate=
'$end_date2'
where f_year=
'$fiscal_year'
;
";
			 
mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11");



$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&report_type=form");}
	  
  

 ?>