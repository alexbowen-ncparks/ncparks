<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

$query1="CREATE TABLE `budget`.`beacon_payments_ws` (
`location_id` varchar( 30  )  NOT  NULL default  '',
 `location_name` varchar( 75  )  NOT  NULL default  '',
 `employee_id` varchar( 20  )  NOT  NULL default  '',
 `employee_name` varchar( 75  )  NOT  NULL default  '',
 `account` varchar( 15  )  NOT  NULL default  '',
 `account_name` varchar( 75  )  NOT  NULL default  '',
 `amount` decimal( 12, 2  )  NOT  NULL default  '0.00',
 `org_unit` varchar( 30  )  NOT  NULL default  '',
 `payment_date` date NOT  NULL default  '0000-00-00',
 `f_year` varchar( 4  )  NOT  NULL default  '',
 `month` char( 2  )  NOT  NULL ,
 `calyear` varchar( 15  )  NOT  NULL ,
 `center` varchar( 30  )  NOT  NULL default  '',
 `source` varchar( 30  )  NOT  NULL default  '',
 `temp_payroll_valid` char( 1  )  NOT  NULL default  'n',
 `location_id_last4` varchar( 10  )  NOT  NULL default  '',
 `dpr_employee` char( 1  )  NOT  NULL default  '',
 `employee_number_center` varchar( 70  )  NOT  NULL default  '',
 `valid_entry` char( 1  )  NOT  NULL default  '',
 `position_number` varchar( 50  )  NOT  NULL default  '',
 `center_code` varchar( 4  )  NOT  NULL default  '',
 `posnum_center` varchar( 60  )  NOT  NULL default  '',
 `correcting_entry` char( 1  )  NOT  NULL default  'n',
 `adjustment_number` varchar( 10  )  NOT  NULL default  '',
 `adjustment_date` date NOT  NULL default  '0000-00-00',
 `adjustment_type` varchar( 30  )  NOT  NULL default  '',
 `hrdb` char( 1  )  NOT  NULL default  'n',
 `id` int( 10  )  unsigned NOT  NULL  auto_increment ,
 PRIMARY  KEY (  `id`  ) ,
 KEY  `employee_number_center` (  `employee_number_center`  ) ,
 KEY  `center` (  `center`  ) ,
 KEY  `posnum_center` (  `posnum_center`  ) ,
 KEY  `employee_id` (  `employee_id`  )  ) ENGINE  =  MyISAM;
";
		  
		  
mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$query2="INSERT INTO `budget`.`beacon_payments_ws`
SELECT *
FROM `budget`.`beacon_payments` ";
		  
		  
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


$query30="update budget.project_steps_detail set status='complete' 
          where project_category='$project_category' and project_name='$project_name'
		  and step_group='$step_group' and step_num='$step_num' ";
		  
		  
mysqli_query($connection, $query30) or die ("Couldn't execute query 30.  $query30");

$query31="select * from project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result31=mysqli_query($connection, $query31) or die ("Couldn't execute query 31.  $query31");

$num31=mysqli_num_rows($result31);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num31==0)

{$query32="update project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysqli_query($connection, $query32) or die ("Couldn't execute query 32.  $query32");}
////mysql_close();

if($num31==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num31!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name
      &step_group=$step_group&step_name=$step_name&fiscal_year=$fiscal_year&start_date=$start_date
	  &end_date=$end_date");}

 ?>




















