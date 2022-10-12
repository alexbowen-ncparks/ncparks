<?php
//ini_set('display_errors',1);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
$end_date=str_replace("-","",$end_date);
//echo $end_date; exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;

if($compliance_fyear==''){echo "compliance_fyear missing"; exit;}
if($compliance_month==''){echo "compliance_month missing"; exit;}

$fiscal_year=$compliance_fyear;
//echo "<br />fiscal_year=$fiscal_year<br />"; exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters


$query22="update budget.project_steps_detail set fiscal_year='$fiscal_year' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group'  ";
		 
echo "<br />query22=$query22<br />";		 
		 
			 
mysqli_query($connection, $query22) or die ("Couldn't execute query 22.  $query22");




$query23="update budget.project_steps_detail set status='pending' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group'  ";
		 
echo "<br />query23=$query23<br />";		 
		 
			 
mysqli_query($connection, $query23) or die ("Couldn't execute query 23.  $query23");





$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
		 
echo "<br />query23a=$query23a<br />";		 
		 
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");



//exit;






{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&compliance_fyear=$compliance_fyear&compliance_month=$compliance_month&report_type=form");}




 ?>