<?php

session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

$query1=" CREATE TABLE `budget`.`exp_rev_template8` (
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

$query2=" INSERT INTO `budget`.`exp_rev_template8`
SELECT *
FROM `budget`.`exp_rev_template` ;";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$query3="ALTER TABLE `exp_rev_template8` 
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
echo "Query Successful";
echo "<br />";
//echo "<H2 ALIGN=left><font size=4><b><A href=step$step_group$step_num.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&step_num=$step_num> Return to Pcard Updates</A></font></H2>";


?>