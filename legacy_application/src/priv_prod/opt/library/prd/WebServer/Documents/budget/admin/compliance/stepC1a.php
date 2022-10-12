<?php
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}



$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
/* 2022-07-01: ccooper - comment out for FYR turn over
echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit; */

if($compliance_fyear==''){echo "compliance_fyear missing"; exit;}
//if($compliance_month==''){echo "compliance_month missing"; exit;}
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//$status='complete';

//$compliance_calyear1='20'.substr($compliance_fyear,0,2);
//$compliance_calyear2='20'.substr($compliance_fyear,2,2);

//$compliance_fyear_prior=(substr($compliance_fyear,0,2)-1).(substr($compliance_fyear,2,2)-1);



////echo "<br />compliance_calyear1=$compliance_calyear1<br />";
////echo "<br />compliance_calyear2=$compliance_calyear2<br />";
////echo "<br />compliance_fyear_prior=$compliance_fyear_prior<br />";

//exit;




$query30="insert ignore into cash_imprest_authorized(park,center,grand_total,fyear)
          select park,center,grand_total,'$compliance_fyear'
		  from cash_imprest_authorized_centers where 1 " ;
		  
//echo "<br />query30=$query30<br />";	

//exit;	  
mysqli_query($connection, $query30) or die ("Couldn't execute query 30.  $query30");




$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");



{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&compliance_fyear=$compliance_fyear&compliance_month=$compliance_month&report_type=yearly_reset");}





 ?>