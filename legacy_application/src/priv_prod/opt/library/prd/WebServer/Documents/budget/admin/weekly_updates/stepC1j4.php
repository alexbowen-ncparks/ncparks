<?php

/*
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database

*/

//include("../../../include/activity_new.php");// database connection parameters
//$status='complete';

/*
$project_category='fms';
$project_name='weekly_updates';
$step_group='C';
$step_num='1j4';

$query0="select back_date_yn,fiscal_year,start_date,end_date
         from project_steps_mode
		 where project_category='$project_category' and project_name='$project_name' "; 



$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");

$row0=mysqli_fetch_array($result0);
extract($row0);

*/


$query="truncate table exp_rev_dncr_osc3";
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");		  
		  

$query="insert into exp_rev_dncr_osc3
(`gl_date`, `company_id`, `account_id`, `center_id`, `document_id`, `line_number`, `invoice_date`, `pay_entity`, `additional_descript`, `check_number`, `control_group`, `sign_amount`, `subsystem`, `vendor_number`, `vendor_group`, `buyer_entity`, `po`, `pc_merchantname`, `agency_admin`, `agency_location`, `pc_transid`, `pc_transdate`, `pc_cardname`, `pc_purchdate`)

SELECT `gl_date`, `company_id`, `account_id`, `center_id`, `document_id`, `line_number`, `invoice_date`, `pay_entity`, `additional_descript`, `check_number`, `control_group`, `sign_amount`, `subsystem`, `vendor_number`, `vendor_group`, `buyer_entity`, `po`, `pc_merchantname`, `agency_admin`, `agency_location`, `pc_transid`, `pc_transdate`, `pc_cardname`, `pc_purchdate` FROM `exp_rev_dncr_osc2` WHERE 1";
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update exp_rev_dncr_osc3
set sign_amount2=sign_amount/100
where 1";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update exp_rev_dncr_osc3
set gl_date2=concat(mid(gl_date,5,4),mid(gl_date,1,2),mid(gl_date,3,2))
where 1";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");




$query="update exp_rev_dncr_osc3,center
set exp_rev_dncr_osc3.valid_dpr_center='y'
where exp_rev_dncr_osc3.center_id=center.new_center ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");



$query="update exp_rev_dncr_osc3 set vendor_numgroup=concat(vendor_number,vendor_group) where 1";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");

	
$query="update exp_rev_dncr_osc3 set debit=sign_amount2 where sign_amount2 > '0.00' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");


$query="update exp_rev_dncr_osc3 set credit=-sign_amount2 where sign_amount2 < '0.00' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");
	
	
$query="update exp_rev_dncr_osc3 set valid_dpr_center='y' where center_id like '1680%' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	
	
	
	
	
		  
/*
$query="update budget.project_steps_detail set status='complete' 
          where project_category='$project_category' and project_name='$project_name'
		  and step_group='$step_group' and step_num='$step_num' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	
*/



//{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&report_type=form");}




 
 ?>