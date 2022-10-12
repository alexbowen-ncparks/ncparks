<?php

session_start();

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
include("../../../../include/connectBUDGET.inc");// database connection parameters

////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");


$query1="insert into project_substeps_detail(fiscal_year,start_date,end_date,project_category,project_name,
         step_group,step,step_num,step_name,substep_num,substep_name,link,weblink,status) 
values ('$fiscal_year','$start_date','$end_date','$project_category','$project_name',
        '$step_group','$step','$step_num','$step_name','$substep_num','$substep_name','$link','$weblink','$status')";

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


////mysql_close();
header("location:main.php?project_category=$project_category&project_name=$project_name&step_group='$step_group'");


 ?>



 