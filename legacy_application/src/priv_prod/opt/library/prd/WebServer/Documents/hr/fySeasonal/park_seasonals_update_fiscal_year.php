<?php
session_start();
$level=$_SESSION['hr']['level'];

$fiscal_year=$_SESSION['hr']['fiscal_year'];
if($level<1){echo "You do not have access to this database. <a href='http://www.dpr.ncparks.gov/hr/'>login</a>";exit;}

if(empty($fiscal_year)){echo "No Fiscal Year specified.";exit;}

//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

$database="hr";
include("../../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);

$center_code=$_POST['center_code'];
@$datebegin=$_POST['datebegin'];

// echo "<pre>"; print_r($_POST); echo "</pre>";  exit;

foreach($_POST['position'] as $k=>$beacon_posnum)
	{
	$sql="UPDATE seasonal_payroll_fiscal_year set div_app='y', park_approve='y'
	WHERE beacon_posnum='$beacon_posnum' and fiscal_year='$fiscal_year'";
// 	echo "$sql";exit;
	$result = mysqli_query($connection,$sql);
	}
	
header("Location: /hr/fySeasonal/park_seasonals_fiscal_year.php?center_code=$center_code");
?>