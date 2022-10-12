<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
$system_entry_date=date("Ymd");

$query1="update crs_tdrr_division_deposits_checklist SET";
for($j=0;$j<$num14;$j++){
$query2=$query1;
//$checknum2=addslashes($checknum[$j]);
$checknum2=($checknum[$j]);
//if($checknum2==''){continue;}
//$payor2=addslashes($payor[$j]);
$payor2=($payor[$j]);
//$payor_bank2=addslashes($payor_bank[$j]);
$payor_bank2=($payor_bank[$j]);
//$description2=addslashes($description[$j]);
$description2=($description[$j]);
$amount2=$amount[$j];
$amount2=str_replace(",","",$amount2);
$amount2=str_replace("$","",$amount2);
	$query2.=" checknum='$checknum2',";
	$query2.=" payor='$payor2',";
	$query2.=" payor_bank='$payor_bank2',";
	$query2.=" amount='$amount2',";
	$query2.=" description='$description2',";
	$query2.=" system_entry_date='$system_entry_date'";
	$query2.=" where id='$checklist_id[$j]'";
		

$result=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");
}	
$query3="delete from crs_tdrr_division_deposits_checklist
         where checknum='' and payor='' and payor_bank='' and amount='0.00' ";
$result3=mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");


//echo "Update Successful<br />";

/*
if($project_note=='games')
{
header("location: /budget/games/multiple_choice/notes.php?comment=y&add_comment=y&project_note_id=$project_note_id&folder=community&category_selected=y&name_selected=y");
}
*/
//echo "project_note=$project_note";exit;



header("location: check_listing.php?id=$ctdd_id");

 
 ?>




















