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
$date=date("Ymd");
$today=$date; echo "<br />today=$today<br />";
//echo "<br />tempid=$tempid<br />";
//$table="infotrack_projects";

//echo "<pre>";print_r($_SESSION);"</pre>"; //exit;
//echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;


extract($_REQUEST);
/*
$invoice_num2=str_replace('-','',$invoice_num);
$invoice_num2=strtoupper($invoice_num2);
$invoice_amount2=str_replace(",","",$invoice_amount);
$invoice_amount2=str_replace("$","",$invoice_amount2);

if($invoice_num==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}
if($invoice_date==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}
if($invoice_amount==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}
if($service_period==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}
*/


//define('PROJECTS_UPLOADPATH','documents/');
//$document=$_FILES['document']['name'];
//echo "document=$document<br />";
//$document_format2=substr($document, -3);
//echo "document_format2=$document_format2<br />";
//if($document_format2=='jpg' or $document_format2=='JPG'){$format_ok='y';} else {$format_ok='n';}
//if($document_format2=='pdf' or $document_format2=='PDF'){$format_ok='y';} else {$format_ok='n';}
//echo "format_ok=$format_ok<br />";

//if($document == ""){echo "<font color='brown' size='5'><b>No Document Found. <br /><br />Please hit back button on Browser to Upload Document</b></font>"; exit;}
//if($format_ok == 'n'){echo "<font color='brown' size='5'><b>Filetype is NOT in PDF Format. Please Upload a PDF File. <br /><br />Please hit back button on Browser to Upload PDF File</b></font>"; exit;}

$database="budget";
$db="budget";

include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database
include("../../../include/activity_new.php");// database connection parameters
include("../../budget/~f_year.php");

//$query="select count(id) as 'invoice_count',invoice_num from service_contracts_invoices where scid='$scid' and invoice_num='$invoice_num2' ";
//$query="select count(`id`) as 'invoice_count',`invoice_num` from `budget_service_contracts`.`invoices` where `scid`='$scid' and `invoice_num`='$invoice_num2' ";
		 
//echo "query=$query<br />";
/*
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
$row=mysqli_fetch_array($result);
extract($row);

if($invoice_count > 0 and $submit == 'Add')
{echo "<font color='red' size='5'>Oops: Invoice# $invoice_num2 has already been entered for this Contract.</font> <br /><br /> <font size='5' color='brown'>Click the BACK button on your Browser to enter the correct Invoice Number</font><br />"; exit;}
*/

/*
$query2=" insert into service_contracts_invoices set
          scid='$scid',invoice_num='$invoice_num2',invoice_date='$invoice_date',invoice_amount='$invoice_amount2',ncas_account='$ncas_account',center='$center',park='$park',company='$company',
		  service_period='$service_period',cashier='$tempid',cashier_date='$system_entry_date',remit_address='$remit_address'  ";
*/
/*
$query2=" insert into `budget_service_contracts`.`invoices` set
          `scid`='$scid',`invoice_num`='$invoice_num2',`invoice_date`='$invoice_date',`invoice_amount`='$invoice_amount2',`ncas_account`='$ncas_account',`center`='$center',`park`='$park',`company`='$company',
		  `service_period`='$service_period',`cashier`='$tempid',`cashier_date`='$system_entry_date',`remit_address`='$remit_address'  ";



		  
		  
$result2=mysqli_query($connection,$query2) or die ("Couldn't execute query2. $query2");		
*/
  
		  
//$query2a=" select max(id) as 'eid' from service_contracts_invoices where scid='$scid' ";
/*
$query2a=" select max(`id`) as 'eid' from `budget_service_contracts`.`invoices` where `scid`='$scid' ";
$result2a=mysqli_query($connection,$query2a) or die ("Couldn't execute query2a. $query2a");
$row2a=mysqli_fetch_array($result2a);
extract($row2a);


$query6="select max(`id`) as 'last_id' from `budget_service_contracts`.`invoices` where `scid`='$scid' ";
$result6=mysqli_query($connection,$query6) or die ("Couldn't execute query 6. $query6");		  
$row6=mysqli_fetch_array($result6);
extract($row6);

//$source_table='service_contracts_invoices' ;
$source_table='invoices' ;
$doc_mod=$document;
$document=$source_table."_".$last_id;//echo $document;//exit;
$ext=explode(".",$doc_mod);
$num=count($ext)-1;
$ext1=$ext[$num];
$document.=".".$ext1;
$target=PROJECTS_UPLOADPATH.$document;
move_uploaded_file($_FILES['document']['tmp_name'], $target);

//$query7="update service_contracts_invoices set document_location='$target' where id='$last_id' ";
$query7="update `budget_service_contracts`.`invoices` set `document_location`='$target' where `id`='$last_id' ";
$result7=mysqli_query($connection,$query7) or die ("Couldn't execute query 7. $query7");		 
*/
//echo "<br />Line 98: Update Successful<br />"; //exit;

//$query1="insert into service_contracts_invoices_paylines SET";
$query1="update `budget_service_contracts`.`pay_lines` SET";
for($j=0;$j<$paylines;$j++){
$query2=$query1;

$payline_amount2=$preDB_amount[$j];
$payline_amount2=str_replace(",","",$payline_amount2);
$payline_amount2=str_replace("$","",$payline_amount2);
$payline_num2=$payline_num[$j];
//if($po_line_num_beg_bal2==''){continue;}

	$query2.=" `payline_amount`='$payline_amount2'";
	$query2.=" where `scid`='$scid' and `payline_num`='$payline_num2' and `preDB`='y' ";
			
//echo "<br />query2=$query2<br />";
$result2=mysqli_query($connection,$query2) or die ("Couldn't execute query 2. $query2");
}

$query2a="select sum(`payline_amount`) as 'invoice_total' from `budget_service_contracts`.`pay_lines` where `scid`='$scid' and `preDB`='y' ";
$result2a=mysqli_query($connection,$query2a) or die ("Couldn't execute query2a. $query2a");
$row2a=mysqli_fetch_array($result2a);
extract($row2a);
//echo "<br />invoice_total=$invoice_total<br />";


$query2b="update `budget_service_contracts`.`contracts`,`budget`.`cash_handling_roles`
          set `budget_service_contracts`.`contracts`.`contract_admin_tempid`=`budget`.`cash_handling_roles`.`tempid`
          where `budget`.`cash_handling_roles`.`park`='$park' and `budget`.`cash_handling_roles`.`lead_superintendent`='y'
          and `budget_service_contracts`.`contracts`.id='$scid'		  ";
		  
//echo "<br />query2b=$query2b<br />";		  
		  
$result2b=mysqli_query($connection,$query2b) or die ("Couldn't execute query2b. $query2b");

$query2c="insert ignore into `budget_service_contracts`.`invoices`
          set `scid`='$scid',`invoice_num`='preDB' ";
		  
//echo "<br />query2c=$query2c<br />";		  
		  
$result2c=mysqli_query($connection,$query2c) or die ("Couldn't execute query2c. $query2c");




$query3=" update `budget_service_contracts`.`invoices` 
          set `invoice_date`='$today',
		      `invoice_amount`='$invoice_total',
			  `ncas_account`='$ncas_account',
			  `center`='$center',
			  `park`='$park',
			  `company`='$company',
		      `service_period`='preDB_period',
			  `cashier`='$tempid',`cashier_date`='$today',`cashier_approved`='y',
			  `manager`='$tempid',`manager_date`='$today',`manager_approved`='y',
			  `contract_administrator`='$tempid',`contract_administrator_date`='$today',`contract_administrator_approved`='y', 			  
			  `remit_address`='none'
          where `scid`='$scid' and `invoice_num`='preDB' ";
		  
		  
		  
//echo "<br />query3=$query3<br />";		  
		  
		  
$result3=mysqli_query($connection,$query3) or die ("Couldn't execute query3. $query3");



	

//echo "<br />Line 119: Update Successful<br />"; exit;

header("location: po_lines.php?scid=$scid&submit=PO_Lines");





?>