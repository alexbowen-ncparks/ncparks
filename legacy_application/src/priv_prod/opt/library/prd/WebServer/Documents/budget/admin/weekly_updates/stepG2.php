<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//$end_date=str_replace("-","",$end_date);
//$start_date=str_replace("-","",$start_date);


//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
//echo "start_date=$start_date <br />"; //exit;
//echo "end_date=$end_date <br />";  //exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

$end_date=str_replace("-","",$end_date);
$start_date=str_replace("-","",$start_date);


//echo "start_date=$start_date <br />"; //exit;
//echo "end_date=$end_date <br />"; exit;

$query1="truncate table pcard_extract_worksheet;
";
			 
mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$query2="insert into pcard_extract_worksheet (new_center,new_fund,acctdate,invoice,pe,description,debit,credit,sys,acct,f_year,dist,debit_credit,acct6,ciad,caa6,calendar_acctdate,extract_id)
select new_center,new_fund,acctdate,invoice,pe,description,debit,credit,sys,acct,f_year,dist,debit_credit,acct6,ciad,caa6,calendar_acctdate,id
from pcard_extract
where 1 and acctdate >=  
'$start_date'
and acctdate <=
'$end_date'
and record_complete='n'
group by id;
";
			 
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$query3="update pcard_extract_worksheet
set debit_credit=debit-credit
where 1;
";
			 
mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");



$query4="update pcard_extract_worksheet
set center=new_center,fund=new_fund
where 1;
";
			 
mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");




















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




















