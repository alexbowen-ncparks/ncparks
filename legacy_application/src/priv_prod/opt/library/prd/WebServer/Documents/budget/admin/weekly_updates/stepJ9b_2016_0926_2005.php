<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";  exit;
//$start_date=str_replace("-","",$start_date);
//$end_date=str_replace("-","",$end_date);
//$today_date=date("Ymd");
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date";//exit;
//echo "<br />"; 
//echo "today_date=$today_date";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);
$today_date=date("Ymd");

//$start_date='20150701';
//echo "<br />start_date=$start_date<br />";
//echo "<br />end_date=$end_date<br />";  exit;



$query1="insert into partf_fund_trans(
trans_type,
proj_out,
fund_out,
proj_in,
fund_in,
amount,
trans_date,
post_date,
comments,
posted,
post_yn,
trans_num,
trans_source,
ncas_in,
ncas_out,
grant_rec_name,
grant_rec_vendor,
grant_po,
grant_num,
bo_2_denr_req_date,
datenew,
f_year,
datemod,
blank_field)
SELECT '','',fund,'','',sum(debit),'','',description,'','','','','',acct,'','','','','',acctdate,f_year,'','' FROM exp_rev WHERE 1 and debit > '0' and acctdate >= '$start_date'
and acctdate <= '$end_date' and fund != '1280' and fund != '2802' and fund != '2803' and fund != '1680' and (acct not like '531%' and acct not like '532%' and acct not like '533%' and acct not like '534%' and acct not like '535%')
group by whid
order by exp_rev.center,exp_rev.acct asc ";


//echo "query1=$query1<br />";exit;

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

























