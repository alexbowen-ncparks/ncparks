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

//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;


/*

$rc_total=array_sum($rc_amount);
*/
if($approval_number==1)
{
define('PROJECTS_UPLOADPATH','pcard_documents/');
$document=$_FILES['document']['name'];
if($document==""){echo "<font color='red' size='5'><b>No Document Found. <br /><br />Please hit back button on Browser to Upload Document</b></font>";exit;}
$source_table="pcard_users";
$entered_by=$tempid;

$sed=date("Ymd");
/*
if($card_number==""){echo "<font color='brown' size='5'><b>Card# missing<br /><br />Click the BACK button on your Browser to enter Card#</b></font><br />";exit;}
*/

if($buof_approved==""){echo "<font color='brown' size='5'><b>Budget Approval missing<br /><br />Click the BACK button on your Browser to enter Budget Approval</b></font><br />";exit;}


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters

$doc_mod=$document;
//$doc_mod=$document;
//$document=$myusername."_".$date."_".$message_note_id;
//echo $document;//exit;
//$document="pcard_unreconciled".$source_id;
$document=$source_table."_".$id."_final"; echo $document; //exit;
//echo "<br />";
//echo "<br />";
//echo $document;
$ext=explode(".",$doc_mod);
$num=count($ext)-1;
$ext1=$ext[$num];
$document.=".".$ext1;

$target=PROJECTS_UPLOADPATH.$document;
//echo "<br /><br />";
//echo $target; exit;

move_uploaded_file($_FILES['document']['tmp_name'], $target);  //exit;

$target2="/budget/acs/".$target ;

if($buof_approved=='y')
{


$query1="update pcard_users set fs_approver='$entered_by',fs_approver_date='$sed',card_number='$card_number'
         where id='$id' ";  

  
		 
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");	




$query2="update pcard_users set document_location_final='$target2'
where id='$id' ";

mysqli_query($connection, $query2) or die ("Error updating Database $query2");
}


//echo "<font color='red' size='5'>update successful</font>";
//echo "<H3 ALIGN=left><A href=pcard_request1.php?edit=y>Return to PCARD Request</A></H3>";
}

if($approval_number==2)
{
	
if($card_number==""){echo "<font color='brown' size='5'><b>Card# missing<br /><br />Click the BACK button on your Browser to enter Card#</b></font><br />";exit;}	
	
if($buof_approved==""){echo "<font color='brown' size='5'><b>Budget Approval missing<br /><br />Click the BACK button on your Browser to enter Budget Approval</b></font><br />";exit;}


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters	
//echo "Line 101: Code Pending"; exit;	
$entered_by=$tempid;

$sed=date("Ymd");
$query3="update pcard_users set fs_approver2='$entered_by',fs_approver_date2='$sed',card_number='$card_number',act_id='y'
         where id='$id' ";  

  
		 
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");	



}

{header("location: pcard_request4.php?menu=RCard ");}



?>