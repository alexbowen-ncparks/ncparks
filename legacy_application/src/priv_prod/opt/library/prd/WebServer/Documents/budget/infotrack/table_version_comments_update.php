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
//$deposit_amount=str_replace(",","",$deposit_amount);
//$deposit_amount=str_replace("$","",$deposit_amount);

//echo "Currently Under Construction-TBASS<br />";//exit;
//$center=str_replace("-","",$center);

//echo "bo_receipt_date";exit;

//echo "tempid=$tempid";

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;


$source_table="table_version_comments";

$park=substr($park,0,4);


if($park==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
//if($center==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($table_name==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($version==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($comment_note==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}


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

$query1="insert into table_version_comments
set park='$park',table_name='$table_name',version='$version',comment_note='$comment_note',entered_by='$entered_by',sed='$system_entry_date',f_year='$f_year'
";

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


$query2="update table_version_comments,center
         set table_version_comments.center=center.center
		 where table_version_comments.park=center.parkcode; ";

mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

/*
$query3="select max(id) as 'maxid'
         from menu_add_records1 where 1 ; ";

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
		  
$row3=mysqli_fetch_array($result3);

extract($row3);
*/


header("location: table_version_comments.php?add_your_own=y&message=update_successful");


?>