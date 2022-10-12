<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

//echo "<pre>";print_r($_SESSION);echo "</pre>"; //exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];

//$file = "articles_menu.php";
//$lines = count(file($file));
$system_entry_date=date("Ymd");
$today=date("Ymd");
//$table="infotrack_projects";

//echo "<pre>";print_r($_SESSION);"</pre>"; //exit;
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;


extract($_REQUEST);

//$invoice_num2=str_replace('-','',$invoice_num);
//$invoice_num2=strtoupper($invoice_num2);
//$invoice_amount2=str_replace(",","",$invoice_amount);
//$invoice_amount2=str_replace("$","",$invoice_amount2);

if($cashier_approved != "y"){echo "<font color='brown' size='5'>Oops:We did not receive Approval<br /><br /> Click the BACK button on your Browser to Approve Form</font><br />";exit;}
//if($invoice_date==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}
//if($invoice_amount==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}
//if($service_period==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");

//echo "<br />Line 45: Update Successful<br />"; exit;


$query10="update cash_imprest_count_scoring set approved_by='$tempid' where fyear='$compliance_fyear' and cash_month='$compliance_month' ";
//echo "query10=$query10<br />";
$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");



$query23a="update budget.project_steps_detail set status='complete' where project_category='fms'
         and project_name='monthly_compliance' and step_group='B' and step_num='0b' ";
		 
//echo "query23a=$query23a<br />";		 
		 
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

//exit;


header("location: /budget/admin/compliance/step_group.php?report_type=form&compliance_fyear=$compliance_fyear&compliance_month=$compliance_month ");





?>