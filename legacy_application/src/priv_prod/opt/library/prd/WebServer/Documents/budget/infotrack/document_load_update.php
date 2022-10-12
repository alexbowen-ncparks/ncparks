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
//$table="infotrack_projects";

//echo "<pre>";print_r($_SESSION);"</pre>"; //exit;
//echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;


extract($_REQUEST);

/*
$invoice_num2=str_replace('-','',$invoice_num);
$invoice_num2=strtoupper($invoice_num2);
echo "Line 28: invoice_num2=$invoice_num2<br />";
*/



if($report_name==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}

/*
if($invoice_num==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}
if($invoice_date==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}
if($invoice_amount==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}
if($service_period==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}
*/


define('PROJECTS_UPLOADPATH','documents/');
$document=$_FILES['document']['name'];
//echo "document=$document<br />";
/*
$document_format2=substr($document, -3);
if($document_format2=='jpg' or $document_format2=='JPG'){$format_ok='y';} else {$format_ok='n';}
echo "format_ok=$format_ok<br />";
*/


if($document == ""){echo "<font color='brown' size='5'><b>No Document Found. <br /><br />Please hit back button on Browser to Upload Document</b></font>"; exit;}
/*
if($format_ok == 'n'){echo "<font color='brown' size='5'><b>Filetype is NOT in JPG Format. Please Upload a JPG File. <br /><br />Please hit back button on Browser to Upload JPG File</b></font>"; exit;}
*/

//echo "Line 58. Error not detected<br />";  exit;

//echo "Line 51<br />"; exit;




$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../budget/~f_year.php");


/*  ends at line 169
if($submit=='Add')
{
if($beacnum != '60032781')
{
$query2=" insert into service_contracts_invoices set
          scid='$scid',invoice_num='$invoice_num2',invoice_date='$invoice_date',invoice_amount='$invoice_amount2',
          previous_amount_paid='$line_num_previous_paid',ncas_account='$ncas_account',park='$park',center='$center',company='$company',
		  service_period='$service_period',cashier='$tempid',cashier_date='$system_entry_date'  ";
		  
}

//If invoice is entered by Budget Officer (beacon number 60032781), both Cashier and Manager approval are Updated with Budget Officer tempid
if($beacnum == '60032781')
{
$query2=" insert into service_contracts_invoices set
          scid='$scid',invoice_num='$invoice_num2',invoice_date='$invoice_date',invoice_amount='$invoice_amount2',
          previous_amount_paid='$line_num_previous_paid',ncas_account='$ncas_account',park='$park',center='$center',company='$company',
		  service_period='$service_period',cashier='$tempid',cashier_date='$system_entry_date',cashier_approved='y',manager='$tempid',manager_date='$system_entry_date'  ";
		  
}


//echo "query2=$query2";exit;
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$query2a=" select max(id) as 'eid' from service_contracts_invoices where scid='$scid' ";

$result2a = mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a.  $query2a");

$row2a=mysqli_fetch_array($result2a);
extract($row2a);


}

echo "Error not detected. Line 126<br />"; //exit;

if($submit=='Update')
{

if($keep_old_cashier=='y')
{$cashier_value=$old_cashier;


$query3=" update service_contracts_invoices set
          invoice_num='$invoice_num2',invoice_date='$invoice_date',invoice_amount='$invoice_amount2',
          previous_amount_paid='$line_num_previous_paid',ncas_account='$ncas_account',center='$center',company='$company',service_period='$service_period',cashier='$cashier_value',cashier_date='$system_entry_date'
          where id='$eid'		  ";

}

if($keep_old_cashier!='y')
{

$query3=" update service_contracts_invoices set
          invoice_num='$invoice_num2',invoice_date='$invoice_date',invoice_amount='$invoice_amount2',
          previous_amount_paid='$line_num_previous_paid',ncas_account='$ncas_account',center='$center',company='$company',service_period='$service_period',cashier='$tempid',cashier_date='$system_entry_date'
          where id='$eid'		  ";

}
		  
		  
mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");


//echo "Code Pending<br />"; exit;

}

$query4=" update service_contracts_invoices,service_contracts
          set service_contracts_invoices.line_num_beg_bal=service_contracts.line_num_beg_bal
		  where service_contracts_invoices.scid=service_contracts.id
       ";


mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

$query5="update service_contracts_invoices
         set cummulative_amount_paid=invoice_amount+previous_amount_paid
		 where 1  ";
		 
		 
mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");		 
		 

*/		 
$query5="insert into position_report
         set report_name='$report_name',status_ok='y',new_tab='y',dpr='n',download_available='n',document_yn='y',sed='$system_entry_date'  ";
		 
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
		 
		 
		 
		 
		 
$query6="select max(report_id) as 'last_id'
         from position_report
         where 1
           ";

$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");
		  
$row6=mysqli_fetch_array($result6);

extract($row6);

//echo "last_id=$last_id<br />"; exit;

$source_table='position_report' ;


$doc_mod=$document;

$document=$source_table."_".$last_id;//echo $document;//exit;

$ext=explode(".",$doc_mod);
$num=count($ext)-1;
$ext1=$ext[$num];
$document.=".".$ext1;

$target=PROJECTS_UPLOADPATH.$document;
move_uploaded_file($_FILES['document']['tmp_name'], $target);


$query7="update position_report set report_location='$target'
where report_id='$last_id' ";
mysqli_query($connection, $query7) or die ("Error updating Database $query7");		 

	
$query8="insert into position_report_users set beacnum='$beacnum',report_id='$last_id',downloaded='y',tempid='$tempid',download_date='$system_entry_date'  ";
mysqli_query($connection, $query8) or die ("Error updating Database $query8");


	
//echo "Line 195. Upload Successful<br />";  exit;		 
		 
		 
		 
//echo "Code Pending<br />"; exit;

//exit;

header("location: position_reports.php?menu=1");





?>














