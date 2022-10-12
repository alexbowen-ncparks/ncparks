<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
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
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
$query1="update fixed_assets_unreconciled SET";
for($j=0;$j<$num5;$j++){
$query2=$query1;
	$query2.=" perm_an='$perm_an[$j]',";
	$query2.=" comments='$comments[$j]'";
	$query2.=" where id='$id[$j]'";
		

$result=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");
}	


{header("location: report_view.php?report_date=$report_date&message=1");}

 
 ?>




















