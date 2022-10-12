<?php
date_default_timezone_set('America/New_York');
$database="le";
include("../../include/get_parkcodes_reg.php");  // includes iConnect.inc

$database="le";
$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");

$entered_by=$_SESSION[$database]['tempID'];
$level=$_SESSION[$database]['level'];
if($level<2){exit;}
$approval_level="le_approve";
$approval_value="x";

if($level==2)
	{
	$approval_level="dist_approve";
	$approval_value=date("Y-m-d");
	}

foreach($_POST['approve_id'] as $k=>$v)
	{
	$sql="UPDATE pr63
	SET $approval_level='$approval_value', entered_by='$entered_by'
	where id='$k'
	";
// 	echo "$sql";  exit;
	$result = @mysqli_QUERY($connection,$sql); 
	}
?>