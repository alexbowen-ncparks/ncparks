<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

foreach($parkcode as $key=>$value){
$query1="update pcard_users SET parkcode='$value' where card_number='$key'";
$result1=mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");
}

foreach($center as $key=>$value){
$query2="update pcard_users SET center='$value' where card_number='$key'";
$result2=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");
}

foreach($last_name as $key=>$value){
$query3="update pcard_users SET last_name='$value' where card_number='$key'";
$result3=mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");
}

foreach($first_name as $key=>$value){
$query4="update pcard_users SET first_name='$value' where card_number='$key'";
$result4=mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");
}


$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");


{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}

 
 ?>




















