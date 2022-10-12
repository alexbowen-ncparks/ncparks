<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "hello world";
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;

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
$db="budget_$today_date";
$ta="infotrack_projects_community_com";
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

$query1=" CREATE TABLE `$db`.`$ta$ct` 
(  `comment_id` int( 10  )  unsigned NOT  NULL  auto_increment ,
 `project_note_id` int( 10  )  NOT  NULL ,
 `project_note` varchar( 100  )  NOT  NULL ,
 `park` varchar( 4  )  NOT  NULL ,
 `user` varchar( 30  )  NOT  NULL ,
 `system_entry_date` date NOT  NULL default  '0000-00-00',
 `comment_note` text NOT  NULL ,
 `status` varchar( 2  )  NOT  NULL ,
 `show2park` char( 1  )  NOT  NULL default  'y',
 `show2dpr` char( 1  )  NOT  NULL default  'n',
 `alert` char( 1  )  NOT  NULL default  'n',
 `weblink` varchar( 150  )  NOT  NULL ,
 `original_entry_date` date NOT  NULL ,
 `days_elapsed` int( 11  )  NOT  NULL ,
 `message_read` char( 1  )  NOT  NULL default  'n',
 `message_reader` varchar( 100  )  NOT  NULL ,
 `message_read_date` date NOT  NULL ,
 `keyword` char( 1  )  NOT  NULL default  'n',
 PRIMARY  KEY (  `comment_id`  )  ) ENGINE  =  MyISAM  DEFAULT CHARSET  = latin1;
";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result1 = mysql_query($query1) or die ("Couldn't execute query 1.  $query1");


$query2=" INSERT INTO `$db`.`$ta$ct`
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