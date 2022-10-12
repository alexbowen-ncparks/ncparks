<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "hello world";
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;

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
$td=date("Ymd");
$ta="exp_rev";
//$ct=date("His");
$ta2="$ta"."_"."$td";
//echo $ta2;exit;
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


//////mysql_connect($host,$username,$password);
//@mysql_select_db($database) or die( "Unable to select database");

//echo "create table budget."."$ta"."_"."$td"."_"."$ct";
//exit;



$query1=" CREATE TABLE `budget`.`$ta2` 
(
 `center` varchar(12) NOT NULL DEFAULT '',
 `new_center` varchar(15) NOT NULL,
 `old_center` varchar(15) NOT NULL,
 `fund` varchar(12) NOT NULL DEFAULT '',
 `new_fund` varchar(12) NOT NULL,
 `old_fund` varchar(12) NOT NULL,
 `acctdate` varchar(8) NOT NULL DEFAULT '',
 `invoice` varchar(100) NOT NULL DEFAULT '',
 `pe` varchar(10) NOT NULL DEFAULT '',
 `description` varchar(60) NOT NULL DEFAULT '',
 `debit` decimal(12,2) NOT NULL DEFAULT '0.00',
 `credit` decimal(12,2) NOT NULL DEFAULT '0.00',
 `sys` varchar(12) NOT NULL DEFAULT '',
 `acct` varchar(16) NOT NULL DEFAULT '',
 `f_year` varchar(4) NOT NULL DEFAULT '',
 `dist` varchar(4) NOT NULL DEFAULT '',
 `debit_credit` decimal(12,2) NOT NULL DEFAULT '0.00',
 `acct6` varchar(10) NOT NULL DEFAULT '',
 `ciad` varchar(60) NOT NULL DEFAULT '',
 `caa6` varchar(40) NOT NULL DEFAULT '',
 `month` char(2) NOT NULL DEFAULT '',
 `calyear` varchar(15) NOT NULL DEFAULT '',
 `ciad_count` varchar(15) NOT NULL DEFAULT '',
 `pcard_vendor` varchar(20) NOT NULL DEFAULT '',
 `pcard_user` varchar(20) NOT NULL DEFAULT '',
 `pcard_trans_date` varchar(20) NOT NULL DEFAULT '',
 `vendor_description` varchar(60) NOT NULL DEFAULT '',
 `pcardyn` char(1) NOT NULL DEFAULT '',
 `ciaadd` varchar(150) NOT NULL DEFAULT '',
 `ciaa` varchar(100) NOT NULL DEFAULT '',
 `cvip_match` char(1) NOT NULL DEFAULT '',
 `caa` varchar(50) NOT NULL DEFAULT '',
 `pcard_transid` varchar(15) NOT NULL DEFAULT '',
 `acct_description` varchar(75) NOT NULL DEFAULT '',
 `cash_type2` varchar(10) NOT NULL DEFAULT '',
 `budget` varchar(30) NOT NULL DEFAULT '',
 `center_description` varchar(50) NOT NULL DEFAULT '',
 `park` varchar(4) NOT NULL DEFAULT '',
 `proj_dncr` char(1) NOT NULL DEFAULT 'n',
 `comp` varchar(10) NOT NULL,
 `line` varchar(15) NOT NULL,
 `inv_date` varchar(15) NOT NULL,
 `check_num` varchar(20) NOT NULL,
 `ctrld` varchar(15) NOT NULL,
 `grp` varchar(15) NOT NULL,
 `vendor_num` varchar(30) NOT NULL,
 `buy_entity` varchar(10) NOT NULL,
 `po_number` varchar(30) NOT NULL,
 `pc_merchantname` varchar(75) NOT NULL,
 `agency_admin` varchar(20) NOT NULL,
 `agency_location` varchar(20) NOT NULL,
 `pc_transid` varchar(20) NOT NULL,
 `pc_transdate` varchar(20) NOT NULL,
 `pc_cardname` varchar(40) NOT NULL,
 `pc_purchdate` varchar(20) NOT NULL,
 `whid` int(12) unsigned NOT NULL AUTO_INCREMENT,
 PRIMARY KEY (`whid`),
 KEY `center` (`center`),
 KEY `fund` (`fund`),
 KEY `acctdate` (`acctdate`),
 KEY `description` (`description`),
 KEY `acct` (`acct`),
 KEY `f_year` (`f_year`),
 KEY `dist` (`dist`),
 KEY `ciad` (`ciad`),
 KEY `caa6` (`caa6`),
 KEY `month` (`month`),
 KEY `calyear` (`calyear`),
 KEY `ciaa` (`ciaa`),
 KEY `acct_description` (`acct_description`),
 KEY `cash_type2` (`cash_type2`),
 KEY `budget` (`budget`),
 KEY `center_description` (`center_description`),
 KEY `park` (`park`),
 KEY `debit_credit` (`debit_credit`),
 KEY `invoice` (`invoice`),
 KEY `new_center` (`new_center`),
 KEY `old_center` (`old_center`),
 KEY `new_fund` (`new_fund`),
 KEY `old_fund` (`old_fund`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


 ";


// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


$query2=" INSERT INTO `budget`.`$ta2`
SELECT *
FROM `budget`.`exp_rev` ;";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
/*
$query3="ALTER TABLE `budget`.`$ta2`
ADD INDEX ( `center` ),
ADD INDEX ( `fund` ),
ADD INDEX ( `acctdate` ),
ADD INDEX ( `description` ),
ADD INDEX ( `acct` ),
ADD INDEX ( `f_year` ),
ADD INDEX ( `dist` ),
ADD INDEX ( `ciad` ),
ADD INDEX ( `caa6` ),
ADD INDEX ( `month` ),
ADD INDEX ( `calyear` ),
ADD INDEX ( `ciaa` ),
ADD INDEX ( `acct_description` ),
ADD INDEX ( `cash_type2` ),
ADD INDEX ( `budget` ),
ADD INDEX ( `center_description` ),
ADD INDEX ( `park` ) ; ";

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
*/
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