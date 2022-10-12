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
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

$query1="insert into fixed_asset_exprev(
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
exp_rev.center,
exp_rev.fund,
exp_rev.acctdate,
exp_rev.invoice,
exp_rev.pe,
exp_rev.description,
exp_rev.debit,
exp_rev.credit,
exp_rev.sys,
exp_rev.acct,
exp_rev.f_year,
exp_rev.dist,
exp_rev.debit_credit,
exp_rev.acct6,
exp_rev.ciad,
exp_rev.caa6,
exp_rev.month,
exp_rev.calyear,
exp_rev.ciad_count,
exp_rev.pcard_vendor,
exp_rev.pcard_user,
exp_rev.pcard_trans_date,
exp_rev.vendor_description,
exp_rev.pcardyn,
exp_rev.ciaadd,
exp_rev.ciaa,
exp_rev.cvip_match,
exp_rev.caa
from exp_rev
left join coa on exp_rev.acct=coa.ncasnum
 WHERE 1
and f_year=
'$fiscal_year'
and (acct like '5345%' or acct like '5346%' or acct like '5347%')
ORDER by acctdate desc;
";
mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");


$query2="
update fixed_asset_exprev set gt500='y' where debit_credit > '500'
";

mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");



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

























