<?php
$database="inspect";
include("../../include/iConnect.inc"); // database connection parameters

mysqli_select_db($connection,$database);

// ********** Set Variables *********
extract($_POST);
//	echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
//	echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
if($submit=="Add")
	{
	session_start();
	date_default_timezone_set('America/New_York');
	$month=str_pad($month,2, "0", STR_PAD_LEFT);
	$day=str_pad($day,2, "0", STR_PAD_LEFT);
	$di=$year."-".$month."-".$day;
	$test_date=date("Y-m-d"); //echo "$di $test_date";
	//exit;
	if($di>$test_date)
		{
		echo "You cannot enter an inspection for a date $di greater than today $test_date !<br /><br />Click your browser's back button.";exit;
		}
	$tag=$_SESSION['inspect']['tempID']."_".date('Ymdhis');
	$sql="INSERT INTO document set parkcode='$parkcode', date_inspect='$di', id_inspect='$subunit',tag='$tag'"; //echo "$sql";exit;
	
	$result = @mysqli_query($connection,$sql) or die("no go $sql");
	if(!empty($v_pr63)){$var="&v_pr63=$v_pr63&date_occur=$date_occur&pr_id=$pr_id";}else{$var="";}
	header("Location: park_entry.php?parkcode=$parkcode&subunit=$subunit$var"); exit;
	}


?>