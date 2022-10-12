<?php

echo "<br />stepC1j2d.php<br />";
//exit;


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

$system_entry_date=date("Ymd");

$query1d="update bd725_dpr_temp_unique2 as t1 ,center as t2
          set t1.dpr='y',t1.verified='y',t1.center_yn='y',t1.verified_date='$system_entry_date'
		  where t1.fund=t2.new_center
		  and t1.verified='n' ";

//echo "Line 107: query1d=$query1d<br />";

//exit;
mysqli_query($connection, $query1d) or die ("Couldn't execute query 1d.  $query1d");





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


$query11a="update bd725_dpr,bd725_dpr_temp_unique2
          set bd725_dpr.dpr='y'
          where bd725_dpr.fund=bd725_dpr_temp_unique2.fund
		  and bd725_dpr.fund_descript2=bd725_dpr_temp_unique2.fund_descript2
          and bd725_dpr.f_year='$fiscal_year'
          and bd725_dpr_temp_unique2.dpr='y'	 ";
		  
		  
//echo "Line 34 query11a=$query11a"; exit;		  
			 
mysqli_query($connection, $query11a) or die ("Couldn't execute query 11a.  $query11a");

//echo "Line 38 query11a=$query11a"; exit;






$query2a="select count(account) as 'missing_accounts' from bd725_dpr where dpr='y' and match_coa='n' and f_year='$fiscal_year'  ";		 
$result2a = mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a.  $query2a");
$row2a=mysqli_fetch_array($result2a);
extract($row2a);


//echo "<br />Line 199: query2a=$query2a<br />";
//echo "<br />Line 200: missing_accounts=$missing_accounts<br />";
//exit;

if($missing_accounts>0)
{
$query3="select distinct(account) as 'account',lpad(account,9,0) as 'account_pad' from bd725_dpr where dpr='y' and match_coa='n' and f_year='$fiscal_year' ";	 

//echo "<br />Query3=$query3<br />";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");


while($row3 = mysqli_fetch_array($result3)){
extract($row3);
$account_first3=substr($account,0,3);

//echo "<br />account=$account<br />";
//echo "<br />account_pad=$account_pad<br />";
//echo "<br />account_first4=$account_first4<br />";


$query4="insert ignore into coa(ncasnum,acct_cat,cash_type,series,valid_ci,valid_1280,budget_group,ncasnum2)
select '$account',acct_cat,cash_type,series,'y','n',budget_group,'$account_pad' from coa where ncasnum like '$account_first3%' order by coaid desc limit 1  ";
//echo "<br />query4=$query4<br />";

$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");


$query5="select ncasnum,acct_cat,cash_type from coa where 1 order by coaid desc limit 1  ";
//echo "<br />query4=$query4<br />";

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$row5=mysqli_fetch_array($result5);
extract($row5);

$query5a="insert ignore into bd725_dpr_accounts(account,cash_type)
          select ncasnum,cash_type from coa where 1 order by coaid desc limit 1 ";
//echo "<br />query4=$query4<br />";

$result5a = mysqli_query($connection, $query5a) or die ("Couldn't execute query 5a.  $query5a");



}// 
}

$query4a="update budget.bd725_dpr,budget.coa 
set budget.bd725_dpr.match_coa='y',budget.bd725_dpr.cash_type=budget.coa.cash_type
where budget.bd725_dpr.account=budget.coa.ncasnum and budget.bd725_dpr.dpr='y' and budget.bd725_dpr.f_year='$fiscal_year' ";
			 
mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");



$query4b="update budget.bd725_dpr
set receipt_amt=ytd
where dpr='y' and cash_type='receipt'
and f_year='$fiscal_year' ";
			 
mysqli_query($connection, $query4b) or die ("Couldn't execute query 4b.  $query4b");



$query4c="update budget.bd725_dpr
set disburse_amt=ytd
where dpr='y' and cash_type='disburse'
and f_year='$fiscal_year' ";
			 
mysqli_query($connection, $query4c) or die ("Couldn't execute query 4c.  $query4c");







/*
$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");
*/


	  
  

 ?>