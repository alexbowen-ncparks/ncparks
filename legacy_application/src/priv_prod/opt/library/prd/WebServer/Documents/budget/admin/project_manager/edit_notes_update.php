<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
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
include("../../../../include/activity.php");

//echo "submit1=$submit1";echo "submit2=$submit2";exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
$query1="update project_steps SET";
for($j=0;$j<$num3;$j++){
$query2=$query1;
	$query2.=" fiscal_year='$fiscal_year[$j]',";
	$query2.=" start_date='$start_date[$j]',";
	$query2.=" end_date='$end_date[$j]',";
	$query2.=" project_category='$project_category[$j]',";
	$query2.=" project_name='$project_name[$j]',";
	$query2.=" step_group='$step_group[$j]',";
	$query2.=" step='$step[$j]',";
	$query2.=" link='$link[$j]',";
	$query2.=" weblink='$weblink[$j]',";
	$query2.=" status='$status[$j]'";	
	$query2.=" where cid='$cid[$j]'";
		

$result=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");
}	
//echo "project_name=$project_name";exit
////mysql_close();
header("location:main.php?project_name=$project_name2");

?>















