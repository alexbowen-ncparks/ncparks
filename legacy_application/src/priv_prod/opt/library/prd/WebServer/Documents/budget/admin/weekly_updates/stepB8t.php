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
$ta="pcard_users";
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

//echo "create table $db.$ta$ct";
//exit;



$query1=" CREATE TABLE `$db`.`$ta$ct` 
(  `dncr` char( 1  )  NOT  NULL default  'n',
 `employee` varchar( 75  )  NOT  NULL ,
 `cardholder_xtnd` varchar( 150  )  NOT  NULL ,
 `last_name` varchar( 30  )  NOT  NULL default  '',
 `first_name` varchar( 30  )  NOT  NULL default  '',
 `middle_initial` varchar( 10  )  NOT  NULL ,
 `suffix` varchar( 10  )  NOT  NULL ,
 `position_number` varchar( 20  )  NOT  NULL ,
 `affirmation_abundance` text NOT  NULL ,
 `photo_location` varchar( 150  )  NOT  NULL ,
 `photo_comment` varchar( 100  )  NOT  NULL ,
 `employee_number` varchar( 30  )  NOT  NULL ,
 `job_title` varchar( 75  )  NOT  NULL ,
 `employee_tempid` varchar( 50  )  NOT  NULL ,
 `phone_number` varchar( 50  )  NOT  NULL ,
 `act_id` varchar( 5  )  NOT  NULL default  '',
 `parkcode` varchar( 10  )  NOT  NULL default  '',
 `location` varchar( 10  )  NOT  NULL default  '',
 `admin` varchar( 10  )  NOT  NULL default  '',
 `card_number` varchar( 30  )  NOT  NULL default  '',
 `dup_record` char( 1  )  NOT  NULL default  'n',
 `last_four` varchar( 4  )  NOT  NULL default  '',
 `monthly_limit` decimal( 12, 2  )  NOT  NULL ,
 `last_update` varchar( 15  )  NOT  NULL default  '',
 `date_added` date NOT  NULL ,
 `count` decimal( 10, 0  )  NOT  NULL default  '0',
 `pcard_numname` varchar( 30  )  NOT  NULL default  '',
 `center` varchar( 15  )  NOT  NULL default  '',
 `park_active` char( 1  )  NOT  NULL default  '',
 `active_eva` char( 1  )  NOT  NULL default  '',
 `bank` varchar( 10  )  NOT  NULL default  '',
 `status` varchar( 20  )  NOT  NULL default  '',
 `act_id_030707` varchar( 5  )  NOT  NULL default  '',
 `last5` varchar( 10  )  NOT  NULL default  '',
 `comments` varchar( 75  )  NOT  NULL default  '',
 `justification` text NOT  NULL ,
 `justification_manager` text NOT  NULL ,
 `employee_approval_type` varchar( 50  )  NOT  NULL ,
 `transactions` decimal( 12, 2  )  NOT  NULL default  '0.00',
 `total_amount` decimal( 12, 2  )  NOT  NULL default  '0.00',
 `pcard_usage` char( 1  )  NOT  NULL default  'n',
 `view` char( 3  )  NOT  NULL default  'all',
 `document_location` varchar( 75  )  NOT  NULL default  '',
 `document_location_final` varchar( 75  )  NOT  NULL ,
 `sed` date NOT  NULL ,
 `entered_by` varchar( 75  )  NOT  NULL ,
 `cashier` varchar( 30  )  NOT  NULL ,
 `cashier_date` date NOT  NULL ,
 `pcard_holder` varchar( 30  )  NOT  NULL ,
 `pcard_holder_date` date NOT  NULL ,
 `manager` varchar( 30  )  NOT  NULL ,
 `manager_date` date NOT  NULL ,
 `disu` varchar( 40  )  NOT  NULL ,
 `disu_date` date NOT  NULL ,
 `fs_approver` varchar( 30  )  NOT  NULL ,
 `fs_approver2` varchar( 30  )  NOT  NULL ,
 `fs_approver_date` date NOT  NULL ,
 `fs_approver_date2` date NOT  NULL ,
 `quiz_id` int( 10  )  NOT  NULL ,
 `student_id` varchar( 30  )  NOT  NULL ,
 `student_test_date` date NOT  NULL ,
 `student_score` decimal( 12, 2  )  NOT  NULL ,
 `dup_id` varchar( 10  )  NOT  NULL ,
 `dup_yn` char( 1  )  NOT  NULL default  'n',
 `id` int( 10  )  unsigned NOT  NULL  auto_increment ,
 PRIMARY  KEY (  `id`  ) ,
 UNIQUE  KEY  `card_number` (  `card_number` ,  `admin` ,  `location` ,  `employee_tempid` ,  `dup_yn`  )  ) ENGINE  =  MyISAM  DEFAULT CHARSET  = latin1;


";


// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


$query2=" INSERT INTO `$db`.`$ta$ct`
SELECT *
FROM `budget`.`$ta` ;";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");



$query4="update budget.project_steps_detail set status='complete' 
          where project_category='$project_category' and project_name='$project_name'
		  and step_group='$step_group' and step_num='$step_num' ";
		  
		  
mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");


$query5="select * from project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result5=mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");

$num5=mysqli_num_rows($result5);

if($num5==0)

{$query32="update project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysqli_query($connection, $query32) or die ("Couldn't execute query 32.  $query32");}


if($num5==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num5!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}


?>