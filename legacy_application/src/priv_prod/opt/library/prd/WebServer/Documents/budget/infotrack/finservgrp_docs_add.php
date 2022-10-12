<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
}


$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];

extract($_REQUEST);


//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
echo "<pre>";print_r($_REQUEST);"</pre>";  //exit;

$database="budget";
$db="budget";
//include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
//mysqli_select_db($connection, $database); // database
mysqli_select_db($connection,$database); // database
//include("../../../include/activity.php");// database connection parameters
//include("../../../include/activity_new.php");// database connection parameters
//include("../budget/~f_year.php");
//include("../../budget/~f_year.php");

if($report_nameF==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form(Document Name)<br />Click Browser back button to return to FORM<br />";  exit;}

//echo "Line 34"; exit;

//exit;

define('PROJECTS_UPLOADPATH','documents/');
$document=$_FILES['document']['name'];
if($document==""){echo "<font color='red' size='5'><b>No Document Found. <br /><br />Please hit back button on Browser to Upload Document</b></font>";
//echo "$form_return";
exit;}

echo "<br />Line 44<br />";
//exit;


$entered_by=substr($tempid,0,-2);
$sed=date("Ymd");


//exit;



if($edit=='')
{
$query1="insert into `budget`.`position_report` set report_name='$report_nameF',sed='$sed',document_yn='y',fs_group='y',mc_module='$mc_module',fs_user='$entered_by',fs_user_date='$sed' ";
echo "<br />Line 63: query1=$query1<br />"; //exit;
$result1=mysqli_query($connection,$query1) or die ("Couldn't execute query 1. $query1");

$query2="SELECT max(report_id) as 'maxid' from `budget`.`position_report` where 1 ";
$result2=mysqli_query($connection,$query2) or die ("Couldn't execute query 2. $query2");
$row2=mysqli_fetch_array($result2);
extract($row2);
echo "<br />maxid=$maxid<br />";
}


if($edit=='y' and $report_id != '')
{
$query1="update `budget`.`position_report`  set report_name='$report_nameF',sed='$sed',document_yn='y',fs_group='y',mc_module='$mc_module',fs_user='$entered_by',fs_user_date='$sed' where report_id='$report_id' ";
echo "<br />Line 77: query1=$query1<br />"; //exit;
$result1=mysqli_query($connection,$query1) or die ("Couldn't execute query 1. $query1");
$maxid=$report_id;
echo "<br />maxid=$maxid<br />";
}


echo "<br />Line 84";
//exit;






define('PROJECTS_UPLOADPATH','documents/');
$source_table="position_report";
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

$target2="/budget/infotrack/".$target ;
$query3="update `budget`.`position_report` set report_location='$target2' where report_id='$maxid' ";

$result3=mysqli_query($connection,$query3) or die ("Couldn't execute query 3. $query3");

//header("location: service_contracts1.php?id=$maxid");
header("location: finservgrp_docs.php?mc_module=$mc_module");


?>