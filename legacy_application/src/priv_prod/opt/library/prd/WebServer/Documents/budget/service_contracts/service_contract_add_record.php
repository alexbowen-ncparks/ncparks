<?php

session_start();

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];

extract($_REQUEST);
$monthly_cost2=str_replace(",","",$monthly_cost);
$monthly_cost2=str_replace("$","",$monthly_cost2);

$yearly_cost2=str_replace(",","",$yearly_cost);
$yearly_cost2=str_replace("$","",$yearly_cost2);

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;

$database="budget";
$db="budget";
//include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
//mysqli_select_db($connection, $database); // database
mysqli_select_db($connection,$database); // database
//include("../../../include/activity.php");// database connection parameters
include("../../../include/activity_new.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");

$form_return="<form method='post' action='service_contracts1_add.php'>
<input type='hidden' name='park' value='$park'>
<input type='hidden' name='contract_admin_tempid' value='$contract_admin_tempid'>
<input type='hidden' name='contract_type' value='$contract_type'>
<input type='hidden' name='service_type' value='$service_type'>
<input type='hidden' name='vendor' value='$vendor'>
<input type='hidden' name='contract_num' value='$contract_num'>
<input type='hidden' name='po_num' value='$po_num'>
<input type='hidden' name='buy_entity' value='$buy_entity'>
<input type='hidden' name='center' value='$center'>
<input type='hidden' name='ncas_account' value='$ncas_account'>
<input type='hidden' name='company' value='$company'>
<input type='hidden' name='remit_address' value='$remit_address'>
<input type='hidden' name='fid_num' value='$fid_num'>
<input type='hidden' name='group_num' value='$group_num'>
<input type='hidden' name='monthly_cost' value='$monthly_cost'>
<input type='hidden' name='yearly_cost' value='$yearly_cost'>
<input type='hidden' name='original_contract_start_date' value='$original_contract_start_date'>
<input type='hidden' name='original_contract_end_date' value='$original_contract_end_date'>
<input type='hidden' name='comments' value='$comments'>
<input type='hidden' name='menu_sc' value='SC1'>
<input type='hidden' name='submit' value='Submit'>
<input type='submit' name='submit2' value='Return to Form'></form>";


if($park==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form(park)<br /><br />"; echo "$form_return"; exit;}
if($contract_admin_tempid==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form(contract_admin_tempid)<br /><br />"; echo "$form_return"; exit;}
if($contract_type==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form(contract_type)<br /><br />"; echo "$form_return"; exit;}	
if($service_type==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form(service_type)<br /><br />"; echo "$form_return"; exit;}	
if($vendor==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form(vendor)<br /><br />"; echo "$form_return"; exit;}	
if($contract_num==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form(contract_num)<br /><br />"; echo "$form_return"; exit;}	
if($po_num==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form(po_num)<br /><br />"; echo "$form_return"; exit;}	
if($buy_entity==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form(buy_entity)<br /><br />"; echo "$form_return"; exit;}	
if($center==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form(center)<br /><br />"; echo "$form_return"; exit;}	
if($ncas_account==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form(ncas_account)<br /><br />"; echo "$form_return"; exit;}	
if($company==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form(company)<br /><br />"; echo "$form_return"; exit;}	
if($remit_address==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form(remit_address)<br /><br />"; echo "$form_return"; exit;}	
if($fid_num==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form(fid_num)<br /><br />"; echo "$form_return"; exit;}	
if($group_num==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form(group_num)<br /><br />"; echo "$form_return"; exit;}	
if($monthly_cost==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form(monthly_cost)<br /><br />"; echo "$form_return"; exit;}	
if($yearly_cost==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form(yearly_cost)<br /><br />"; echo "$form_return"; exit;}	
if($original_contract_start_date==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form(original_contract_start_date)<br /><br />"; echo "$form_return"; exit;}
if($original_contract_end_date==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form(original_contract_end_date)<br /><br />"; echo "$form_return"; exit;}	
if($comments==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form(comments)<br /><br />"; echo "$form_return"; exit;}


define('PROJECTS_UPLOADPATH','documents/');
$document=$_FILES['document']['name'];
if($document==""){echo "<font color='red' size='5'><b>No Document Found. <br /><br />Please hit back button on Browser to Upload Document</b></font>";
echo "$form_return";
exit;}

$entered_by=substr($tempid,0,-4);
$system_entry_date=date("Ymd");

$park=strtolower($park);
$contract_admin_tempid=strtolower($contract_admin_tempid);
if($park=='admn'){$contract_admin_tempid2=$contract_admin_tempid;}


$query1="insert into `budget_service_contracts`.`contracts`
set division='dpr',park='$park',contract_admin_tempid='$contract_admin_tempid',service_type='$service_type',contract_type='$contract_type',vendor='$vendor',contract_num='$contract_num',po_num='$po_num',po_original_total='$po_original_total',buy_entity='$buy_entity',monthly_cost='$monthly_cost2',yearly_cost='$yearly_cost2',original_contract_start_date='$original_contract_start_date',original_contract_end_date='$original_contract_end_date',comments='$comments',entered_by='$entered_by',entered_by_full='$tempid',center='$center',ncas_account='$ncas_account',company='$company',remit_address='$remit_address',fid_num='$fid_num',group_num='$group_num'
";

$result1=mysqli_query($connection,$query1) or die ("Couldn't execute query 1. $query1");

$query2="SELECT max(id) as 'maxid'
         from `budget_service_contracts`.`contracts`
         where 1 ";

$result2=mysqli_query($connection,$query2) or die ("Couldn't execute query 2. $query2");
$row2=mysqli_fetch_array($result2);
extract($row2);

define('PROJECTS_UPLOADPATH','documents/');
$source_table="contracts";
$doc_mod=$document;
$document=$source_table."_".$maxid;//echo $document;//exit;
$ext=explode(".",$doc_mod);
$num=count($ext)-1;
$ext1=$ext[$num];
$document.=".".$ext1;
$target=PROJECTS_UPLOADPATH.$document;
echo $target; //exit;
//echo "$form_return"; exit;
move_uploaded_file($_FILES['document']['tmp_name'], $target);
//echo $target; exit;

$target2="/budget/service_contracts/".$target ;
$query3="update `budget_service_contracts`.`contracts` set document_location='$target2'
where id='$maxid' ";

$result3=mysqli_query($connection,$query3) or die ("Couldn't execute query 3. $query3");

//header("location: service_contracts1.php?id=$maxid");
header("location: service_contracts2.php?park=$park");


?>