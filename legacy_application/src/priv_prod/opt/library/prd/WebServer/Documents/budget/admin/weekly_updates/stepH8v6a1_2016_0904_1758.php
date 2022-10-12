<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database c



$query1="
delete from report_budget_history_range where f_year='$fiscal_year'; ";

mysql_query($query1) or die ("Couldn't execute query 1. $query1");



$query2="
insert into report_budget_history_range(center,account,amount,postdate,f_year)
SELECT center, acct,sum(credit-debit),acctdate,f_year 
FROM `exp_rev` 
WHERE 1 AND f_year = '$fiscal_year'
and center like '1280%'
GROUP BY center, acct, acctdate; ";

mysql_query($query2) or die ("Couldn't execute query 2. $query2");


$query3="
update report_budget_history_range,coa
set report_budget_history_range.budget_group=coa.budget_group
 where report_budget_history_range.account=coa.ncasnum; ";

mysql_query($query3) or die ("Couldn't execute query 3. $query3");

$query4="
update report_budget_history_range,coa
set report_budget_history_range.cash_type=coa.cash_type
where report_budget_history_range.account=coa.ncasnum; ";

mysql_query($query4) or die ("Couldn't execute query 4. $query4");

$query5="
update report_budget_history_range,coa
set report_budget_history_range.account_description=coa.park_acct_desc
 where report_budget_history_range.account=coa.ncasnum; ";

mysql_query($query5) or die ("Couldn't execute query 5. $query5");

$query6="
update report_budget_history_range,coa
set report_budget_history_range.gmp=coa.gmp
 where report_budget_history_range.account=coa.ncasnum; ";

mysql_query($query6) or die ("Couldn't execute query 6. $query6");

$query7="
update report_budget_history_range,center
set report_budget_history_range.center_description=center.center_desc
 where report_budget_history_range.center=center.center; ";

mysql_query($query7) or die ("Couldn't execute query 7. $query7");

$query8="
update report_budget_history_range,center
set report_budget_history_range.parkcode=center.parkcode
 where report_budget_history_range.center=center.center; ";

mysql_query($query8) or die ("Couldn't execute query 8. $query8");

$query9="
update report_budget_history_range,center
set report_budget_history_range.district=center.dist
 where report_budget_history_range.center=center.center; ";

mysql_query($query9) or die ("Couldn't execute query 9. $query9");

$query10="
update report_budget_history_range,center
set report_budget_history_range.section=center.section
 where report_budget_history_range.center=center.center; ";

mysql_query($query10) or die ("Couldn't execute query 10. $query10");

 
 $query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category' and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysql_query($query23a) or die ("Couldn't execute query 23a.  $query23a");

$query24="select * from budget.project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result24=mysql_query($query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysql_num_rows($result24);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num24==0)

{$query25="update budget.project_steps set status='complete' where project_category='$project_category' and project_name='$project_name' and step_group='$step_group' ";
mysql_query($query25) or die ("Couldn't execute query 25.  $query25");}

mysql_close();

if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}
 

?>