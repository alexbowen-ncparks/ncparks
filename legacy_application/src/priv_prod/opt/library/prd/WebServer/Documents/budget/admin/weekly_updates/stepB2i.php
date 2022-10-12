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
$ta="partf_payments";
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
(
 `company` varchar(6) NOT NULL DEFAULT '',
 `fund` varchar(10) NOT NULL DEFAULT '',
 `center` varchar(10) NOT NULL DEFAULT '',
 `denr_center` char(1) NOT NULL DEFAULT 'n',
 `old_center` varchar(15) NOT NULL,
 `new_center` varchar(15) NOT NULL,
 `account` varchar(15) NOT NULL DEFAULT '',
 `datePost` varchar(14) NOT NULL DEFAULT '0000-00-00',
 `checknum` varchar(12) NOT NULL DEFAULT '',
 `invoice` varchar(40) NOT NULL DEFAULT '',
 `amount` decimal(12,2) NOT NULL DEFAULT '0.00',
 `vendornum` varchar(15) NOT NULL DEFAULT '',
 `groupnum` varchar(4) NOT NULL DEFAULT '',
 `vendorname` varchar(60) NOT NULL DEFAULT '',
 `po_number` varchar(30) NOT NULL,
 `proj_num` varchar(12) NOT NULL DEFAULT 'na',
 `contract_num` varchar(10) NOT NULL DEFAULT 'na',
 `contract_amt` decimal(11,2) NOT NULL DEFAULT '0.00',
 `charg_proj_num` varchar(4) NOT NULL DEFAULT 'na',
 `noncon_amt` decimal(10,2) NOT NULL DEFAULT '0.00',
 `dateInvoice` varchar(15) NOT NULL DEFAULT '',
 `datenew` varchar(15) NOT NULL DEFAULT '',
 `pcard_num` varchar(10) NOT NULL DEFAULT '',
 `pcard_name` varchar(25) NOT NULL DEFAULT '',
 `pcard_vendor` varchar(35) NOT NULL DEFAULT '',
 `pcard_descr` varchar(35) NOT NULL DEFAULT '',
 `trans_id` varchar(20) NOT NULL DEFAULT '',
 `purch_descr_input` varchar(35) NOT NULL DEFAULT '',
 `trans_id_9` varchar(15) NOT NULL DEFAULT '',
 `transid_verified` char(1) NOT NULL DEFAULT 'n',
 `PE` varchar(10) NOT NULL DEFAULT '',
 `f_year` varchar(10) NOT NULL DEFAULT '',
 `record_complete` char(1) NOT NULL DEFAULT 'n',
 `CIAD` varchar(50) NOT NULL DEFAULT '',
 `ACCT6` varchar(15) NOT NULL DEFAULT '',
 `CAA6` varchar(40) NOT NULL DEFAULT '',
 `CIAA` varchar(60) NOT NULL DEFAULT '',
 `CIA` varchar(40) NOT NULL DEFAULT '',
 `ci` varchar(30) NOT NULL DEFAULT '',
 `ca` varchar(30) NOT NULL DEFAULT '',
 `ci_match` varchar(30) NOT NULL DEFAULT 'na',
 `ca_match` varchar(30) NOT NULL DEFAULT 'na',
 `pcard_postdate` varchar(15) NOT NULL DEFAULT '',
 `pcard_transdate` varchar(15) NOT NULL DEFAULT '',
 `caa6_count` decimal(12,0) NOT NULL DEFAULT '0',
 `center_description` varchar(40) NOT NULL DEFAULT '',
 `section` varchar(30) NOT NULL DEFAULT '',
 `center_vendor` varchar(75) NOT NULL DEFAULT '',
 `f_year_funded` varchar(10) NOT NULL DEFAULT '',
 `project_category` varchar(5) NOT NULL DEFAULT '',
 `projcat2` char(2) NOT NULL DEFAULT '',
 `spo_valid` char(1) NOT NULL DEFAULT 'n',
 `proj_dncr` char(1) NOT NULL DEFAULT 'n',
 `move_balances` char(1) NOT NULL DEFAULT 'n',
 `pcard` char(1) NOT NULL DEFAULT 'n',
 `transid_dncr` varchar(20) NOT NULL,
 `pcard_last_name` varchar(30) NOT NULL,
 `pcard_vendor_name` varchar(50) NOT NULL,
 `pcard_trans_date` varchar(15) NOT NULL,
 `pcard_vendor_name_dncr` varchar(125) NOT NULL,
 `contract_yn` char(1) NOT NULL DEFAULT 'n',
 `notes` text NOT NULL,
 `adjustment` char(1) NOT NULL DEFAULT 'n',
 `xtid` int(10) unsigned NOT NULL AUTO_INCREMENT,
 PRIMARY KEY (`xtid`),
 KEY `proj_num` (`proj_num`),
 KEY `charg_proj_num` (`charg_proj_num`),
 KEY `company` (`company`),
 KEY `datenew` (`datenew`),
 KEY `CIAD` (`CIAD`),
 KEY `CAA6` (`CAA6`),
 KEY `CIAA` (`CIAA`),
 KEY `CIA` (`CIA`),
 KEY `ci` (`ci`),
 KEY `ca` (`ca`),
 KEY `f_year` (`f_year`),
 KEY `projcat2` (`projcat2`),
 KEY `account` (`account`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1




";
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


$query2=" INSERT INTO `$db`.`$ta$ct`
SELECT *
FROM `budget`.`$ta` ;";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
/*
$query3="ALTER TABLE `$db`.`$ta$ct`
ADD INDEX ( `proj_num` ),
ADD INDEX ( `charg_proj_num` ),
ADD INDEX ( `company` ),
ADD INDEX ( `datenew` ),
ADD INDEX ( `ciad` ),
ADD INDEX ( `caa6` ),
ADD INDEX ( `ciaa` ),
ADD INDEX ( `cia` ),
ADD INDEX ( `ci` ),
ADD INDEX ( `ca` ),
ADD INDEX ( `f_year` ),
ADD INDEX ( `projcat2` );";


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