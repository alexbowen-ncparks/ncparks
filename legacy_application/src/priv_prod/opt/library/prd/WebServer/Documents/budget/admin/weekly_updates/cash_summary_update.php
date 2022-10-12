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
$today=date("Ymd", time() );
$yesterday=date("Ymd", time() - 60 * 60 * 24);
$dayb4yesterday=date("Ymd", time() - 60 * 60 * 24*2);
if($cs_update=='')
{
echo "today=$today<br />";
echo "yesterday=$yesterday<br />";
echo "dayb4yesterday=$dayb4yesterday<br />";
echo "<a href='cash_summary_update.php?cs_update=y'>Cash Summary Update thru: $yesterday </a>";
exit;
}
if($cs_update=='y')
{
//echo "Run Queries to Update Table=cash_summary"; exit;

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
//echo "end_date=$end_date"; exit;
//Tables used:
//budget.cab_dpr,budget.coa,budget.authorized_budget,budget.valid_fund_accounts,
//budget.project_steps_detail,budget.project_steps

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters




$query1="insert into cash_trans
(center,trans_date,amount)
SELECT center, transdate_new, sum( amount )
FROM `crs_tdrr_division_history`
WHERE transdate_new = '$yesterday'
AND deposit_transaction = 'y'
and ncas_account != '000437995'
GROUP BY center, transdate_new";
		 

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


$query1a="insert into cash_deposits
(center,deposit_date,amount)
SELECT center,deposit_date_new,sum(amount)
from crs_tdrr_division_history_parks
where 1 and deposit_transaction='y'
and deposit_date_new = '$yesterday'
group by center,deposit_date_new";
			 
mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");

$query2="update crs_tdrr_division_history
set deposit_date_new='0000-00-00',deposit_id='none'
where deposit_date_new='$today'; ";

		 
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");



$query2a="insert into cash_undeposited
(center,effective_date,amount)
select center,'$yesterday',sum(amount)
from crs_tdrr_division_history
where deposit_transaction='y'
and deposit_id='none'
and ncas_account != '000437995'
group by center;";
			 
mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a.  $query2a");



$query3="insert into cash_summary(center,effect_date)
select center,'$yesterday'
from center_taxes
where orms='y'";
			 
mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$query4="update cash_summary,cash_trans
set cash_summary.transaction_amount=cash_trans.amount
where cash_summary.center=cash_trans.center
and cash_summary.effect_date='$yesterday'
and cash_trans.trans_date='$yesterday'";
			 
mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

$query5="update cash_summary,cash_deposits
set cash_summary.deposit_amount=cash_deposits.amount
where cash_summary.center=cash_deposits.center
and cash_summary.effect_date='$yesterday'
and cash_deposits.deposit_date='$yesterday'";
			 
mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");

$query6="update cash_summary,cash_undeposited
set cash_summary.end_bal=cash_undeposited.amount
where cash_summary.center=cash_undeposited.center
and cash_summary.effect_date='$yesterday'
and cash_undeposited.effective_date='$yesterday'";
			 
mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$query7="update cash_summary
set beg_bal=end_bal-transaction_amount+deposit_amount
where effect_date='$yesterday'";
			 
mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");

$query8="update cash_summary
set undeposited_amount=beg_bal-deposit_amount
where effect_date='$yesterday'";
			 
mysqli_query($connection, $query8) or die ("Couldn't execute query 8.  $query8");

$query9="truncate table cash_deposits_max; ";
			 
mysqli_query($connection, $query9) or die ("Couldn't execute query 9.  $query9");


$query9a="insert into cash_deposits_max(center,deposit_date_max)
select center,max(orms_deposit_date)
from crs_tdrr_division_deposits
where trans_table='y'
group by center;";
			 
mysqli_query($connection, $query9a) or die ("Couldn't execute query 9a.  $query9a");


$query9b="truncate table cash_undeposited_min; ";
			 
mysqli_query($connection, $query9b) or die ("Couldn't execute query 9b.  $query9b");


$query9c="insert into cash_undeposited_min(center,cash_trans_min)
select center,min(transdate_new)
from crs_tdrr_division_history
where deposit_id='none'
group by center; ";
			 
mysqli_query($connection, $query9c) or die ("Couldn't execute query 9c.  $query9c");


$query10="update cash_summary,cash_deposits_max
set cash_summary.last_deposit=cash_deposits_max.deposit_date_max
where cash_summary.center=cash_deposits_max.center
and cash_summary.effect_date='$yesterday'; ";
			 
mysqli_query($connection, $query10) or die ("Couldn't execute query 10.  $query10");


$query10a="update cash_summary,cash_undeposited_min
set cash_summary.undeposited_transdate_min=cash_undeposited_min.cash_trans_min
where cash_summary.center=cash_undeposited_min.center
and cash_summary.effect_date='$yesterday'; ";
			 
mysqli_query($connection, $query10a) or die ("Couldn't execute query 10a.  $query10a");


$query11="update cash_summary set days_elapsed=datediff(effect_date,last_deposit)
where effect_date='$yesterday';";
			 
mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11");


$query11a="update cash_summary set days_elapsed2=datediff(effect_date,undeposited_transdate_min)
where effect_date='$yesterday'; ";
			 
mysqli_query($connection, $query11a) or die ("Couldn't execute query 11a.  $query11a");


$query11b="update cash_summary set
days_elapsed2='0'
where days_elapsed2=''
and effect_date='$yesterday'
;";
			 
mysqli_query($connection, $query11b) or die ("Couldn't execute query 11b.  $query11b");


$query12="update cash_summary,center
set cash_summary.park=center.parkcode
where cash_summary.center=center.center";
			 
mysqli_query($connection, $query12) or die ("Couldn't execute query 12.  $query12");


$query13="update cash_summary
set compliance='n'
where deposit_amount < beg_bal
and beg_bal >= '250.00'
and effect_date='$yesterday'";
			 
mysqli_query($connection, $query13) or die ("Couldn't execute query 13.  $query13");


$query14="update cash_summary
set compliance='n'
where beg_bal < '250.00'
and days_elapsed2 > '6'
and deposit_amount < beg_bal
and effect_date='$yesterday'";
			 
mysqli_query($connection, $query14) or die ("Couldn't execute query 14.  $query14");


$query15="select weekend as 'weekendDay'
          from mission_headlines where date='$yesterday' ";
		 
//echo "query1=$query1<br />";		 

$result15 = mysqli_query($connection, $query15) or die ("Couldn't execute query 15.  $query15");

$row15=mysqli_fetch_array($result15);
extract($row15);

if($weekendDay=='y')
{
$query16="update cash_summary
set weekend='y'
where effect_date='$yesterday'";

$result16 = mysqli_query($connection, $query16) or die ("Couldn't execute query 16.  $query16");

}

}

{header("location: bank_deposits_menu_division_final.php?menu_id=a&menu_selected=y ");}
	  
  

 ?>




















