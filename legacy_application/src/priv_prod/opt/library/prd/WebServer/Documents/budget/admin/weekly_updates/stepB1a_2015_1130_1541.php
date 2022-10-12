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
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
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
//$db="budget_$today_date";
$db="$today_date";
$ta="crs_tdrr_division_deposits";
$ct=date("His");
//echo $ct;exit;
//echo "database=$db";echo "<br />";
//echo "table=$ta";echo "<br />";
//echo "current time=$ct";echo "<br />";
//echo "create table $db.$ta_$ct";
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

//mysql_connect($host,$username,$password);
//@mysql_select_db($database) or die( "Unable to select database");

$query1=" CREATE TABLE `$db$ta$ct` 

(  `id` int( 10  )  unsigned NOT  NULL  auto_increment ,
 `dncr` char( 1  )  NOT  NULL default  'y',
 `park` varchar( 4  )  NOT  NULL ,
 `center` varchar( 15  )  NOT  NULL ,
 `new_center` varchar( 15  )  NOT  NULL ,
 `old_center` varchar( 15  )  NOT  NULL ,
 `orms_deposit_id` varchar( 15  )  NOT  NULL ,
 `orms_start_date` date NOT  NULL ,
 `orms_end_date` date NOT  NULL ,
 `orms_deposit_date` date NOT  NULL ,
 `orms_deposit_amount` decimal( 12, 2  )  NOT  NULL ,
 `orms_deposit_amount2` decimal( 12, 2  )  NOT  NULL ,
 `download_date` date NOT  NULL ,
 `bank_deposit_date` date NOT  NULL ,
 `controllers_deposit_id` varchar( 15  )  NOT  NULL ,
 `controllers_deposit_amount` decimal( 12, 2  )  NOT  NULL ,
 `trans_table` char( 1  )  NOT  NULL default  'n',
 `days_elapsed` int( 10  )  NOT  NULL ,
 `checks` char( 1  )  NOT  NULL default  'n',
 `document_location` varchar( 150  )  NOT  NULL ,
 `document_location2` varchar( 150  )  NOT  NULL ,
 `cashier` varchar( 50  )  NOT  NULL ,
 `cashier_overshort_comment` text NOT  NULL ,
 `cashier_date` date NOT  NULL ,
 `manager` varchar( 50  )  NOT  NULL ,
 `manager_overshort_comment` text NOT  NULL ,
 `manager_date` date NOT  NULL ,
 `orms_depositor` varchar( 50  )  NOT  NULL ,
 `f_year` varchar( 4  )  NOT  NULL ,
 `document_location_old` varchar( 150  )  NOT  NULL ,
 `fs_approver` varchar( 50  )  NOT  NULL ,
 `fs_approver_overshort_comment` text NOT  NULL ,
 `fs_approver_date` date NOT  NULL ,
 `accountant_comment_name` varchar( 30  )  NOT  NULL ,
 `accountant_comment` text NOT  NULL ,
 `accountant_comment_date` date NOT  NULL ,
 `version3` char( 1  )  NOT  NULL default  'y',
 `version3_active` char( 1  )  NOT  NULL default  'y',
 `record_complete` char( 1  )  NOT  NULL default  'n',
 `manual_adjustments` char( 1  )  NOT  NULL default  'n',
 `comments` text NOT  NULL ,
 `park_complete` char( 1  )  NOT  NULL default  'n',
 `orms_depositor_lname` varchar( 50  )  NOT  NULL ,
 `days_unapproved_park` varchar( 10  )  NOT  NULL ,
 `crj_days_elapsed` varchar( 5  )  NOT  NULL ,
 `crj_elapsed_override` char( 1  )  NOT  NULL default  'n',
 `crj_elapsed_override_comments` text NOT  NULL ,
 `crj_compliance` char( 1  )  NOT  NULL default  'y',
 `crj_pasu_comment` text NOT  NULL ,
 `crj_pasu_player` varchar( 50  )  NOT  NULL ,
 `crj_pasu_comment_date` date NOT  NULL ,
 `crj_disu_comment` text NOT  NULL ,
 `crj_disu_player` varchar( 50  )  NOT  NULL ,
 `crj_disu_comment_date` date NOT  NULL ,
 `crj_buof_comment` text NOT  NULL ,
 `crj_buof_player` varchar( 50  )  NOT  NULL ,
 `crj_buof_comment_date` date NOT  NULL ,
 `post2ncas` char( 1  )  NOT  NULL default  'n',
 `post_date` date NOT  NULL ,
 `manual_yn` char( 1  )  NOT  NULL default  'n',
 `manual_count` int( 11  )  NOT  NULL ,
 `manual_amount` decimal( 12, 2  )  NOT  NULL ,
 PRIMARY  KEY (  `id`  ) ,
 UNIQUE  KEY  `orms_deposit_id` (  `orms_deposit_id`  )  ) ENGINE  =  MyISAM  DEFAULT CHARSET  = latin1;





";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result1 = mysql_query($query1) or die ("Couldn't execute query 1.  $query1");


$query2=" INSERT INTO `$db$ta$ct`
SELECT *
FROM `budget`.`$ta` ;";

$result2 = mysql_query($query2) or die ("Couldn't execute query 2.  $query2");




$query4="update budget.project_steps_detail set status='complete' 
          where project_category='$project_category' and project_name='$project_name'
		  and step_group='$step_group' and step_num='$step_num' ";
		  
		  
mysql_query($query4) or die ("Couldn't execute query 4.  $query4");


$query5="select * from project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result5=mysql_query($query5) or die ("Couldn't execute query 5.  $query5");

$num5=mysql_num_rows($result5);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;

if($num5==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num5!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}


?>