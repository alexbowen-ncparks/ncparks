<?php

session_start();

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");

////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");


$query1="insert into project_substeps_detail(fiscal_year,start_date,end_date,project_category,project_name,
         step_group,step,step_num,step_name,substep_num,substep_name,link,weblink,status) 
values ('$fiscal_year','$start_date','$end_date','$project_category','$project_name',
        '$step_group','$step','$step_num','$step_name','$substep_num','$substep_name',
		'$link','$weblink','$status')";

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


////mysql_close();
header("location:project_substeps_detail.php?project_name=$project_name");


 ?>



 