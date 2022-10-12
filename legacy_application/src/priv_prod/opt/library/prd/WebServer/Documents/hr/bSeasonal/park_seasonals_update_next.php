<?php
session_start();
$level=$_SESSION['hr']['level'];
if($level<1){echo "You do not have access to this database.";exit;}

//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

$database="hr";
include("../../../include/iConnect.inc"); // database connection parameters
//extract($_REQUEST);
mysqli_select_db($connection,$database);

$center_code=$_POST['center_code'];
@$datebegin=$_POST['datebegin'];
//echo "<pre>";
//print_r($_POST);
//print_r($_REQUEST);
//echo "<pre>";print_r($_POST);echo "</pre>";
//echo "</pre>";  exit;

//$datebegin=$_POST['datebegin'];

foreach($_POST['position'] as $k=>$beacon_posnum)
	{
	$sql="UPDATE seasonal_payroll_next set park_approve='y' WHERE beacon_posnum='$beacon_posnum'";
	//echo "$sql";exit;
	$result = mysqli_query($connection,$sql);
	}
	
header("Location: /hr/bSeasonal/park_seasonals_next.php?center_code=$center_code");
?>