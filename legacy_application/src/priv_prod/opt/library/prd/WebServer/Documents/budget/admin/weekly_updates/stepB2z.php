<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}


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
$ta="coa";
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
(  `ncasNum` varchar( 20  )  NOT  NULL default  '',
 `description` varchar( 75  )  NOT  NULL default  '',
 `park_acct_desc` varchar( 75  )  NOT  NULL default  '',
 `acct_cat` char( 3  )  NOT  NULL default  '',
 `cash_type` varchar( 10  )  NOT  NULL default  '',
 `acct_group` varchar( 100  )  NOT  NULL default  '',
 `comment` text NOT  NULL ,
 `tammy_comment_072514` text NOT  NULL ,
 `track_rcc` char( 1  )  NOT  NULL default  'n',
 `series` char( 3  )  NOT  NULL default  '',
 `valid_cdcs` char( 1  )  NOT  NULL default  'n',
 `valid_osc` char( 1  )  NOT  NULL default  'n',
 `valid_div` char( 1  )  NOT  NULL default  'n',
 `valid_ci` char( 1  )  NOT  NULL default  'n',
 `valid_1280` char( 1  )  NOT  NULL default  '',
 `dateM` timestamp NOT  NULL  default CURRENT_TIMESTAMP  on  update  CURRENT_TIMESTAMP ,
 `fseries` varchar( 4  )  NOT  NULL default  '',
 `fseries_descript` varchar( 50  )  NOT  NULL default  '',
 `acct_cat_group` varchar( 50  )  NOT  NULL default  '',
 `budget_group` varchar( 30  )  NOT  NULL default  '',
 `IT` char( 1  )  NOT  NULL default  'n',
 `ZBA` char( 1  )  NOT  NULL default  'n',
 `repair` char( 1  )  NOT  NULL default  'n',
 `contract` char( 1  )  NOT  NULL default  'n',
 `travel` char( 1  )  NOT  NULL default  'n',
 `description2` varchar( 75  )  NOT  NULL default  '',
 `user_id2` varchar( 40  )  NOT  NULL default  '',
 `view` char( 3  )  NOT  NULL default  '',
 `cab_bd725` char( 1  )  NOT  NULL default  '',
 `track_center` char( 1  )  NOT  NULL default  'n',
 `energy` char( 1  )  NOT  NULL default  'n',
 `utility` char( 1  )  NOT  NULL default  'n',
 `carol_class` varchar( 20  )  NOT  NULL default  '',
 `useful_life_years` varchar( 5  )  NOT  NULL default  '',
 `taxable` char( 1  )  NOT  NULL default  'n',
 `account_group` varchar( 40  )  NOT  NULL default  '',
 `cert1011` char( 1  )  NOT  NULL default  'n',
 `crs` char( 1  )  NOT  NULL default  'n',
 `reservable` char( 1  )  NOT  NULL default  'n',
 `gmp` char( 1  )  NOT  NULL default  'n',
 `crs_yn` char( 1  )  NOT  NULL default  'n',
 `crs_site` char( 1  )  NOT  NULL default  'n',
 `crs_pos` char( 1  )  NOT  NULL default  'n',
 `ncasnum2` varchar( 15  )  NOT  NULL ,
 `naspd_funding_source` varchar( 100  )  NOT  NULL ,
 `naspd_revenue_type` varchar( 100  )  NOT  NULL ,
 `naspd_yn` char( 1  )  NOT  NULL default  'n',
 `legisurvey` varchar( 75  )  NOT  NULL ,
 `real_estate_exp` char( 1  )  NOT  NULL default  'n',
 `real_estate_category` varchar( 50  )  NOT  NULL ,
 `coaid` int( 10  )  unsigned NOT  NULL  auto_increment ,
 PRIMARY  KEY (  `coaid`  ) ,
 UNIQUE  KEY  `ncasNum` (  `ncasNum`  ) ,
 KEY  `budget_group` (  `budget_group`  )  ) ENGINE  =  MyISAM  DEFAULT CHARSET  = latin1;
";


// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


$query2=" INSERT INTO `$db`.`$ta$ct`
SELECT *
FROM `budget`.`$ta` ;";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$query3="ALTER TABLE `$db`.`$ta$ct`
ADD INDEX ( `budget_group` ) ;";



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