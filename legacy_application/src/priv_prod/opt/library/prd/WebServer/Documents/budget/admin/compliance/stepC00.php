<?php

//echo "PHP File table1_backup.php";  //exit;

//ini_set('display_errors',1);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//$end_date=str_replace("-","",$end_date);
//echo $end_date; exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;

if($compliance_fyear==''){echo "compliance_fyear missing"; exit;}
//if($compliance_month==''){echo "compliance_month missing"; exit;}

//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//include("../../../../include/activity.php");// database connection parameters


$start_date=$_REQUEST['start_date'];
$end_date=$_REQUEST['end_date'];

$start_date=str_replace("-","",$start_date);
$end_date=str_replace('-','',$end_date);
$today_date=date("Ymd");
//$db="budget_$today_date";

$query0="select report_year as 'old_compliance_fyear' from fiscal_year where active_year_compliance='y' ";	
$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");
$row0=mysqli_fetch_array($result0);
extract($row0);
//0628: Brings back Existing "compliance_fyear" as "old_compliance_fyear"
echo "<br />old_compliance_fyear=$old_compliance_fyear<br />";  

$query0a="select report_year as 'new_compliance_fyear' from fiscal_year where report_year > '$old_compliance_fyear' order by report_year asc limit 1 ";		 
$result0a = mysqli_query($connection, $query0a) or die ("Couldn't execute query 0a.  $query0a");
$row0a=mysqli_fetch_array($result0a);
extract($row0a);
//0628: Brings back New "compliance_fyear" as "new_compliance_fyear"
echo "<br />new_compliance_fyear=$new_compliance_fyear<br />";  
//exit;

$query0b="update fiscal_year set active_year_compliance='n' where report_year='$old_compliance_fyear' ";
$result0b = mysqli_query($connection, $query0b) or die ("Couldn't execute query 0b.  $query0b");
$row0b=mysqli_fetch_array($result0b);
extract($row0b);
//0628: Existing "compliance_year" is no longer the ACTIVE year 


$query0c="update fiscal_year set active_year_compliance='y' where report_year='$new_compliance_fyear' ";
$result0c = mysqli_query($connection, $query0c) or die ("Couldn't execute query 0c.  $query0c");
$row0c=mysqli_fetch_array($result0c);
extract($row0c);
//0628: New "compliance_fyear" is set as the ACTIVE year 



$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

//echo "<br />query23a=$query23a<br />"; exit;

//echo "<br />";
//echo "<table align='center' border='1'><tr><td><a href='step_group.php?fyear=&report_type=form&reset=y'>Return to Monthly Compliance Updates</a></td></tr></table>";



//{header("location: step_group.php?report_type=form&compliance_fyear=$compliance_fyear&compliance_month=$compliance_month");}


{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&compliance_fyear=$compliance_fyear&compliance_month=$compliance_month&report_type=yearly_reset");}











?>