<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database parameters



//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
//$fiscal_year=$_REQUEST['fiscal_year'];
//$project_category=$_REQUEST['project_category'];
//$project_name=$_REQUEST['project_name'];
//$start_date=$_REQUEST['start_date'];
$end_date=$_REQUEST['end_date'];
//$step_group=$_REQUEST['step_group'];
//echo "fiscal_year=$fiscal_year";
//echo "project_category=$project_category";
//echo "project_name=$project_name";
//echo "start_date=$start_date";
//echo "end_date=$end_date";
//echo "step=$step";
//exit;
$end_date=str_replace('-','',$end_date);
$db_backup="budget$end_date";
//echo $db_backup;
//exit;

////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query1="CREATE TABLE `budget`.`exp_rev$end_date` (
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
PRIMARY KEY ( `whid` ))
 ENGINE = MyISAM ;
";

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


/*$query1="create table budget.exp_rev$end_date
(
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
KEY `center` ( `center` ) ,
KEY `fund` ( `fund` ) ,
KEY `acctdate` ( `acctdate` ) ,
KEY `description` ( `description` ) ,
KEY `acct` ( `acct` ) ,
KEY `f_year` ( `f_year` ) ,
KEY `dist` ( `dist` ) ,
KEY `ciad` ( `ciad` ) ,
KEY `caa6` ( `caa6` ) ,
KEY `month` ( `month` ) ,
KEY `calyear` ( `calyear` ) ,
KEY `ciaa` ( `ciaa` ) ,
KEY `acct_description` ( `acct_description` ) ,
KEY `cash_type` ( `cash_type2` ) ,
KEY `budget_group` ( `budget` ) ,
KEY `center_description` ( `center_description` ) ,
KEY `park` ( `park` )
) ENGINE = MyISAM" ;

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


$query2="insert into
budget.exp_rev$end_date
select *
from budget.exp_rev";
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");



$query3="update budget.project_steps_detail set status='complete' 
          where project_category='$project_category' and project_name='$project_name'
		  and step_group='$step_group' and step_num='$step_num' ";
		  
		  
mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");


$query3="select * from project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result3=mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$num3=mysqli_num_rows($result3);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num3==0)

{$query4="update project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");}
////mysql_close();

if($num3==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num3!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name
      &step_group=$step_group&step_name=$step_name&fiscal_year=$fiscal_year&start_date=$start_date
	  &end_date=$end_date");}
*/

?>