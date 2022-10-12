<?php

session_start();

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");

////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");


$query1="
insert into scoring_rules
set gid='$gid',
f_year='$fiscal_year',
score_month='$score_month',
score_value='$score_value',
completion_date_begin='$completion_date_begin',
completion_date_end='$completion_date_end'; ";

//echo "query1=$query1";exit;

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


////mysql_close();
header("location: stepB2a.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&step=$step&step_name=$step_name&gid=$gid&score_month2=$score_month&message=y");


 ?>



 