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
$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date";//exit;
//echo "<br />";
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";//exit;

$today_date=date("Ymd");
//echo "<br />today_date=$today_date"; exit;
$query1="CREATE TABLE `budget`.`budget_center_allocations_$today_date`  
(  `center` varchar( 8  )  NOT  NULL default  '',
 `new_center` varchar( 15  )  NOT  NULL ,
 `old_center` varchar( 15  )  NOT  NULL ,
 `ncas_acct` varchar( 10  )  NOT  NULL default  '',
 `fy_req` varchar( 4  )  NOT  NULL default  '',
 `equipment_request` char( 1  )  NOT  NULL default  '',
 `user_id` varchar( 20  )  NOT  NULL default  '',
 `allocation_level` varchar( 30  )  NOT  NULL default  '',
 `allocation_amount` decimal( 12, 2  )  NOT  NULL default  '0.00',
 `allocation_justification` varchar( 50  )  NOT  NULL default  '',
 `allocation_date` date NOT  NULL default  '0000-00-00',
 `budget_group` varchar( 30  )  NOT  NULL default  '',
 `entrydate` date NOT  NULL default  '0000-00-00',
 `comments` varchar( 175  )  NOT  NULL default  '',
 `id` int( 10  )  unsigned NOT  NULL  auto_increment ,
 PRIMARY  KEY (  `id`  ) ,
 KEY  `center` (  `center`  ) ,
 KEY  `fy_req` (  `fy_req`  )  ) ENGINE  =  MyISAM  DEFAULT CHARSET  = latin1;
";
//echo "<br />$query1";//exit;
mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

$query2="INSERT INTO `budget`.`budget_center_allocations_$today_date`
SELECT *
FROM `budget`.`budget_center_allocations` ;
";
//echo "<br />$query2";//exit;
mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");



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




?>

























