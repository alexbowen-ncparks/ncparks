<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
//$project_category=$_REQUEST['project_category'];
//$project_name=$_REQUEST['project_name'];
//echo $project_category;
//echo $project_name;
//$table1="weekly_updates";
//$table2="project_notes2";

////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query30="update budget.project_steps_detail set status='complete' 
          where project_category='$project_category' and project_name='$project_name'
		  and step_group='$step_group' and step_num='$step_num' ";
		  
		  
mysqli_query($connection, $query30) or die ("Couldn't execute query 30.  $query30");


$query31="select * from project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result31=mysqli_query($connection, $query31) or die ("Couldn't execute query 31.  $query31");

$num31=mysqli_num_rows($result31);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num31==0)

{$query32="update project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysqli_query($connection, $query32) or die ("Couldn't execute query 32.  $query32");}
////mysql_close();

if($num31==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num31!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&step=$step&fiscal_year=$fiscal_year&start_date=$start_date
	  &end_date=$end_date");}

?>

























