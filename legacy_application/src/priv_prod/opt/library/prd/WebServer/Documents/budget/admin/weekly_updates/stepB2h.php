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
$ta="partf_fund_trans";
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
 `trans_type` varchar(30) NOT NULL DEFAULT '',
 `trans_manual` char(1) NOT NULL DEFAULT 'n',
 `proj_out` varchar(5) NOT NULL DEFAULT '',
 `fund_out` varchar(10) NOT NULL DEFAULT '',
 `fund_out_dncr` char(1) NOT NULL DEFAULT 'y',
 `fund_out_denr_new` varchar(15) NOT NULL,
 `new_fund_out` varchar(10) NOT NULL,
 `proj_in` varchar(5) NOT NULL DEFAULT '',
 `fund_in` varchar(10) NOT NULL DEFAULT '',
 `fund_in_dncr` char(1) NOT NULL DEFAULT 'y',
 `fund_in_denr_new` varchar(15) NOT NULL,
 `new_fund_in` varchar(10) NOT NULL,
 `amount` decimal(14,2) NOT NULL DEFAULT '0.00',
 `trans_date` varchar(15) NOT NULL DEFAULT '',
 `post_date` varchar(15) NOT NULL DEFAULT '',
 `comments` text NOT NULL,
 `posted` char(1) NOT NULL DEFAULT '',
 `post_yn` char(1) NOT NULL DEFAULT '',
 `trans_num` varchar(25) NOT NULL DEFAULT '',
 `trans_source` varchar(20) NOT NULL DEFAULT '',
 `ncas_in` varchar(20) NOT NULL DEFAULT '',
 `ncas_out` varchar(20) NOT NULL DEFAULT '',
 `grant_rec_name` varchar(50) NOT NULL DEFAULT '',
 `grant_rec_vendor` varchar(30) NOT NULL DEFAULT '',
 `grant_PO` varchar(25) NOT NULL DEFAULT '',
 `grant_num` varchar(20) NOT NULL DEFAULT '',
 `bo_2_denr_req_date` varchar(15) NOT NULL DEFAULT '',
 `datenew` date NOT NULL DEFAULT '0000-00-00',
 `datemod` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 `blank_field` varchar(10) NOT NULL DEFAULT '',
 `amount2` decimal(12,2) NOT NULL DEFAULT '0.00',
 `f_year` varchar(4) NOT NULL DEFAULT '',
 `proj_dncr` char(1) NOT NULL DEFAULT 'n',
 `fid` int(10) unsigned NOT NULL AUTO_INCREMENT,
 PRIMARY KEY (`fid`),
 KEY `proj_out` (`proj_out`),
 KEY `proj_in` (`proj_in`),
 KEY `trans_type` (`trans_type`),
 KEY `post_date` (`post_date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1

";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


$query2=" INSERT INTO `$db`.`$ta$ct`
SELECT *
FROM `budget`.`$ta` ;";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$query3="ALTER TABLE `$db`.`$ta$ct`
ADD INDEX ( `proj_out` ),
ADD INDEX ( `proj_in` ),
ADD INDEX ( `trans_type` ),
ADD INDEX ( `post_date` ); ";


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