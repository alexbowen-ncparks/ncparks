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
//echo $end_date; exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
//echo "end_date=$end_date"; exit;
//Tables used:
//budget.cab_dpr,budget.coa,budget.authorized_budget,budget.valid_fund_accounts,
//budget.project_steps_detail,budget.project_steps

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

$query="insert into pcard_utility_xtnd_1646_ws(
        card4,last_name,vendor,postdate,transid,transdate,company,account,center,trans_amount)
		select card4,last_name,vendor,postdate,transid,transdate,company,account,center,trans_amount
		from pcard_utility_xtnd_1646_down
		where valid_record='y' ";
		
mysqli_query($connection, $query) or die ("Couldn't execute query. $query");


$query1="update pcard_utility_xtnd_1646_ws
set card4=trim(card4),
last_name=trim(last_name),
vendor=trim(vendor),
postdate=trim(postdate),
transid=trim(transid),
transdate=trim(transdate),
company=trim(company),
account=trim(account),
center=trim(center),
trans_amount=trim(trans_amount),
xtnd_date=trim(xtnd_date),
f_year=trim(f_year);";

mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

$query2="update pcard_utility_xtnd_1646_ws
set xtnd_date=concat(mid(postdate,7,4),mid(postdate,1,2),mid(postdate,4,2))
where 1;";

mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");

$query2a="update pcard_utility_xtnd_1646_ws
set transdate_new=concat(mid(transdate,7,4),mid(transdate,1,2),mid(transdate,4,2))
where 1; ";
mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a. $query2a");

$query3="update pcard_utility_xtnd_1646_ws
set f_year='$fiscal_year'
where f_year='';";

mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");

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
























