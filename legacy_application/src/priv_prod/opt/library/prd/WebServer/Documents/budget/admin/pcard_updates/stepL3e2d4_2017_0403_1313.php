<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "hello world";
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters


//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
//$fiscal_year=$_REQUEST['fiscal_year'];
//$project_category=$_REQUEST['project_category'];
//$project_name=$_REQUEST['project_name'];
$start_date=$_REQUEST['start_date'];
$end_date=$_REQUEST['end_date'];
//$step_group=$_REQUEST['step_group'];
//echo "fiscal_year=$fiscal_year";
//echo "project_category=$project_category";
//echo "project_name=$project_name";
//echo "start_date=$start_date";
//echo "end_date=$end_date";
//echo "step=$step";
//exit;
$start_date=str_replace("-","",$start_date);
$end_date_header=$end_date;
$end_date=str_replace('-','',$end_date);
$today_date=date("Ymd");
echo "<br />Line 37: today_date=$today_date<br />"; exit;
//$xtnd_rundate=substr($end_date,4,2)."/".substr($end_date,6,2)."/".substr($end_date,2,2);




//$db="budget_$today_date";


//$db="$today_date";
//$ta="pcard_unreconciled";
//$ct=date("His");



//echo $ct;exit;
//echo "database=$db";echo "<br />";
//echo "table=$ta";echo "<br />";
//echo "current time=$ct";echo "<br />";
//echo "create table $db.$ta_$ct";
//exit;
//echo "end_date=$end_date <br /><br />";
//$db_backup="budget$end_date";
//echo $db_backup;
//exit;
//echo "start_date=$start_date<br /><br />"; //exit;
//echo "xtnd_rundate=$xtnd_rundate"; exit;
//echo "<br />";
//echo "end_date=$end_date";
//echo "<br />";
//echo "today_date=$today_date";
//echo "<br />";
//echo "backup table=budget.exp_rev_$today_date";exit;
//echo "database=$database";exit;

//mysql_connect($host,$username,$password);
//@mysql_select_db($database) or die( "Unable to select database");

//echo "<br />db=$db<br />";
//echo "<br />ta=$ta<br />";
//echo "<br />ct=$ct<br />";   //exit;

/*
$query1="insert into pcard_unreconciled(location,admin_num,post_date,trans_date,amount,vendor_name,trans_id,pcard_num,xtnd_rundate,transdate_new,cardholder,transid_new,postdate_new,xtnd_rundate_new,center,company,last_name,first_name,report_date)
select location,admin_num,date_posted,date_purchased,purchase_amount,vendor,document,account_id,'12/21/16',date_purchased_new,primary_account_holder,document,date_posted_new,'20161221',center,company,last_name,first_name,'20161221'
from pcard_works
where dpr='y' ; ";
*/


$query1="insert into pcard_unreconciled(location,admin_num,post_date,trans_date,amount,vendor_name,trans_id,pcard_num,xtnd_rundate,transdate_new,cardholder,transid_new,postdate_new,xtnd_rundate_new,center,company,last_name,first_name,report_date)
select location,admin_num,date_posted,date_purchased,amount,merchant_name,trans_id,card_number2,
xtnd_rundate,date_purchased_new,primary_account_holder,trans_id,date_posted_new,'$end_date',center,company,last_name,first_name,'$end_date'
from pcard_unreconciled_xtnd_temp2_perm
where xtnd_report_date='$end_date' ; ";


//echo "<br />query1=$query1<br />";  exit;

$result1 = mysql_query($query1) or die ("Couldn't execute query 1.  $query1");


$query2="update pcard_report_dates
         set active='y' where report_date='$end_date' "; 

$result2 = mysql_query($query2) or die ("Couldn't execute query 2.  $query2");


$query23a="update budget.project_substeps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' and substep_num='$substep_num' ";
			 
mysql_query($query23a) or die ("Couldn't execute query 23a.  $query23a");

$query24="select * from budget.project_substeps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and step_num='$step_num' and status='pending' "; 

$result24=mysql_query($query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysql_num_rows($result24);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;

/*
if($num24==0)

{$query25="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
mysql_query($query25) or die ("Couldn't execute query 25.  $query25");}
mysql_close();

if($num24==0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group ");}

if($num24!=0)
*/
/*
{header("location: step$step_group$step_num.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&step_num=$step_num ");}
*/
{header("location: ../../../budget/aDiv/pcard_weekly_reports.php?report_date=$end_date_header");}


?>