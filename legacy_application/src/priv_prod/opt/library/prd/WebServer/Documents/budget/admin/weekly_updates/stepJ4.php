<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//$start_date=str_replace("-","",$start_date);
//$end_date=str_replace("-","",$end_date);
//$today_date=date("Ymd");
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date";//exit;
//echo "<br />"; 
//echo "today_date=$today_date";exit;


/*
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
*/


//$start_date=str_replace("-","",$start_date);
//$end_date=str_replace("-","",$end_date);
//$today_date=date("Ymd");




$query1="CREATE TABLE `count_center` (
`center` VARCHAR( 15 ) NOT NULL ,
`count_center` DECIMAL( 12, 2 ) NOT NULL ,
`id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `id` )
)";
mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

$query2="CREATE TABLE `count_center2` (
`center` VARCHAR( 15 ) NOT NULL ,
`count_center` DECIMAL( 12, 2 ) NOT NULL ,
`id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `id` )
)";
mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");

$query3="CREATE TABLE `count_center3` (
`projnum` VARCHAR( 15 ) NOT NULL ,
`center` VARCHAR( 15 ) NOT NULL ,
`count_center` DECIMAL( 12, 2 ) NOT NULL ,
`id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `id` )
)";
mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");



/*

$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

$query24="select * from budget.project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result24=mysqli_query($connection, $query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysqli_num_rows($result24);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num24==0)

{$query25="update budget.project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");}
////mysql_close();

if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}

*/


?>