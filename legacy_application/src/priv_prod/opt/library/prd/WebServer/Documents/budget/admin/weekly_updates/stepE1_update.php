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

$query1="update beacon_paydates set paydate='$paydate',status='complete' where 1 ";

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
//echo "ok";

$query2="update project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";

mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

//echo "ok";


$query3="select * from project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result3=mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$num3=mysqli_num_rows($result3);

//echo $num3;


if($num3==0)

{$query4="update project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");}

if($num3==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name
        &fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date ");}

if($num3 !=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name
      &step_group=$step_group&step_name=$step_name&fiscal_year=$fiscal_year&start_date=$start_date
	  &end_date=$end_date");}

 ?>




















