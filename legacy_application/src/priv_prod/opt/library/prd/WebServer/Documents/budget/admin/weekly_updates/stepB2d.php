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
$ta="cab_dpr";
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
(  `BC` varchar( 15  )  NOT  NULL default  '',
 `BC_Descript` varchar( 50  )  NOT  NULL default  '',
 `Fund` varchar( 15  )  NOT  NULL default  '',
 `Fund_Descript` varchar( 50  )  NOT  NULL default  '',
 `Acct` varchar( 15  )  NOT  NULL default  '',
 `Acct_Descript` varchar( 50  )  NOT  NULL default  '',
 `Certified` decimal( 12, 2  )  NOT  NULL default  '0.00',
 `Authorized` decimal( 12, 2  )  NOT  NULL default  '0.00',
 `Curr_Month` decimal( 12, 2  )  NOT  NULL default  '0.00',
 `YTD` decimal( 12, 2  )  NOT  NULL default  '0.00',
 `Unexpended` decimal( 12, 2  )  NOT  NULL default  '0.00',
 `Unrealized` decimal( 12, 2  )  NOT  NULL default  '0.00',
 `Encumbrances` decimal( 12, 2  )  NOT  NULL default  '0.00',
 `F_Year` varchar( 15  )  NOT  NULL default  '',
 `DPR` char( 1  )  NOT  NULL default  '',
 `cash_type` varchar( 15  )  NOT  NULL default  '',
 `receipt_amt` decimal( 12, 2  )  NOT  NULL default  '0.00',
 `disburse_amt` decimal( 12, 2  )  NOT  NULL default  '0.00',
 `xtnd_rundate` date NOT  NULL default  '0000-00-00',
 `match_coa` char( 1  )  NOT  NULL default  '',
 `dpr_valid` char( 1  )  NOT  NULL default  'n',
 `id` int( 10  )  unsigned NOT  NULL  auto_increment ,
 PRIMARY  KEY (  `id`  ) ,
 KEY  `Acct` (  `Acct`  )  ) ENGINE  =  MyISAM  DEFAULT CHARSET  = latin1;
  ";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


$query2=" INSERT INTO `$db`.`$ta$ct`
SELECT *
FROM `budget`.`$ta` ;";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$query3="ALTER TABLE `$db`.`$ta$ct`
ADD INDEX ( `acct` ); ";

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