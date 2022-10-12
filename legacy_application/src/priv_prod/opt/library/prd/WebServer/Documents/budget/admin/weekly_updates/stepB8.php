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
//echo "backup table=budget.exp_rev_ws_$today_date";exit;


//////mysql_connect($host,$username,$password);
//@mysql_select_db($database) or die( "Unable to select database");

$query1=" CREATE TABLE `budget`.`exp_rev_ws_$today_date` (
`center` varchar( 12 ) NOT NULL default '',
`fund` varchar( 12 ) NOT NULL default '',
`acctdate` varchar( 8 ) NOT NULL default '',
`invoice` varchar( 100 ) NOT NULL default '',
`pe` varchar( 10 ) NOT NULL default '',
`description` varchar( 60 ) NOT NULL default '',
`debit` decimal( 12, 2 ) NOT NULL default '0.00',
`credit` decimal( 12, 2 ) NOT NULL default '0.00',
`sys` varchar( 12 ) NOT NULL default '',
`acct` varchar( 16 ) NOT NULL default '',
`f_year` varchar( 4 ) NOT NULL default '',
`dist` varchar( 4 ) NOT NULL default '',
`debit_credit` decimal( 12, 2 ) NOT NULL default '0.00',
`acct6` varchar( 10 ) NOT NULL default '',
`ciad` varchar( 60 ) NOT NULL default '',
`caa6` varchar( 40 ) NOT NULL default '',
`month` char( 2 ) NOT NULL default '',
`calyear` varchar( 15 ) NOT NULL default '',
`ciad_count` varchar( 15 ) NOT NULL default '',
`pcard_vendor` varchar( 20 ) NOT NULL default '',
`pcard_user` varchar( 20 ) NOT NULL default '',
`pcard_trans_date` varchar( 20 ) NOT NULL default '',
`vendor_description` varchar( 60 ) NOT NULL default '',
`pcardyn` char( 1 ) NOT NULL default '',
`ciaadd` varchar( 150 ) NOT NULL default '',
`ciaa` varchar( 100 ) NOT NULL default '',
`cvip_match` char( 1 ) NOT NULL default '',
`caa` varchar( 50 ) NOT NULL default '',
`pcard_transid` varchar( 15 ) NOT NULL default '',
`acct_description` varchar( 75 ) NOT NULL default '',
`cash_type2` varchar( 10 ) NOT NULL default '',
`budget` varchar( 30 ) NOT NULL default '',
`center_description` varchar( 50 ) NOT NULL default '',
`park` varchar( 4 ) NOT NULL default '',
`whid` int( 12 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `whid` ) ,
) ENGINE = MyISAM ;";


// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


$query2=" INSERT INTO `budget`.`exp_rev_ws_$today_date`(center,fund,acctdate,invoice,pe,description,
          debit,credit,sys,acct,f_year,dist,debit_credit,acct6,ciad,caa6,month,calyear,ciad_count,
		  pcard_vendor,pcard_user,pcard_trans_date,vendor_description,pcardyn,ciaadd,ciaa,cvip_match,
		  caa,pcard_transid,acct_description,cash_type2,budget,center_description,park)
		  
SELECT center,fund,acctdate,invoice,pe,description,debit,credit,sys,acct,f_year,dist,debit_credit,
       acct6,ciad,caa6,month,calyear,ciad_count,pcard_vendor,pcard_user,pcard_trans_date,
	   vendor_description,pcardyn,ciaadd,ciaa,cvip_match,caa,pcard_transid,acct_description,
	   cash_type2,budget,center_description,park
FROM `budget`.`exp_rev_ws` ;";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$query3="ALTER TABLE `budget`.`exp_rev_ws_$today_date`
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