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
echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);
//echo "start_date=$start_date";
//echo "<br />";
echo "end_date=$end_date";exit;


$query1="update project_steps_detail set
         fiscal_year='$fiscal_year',
         start_date='$start_date',
         end_date='$end_date',
         project_category='$project_category',
         project_name='$project_name',
         step_group='$step_group',
         step='$step',
         step_num='$step_num',
         step_name='$step_name',
         link='$link',
         weblink='$weblink',
         status='$status' 
		 where cid='$cid' ";
		 
 $result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");        
		 
		 
header("location:project_steps_detail.php?project_name=$project_name");

?>















