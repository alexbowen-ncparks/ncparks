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
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
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
$end_date=str_replace('-','',$end_date);
$today_date=date("Ymd");
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
//echo "start_date=$start_date";
//echo "<br />";
//echo "end_date=$end_date";
//echo "<br />";
//echo "today_date=$today_date";
//echo "<br />";
//echo "backup table=budget.exp_rev_$today_date";exit;
//echo "database=$database";exit;

//////mysql_connect($host,$username,$password);
//@mysql_select_db($database) or die( "Unable to select database");

//echo "<br />db=$db<br />";
//echo "<br />ta=$ta<br />";
//echo "<br />ct=$ct<br />";   //exit;
$start_date2=str_replace("-"," ",$start_date);
$end_date2=str_replace("-"," ",$end_date);
$weekly_table_name="pcard_works_".$start_date2."_".$end_date2;
$weekly_date_range=$start_date2."_".$end_date2;

//echo "<br />start_date2=$start_date2<br />"; //exit;
//echo "<br />end_date2=$end_date2<br />"; //exit;
//echo "<br />weekly_table_name=$weekly_table_name<br />"; //exit;
//echo "<br />weekly_date_range=$weekly_date_range<br />"; exit;

$query1="truncate table pcard_works; ";
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

/*
$query1a="insert into pcard_works(account_id,sign_off,document,date_posted,date_purchased,primary_account_holder,purchase_amount,vendor,blank,allocation,amount_allocated,download_period)
select a,b,c,d,e,f,g,h,i,j,k,'12162016_12212016'
from pcard_works_12162016_12212016
where 1;";
*/

$query1a="insert into pcard_works(account_id,sign_off,document,date_posted,date_purchased,primary_account_holder,purchase_amount,vendor,blank,allocation,amount_allocated)
select a,b,c,d,e,f,g,h,i,j,k
from $weekly_table_name
where 1;";



$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");



$query1b="update pcard_works set account_id=LPAD(account_id, 4, '0')
where 1 ; ";
$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");

$query1c="update pcard_works,pcard_holders_dncr2
set pcard_works.dpr='y'
where pcard_works.account_id=pcard_holders_dncr2.pcard_num;
 ";
$result1c = mysqli_query($connection, $query1c) or die ("Couldn't execute query 1c.  $query1c");

$query1d="update pcard_works,pcard_holders_dncr2
set pcard_works.location=pcard_holders_dncr2.location
where pcard_works.account_id=pcard_holders_dncr2.pcard_num;
 ";
$result1d = mysqli_query($connection, $query1d) or die ("Couldn't execute query 1d.  $query1d");

$query1e="update pcard_works,pcard_holders_dncr2
set pcard_works.admin_num=pcard_holders_dncr2.admin_num
where pcard_works.account_id=pcard_holders_dncr2.pcard_num; ";
$result1e = mysqli_query($connection, $query1e) or die ("Couldn't execute query 1e.  $query1e");

$query1f="update pcard_works
set date_posted_new=concat('20',mid(date_posted,7,2),mid(date_posted,1,2),mid(date_posted,4,2))
where 1; ";
$result1f = mysqli_query($connection, $query1f) or die ("Couldn't execute query 1f.  $query1f");

$query1g="update pcard_works
set date_purchased_new=concat('20',mid(date_purchased,7,2),mid(date_purchased,1,2),mid(date_purchased,4,2))
where 1; ";
$result1g = mysqli_query($connection, $query1g) or die ("Couldn't execute query 1g.  $query1g");

$query1h="update pcard_works
set report_date='$end_date2'
where 1; ";
$result1h = mysqli_query($connection, $query1h) or die ("Couldn't execute query 1h.  $query1h");


$query1j="update pcard_works
set company='4601'
where location='1656';
 ";
$result1j = mysqli_query($connection, $query1j) or die ("Couldn't execute query 1j.  $query1j");


$query1k="update pcard_works
set company='4604'
where location='1669';
 ";
$result1k = mysqli_query($connection, $query1k) or die ("Couldn't execute query 1k.  $query1k");


$query1m="update pcard_works,pcard_holders_dncr2
set pcard_works.center=pcard_holders_dncr2.center
where pcard_works.account_id=pcard_holders_dncr2.pcard_num
and pcard_holders_dncr2.center != 'none' ;
 ";
$result1m = mysqli_query($connection, $query1m) or die ("Couldn't execute query 1m.  $query1m");

$query1n="update pcard_works,pcard_holders_dncr2
set pcard_works.last_name=pcard_holders_dncr2.last_name,
pcard_works.first_name=pcard_holders_dncr2.first_name
where pcard_works.account_id=pcard_holders_dncr2.pcard_num ; ";
$result1n = mysqli_query($connection, $query1n) or die ("Couldn't execute query 1n.  $query1n");


$query1p="update pcard_works
set admin_num='sodi',center='1680531'
where admin_num='nodi' ; ";
$result1p = mysqli_query($connection, $query1p) or die ("Couldn't execute query 1p.  $query1p");


$query4="update budget.project_steps_detail set status='complete' 
          where project_category='$project_category' and project_name='$project_name'
		  and step_group='$step_group' and step_num='$step_num' ";
		  
		  
mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");







$query5="select * from project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result5=mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");

$num5=mysqli_num_rows($result5);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;

if($num5==0)

{$query32="update project_steps set status='complete',time_complete=unix_timestamp(now()) where project_category='$project_category' and project_name='$project_name' and step_group='$step_group' ";
		 
mysqli_query($connection, $query32) or die ("Couldn't execute query 32.  $query32");

}

if($num5==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num5!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}


?>