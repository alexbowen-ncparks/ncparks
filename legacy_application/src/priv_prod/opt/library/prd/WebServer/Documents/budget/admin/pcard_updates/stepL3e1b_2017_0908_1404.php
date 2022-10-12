<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "hello world";
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;

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
$ta="pcard_unreconciled_xtnd_temp2_perm";
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

//echo "<br />db=$db<br />";
//echo "<br />ta=$ta<br />";
//echo "<br />ct=$ct<br />";   //exit;


$query1=" CREATE TABLE `$db$ta$ct` 
(  `complete` char( 1  )  NOT  NULL default  'n',
 `xtnd_report_date` date NOT  NULL ,
 `xtnd_rundate` varchar( 20  )  NOT  NULL ,
 `cardholder` varchar( 50  )  NOT  NULL ,
 `division` varchar( 20  )  NOT  NULL ,
 `pcard_users_match` char( 1  )  NOT  NULL ,
 `pcard_unreconciled_match` char( 1  )  NOT  NULL default  'n',
 `post_date` varchar( 20  )  NOT  NULL ,
 `trans_date` varchar( 20  )  NOT  NULL ,
 `amount` decimal( 12, 2  )  NOT  NULL ,
 `merchant_name` varchar( 75  )  NOT  NULL ,
 `city_state` varchar( 75  )  NOT  NULL ,
 `trans_id` varchar( 20  )  NOT  NULL ,
 `card_number` varchar( 30  )  NOT  NULL ,
 `card_number2` varchar( 4  )  NOT  NULL ,
 `dpr` char( 1  )  NOT  NULL ,
 `admin_num` varchar( 10  )  NOT  NULL ,
 `location` varchar( 10  )  NOT  NULL ,
 `date_posted_new` date NOT  NULL ,
 `date_purchased_new` date NOT  NULL ,
 `company` varchar( 10  )  NOT  NULL ,
 `center` varchar( 15  )  NOT  NULL ,
 `last_name` varchar( 35  )  NOT  NULL ,
 `first_name` varchar( 35  )  NOT  NULL ,
 `report_date` date NOT  NULL ,
 `account_id` varchar( 15  )  NOT  NULL ,
 `document` varchar( 30  )  NOT  NULL ,
 `date_posted` varchar( 20  )  NOT  NULL ,
 `date_purchased` varchar( 20  )  NOT  NULL ,
 `primary_account_holder` varchar( 50  )  NOT  NULL ,
 `purchase_amount` decimal( 12, 2  )  NOT  NULL ,
 `vendor` varchar( 75  )  NOT  NULL ,
 `amount_allocated` decimal( 12, 2  )  NOT  NULL ,
 `id` int( 10  )  unsigned NOT  NULL  auto_increment ,
 PRIMARY  KEY (  `id`  ) ,
 UNIQUE  KEY  `trans_id` (  `trans_id` ,  `trans_date`  )  ) ENGINE  =  MyISAM  DEFAULT CHARSET  = latin1;



";

//echo "<br />query1=$query1<br />";  exit;

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result1 = mysql_query($query1) or die ("Couldn't execute query 1.  $query1");


$query2=" INSERT INTO `$db$ta$ct`
SELECT *
FROM `budget`.`$ta` ;";

$result2 = mysql_query($query2) or die ("Couldn't execute query 2.  $query2");

$query23a="update budget.project_substeps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' and substep_num='$substep_num' ";
			 
mysql_query($query23a) or die ("Couldn't execute query 23a.  $query23a");

$query24="select * from budget.project_substeps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and step_num='$step_num' and status='pending' "; 

$result24=mysql_query($query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysql_num_rows($result24);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num24==0)

{$query25="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
mysql_query($query25) or die ("Couldn't execute query 25.  $query25");}
mysql_close();

if($num24==0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group ");}

if($num24!=0)

{header("location: step$step_group$step_num.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&step_num=$step_num ");}




?>