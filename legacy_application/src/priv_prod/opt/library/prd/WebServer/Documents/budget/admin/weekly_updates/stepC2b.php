<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;

echo "<br />Welcome to stepC2b.php LINE 5 <br />";
//exit;



$query23="update cab_dpr_temp 
          set acct=trim(acct),acct_descript=trim(acct_descript),certified=trim(certified),authorized=trim(authorized),curr_month=trim(curr_month),ytd=trim(ytd),unexpended=trim(unexpended),unrealized=trim(unrealized),encumbrances=trim(encumbrances)
		  where 1 ";
		  
		  
mysqli_query($connection, $query23) or die ("Couldn't execute query 23.  $query23");



$query23a="UPDATE cab_dpr_temp
SET certified= REPLACE(certified,',',''),authorized= REPLACE(authorized,',',''),curr_month= REPLACE(curr_month,',',''),ytd= REPLACE(ytd,',',''),unexpended= REPLACE(unexpended,',',''),unrealized= REPLACE(unrealized,',',''),encumbrances= REPLACE(encumbrances,',','')
WHERE 1 ";

mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

///

//
$query2j="update cab_dpr_temp set amount1_neg='yes' where right(certified,1)='-' and right(certified,2) != '--' ";

		  
mysqli_query($connection, $query2j) or die ("Couldn't execute query 2j.  $query2j ");


$query3j="update cab_dpr_temp set amount1_neg='no' where amount1_neg != 'yes' ";

		  
mysqli_query($connection, $query3j) or die ("Couldn't execute query 3j.  $query3j ");


$query4j="update cab_dpr_temp set amount1_correct=concat('-',(LEFT(certified,LENGTH(certified)-1))) where amount1_neg='yes' ";
		  
		  
mysqli_query($connection, $query4j) or die ("Couldn't execute query 4j.  $query4j");


$query5j="update cab_dpr_temp set certified=amount1_correct where amount1_neg='yes' ";
		  
		  
mysqli_query($connection, $query5j) or die ("Couldn't execute query 5j.  $query5j");
//

//
$query2k="update cab_dpr_temp set amount2_neg='yes' where right(authorized,1)='-' and right(authorized,2) != '--' ";

		  
mysqli_query($connection, $query2k) or die ("Couldn't execute query 2k.  $query2k ");


$query3k="update cab_dpr_temp set amount2_neg='no' where amount2_neg != 'yes' ";

		  
mysqli_query($connection, $query3k) or die ("Couldn't execute query 3k.  $query3k ");

$query4k="update cab_dpr_temp set amount2_correct=concat('-',(LEFT(authorized,LENGTH(authorized)-1))) where amount2_neg='yes' ";
		  
		  
mysqli_query($connection, $query4k) or die ("Couldn't execute query 4k.  $query4k");

$query5k="update cab_dpr_temp set authorized=amount2_correct where amount2_neg='yes' ";
		  
		  
mysqli_query($connection, $query5k) or die ("Couldn't execute query 5k.  $query5k");
//


//
$query2L="update cab_dpr_temp set amount3_neg='yes' where right(curr_month,1)='-' and right(curr_month,2) != '--' ";

		  
mysqli_query($connection, $query2L) or die ("Couldn't execute query 2L.  $query2L ");


$query3L=" update cab_dpr_temp set amount3_neg='no' where amount3_neg != 'yes' ";

		  
mysqli_query($connection, $query3L) or die ("Couldn't execute query 3L.  $query3L ");

$query4L="update cab_dpr_temp set amount3_correct=concat('-',(LEFT(curr_month,LENGTH(curr_month)-1))) where amount3_neg='yes' ";
		  
		  
mysqli_query($connection, $query4L) or die ("Couldn't execute query 4L.  $query4L");


$query5L="update cab_dpr_temp set curr_month=amount3_correct where amount3_neg='yes' ";
		  
		  
mysqli_query($connection, $query5L) or die ("Couldn't execute query 5L.  $query5L");
//


//
$query2m="update cab_dpr_temp set amount4_neg='yes' where right(ytd,1)='-' and right(ytd,2) != '--' ";

		  
mysqli_query($connection, $query2m) or die ("Couldn't execute query 2m.  $query2m ");


$query3m=" update cab_dpr_temp set amount4_neg='no' where amount4_neg != 'yes' ";

		  
mysqli_query($connection, $query3m) or die ("Couldn't execute query 3m.  $query3m ");


$query4m="update cab_dpr_temp set amount4_correct=concat('-',(LEFT(ytd,LENGTH(ytd)-1))) where amount4_neg='yes' ";
		  
		  
mysqli_query($connection, $query4m) or die ("Couldn't execute query 4m.  $query4m");


$query5m="update cab_dpr_temp set ytd=amount4_correct where amount4_neg='yes' ";
		  
		  
mysqli_query($connection, $query5m) or die ("Couldn't execute query 5m.  $query5m");
//


//
$query2n="update cab_dpr_temp set amount5_neg='yes' where right(unexpended,1)='-' and right(unexpended,2) != '--' ";

		  
mysqli_query($connection, $query2n) or die ("Couldn't execute query 2n.  $query2n ");


$query3n=" update cab_dpr_temp set amount5_neg='no' where amount5_neg != 'yes' ";

		  
mysqli_query($connection, $query3n) or die ("Couldn't execute query 3n.  $query3n ");


$query4n="update cab_dpr_temp set amount5_correct=concat('-',(LEFT(unexpended,LENGTH(unexpended)-1))) where amount5_neg='yes' ";
		  
		  
mysqli_query($connection, $query4n) or die ("Couldn't execute query 4n.  $query4n");


$query5n="update cab_dpr_temp set unexpended=amount5_correct where amount5_neg='yes' ";
		  
		  
mysqli_query($connection, $query5n) or die ("Couldn't execute query 5n.  $query5n");
//


//
$query2p="update cab_dpr_temp set amount6_neg='yes' where right(unrealized,1)='-' and right(unrealized,2) != '--' ";

		  
mysqli_query($connection, $query2p) or die ("Couldn't execute query 2p.  $query2p ");


$query3p=" update cab_dpr_temp set amount6_neg='no' where amount6_neg != 'yes' ";

		  
mysqli_query($connection, $query3p) or die ("Couldn't execute query 3p.  $query3p ");


$query4p="update cab_dpr_temp set amount6_correct=concat('-',(LEFT(unrealized,LENGTH(unrealized)-1))) where amount6_neg='yes' ";
		  
		  
mysqli_query($connection, $query4p) or die ("Couldn't execute query 4p.  $query4p");


$query5p="update cab_dpr_temp set unrealized=amount6_correct where amount6_neg='yes' ";
		  
		  
mysqli_query($connection, $query5p) or die ("Couldn't execute query 5p.  $query5p");
//


//
$query2r="update cab_dpr_temp set amount7_neg='yes' where right(encumbrances,1)='-' and right(encumbrances,2) != '--' and encumbrances != '-' ";

		  
mysqli_query($connection, $query2r) or die ("Couldn't execute query 2r.  $query2r ");


$query3r=" update cab_dpr_temp set amount7_neg='no' where amount7_neg != 'yes' ";

		  
mysqli_query($connection, $query3r) or die ("Couldn't execute query 3r.  $query3r ");


$query4r="update cab_dpr_temp set amount7_correct=concat('-',(LEFT(encumbrances,LENGTH(encumbrances)-1))) where amount7_neg='yes' ";
		  
		  
mysqli_query($connection, $query4r) or die ("Couldn't execute query 4r.  $query4r");


$query5r="update cab_dpr_temp set encumbrances=amount7_correct where amount7_neg='yes' ";
		  
		  
mysqli_query($connection, $query5r) or die ("Couldn't execute query 5r.  $query5r");





//echo "<br />LINE 12 <br />";

//exit;

/*
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//$end_date=str_replace("-","",$end_date);
//echo $end_date; exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
//Tables used:
//budget.cab_dpr,budget.coa,budget.authorized_budget,budget.valid_fund_accounts,
//budget.project_steps_detail,budget.project_steps

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//include("../../../../include/activity.php");// database connection parameters
//echo "f_year=$fiscal_year"; exit;

$project_category='fms';
$project_name='weekly_updates';
$step_group='C';
$step_num='2b';

$query0="select back_date_yn,fiscal_year,start_date,end_date
         from project_steps_mode
		 where project_category='$project_category' and project_name='$project_name' "; 



$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");

$row0=mysqli_fetch_array($result0);
extract($row0);

*/


//$end_date=str_replace("-","",$end_date);




$query0="delete from cab_dpr where f_year='$fiscal_year' ";

mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");

$query1="insert into cab_dpr(
         bc,bc_descript,fund,fund_descript,acct,acct_descript,certified,authorized,
		 curr_month,ytd,unexpended,unrealized,encumbrances)
		 select
		 'bc','bc_descript','1680','fund_descript',acct,acct_descript,certified,authorized,
		 curr_month,ytd,unexpended,unrealized,encumbrances
		 from cab_dpr_temp
		 where 1; ";
		 

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


$query1a="update budget.cab_dpr set bc=trim(bc),
bc_descript=trim(bc_descript),
fund=trim(fund),
fund_descript=trim(fund_descript),
acct=trim(acct),
acct_descript=trim(acct_descript),
certified=trim(certified),
authorized=trim(authorized),
curr_month=trim(curr_month),
ytd=trim(ytd),
unexpended=trim(unexpended),
unrealized=trim(unrealized),
encumbrances=trim(encumbrances),
f_year=trim(f_year),
dpr=trim(dpr),
cash_type=trim(cash_type),
receipt_amt=trim(receipt_amt),
disburse_amt=trim(disburse_amt),
xtnd_rundate=trim(xtnd_rundate);
";
			 
mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");

$query2="delete from budget.cab_dpr
where f_year=''
and acct not like '53%'
and acct not like '43%';
";
			 
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$query3="delete from budget.cab_dpr
where f_year=''
and acct like '%xxx';
";
			 
mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$query4="update budget.cab_dpr,budget.coa 
set budget.cab_dpr.match_coa='y'
where budget.cab_dpr.acct=coa.ncasnum;
";
			 
mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

$query5="update budget.cab_dpr
set f_year=
'$fiscal_year'
where f_year='';
";
			 
mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");

$query6="update budget.cab_dpr,budget.coa
set cab_dpr.cash_type=coa.cash_type
where cab_dpr.acct=coa.ncasnum
and cab_dpr.f_year=
'$fiscal_year'
and cab_dpr.cash_type='';
";
			 
mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$query7="update budget.cab_dpr
set receipt_amt=ytd
where f_year=
'$fiscal_year'
and cash_type='receipt';
";
			 
mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");

$query8="update budget.cab_dpr
set disburse_amt=ytd
where f_year=
'$fiscal_year'
and cash_type='disburse';
";
			 
mysqli_query($connection, $query8) or die ("Couldn't execute query 8.  $query8");

$query9="update budget.cab_dpr
set xtnd_rundate=
'$end_date2'
where f_year=
'$fiscal_year'
;
";
			 
mysqli_query($connection, $query9) or die ("Couldn't execute query 9.  $query9");


$query9a="update budget.cab_dpr,budget.center
set budget.cab_dpr.dpr_valid='y'
where budget.cab_dpr.fund=center.new_fund
and budget.cab_dpr.fund != ''
and f_year=
'$fiscal_year'
;
";
			 
mysqli_query($connection, $query9a) or die ("Couldn't execute query 9a.  $query9a");






$query10="delete from budget.authorized_budget
where f_year=
'$fiscal_year'
;
";
			 
mysqli_query($connection, $query10) or die ("Couldn't execute query 10.  $query10");

$query11="insert into authorized_budget(
budget_code,
fund,
account,
description,
certified,
authorized,
current_month,
ytd,
unexpend_cert,
unrealize_auth,
encumbrance,
rate,
xtnd_date,
f_year)
select
bc,
fund,
acct,
acct_descript,
certified,
authorized,
curr_month,
ytd,
unexpended,
unrealized,
encumbrances,'',
xtnd_rundate,
f_year
from 
budget.cab_dpr
where f_year=
'$fiscal_year'
;
";
			 
mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11");

$query12="truncate table valid_fund_accounts;
";
			 
mysqli_query($connection, $query12) or die ("Couldn't execute query 12.  $query12");

$query13="insert ignore into valid_fund_accounts(fund,account)
select distinct(fund),acct
from cab_dpr
where 1
and fund='1680'
and f_year=
'$fiscal_year'
;
";
			 
mysqli_query($connection, $query13) or die ("Couldn't execute query 13.  $query13");

$query14="insert ignore into valid_fund_accounts(fund,account)
select distinct(fund),account
from bd725_dpr
where 1
and f_year=
'$fiscal_year'
;
";
			 
mysqli_query($connection, $query14) or die ("Couldn't execute query 14.  $query14");

$query15="update valid_fund_accounts,coa
set valid_fund_accounts.account_description=coa.park_acct_desc
where valid_fund_accounts.account=coa.ncasnum;
";
			 
mysqli_query($connection, $query15) or die ("Couldn't execute query 15.  $query15");

$query16="update valid_fund_accounts,coa
set valid_fund_accounts.account_category=coa.acct_cat
where valid_fund_accounts.account=coa.ncasnum;
";
			 
mysqli_query($connection, $query16) or die ("Couldn't execute query 16.  $query16");

$query17="update valid_fund_accounts
set series=mid(account,1,3)
where 1;
";
			 
mysqli_query($connection, $query17) or die ("Couldn't execute query 17.  $query17");

$query18="update valid_fund_accounts,coa
set valid_fund_accounts.valid_cdcs=coa.valid_cdcs
where valid_fund_accounts.account=coa.ncasnum;
";
			 
mysqli_query($connection, $query18) or die ("Couldn't execute query 18.  $query18");

$query19="update valid_fund_accounts,coa
set valid_fund_accounts.valid_div=coa.valid_div
where valid_fund_accounts.account=coa.ncasnum;
";
			 
mysqli_query($connection, $query19) or die ("Couldn't execute query 19.  $query19");

$query20="update valid_fund_accounts,coa
set valid_fund_accounts.cash_type=coa.cash_type
where valid_fund_accounts.account=coa.ncasnum;
";
			 
mysqli_query($connection, $query20) or die ("Couldn't execute query 20.  $query20");

$query21="update valid_fund_accounts,coa
set valid_fund_accounts.budget_group=coa.budget_group
where valid_fund_accounts.account=coa.ncasnum;
";
			 
mysqli_query($connection, $query21) or die ("Couldn't execute query 21.  $query21");

$query22="update valid_fund_accounts
set account_series='receipt'
where cash_type='receipt';
";
			 
mysqli_query($connection, $query22) or die ("Couldn't execute query 22.  $query22");

$query22a="update valid_fund_accounts
set account_series='payroll'
where cash_type='disburse'
and account like '531%';
";
			 
mysqli_query($connection, $query22a) or die ("Couldn't execute query 22a.  $query22a");

$query22b="update valid_fund_accounts
set account_series='services'
where cash_type='disburse'
and account like '532%';
";
			 
mysqli_query($connection, $query22b) or die ("Couldn't execute query 22b.  $query22b");

$query22c="update valid_fund_accounts
set account_series='supplies'
where cash_type='disburse'
and account like '533%';
";
			 
mysqli_query($connection, $query22c) or die ("Couldn't execute query 22c.  $query22c");

$query22d="update valid_fund_accounts
set account_series='equipment'
where cash_type='disburse'
and account like '534%';
";
			 
mysqli_query($connection, $query22d) or die ("Couldn't execute query 22d.  $query22d");

$query22e="update valid_fund_accounts
set account_series='services'
where cash_type='disburse'
and account like '535%';
";
			 
mysqli_query($connection, $query22e) or die ("Couldn't execute query 22e.  $query22e");

$query22f="update valid_fund_accounts
set account_series='other'
where cash_type='disburse'
and account like '536%';
";
			 
mysqli_query($connection, $query22f) or die ("Couldn't execute query 22f.  $query22f");

$query22g="update valid_fund_accounts
set account_series='other'
where cash_type='disburse'
and account like '537%';
";
			 
mysqli_query($connection, $query22g) or die ("Couldn't execute query 22g.  $query22g");


$query22h="update valid_fund_accounts
set account_series='other'
where cash_type='disburse'
and account like '538%';
";
			 
mysqli_query($connection, $query22h) or die ("Couldn't execute query 22h.  $query22h");

$query22i="update valid_fund_accounts,coa
set valid_fund_accounts.account_description=coa.park_acct_desc
where valid_fund_accounts.account=coa.ncasnum;
";
			 
mysqli_query($connection, $query22i) or die ("Couldn't execute query 22i.  $query22i");

/*
$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");
*/

//{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&report_type=form");}
	  
  

 ?>