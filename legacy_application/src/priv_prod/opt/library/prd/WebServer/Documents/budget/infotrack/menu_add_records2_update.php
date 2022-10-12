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
$deposit_amount=str_replace(",","",$deposit_amount);
$deposit_amount=str_replace("$","",$deposit_amount);

//echo "Currently Under Construction-TBASS<br />";//exit;
//$center=str_replace("-","",$center);

//echo "bo_receipt_date";exit;

//echo "tempid=$tempid";

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;


$source_table="menu_add_records2";

$park=substr($park,0,4);


if($park==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
//if($center==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($deposit_id==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}

if($comment_note==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}


if($deposit_amount==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($bank_deposit_date==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
//if($collection_start_date==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
//if($collection_end_date==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($bo_receipt_date==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}

define('PROJECTS_UPLOADPATH','documents/');
$document=$_FILES['document']['name'];
if($document==""){echo "<font color='red' size='5'><b>No Document Found. <br /><br />Please hit back button on Browser to Upload Document</b></font>";exit;}

$entered_by=substr($tempid,0,-2);

//$date=$_POST['date'];
//$project_category=$_POST['project_category'];
//$project_name=$_POST['project_name'];
//$project_note=$_POST['project_note'];
//$weblink=$_POST['weblink'];
$system_entry_date=date("Ymd");
//$project_start_date=$_POST['project_start_date'];
//$project_end_date=$_POST['project_end_date'];
//$project_status=$_POST['project_status'];

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");

$comment_note=addslashes($comment_note);

$query1="insert into menu_add_records2
set park='$park',deposit_id='$deposit_id',comment_note='$comment_note',deposit_amount='$deposit_amount',bank_deposit_date='$bank_deposit_date',collection_start_date='$collection_start_date',collection_end_date='$collection_end_date',bo_receipt_date='$bo_receipt_date',entered_by='$entered_by',sed='$system_entry_date',f_year='$f_year'
";

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


$query2="update menu_add_records2,center
         set menu_add_records2.center=center.center
		 where menu_add_records2.park=center.parkcode; ";

mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


$query3="select max(id) as 'maxid'
         from menu_add_records2 where 1 ; ";

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
		  
$row3=mysqli_fetch_array($result3);

extract($row3);


$doc_mod=$document;
//$doc_mod=$document;
//$document=$myusername."_".$date."_".$message_note_id;
//echo $document;//exit;
//$document="pcard_unreconciled".$source_id;
$document=$source_table."_".$maxid;//echo $document;//exit;
//echo "<br />";
//echo "<br />";
//echo $document;
$ext=explode(".",$doc_mod);
$num=count($ext)-1;
$ext1=$ext[$num];
$document.=".".$ext1;
//echo $document;exit;
//echo "<br />";
//echo "<pre>";print_r($ext);echo "</pre>";exit;

//$document=str_replace(" ","_",$document);
//$document=str_replace("%20","_",$document);

//echo $document;
//$target=PROJECTS_UPLOADPATH.$myusername."_".$date."_".$message_note_id."_".$document;
$target=PROJECTS_UPLOADPATH.$document;
move_uploaded_file($_FILES['document']['tmp_name'], $target);
// echo "upload_successful";
//echo $target;//exit;
$query="update menu_add_records2 set document_location='$target'
where id='$maxid' ";
mysqli_query($connection, $query) or die ("Error updating Database $query");
//echo "update successful";



header("location: menu_add_records2.php?add_your_own=y&message=update_successful");


?>