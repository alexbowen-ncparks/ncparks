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

$query="delete from project_steps_detail 
where cid='$cid' ";

mysqli_query($connection, $query) or die ('Error updating Database');
//echo "Update Successful-$cid-$step_group-$step was deleted";

//echo "</br> </br>";

//echo"<A href=main.php?project_category=$project_category&project_name=$project_name
//  &fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date>Return HOME </A>";


header("location:main.php?project_category=$project_category&project_name=$project_name&step_group=$step_group ");

?>
