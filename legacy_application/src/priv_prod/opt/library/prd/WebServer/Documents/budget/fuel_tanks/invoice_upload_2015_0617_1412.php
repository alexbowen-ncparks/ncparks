<?php

session_start();

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
$concession_center_L3=substr($concession_center,-3);
$first_fyear_deposit=$concession_center_L3.'001';
//echo "concession_center_L3=$concession_center_L3<br />";//exit;
//echo "first_fyear_deposit=$first_fyear_deposit";//exit;


extract($_REQUEST);
$rc_total=array_sum($rc_amount);

// echo "rc_total=$rc_total<br />";//exit;
 
//echo "orms_deposit_id=$orms_deposit_id";exit;

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo "cashier_overshort_comment=$cashier_overshort_comment<br />"; exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../include/activity.php");// database connection parameters

$query11a="select first_name as 'cashier_first',nick_name as 'cashier_nick',last_name as 'cashier_last',count(id) as 'cashier_count'
          from cash_handling_roles
		  where park='$concession_location' and role='cashier' and tempid='$tempid' ";	 

$result11a = mysql_query($query11a) or die ("Couldn't execute query 11a.  $query11a");
		  
$row11a=mysql_fetch_array($result11a);

extract($row11a);

if($cashier_nick){$cashier_first=$cashier_nick;}

echo "cashier_first=$cashier_first<br />";
echo "cashier_count=$cashier_count<br />"; 


if($cashier_count==1)
{

$source_table="fuel_tank_usage";

define('PROJECTS_UPLOADPATH','invoices/');
$document=$_FILES['document']['name'];
echo "document=$document<br />";
$document_format2=substr($document, -3);
echo "document_format2=$document_format2<br />";
if($document_format2=='jpg' or $document_format2=='JPG'){$format_ok='y';} else {$format_ok='n';}
echo "format_ok=$format_ok<br />";

if($cost_per_gallon==""){echo "<font color='brown' size='5'><b>Oops! Cost per Gallon Missing<br /><br />Click the BACK button on your Browser to enter Cost per Gallon. Thanks!</b></font><br />";exit;}

if($document==""){echo "<font color='brown' size='5'><b>Oops! Invoice Missing. <br /><br />Please hit back button on Browser to Upload Invoice. Thanks!</b></font>";exit;}

if($format_ok=='n'){echo "<font color='brown' size='5'><b>Filetype is NOT in JPG Format. Please Upload a JPG File. <br /><br />Please hit back button on Browser to Upload JPG File</b></font>";exit;}


$system_entry_date=date("Ymd");

$doc_mod=$document;

$document=$source_table."_".$id;//echo $document;//exit;

$ext=explode(".",$doc_mod);
$num=count($ext)-1;
$ext1=$ext[$num];
$document.=".".$ext1;

$target=PROJECTS_UPLOADPATH.$document;
move_uploaded_file($_FILES['document']['tmp_name'], $target);


$query5="update fuel_tank_usage set document_location='$target'
where park='$parkcode' and cash_month='$cash_month' and cash_month_calyear='$cash_month_calyear'  ";
mysql_query($query5) or die ("Error updating Database $query5");

}

echo "Update Successful<br />";



?>