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
$db="budget_$today_date";
$ta="partf_projects";
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

//mysql_connect($host,$username,$password);
//@mysql_select_db($database) or die( "Unable to select database");

//echo "create table $db.$ta$ct";
//exit;



$query1=" CREATE TABLE `$db`.`$ta$ct` 
(  `projNum` varchar( 4  )  NOT  NULL default  '',
 `projYN` char( 1  )  NOT  NULL default  '',
 `reportDisplay` char( 1  )  NOT  NULL default  '',
 `projCat` char( 2  )  NOT  NULL default  '',
 `projSCnum` varchar( 10  )  NOT  NULL default  '',
 `projDENRnum` varchar( 11  )  NOT  NULL default  '',
 `Center` varchar( 10  )  NOT  NULL default  '',
 `budgCode` varchar( 5  )  NOT  NULL default  '',
 `comp` varchar( 4  )  NOT  NULL default  '',
 `projsup` varchar( 35  )  NOT  NULL default  '',
 `manager` varchar( 30  )  NOT  NULL default  '',
 `fundMan` varchar( 35  )  NOT  NULL default  '',
 `YearFundC` varchar( 4  )  NOT  NULL default  '',
 `YearFundF` varchar( 6  )  NOT  NULL default  '',
 `fullname` varchar( 35  )  NOT  NULL default  '',
 `dist` varchar( 20  )  NOT  NULL default  '',
 `county` varchar( 25  )  NOT  NULL default  '',
 `section` varchar( 25  )  NOT  NULL default  '',
 `park` varchar( 4  )  NOT  NULL default  '',
 `projName` varchar( 255  )  NOT  NULL default  '',
 `active` char( 1  )  NOT  NULL default  '',
 `startDate` varchar( 14  )  NOT  NULL default  '',
 `trackStartDate` varchar( 14  )  NOT  NULL default  '',
 `pj_timestamp` timestamp NOT  NULL  default CURRENT_TIMESTAMP  on  update  CURRENT_TIMESTAMP ,
 `endDate` varchar( 14  )  NOT  NULL default  '',
 `trackEndDate` varchar( 14  )  NOT  NULL default  '',
 `statusProj` varchar( 7  )  NOT  NULL default  '',
 `percentCom` char( 3  )  NOT  NULL default  '',
 `statusPer` varchar( 6  )  NOT  NULL default  'ns',
 `comments` text NOT  NULL ,
 `commentsI` text NOT  NULL ,
 `dateadded` varchar( 14  )  NOT  NULL default  '',
 `brucefy` varchar( 5  )  NOT  NULL default  '',
 `proj_man` char( 3  )  NOT  NULL default  '',
 `secondCounty` varchar( 15  )  NOT  NULL default  '',
 `div_app_amt` decimal( 12, 2  )  NOT  NULL default  '0.00',
 `res_proj` char( 1  )  NOT  NULL default  '',
 `partfyn` char( 1  )  NOT  NULL default  '',
 `partf_approv_num` varchar( 4  )  NOT  NULL default  '',
 `femayn` char( 1  )  NOT  NULL default  '',
 `fema_proj_num` varchar( 6  )  NOT  NULL default  '',
 `mult_proj` char( 1  )  NOT  NULL default  '',
 `bond_fund` char( 1  )  NOT  NULL default  '',
 `state_appro` char( 1  )  NOT  NULL default  '',
 `reserve_proj` char( 1  )  NOT  NULL default  '',
 `cwmtf_fund` char( 1  )  NOT  NULL default  '',
 `design` char( 3  )  NOT  NULL default  '0',
 `construction` char( 3  )  NOT  NULL default  '0',
 `showpa` char( 1  )  NOT  NULL default  '',
 `user_id` varchar( 35  )  NOT  NULL default  '',
 `project_center_year_type` varchar( 60  )  NOT  NULL default  '',
 `center_year_type` varchar( 30  )  NOT  NULL default  '',
 `app_amt_052307` decimal( 12, 2  )  NOT  NULL default  '0.00',
 `gis_tract_num` varchar( 50  )  NOT  NULL default  '',
 `loi_lt` varchar( 30  )  NOT  NULL default  '',
 `spo_number` varchar( 30  )  NOT  NULL default  '',
 `acres` decimal( 12, 4  )  NOT  NULL default  '0.0000',
 `est_amt` decimal( 12, 2  )  NOT  NULL default  '0.00',
 `po1_po2` varchar( 30  )  NOT  NULL default  '',
 `cos` varchar( 30  )  NOT  NULL default  '',
 `closed` varchar( 30  )  NOT  NULL default  '',
 `land_status` varchar( 30  )  NOT  NULL default  '',
 `centers_used` varchar( 75  )  NOT  NULL default  '',
 `div_app_amt_set` char( 3  )  NOT  NULL default  '',
 `state_prop_num` varchar( 20  )  NOT  NULL ,
 `statusper_fi_date` date NOT  NULL ,
 `partfid` int( 10  )  unsigned NOT  NULL  auto_increment ,
 `track_percentCom_con` char( 3  )  NOT  NULL default  '',
 `track_percentCom_des` char( 3  )  NOT  NULL default  '',
 `track_statusPer` varchar( 6  )  NOT  NULL default  '',
 PRIMARY  KEY (  `partfid`  ) ,
 UNIQUE  KEY  `projNum` (  `projNum`  ) ,
 KEY  `park` (  `park`  ) ,
 KEY  `manager` (  `manager`  ) ,
 KEY  `projCat` (  `projCat`  ) ,
 KEY  `budgCode` (  `budgCode`  )  ) ENGINE  =  MyISAM  DEFAULT CHARSET  = latin1 COMMENT  =  'flds statusProj, percentComm not used';
 ";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result1 = mysql_query($query1) or die ("Couldn't execute query 1.  $query1");


$query2=" INSERT INTO `$db`.`$ta$ct`
SELECT *
FROM `budget`.`$ta` ;";

$result2 = mysql_query($query2) or die ("Couldn't execute query 2.  $query2");

/*
$query3="ALTER TABLE `$db`.`$ta$ct`
ADD INDEX ( `park` ),
ADD INDEX ( `manager` ),
ADD INDEX ( `projCat` ),
ADD INDEX ( `budgCode` ) ;";

$result3 = mysql_query($query3) or die ("Couldn't execute query 3.  $query3");
*/


//echo "Query Successful";
//echo "<br />";

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