<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
//$start_date=str_replace("-","",$start_date);
//$end_date=str_replace("-","",$end_date);
$today_date=date("Ymd");
$yesterday=(date("Ymd")-1);
$yesterday2=substr($yesterday,2,6);

//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date";//exit;
//echo "<br />"; 
//echo "today_date=$today_date";
//echo "<br />";
//echo "yesterday=$yesterday";
//echo "<br />";
//echo "yesterday2=$yesterday2";//exit;
//echo "<br />";

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

$query1="drop table pcard_unreconciled_xtnd_$yesterday2";
echo "query1=$query1";
echo"<H2 ALIGN=left><font size=4 color=red>Are you sure you want to $query1 ???</font></H2>";
echo "<H2 ALIGN=left><font size=4><b><A href=/budget/admin/pcard_updates/stepL3e_update.php?yesterday2=$yesterday2&project_category=$project_category&project_name=$project_name&step_group=$step_group&step_num=$step_num&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date> YES.</A></font></H2>";




 ?>




















