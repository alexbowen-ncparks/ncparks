<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date";//exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

$today_date=date("Ymd");
//echo "<br />$today_date"; exit;
$query1="CREATE TABLE `budget`.`pcard_unreconciled_$today_date` 
(
 `location` varchar(10) NOT NULL DEFAULT '',
 `admin_num` varchar(10) NOT NULL DEFAULT '',
 `post_date` varchar(15) NOT NULL DEFAULT '',
 `trans_date` varchar(15) NOT NULL DEFAULT '',
 `amount` decimal(12,2) NOT NULL DEFAULT '0.00',
 `vendor_name` varchar(40) NOT NULL DEFAULT '',
 `address` varchar(40) NOT NULL DEFAULT '',
 `trans_id` varchar(20) NOT NULL DEFAULT '',
 `pcard_num` varchar(30) NOT NULL DEFAULT '',
 `cardholder_xtnd` varchar(100) NOT NULL,
 `xtnd_rundate` varchar(15) NOT NULL DEFAULT '',
 `transdate_new` date NOT NULL DEFAULT '0000-00-00',
 `parkcode` varchar(10) NOT NULL DEFAULT '',
 `cardholder` varchar(75) NOT NULL DEFAULT '',
 `employee_tempid` varchar(50) NOT NULL,
 `transid_new` varchar(15) NOT NULL DEFAULT '',
 `postdate_new` date NOT NULL DEFAULT '0000-00-00',
 `xtnd_rundate_new` date NOT NULL DEFAULT '0000-00-00',
 `item_purchased` varchar(150) NOT NULL DEFAULT '',
 `ncasnum` varchar(15) NOT NULL DEFAULT '',
 `center` varchar(15) NOT NULL DEFAULT '',
 `old_center` varchar(15) NOT NULL,
 `park_recondate` date NOT NULL DEFAULT '0000-00-00',
 `budget2controllers` date NOT NULL DEFAULT '0000-00-00',
 `post2ncas` date NOT NULL DEFAULT '0000-00-00',
 `company` varchar(10) NOT NULL DEFAULT '',
 `projnum` varchar(15) NOT NULL DEFAULT '',
 `reclass2_1680` char(1) NOT NULL DEFAULT 'n',
 `equipnum` varchar(15) NOT NULL DEFAULT '',
 `budget_ok` char(1) NOT NULL DEFAULT 'n',
 `reconciled` char(1) NOT NULL DEFAULT '',
 `reconcilement_date` date NOT NULL DEFAULT '0000-00-00',
 `recon_complete` char(1) NOT NULL DEFAULT '',
 `deadline_ok` char(1) NOT NULL DEFAULT 'y',
 `ncas_description` varchar(50) NOT NULL DEFAULT '',
 `report_date` date NOT NULL DEFAULT '0000-00-00',
 `ca` varchar(30) NOT NULL DEFAULT '',
 `count_amount` varchar(30) NOT NULL DEFAULT '',
 `ca_count_posted` varchar(30) NOT NULL DEFAULT '',
 `ca_count_unposted` decimal(5,0) NOT NULL DEFAULT '0',
 `f_year` varchar(5) NOT NULL DEFAULT '',
 `ncas_yn` char(1) NOT NULL DEFAULT 'n',
 `travel` char(1) NOT NULL DEFAULT 'n',
 `transid_date_count` char(1) NOT NULL DEFAULT 'n',
 `caa` varchar(60) NOT NULL DEFAULT '',
 `charge_year` varchar(10) NOT NULL DEFAULT '',
 `pce_match` char(1) NOT NULL DEFAULT 'n',
 `pa_number` varchar(10) NOT NULL DEFAULT '',
 `re_number` varchar(10) NOT NULL DEFAULT '',
 `last_name` varchar(35) NOT NULL DEFAULT '',
 `first_name` varchar(35) NOT NULL DEFAULT '',
 `utility` char(1) NOT NULL DEFAULT 'n',
 `code_1099` varchar(4) NOT NULL DEFAULT '',
 `id1646` varchar(20) NOT NULL DEFAULT '',
 `document_location` varchar(75) NOT NULL DEFAULT '',
 `document_location_fa` varchar(75) NOT NULL,
 `fas_num` varchar(20) NOT NULL,
 `contract_num` varchar(10) NOT NULL,
 `center_dncr` char(1) NOT NULL DEFAULT 'y',
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 PRIMARY KEY (`id`),
 UNIQUE KEY `trans_id` (`trans_id`,`trans_date`),
 KEY `transid_new` (`transid_new`),
 KEY `amount` (`amount`),
 KEY `pa_number` (`pa_number`),
 KEY `re_number` (`re_number`),
 KEY `location` (`location`),
 KEY `admin_num` (`admin_num`),
 KEY `parkcode` (`parkcode`),
 KEY `center` (`center`),
 KEY `report_date` (`report_date`),
 KEY `pcard_num` (`pcard_num`),
 KEY `ncasnum` (`ncasnum`),
 KEY `ca` (`ca`),
 KEY `transid_new_2` (`transid_new`),
 KEY `amount_2` (`amount`),
 KEY `ca_2` (`ca`),
 KEY `pa_number_2` (`pa_number`),
 KEY `re_number_2` (`re_number`),
 KEY `location_2` (`location`),
 KEY `admin_num_2` (`admin_num`),
 KEY `parkcode_2` (`parkcode`),
 KEY `center_2` (`center`),
 KEY `report_date_2` (`report_date`),
 KEY `pcard_num_2` (`pcard_num`),
 KEY `ncasnum_2` (`ncasnum`),
 KEY `old_center` (`old_center`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1




";
//echo "<br />$query1";//exit;
mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

$query2="INSERT INTO `budget`.`pcard_unreconciled_$today_date`
SELECT *
FROM `budget`.`pcard_unreconciled` ;";
//echo "<br />$query2";//exit;
mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");



$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

$query24="select * from budget.project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result24=mysqli_query($connection, $query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysqli_num_rows($result24);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num24==0)

{$query25="update budget.project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");}
////mysql_close();

if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}




?>

























