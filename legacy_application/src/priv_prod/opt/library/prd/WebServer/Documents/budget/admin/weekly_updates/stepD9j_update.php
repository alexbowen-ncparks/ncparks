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
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

$query1="update xtnd_ci_monthly_manual set balance='$balance',status='complete' where fund='$fund' ";

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


header("location: stepD9j.php?project_name=$project_name&step_group=$step_group&step_num=$step_num&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date ");

 
 
 ?>




















