<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>"; // exit;
session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

//echo "<pre>";print_r($_SESSION);echo "</pre>"; //exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
//echo $beacnum; exit;
extract($_REQUEST);
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;
$system_entry_date=date("Ymd");

$query1="select COLUMN_DEFAULT as 'fyear_default' from INFORMATION_SCHEMA.COLUMNS where TABLE_SCHEMA='budget' and TABLE_NAME='crs_tdrr_division_deposits' and COLUMN_NAME='f_year'";
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
		  
$row1=mysqli_fetch_array($result1);

extract($row1);

//echo "<br />fyear_default=$fyear_default<br />";
$f_year=$fyear_default;
//echo "<br />fyear_default=$fyear_default<br />";
//echo "<br />f_year=$f_year<br />";
//exit;

$form_return="<form method='post' action='page2_form.php'>
<input type='hidden' name='check_receipt_date' value='$check_receipt_date'>
<input type='hidden' name='checknum' value='$checknum'>
<input type='hidden' name='payor' value='$payor'>
<input type='hidden' name='payor_bank' value='$payor_bank'>
<input type='hidden' name='amount' value='$amount'>
<input type='hidden' name='description' value='$description'>
<input type='hidden' name='edit' value='y'>
<input type='hidden' name='menu_check' value='$menu_check'>
<input type='hidden' name='edit_id' value='$edit_id'>
<input type='hidden' name='submit' value='Submit'>
<input type='submit' name='submit2' value='Return to Form'></form>";

if($check_receipt_date=="")
{echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />";
 echo "$form_return"; exit;
}
if($checknum=="")
{echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />";
 echo "$form_return"; exit;
}
if($payor=="")
{echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />";
 echo "$form_return"; exit;
}	

if($payor_bank=="")
{echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />";
 echo "$form_return"; exit;
}	

if($amount=="")
{echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />";
 echo "$form_return"; exit;
}	

//Dodd and Rumble
/*
if($beacnum=='60032781' or $beacnum=='60036015')
{
if($description=="")
{echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />";
 echo "$form_return"; exit;
}	

}

*/

$amount2=$amount;
$amount2=str_replace(",","",$amount2);
$amount2=str_replace("$","",$amount2);

if($edit_record != 'yes')
{

$query2="insert into crs_tdrr_division_deposits_checklist 
set checknum='$checknum',payor='$payor',payor_bank='$payor_bank',amount='$amount2',system_entry_date='$system_entry_date',check_receipt_date='$check_receipt_date',
f_year='$f_year',cashier='$cashier',budget_office='y' ";

//echo "<br />Line 61: query2=$query2<br />"; exit;

$result2=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");


//cleanup check records that have not been included in CRJ yet (insure that drop-down box for Check info is CLEAN when Heide enters form data for CRJ)-TBASS 6/23/20

include("check_data_cleanup.php");



}
//echo "<br />Line 87<br />"; exit;

if($edit_record == 'yes')
{
	//Dodd and Rumble (includes field=description)
if($beacnum=='60032781' or $beacnum=='60036015')
{	
$query2="update crs_tdrr_division_deposits_checklist 
set checknum='$checknum',payor='$payor',payor_bank='$payor_bank',amount='$amount2',system_entry_date='$system_entry_date',check_receipt_date='$check_receipt_date',
f_year='$f_year',description='$description',budget_office='y'
where id='$edit_id' ";
}


//Rebecca Owen and Rachel Gooding (excludes field=description)
if($beacnum=='60033242' or $beacnum=='60032997')
{	
$query2="update crs_tdrr_division_deposits_checklist 
set checknum='$checknum',payor='$payor',payor_bank='$payor_bank',amount='$amount2',system_entry_date='$system_entry_date',check_receipt_date='$check_receipt_date',
f_year='$f_year',budget_office='y'
where id='$edit_id' ";
}


//echo "<br />Line 61: query2=$query2<br />"; exit;

$result2=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");


//cleanup check records that have not been included in CRJ yet (insure that drop-down box for Check info is CLEAN when Heide enters form data for CRJ)-TBASS 6/23/20

include("check_data_cleanup.php");



}







/*
$query3="delete from crs_tdrr_division_deposits_checklist
         where checknum='' and payor='' and payor_bank='' and amount='0.00' ";
$result3=mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");
*/

//echo "Update Successful<br />";



header("location: page2_form.php?edit=y&menu_check=add&update=yes&check_receipt_date=$check_receipt_date");

 
 ?>