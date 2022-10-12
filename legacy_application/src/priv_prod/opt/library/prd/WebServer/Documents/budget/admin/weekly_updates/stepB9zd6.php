<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}
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
$ta="vmc_posted7_v2";
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
(  `park` varchar( 4  )  NOT  NULL ,
 `center` varchar( 15  )  NOT  NULL ,
 `player` varchar( 50  )  NOT  NULL ,
 `f_year` varchar( 4  )  NOT  NULL ,
 `month` varchar( 2  )  NOT  NULL ,
 `invoice` varchar( 100  )  NOT  NULL ,
 `description` varchar( 100  )  NOT  NULL ,
 `acct` varchar( 15  )  NOT  NULL ,
 `day` varchar( 2  )  NOT  NULL ,
 `acctdate` varchar( 20  )  NOT  NULL ,
 `amount` decimal( 12, 2  )  NOT  NULL ,
 `cvip_id` varchar( 30  )  NOT  NULL ,
 `cvip_id4` varchar( 30  )  NOT  NULL ,
 `pcu_transid` varchar( 15  )  NOT  NULL ,
 `cvip_comments` text NOT  NULL ,
 `pcu_item_purchased` text NOT  NULL ,
 `license_tag` varchar( 15  )  NOT  NULL ,
 `tagmenu_yn` char( 1  )  NOT  NULL default  'y',
 `license_tag_manual` varchar( 15  )  NOT  NULL ,
 `vmc_comments` text NOT  NULL ,
 `parent_record` char( 1  )  NOT  NULL default  'n',
 `parent_id` varchar( 10  )  NOT  NULL ,
 `record_complete` char( 1  )  NOT  NULL default  'n',
 `none_justify` text NOT  NULL ,
 `id` int( 10  )  unsigned NOT  NULL  auto_increment ,
 PRIMARY  KEY (  `id`  ) ,
 KEY  `center` (  `center`  ) ,
 KEY  `acct` (  `acct`  ) ,
 KEY  `acctdate` (  `acctdate`  ) ,
 KEY  `invoice` (  `invoice`  ) ,
 KEY  `description` (  `description`  ) ,
 KEY  `amount` (  `amount`  )  ) ENGINE  =  MyISAM  DEFAULT CHARSET  = latin1;
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

{$query32="update project_steps set status='complete',time_complete=unix_timestamp(now()) where project_category='$project_category' and project_name='$project_name' and step_group='$step_group' ";
		 
mysqli_query($connection, $query32) or die ("Couldn't execute query 32.  $query32");

}


if($num5==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num5!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}


?>