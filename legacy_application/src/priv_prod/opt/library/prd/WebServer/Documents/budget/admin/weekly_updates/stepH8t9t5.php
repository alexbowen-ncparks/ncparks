<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();

if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<h2><font color='red'>FIX Query Tony 4/19/13</font></h2>";
//echo "<pre>";print_r($_REQUEST);"</pre>";echo "fiscal_year=$fiscal_year";exit;
$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date"; exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

//$fiscal_year='1213';

//echo "fiscal_year=$fiscal_year";exit;

/*
$query13="update bank_deposits,crj_posted8_v2
set bank_deposits.post2ncas='y',
bank_deposits.post_date=crj_posted8_v2.acctdate
where bank_deposits.deposit_id=crj_posted8_v2.deposit_id
and bank_deposits.center=crj_posted8_v2.center
and bank_deposits.deposit_amount=crj_posted8_v2.amount_total; ";
//echo "query13=$query13";echo "<br />";//exit;
$result13=mysqli_query($connection, $query13) or die ("Couldn't execute query 13. $query13");
*/


$query13="update bank_deposits,crj_posted9_v2
set bank_deposits.post2ncas='y',
bank_deposits.post_date=crj_posted9_v2.transdate_max
where bank_deposits.deposit_id=crj_posted9_v2.deposit_id
and bank_deposits.center=crj_posted9_v2.center
and bank_deposits.deposit_amount=crj_posted9_v2.amount_total
and crj_posted9_v2.f_year='$fiscal_year' ; ";
//echo "query13=$query13";echo "<br />";exit;
$result13=mysqli_query($connection, $query13) or die ("Couldn't execute query 13. $query13");



$query13a="update crs_tdrr_division_deposits,crj_posted9_v2
set crs_tdrr_division_deposits.post2ncas='y',
crs_tdrr_division_deposits.post_date=crj_posted9_v2.transdate_max
where crs_tdrr_division_deposits.controllers_deposit_id=crj_posted9_v2.deposit_id
and crs_tdrr_division_deposits.center=crj_posted9_v2.center
and crs_tdrr_division_deposits.orms_deposit_amount=crj_posted9_v2.amount_total
and crj_posted9_v2.f_year='$fiscal_year' ; ";
//echo "query13=$query13";echo "<br />";exit;
$result13a=mysqli_query($connection, $query13a) or die ("Couldn't execute query 13a. $query13a");



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