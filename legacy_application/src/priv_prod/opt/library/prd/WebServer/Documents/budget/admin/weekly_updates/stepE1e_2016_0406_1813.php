<?php
//ini_set('display_errors',1);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
$end_date=str_replace("-","",$end_date);
//echo $end_date; exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters

$query1="truncate table exp_rev_down_temp2; ";
			 
mysql_query($query1) or die ("Couldn't execute query 1.  $query1");

$query2="insert into exp_rev_down_temp2(center,fund,acctdate,invoice,pe,description,debit,credit,sys)
select center,fund,acctdate,invoice,pe,description,debit,credit,sys
from exp_rev_down_temp
where 1; ";
			 
mysql_query($query2) or die ("Couldn't execute query 2.  $query2");

$query3="update exp_rev_down_temp2
set acct=acctdate
where acctdate like '%acct%' ; ";
			 
mysql_query($query3) or die ("Couldn't execute query 3.  $query3");

$query4="UPDATE 
exp_rev_down_temp2
set acct=replace(acct,'ACCT','')
where 1; ";
			 
mysql_query($query4) or die ("Couldn't execute query 4.  $query4");

$query5="update budget.exp_rev_down_temp2
set center=trim(center),
fund=trim(fund),
acctdate=trim(acctdate),
invoice=trim(invoice),
pe=trim(pe),
description=trim(description),
debit=trim(debit),
credit=trim(credit),
sys=trim(sys),
acct=trim(acct) ;";
			 
mysql_query($query5) or die ("Couldn't execute query 5.  $query5");

$query5a="truncate table exp_rev_down_temp3; ";
			 
mysql_query($query5a) or die ("Couldn't execute query 5a.  $query5a");

$query5b="insert into exp_rev_down_temp3(center,fund,acctdate,invoice,pe,description,debit,credit,sys,acct)
select center,fund,acctdate,invoice,pe,description,debit,credit,sys,acct
from exp_rev_down_temp2
where 1; ";
			 
mysql_query($query5b) or die ("Couldn't execute query 5b.  $query5b");




$query6="select min(id) as 'start_id' from exp_rev_down_temp3 where 1; ";
			 
$result6=mysql_query($query6) or die ("Couldn't execute query 6.  $query6");

$row6=mysql_fetch_array($result6);

extract($row6); //brings back id value for first record in table=exp_rev_down_temp2

$query7="select max(id) as 'end_id' from exp_rev_down_temp3 where 1; ";
			 
$result7=mysql_query($query7) or die ("Couldn't execute query 7.  $query7");

$row7=mysql_fetch_array($result7);

extract($row7); //brings back id value for first record in table=exp_rev_down_temp2

//echo "<br />";
//echo "start_id=$start_id";echo "<br />"; echo "end_id=$end_id";//exit;
$record2=$start_id+1;
//echo "<br />";
//echo "record2=$record2"; exit;

$query8="select * from exp_rev_down_temp3 where 1 and id >= '$record2' order by id asc ";
$result8=mysql_query($query8) or die ("Couldn't execute query 8.  $query8");

while ($row8=mysql_fetch_array($result8))
{

extract($row8);

$previous_record=$id-1;


$query9="update exp_rev_down_temp3,exp_rev_down_temp2
         set exp_rev_down_temp3.acct=exp_rev_down_temp2.acct
		 where exp_rev_down_temp3.id='$id' and exp_rev_down_temp2.id='$previous_record'
		 and exp_rev_down_temp3.acct='' ";
		 
$result9=mysql_query($query9) or die ("Couldn't execute query 9.  $query9");	

$query10="update exp_rev_down_temp2,exp_rev_down_temp3
         set exp_rev_down_temp2.acct=exp_rev_down_temp3.acct
		 where exp_rev_down_temp2.id='$id' and exp_rev_down_temp3.id='$id'
		 and exp_rev_down_temp2.acct='' ";
		 
$result10=mysql_query($query10) or die ("Couldn't execute query 10.  $query10");


}

$query11="update exp_rev_down_temp3
set valid_record='y'
where mid(acctdate,3,1)='/'
and mid(acctdate,6,1)='/' ; ";

$result11=mysql_query($query11) or die ("Couldn't execute query 11.  $query11");

$query12="update budget.exp_rev_down_temp3
set acctdate_new=concat(mid(acctdate,7,4),
mid(acctdate,1,2),
mid(acctdate,4,2))
where 1 ; ";

$result12=mysql_query($query12) or die ("Couldn't execute query 12.  $query12");




$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysql_query($query23a) or die ("Couldn't execute query 23a.  $query23a");

$query24="select * from budget.project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result24=mysql_query($query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysql_num_rows($result24);
//echo "num24=$num24";exit;
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
//{echo "num24 not equal to zero";}

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}

 ?>




















