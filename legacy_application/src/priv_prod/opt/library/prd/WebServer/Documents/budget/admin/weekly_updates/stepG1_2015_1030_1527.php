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
$start_date=str_replace("-","",$start_date);


//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
//echo "start_date=$start_date <br />"; //exit;
//echo "end_date=$end_date <br />";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters

$query1="insert into pcard_extract(center,fund,acctdate,invoice,pe,description,debit,credit,sys,acct,f_year,dist,debit_credit,acct6,ciad,caa6)
select center,fund,acctdate,invoice,pe,description,debit,credit,sys,acct,f_year,dist,debit_credit,acct6,ciad,caa6
from exp_rev_ws
where 1 and acctdate >=  
'$start_date'
and acctdate <=
'$end_date'
and (description like '%purchasingcard%' or description like '%procurementcard%')
and acct != '535675'
group by whid;
";


			 
mysql_query($query1) or die ("Couldn't execute query 1.  $query1");

$query2="update pcard_extract
set calendar_acctdate=concat(mid(acctdate,5,2),'/',mid(acctdate,7,2),'/',mid(acctdate,1,4))
where f_year=
'$fiscal_year'
and acctdate >=  
'$start_date'
and acctdate <=
'$end_date'
and calendar_acctdate='';
";
			 
mysql_query($query2) or die ("Couldn't execute query 2.  $query2");



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




















