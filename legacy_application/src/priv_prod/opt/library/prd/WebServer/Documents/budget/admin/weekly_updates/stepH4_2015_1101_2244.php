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
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

$query1="insert into exp_rev_extract(
center,
fund,
acctdate,
invoice,
pe,
description,
debit,
credit,
sys,
acct,
f_year,
dist,
debit_credit,
acct6,
ciad,
caa6,
month,
calyear,
ciad_count,
pcard_vendor,
pcard_user,
pcard_trans_date,
vendor_description,
pcardyn,
ciaadd,
ciaa,
cvip_match,
caa)
SELECT 
exp_rev_ws.center,
exp_rev_ws.fund,
exp_rev_ws.acctdate,
exp_rev_ws.invoice,
exp_rev_ws.pe,
exp_rev_ws.description,
exp_rev_ws.debit,
exp_rev_ws.credit,
exp_rev_ws.sys,
exp_rev_ws.acct,
exp_rev_ws.f_year,
exp_rev_ws.dist,
exp_rev_ws.debit_credit,
exp_rev_ws.acct6,
exp_rev_ws.ciad,
exp_rev_ws.caa6,
exp_rev_ws.month,
exp_rev_ws.calyear,
exp_rev_ws.ciad_count,
exp_rev_ws.pcard_vendor,
exp_rev_ws.pcard_user,
exp_rev_ws.pcard_trans_date,
exp_rev_ws.vendor_description,
exp_rev_ws.pcardyn,
exp_rev_ws.ciaadd,
exp_rev_ws.ciaa,
exp_rev_ws.cvip_match,
exp_rev_ws.caa
from exp_rev_ws
left join coa on exp_rev_ws.acct=coa.ncasnum
 WHERE 1
and pcardyn !='y' and sys != 'wa'
and (
acct='531311'
or acct='531312'
or acct like '532%'
or acct like '533%'
or acct like '534%'
or acct like '535%'
or acct like '536%'
or acct like '537%'
or acct like '538%'
or acct like '434196%'
)
and acctdate >= 
'$start_date'
and acctdate <= 
'$end_date'
and f_year=
'$fiscal_year'
ORDER by acctdate desc;
";
mysql_query($query1) or die ("Couldn't execute query 1. $query1");



$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysql_query($query23a) or die ("Couldn't execute query 23a.  $query23a");

$query24="select * from budget.project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result24=mysql_query($query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysql_num_rows($result24);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num24==0)

{$query25="update budget.project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysql_query($query25) or die ("Couldn't execute query 25.  $query25");}
mysql_close();

if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}




?>

























