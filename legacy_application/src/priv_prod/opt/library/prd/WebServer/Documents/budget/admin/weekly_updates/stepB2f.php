<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "hello world";
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters


//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
//$fiscal_year=$_REQUEST['fiscal_year'];
//$project_category=$_REQUEST['project_category'];
//$project_name=$_REQUEST['project_name'];
$start_date=$_REQUEST['start_date'];
$end_date=$_REQUEST['end_date'];
//$step_group=$_REQUEST['step_group'];
//echo "fiscal_year=$fiscal_year";
//echo "project_category=$project_category";
//echo "project_name=$project_name";
//echo "start_date=$start_date";
//echo "end_date=$end_date";
//echo "step=$step";
//exit;
$start_date=str_replace("-","",$start_date);
$end_date=str_replace('-','',$end_date);
$today_date=date("Ymd");
$db="budget_$today_date";
$ta="equipment_request_3";
$ct=date("His");

//echo "database=$db";echo "<br />";
//echo "table=$ta";echo "<br />";
//echo "current time=$ct";echo "<br />";
//echo "create table $db.$ta$ct";
//exit;
//echo "end_date=$end_date <br /><br />";
//$db_backup="budget$end_date";
//echo $db_backup;
//exit;
//echo "start_date=$start_date";
//echo "<br />";
//echo "end_date=$end_date";
//echo "<br />";
//echo "today_date=$today_date";
//echo "<br />";
//echo "backup table=budget.exp_rev_$today_date";exit;
//echo "database=$database";exit;

//////mysql_connect($host,$username,$password);
//@mysql_select_db($database) or die( "Unable to select database");

$query1=" CREATE TABLE `$db`.`$ta$ct` 
(  `location` varchar( 15  )  NOT  NULL default  '',
 `equipment_description` text NOT  NULL ,
 `justification` text NOT  NULL ,
 `funding_source` varchar( 15  )  NOT  NULL default  '',
 `disu_ranking` varchar( 10  )  NOT  NULL default  '',
 `requested_amount` decimal( 12, 2  )  NOT  NULL default  '0.00',
 `district_approved` char( 1  )  NOT  NULL default  'u',
 `section_approved` char( 1  )  NOT  NULL default  '',
 `division_approved` char( 1  )  NOT  NULL default  'u',
 `original_approved` char( 1  )  NOT  NULL default  '',
 `purchaser` varchar( 50  )  NOT  NULL default  '',
 `date_approved` varchar( 50  )  NOT  NULL default  '',
 `ordered_amount` decimal( 12, 2  )  NOT  NULL default  '0.00',
 `pricing_source` varchar( 100  )  NOT  NULL default  '',
 `pay_center` varchar( 15  )  NOT  NULL default  '',
 `new_pay_center` varchar( 15  )  NOT  NULL ,
 `old_pay_center` varchar( 15  )  NOT  NULL ,
 `ncas_account` varchar( 15  )  NOT  NULL default  'na',
 `f_year` varchar( 10  )  NOT  NULL default  '',
 `er_num` int( 11  )  NOT  NULL default  '0',
 `status` varchar( 15  )  NOT  NULL default  'active',
 `order_complete` char( 1  )  NOT  NULL default  'n',
 `Paid_in_Full` char( 1  )  NOT  NULL default  'n',
 `disu_priority` varchar( 15  )  NOT  NULL default  '',
 `comments` varchar( 100  )  NOT  NULL default  '',
 `receive_complete` char( 1  )  NOT  NULL default  'n',
 `district` varchar( 20  )  NOT  NULL default  '',
 `center_code` varchar( 15  )  NOT  NULL default  '',
 `original_amount` decimal( 12, 2  )  NOT  NULL default  '0.00',
 `allocation_type` varchar( 30  )  NOT  NULL default  '',
 `system_entry_date` date NOT  NULL default  '0000-00-00',
 `pasu_priority` varchar( 15  )  NOT  NULL default  '',
 `user_id` varchar( 30  )  NOT  NULL default  '',
 `unit_quantity` int( 5  )  NOT  NULL default  '0',
 `category` varchar( 50  )  NOT  NULL default  '',
 `unit_cost` decimal( 12, 2  )  NOT  NULL default  '0.00',
 `po_number` varchar( 20  )  NOT  NULL default  '',
 `valid_acct` char( 1  )  NOT  NULL default  '',
 `valid_center` char( 1  )  NOT  NULL default  '',
 `equipment_type` varchar( 20  )  NOT  NULL default  '',
 `puof_approved` char( 1  )  NOT  NULL default  'u',
 `itma_approved` char( 1  )  NOT  NULL default  'u',
 `pasu_ranking` tinyint( 4  )  NOT  NULL default  '0',
 `payments_entered` decimal( 12, 2  )  NOT  NULL default  '0.00',
 `order_number` int( 10  )  NOT  NULL default  '0',
 `email_confirmation` varchar( 40  )  NOT  NULL default  '',
 `bo_comments` text NOT  NULL ,
 `id` int( 10  )  unsigned NOT  NULL  auto_increment ,
 PRIMARY  KEY (  `id`  ) ,
 UNIQUE  KEY  `er_num_2` (  `er_num`  ) ,
 KEY  `er_num` (  `er_num`  )  ) ENGINE  =  MyISAM  DEFAULT CHARSET  = latin1 PACK_KEYS  =1;



 ";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


$query2=" INSERT INTO `$db`.`$ta$ct`
SELECT *
FROM `budget`.`$ta` ;";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$query3="ALTER TABLE `$db`.`$ta$ct`
ADD INDEX ( `er_num` ); ";


$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
//echo "Query Successful";
//echo "<br />";


$query4="update budget.project_steps_detail set status='complete' 
          where project_category='$project_category' and project_name='$project_name'
		  and step_group='$step_group' and step_num='$step_num' ";
		  
		  
mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");


$query5="select * from project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result5=mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");

$num5=mysqli_num_rows($result5);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;

if($num5==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num5!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}


?>