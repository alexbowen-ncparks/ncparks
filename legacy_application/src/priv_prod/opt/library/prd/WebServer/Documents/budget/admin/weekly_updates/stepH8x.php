<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);
$cyear=date("Y");
//echo "<br />";
//echo "cyear=$cyear";exit;
//echo "<br />";
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date";//exit;
//echo "<br />";
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

$query1="delete from report_budget_history_multimonth
where calyear='$cyear';
";
mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

$query2="insert into report_budget_history_multimonth

select f_year,calyear,month,budget_group,cash_type,acct as 'account',park_acct_desc as 'account_description',
exp_rev.center,parkcode,center.dist as 'district',section,sum(credit-debit) as 'amount','','','','','','','','','','','','',''
from exp_rev
left join coa on exp_rev.acct=coa.ncasnum
left join center on exp_rev.center=center.center
where 1
and exp_rev.center like '1280%'
and calyear='$cyear'  
and month='01'
group by account,center;
";
mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");

$query3="insert into report_budget_history_multimonth

select f_year,calyear,month,budget_group,cash_type,acct as 'account',park_acct_desc as 'account_description',
exp_rev.center,parkcode,center.dist as 'district',section,'',sum(credit-debit) as 'amount','','','','','','','','','','','',''
from exp_rev
left join coa on exp_rev.acct=coa.ncasnum
left join center on exp_rev.center=center.center
where 1
and exp_rev.center like '1280%'
and calyear='$cyear'  
and month='02'
group by account,center;
";
mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");

$query4="insert into report_budget_history_multimonth

select f_year,calyear,month,budget_group,cash_type,acct as 'account',park_acct_desc as 'account_description',
exp_rev.center,parkcode,center.dist as 'district',section,'','',sum(credit-debit) as 'amount','','','','','','','','','','',''
from exp_rev
left join coa on exp_rev.acct=coa.ncasnum
left join center on exp_rev.center=center.center
where 1
and exp_rev.center like '1280%'
and calyear='$cyear'  
and month='03'
group by account,center;
";
mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");

$query5="insert into report_budget_history_multimonth

select f_year,calyear,month,budget_group,cash_type,acct as 'account',park_acct_desc as 'account_description',
exp_rev.center,parkcode,center.dist as 'district',section,'','','',sum(credit-debit) as 'amount','','','','','','','','','',''
from exp_rev
left join coa on exp_rev.acct=coa.ncasnum
left join center on exp_rev.center=center.center
where 1
and exp_rev.center like '1280%'
and calyear='$cyear'  
and month='04'
group by account,center;
";
mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");

$query6="insert into report_budget_history_multimonth

select f_year,calyear,month,budget_group,cash_type,acct as 'account',park_acct_desc as 'account_description',
exp_rev.center,parkcode,center.dist as 'district',section,'','','','',sum(credit-debit) as 'amount','','','','','','','','',''
from exp_rev
left join coa on exp_rev.acct=coa.ncasnum
left join center on exp_rev.center=center.center
where 1
and exp_rev.center like '1280%'
and calyear='$cyear'  
and month='05'
group by account,center;
";
mysqli_query($connection, $query6) or die ("Couldn't execute query 6. $query6");

$query7="insert into report_budget_history_multimonth

select f_year,calyear,month,budget_group,cash_type,acct as 'account',park_acct_desc as 'account_description',
exp_rev.center,parkcode,center.dist as 'district',section,'','','','','',sum(credit-debit) as 'amount','','','','','','','',''
from exp_rev
left join coa on exp_rev.acct=coa.ncasnum
left join center on exp_rev.center=center.center
where 1
and exp_rev.center like '1280%'
and calyear='$cyear'  
and month='06'
group by account,center;
";
mysqli_query($connection, $query7) or die ("Couldn't execute query 7. $query7");

$query8="insert into report_budget_history_multimonth

select f_year,calyear,month,budget_group,cash_type,acct as 'account',park_acct_desc as 'account_description',
exp_rev.center,parkcode,center.dist as 'district',section,'','','','','','',sum(credit-debit) as 'amount','','','','','','',''
from exp_rev
left join coa on exp_rev.acct=coa.ncasnum
left join center on exp_rev.center=center.center
where 1
and exp_rev.center like '1280%'
and calyear='$cyear'  
and month='07'
group by account,center;
";
mysqli_query($connection, $query8) or die ("Couldn't execute query 8. $query8");

$query9="insert into report_budget_history_multimonth

select f_year,calyear,month,budget_group,cash_type,acct as 'account',park_acct_desc as 'account_description',
exp_rev.center,parkcode,center.dist as 'district',section,'','','','','','','',sum(credit-debit) as 'amount','','','','','',''
from exp_rev
left join coa on exp_rev.acct=coa.ncasnum
left join center on exp_rev.center=center.center
where 1
and exp_rev.center like '1280%'
and calyear='$cyear'  
and month='08'
group by account,center;
";
mysqli_query($connection, $query9) or die ("Couldn't execute query 9. $query9");

$query10="insert into report_budget_history_multimonth

select f_year,calyear,month,budget_group,cash_type,acct as 'account',park_acct_desc as 'account_description',
exp_rev.center,parkcode,center.dist as 'district',section,'','','','','','','','',sum(credit-debit) as 'amount','','','','',''
from exp_rev
left join coa on exp_rev.acct=coa.ncasnum
left join center on exp_rev.center=center.center
where 1
and exp_rev.center like '1280%'
and calyear='$cyear'  
and month='09'
group by account,center;
";
mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$query11="insert into report_budget_history_multimonth

select f_year,calyear,month,budget_group,cash_type,acct as 'account',park_acct_desc as 'account_description',
exp_rev.center,parkcode,center.dist as 'district',section,'','','','','','','','','',sum(credit-debit) as 'amount','','','',''
from exp_rev
left join coa on exp_rev.acct=coa.ncasnum
left join center on exp_rev.center=center.center
where 1
and exp_rev.center like '1280%'
and calyear='$cyear'  
and month='10'
group by account,center;
";
mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$query12="insert into report_budget_history_multimonth

select f_year,calyear,month,budget_group,cash_type,acct as 'account',park_acct_desc as 'account_description',
exp_rev.center,parkcode,center.dist as 'district',section,'','','','','','','','','','',sum(credit-debit) as 'amount','','',''
from exp_rev
left join coa on exp_rev.acct=coa.ncasnum
left join center on exp_rev.center=center.center
where 1
and exp_rev.center like '1280%'
and calyear='$cyear'  
and month='11'
group by account,center;
";
mysqli_query($connection, $query12) or die ("Couldn't execute query 12. $query12");

$query13="insert into report_budget_history_multimonth

select f_year,calyear,month,budget_group,cash_type,acct as 'account',park_acct_desc as 'account_description',
exp_rev.center,parkcode,center.dist as 'district',section,'','','','','','','','','','','',sum(credit-debit) as 'amount','',''
from exp_rev
left join coa on exp_rev.acct=coa.ncasnum
left join center on exp_rev.center=center.center
where 1
and exp_rev.center like '1280%'
and calyear='$cyear'  
and month='12'
group by account,center;
";
mysqli_query($connection, $query13) or die ("Couldn't execute query 13. $query13");

$query14="update report_budget_history_multimonth
set total=(january+february+march+april+may+june+july+august+september+october+november+december)
where calyear='$cyear';  
";
mysqli_query($connection, $query14) or die ("Couldn't execute query 14. $query14");


$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

$query24="select * from budget.project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result24=mysqli_query($connection, $query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysqli_num_rows($result24);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num24==0)

{$query25="update budget.project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");}
////mysql_close();

if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}




?>

























