<?php

session_start();
$level=$_SESSION['hr']['level'];
if($level<1){echo "You do not have access to this database. <a href='/hr/'>login</a>";exit;}

$database="hr";
include("../../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);

$center_code=$_POST['center_code'];
foreach($_POST['comments'] as $k=>$v){

		$comments=addslashes($v);
		$bh=$_POST['budget_hrs'][$k];
		
	$sql="UPDATE seasonal_payroll_next set budget_hrs='$bh',comments='$comments'
	where beacon_posnum='$k'";
//	echo "$sql";exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	
		}
		header("Location: /hr/bSeasonal/park_seasonals_find_next.php?file=Find Position");
?>