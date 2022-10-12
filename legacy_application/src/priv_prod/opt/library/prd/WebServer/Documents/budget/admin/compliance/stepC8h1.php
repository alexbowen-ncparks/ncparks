<?php
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}



$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;

if($compliance_fyear==''){echo "compliance_fyear missing"; exit;}
//if($compliance_month==''){echo "compliance_month missing"; exit;}
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//include("../../../../include/activity.php");// database connection parameters
//$status='complete';

//$compliance_calyear1='20'.substr($compliance_fyear,0,2);
//$compliance_calyear2='20'.substr($compliance_fyear,2,2);

//$compliance_fyear_prior=(substr($compliance_fyear,0,2)-1).(substr($compliance_fyear,2,2)-1);



////echo "<br />compliance_calyear1=$compliance_calyear1<br />";
////echo "<br />compliance_calyear2=$compliance_calyear2<br />";
////echo "<br />compliance_fyear_prior=$compliance_fyear_prior<br />";

//exit;


$query30="update fiscal_year set equipment_request='n' where 1" ;
		  
//echo "<br />query30=$query30<br />";	

//exit;	  
mysqli_query($connection, $query30) or die ("Couldn't execute query 30.  $query30");

$query31="update fiscal_year set equipment_request='y' where report_year='$compliance_fyear' " ;
		  
//echo "<br />query31=$query31<br />";	

mysqli_query($connection, $query31) or die ("Couldn't execute query 31.  $query31");



//exit;	

  



$query32="select report_year as 'equip_request_fyear',start_date as 'equip_request_start',end_date as 'equip_request_end' from fiscal_year where equipment_request='y'  " ;
		  
//echo "<br />query32=$query32<br />";	

	  
$result32 = mysqli_query($connection, $query32) or die ("Couldn't execute query32. $query32");
$row32=mysqli_fetch_array($result32);
extract($row32);

//echo "<br />equip_request_fyear=$equip_request_fyear<br />equip_request_start=$equip_request_start<br />equip_request_end=$equip_request_end<br />";
//exit;	


$query33="update budget_request_acceptable_dates 
          set start_date='$equip_request_start',end_date='$equip_request_end',fyear='$equip_request_fyear'
          where budget_group='equipment'		  " ;
		  
//echo "<br />query33=$query33<br />";	

  
mysqli_query($connection, $query33) or die ("Couldn't execute query 33.  $query33");

//exit;	




$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");



{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&compliance_fyear=$compliance_fyear&compliance_month=$compliance_month&report_type=yearly_reset");}





 ?>