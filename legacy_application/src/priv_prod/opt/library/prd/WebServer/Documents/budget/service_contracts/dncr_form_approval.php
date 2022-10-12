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

if($manager_approved != "y"){echo "<font color='brown' size='5'>Oops:We did not receive Approval<br /><br /> Click the BACK button on your Browser to Approve Form</font><br />";exit;}
//if($invoice_date==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}
//if($invoice_amount==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}
//if($service_period==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}


$database="budget";
$db="budget";

include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database
include("../../../include/activity_new.php");// database connection parameters
include("../../budget/~f_year.php");

//echo "<br />Line 45: Update Successful<br />"; exit;


$query2d="update `budget_service_contracts`.`invoices`
         set `manager`='$tempid',`manager_date`='$today',`manager_approved`='y'
         where `scid`='$scid' and `invoice_num`='$invoice_num' and `cashier_approved`='y' ";
//echo "query=$query<br />";

$result2d=mysqli_query($connection,$query2d) or die ("Couldn't execute query2d. $query2d");


$query2e="update `budget_service_contracts`.`pay_lines` 
         set `manager_approved`='y' 
         where `scid`='$scid' and `invoice_num`='$invoice_num' and `cashier_approved`='y' ";
//echo "query=$query<br />";

$result2e=mysqli_query($connection,$query2e) or die ("Couldn't execute query2e. $query2e");

$query2f="update `budget_service_contracts`.`invoices_paylines`
          set `manager_approved`='y'
          where scid='$scid' and invoice_num='$invoice_num'	and `cashier_approved`='y'	  ";
////echo "<br /><br />query2f=$query2f<br /><br />";
//exit;

$result2f=mysqli_query($connection,$query2f) or die ("Couldn't execute query2f. $query2f");

//exit;


header("location: service_contracts1_invoice_search.php?menu_sc=invoice_search ");





?>