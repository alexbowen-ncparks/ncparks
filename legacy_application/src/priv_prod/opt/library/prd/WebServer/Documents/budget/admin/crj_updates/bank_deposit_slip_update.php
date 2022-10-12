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
//$rc_total=array_sum($rc_amount);

// echo "rc_total=$rc_total<br />";//exit;
 
//echo "orms_deposit_id=$orms_deposit_id";exit;

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
//echo "concession_location=$concession_location";
//exit;
//echo "tempid=$tempid<br />";
//echo "concession_location=$concession_location<br />";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../../budget/~f_year.php");

$f_year='1314';


$query11a="select count(id) as 'cashier_count'
          from cash_handling_roles
		  where park='$concession_location' and role='cashier' and tempid='$tempid' ";	 

$result11a = mysqli_query($connection, $query11a) or die ("Couldn't execute query 11a.  $query11a");
		  
$row11a=mysqli_fetch_array($result11a);

extract($row11a);

//if($cashier_nick){$cashier_first=$cashier_nick;}			  
		  
//echo "query11a=$query11a<br />";//exit;
//echo "cashier_count=$cashier_count<br />";//exit;
//echo "cashier_first=$cashier_first<br />";//exit;
//echo "cashier_last=$cashier_last<br />";//exit;

// 60036015 Budget office (heide rumble), 60032781 Budget office (tammy dodd), 60032793 Budget office (Tony Bass)	
if(($cashier_count==1) or ($beacnum=='60036015' or $beacnum=='60032781' or $beacnum=='60032793'))
{




$source_table="crs_tdrr_division_deposits";
//echo "checks=$checks<br />";
//echo "checknum0=$checknum0<br />";




/*
{
if($rc_total != $rcf_amount)
{echo "<font color='brown' size='5'><b>Reimbursement Allocation does not equal $rcf_amount<br /><br />Click the BACK button on your Browser to re-enter info on form</b></font><br />";exit;}
}
*/


define('PROJECTS_UPLOADPATH','documents_bank_deposits/');
$document=$_FILES['document']['name'];
//echo "document=$document<br />";
$document_format2=substr($document, -3);
//echo "document_format2=$document_format2<br />";
if($document_format2=='jpg' or $document_format2=='JPG'){$format_ok='y';} else {$format_ok='n';}
//echo "format_ok=$format_ok";
//exit;
if($document==""){echo "<font color='brown' size='5'><b>No Document Found. <br /><br />Please hit back button on Browser to Upload Document</b></font>";exit;}

if($format_ok=='n'){echo "<font color='brown' size='5'><b>Filetype is NOT in JPG Format. Please Upload a JPG File. <br /><br />Please hit back button on Browser to Upload JPG File</b></font>";exit;}





/*
$query1a="select count(id) as 'cashier_count'
          from cash_handling_roles
		  where park='$concession_location' and role='cashier' and tempid='$entered_by' ";	 

$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");
		  
$row1a=mysqli_fetch_array($result1a);

extract($row1a);			  
		  
echo "query1a=$query1a<br />";//exit;
echo "cashier_count=$cashier_count<br />";exit;
*/

$system_entry_date=date("Ymd");
//$project_start_date=$_POST['project_start_date'];
//$project_end_date=$_POST['project_end_date'];
//$project_status=$_POST['project_status'];



$doc_mod=$document;

$document=$source_table."_".$id;//echo $document;//exit;

$ext=explode(".",$doc_mod);
$num=count($ext)-1;
$ext1=$ext[$num];
$document.=".".$ext1;

$target=PROJECTS_UPLOADPATH.$document;
move_uploaded_file($_FILES['document']['tmp_name'], $target);


$query5="update crs_tdrr_division_deposits set document_location='$target'
where id='$id' ";
mysqli_query($connection, $query5) or die ("Error updating Database $query5");


//echo "update successful";
}

{header("location: crs_deposits_crj_reports_final.php?deposit_id=$orms_deposit_id&GC=n");}



?>