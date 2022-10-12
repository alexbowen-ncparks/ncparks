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
$ta="center";
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
(  `rcc` varchar( 4  )  NOT  NULL default  '',
 `new_rcc` varchar( 4  )  NOT  NULL ,
 `old_rcc` varchar( 4  )  NOT  NULL ,
 `fund` varchar( 5  )  NOT  NULL default  '',
 `fund_dncr` char( 1  )  NOT  NULL default  'y',
 `fund_denr` char( 1  )  NOT  NULL default  'n',
 `new_fund` varchar( 5  )  NOT  NULL ,
 `old_fund` varchar( 5  )  NOT  NULL ,
 `center` varchar( 8  )  NOT  NULL default  '',
 `center_dncr` char( 1  )  NOT  NULL default  'y',
 `center_dncr_transfer` char( 1  )  NOT  NULL default  'n',
 `dncr_project` char( 1  )  NOT  NULL default  'n',
 `dncr_project_center` varchar( 20  )  NOT  NULL ,
 `center_denr` char( 1  )  NOT  NULL default  'n',
 `connect_bond` char( 1  )  NOT  NULL default  'n',
 `new_center` varchar( 8  )  NOT  NULL ,
 `old_center` varchar( 8  )  NOT  NULL ,
 `center_desc` varchar( 50  )  NOT  NULL default  '',
 `budCode` varchar( 15  )  NOT  NULL default  '',
 `new_budCode` varchar( 15  )  NOT  NULL ,
 `old_budCode` varchar( 15  )  NOT  NULL ,
 `company` varchar( 4  )  NOT  NULL default  '',
 `new_company` varchar( 4  )  NOT  NULL ,
 `old_company` varchar( 4  )  NOT  NULL ,
 `actCenterYN` char( 1  )  NOT  NULL default  '',
 `XTND_cip` char( 1  )  NOT  NULL default  '',
 `CYinitFund` varchar( 4  )  NOT  NULL default  '',
 `parkCode` varchar( 4  )  NOT  NULL default  '',
 `dist` varchar( 5  )  NOT  NULL default  '',
 `dist_old` varchar( 10  )  NOT  NULL ,
 `region` varchar( 10  )  NOT  NULL ,
 `section` varchar( 20  )  NOT  NULL default  '',
 `division` varchar( 15  )  NOT  NULL default  '',
 `stateParkYN` char( 1  )  NOT  NULL default  '',
 `CenterMan` varchar( 35  )  NOT  NULL default  '',
 `distMan` varchar( 35  )  NOT  NULL default  '',
 `sectMan` varchar( 35  )  NOT  NULL default  '',
 `divMan` varchar( 35  )  NOT  NULL default  '',
 `center_num_name_year` varchar( 75  )  NOT  NULL default  '',
 `f_year_funded` varchar( 10  )  NOT  NULL default  '',
 `section_district` varchar( 50  )  NOT  NULL default  '',
 `match_cibd725_table` char( 1  )  NOT  NULL default  '',
 `XTND_location` varchar( 15  )  NOT  NULL default  '',
 `TYPE` varchar( 15  )  NOT  NULL default  '',
 `OD_OK` char( 1  )  NOT  NULL default  'n',
 `stop_pay` char( 1  )  NOT  NULL default  'n',
 `OA_name` varchar( 50  )  NOT  NULL default  '',
 `centerman_email` varchar( 50  )  NOT  NULL default  '',
 `OA_email` varchar( 50  )  NOT  NULL default  '',
 `section_park_center` varchar( 50  )  NOT  NULL default  '',
 `part_fun_perc` decimal( 5, 4  )  NOT  NULL default  '0.0000',
 `fema_fun_perc` decimal( 5, 4  )  NOT  NULL default  '0.0000',
 `bond_fun_perc` decimal( 5, 4  )  NOT  NULL default  '0.0000',
 `appr_fun_perc` decimal( 5, 4  )  NOT  NULL default  '0.0000',
 `cwmt_fun_perc` decimal( 5, 4  )  NOT  NULL default  '0.0000',
 `ci_perc` decimal( 5, 4  )  NOT  NULL default  '0.0000',
 `de_perc` decimal( 5, 4  )  NOT  NULL default  '0.0000',
 `en_perc` decimal( 5, 4  )  NOT  NULL default  '0.0000',
 `er_perc` decimal( 5, 4  )  NOT  NULL default  '0.0000',
 `la_perc` decimal( 5, 4  )  NOT  NULL default  '0.0000',
 `mi_perc` decimal( 5, 4  )  NOT  NULL default  '0.0000',
 `mm_perc` decimal( 5, 4  )  NOT  NULL default  '0.0000',
 `tm_perc` decimal( 5, 4  )  NOT  NULL default  '0.0000',
 `project_type` varchar( 20  )  NOT  NULL default  '',
 `park_name` varchar( 50  )  NOT  NULL default  '',
 `it_billing_code` varchar( 20  )  NOT  NULL ,
 `fa_reconciler` varchar( 50  )  NOT  NULL ,
 `legisurvey_center` char( 1  )  NOT  NULL default  'n',
 `fuel_tank` char( 1  )  NOT  NULL default  'n',
 `crs_active` char( 1  )  NOT  NULL default  'n',
 `third_party_vendors` char( 1  )  NOT  NULL default  'n',
 `ceid` int( 10  )  unsigned NOT  NULL  auto_increment ,
 PRIMARY  KEY (  `ceid`  ) ,
 UNIQUE  KEY  `center` (  `center`  ) ,
 KEY  `CenterMan` (  `CenterMan`  ) ,
 KEY  `fund` (  `fund`  ) ,
 KEY  `old_center` (  `old_center`  ) ,
 KEY  `new_center` (  `new_center`  )  ) ENGINE  =  MyISAM  DEFAULT CHARSET  = latin1;


";


// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


$query2=" INSERT INTO `$db`.`$ta$ct`
SELECT *
FROM `budget`.`$ta` ;";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$query3="ALTER TABLE `$db`.`$ta$ct`
ADD INDEX ( `CenterMan` ),
ADD INDEX ( `fund` ) ;";



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