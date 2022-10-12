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
$today_date=date("Ymd");
//echo "today_date=$today_date";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;



$query1="drop table $tabname";
echo "query1=$query1";

echo"<H2 ALIGN=left><font color=red>Are you sure you want to $query1 ???</font></H2>";
echo "<H2 ALIGN=left><font size=4><b><A href=/budget/admin/table_tools/table_delete_yes.php?tabname=$tabname> YES.</A></font></H2>";

//{header("location: stepA1.php");}




?>

























