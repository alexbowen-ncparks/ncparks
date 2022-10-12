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
$ta="pcard_unreconciled";
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
(  `location` varchar( 10  )  NOT  NULL default  '',
 `admin_num` varchar( 10  )  NOT  NULL default  '',
 `post_date` varchar( 15  )  NOT  NULL default  '',
 `trans_date` varchar( 15  )  NOT  NULL default  '',
 `amount` decimal( 12, 2  )  NOT  NULL default  '0.00',
 `vendor_name` varchar( 40  )  NOT  NULL default  '',
 `address` varchar( 40  )  NOT  NULL default  '',
 `trans_id` varchar( 20  )  NOT  NULL default  '',
 `pcard_num` varchar( 30  )  NOT  NULL default  '',
 `cardholder_xtnd` varchar( 100  )  NOT  NULL ,
 `xtnd_rundate` varchar( 15  )  NOT  NULL default  '',
 `transdate_new` date NOT  NULL default  '0000-00-00',
 `parkcode` varchar( 10  )  NOT  NULL default  '',
 `cardholder` varchar( 75  )  NOT  NULL default  '',
 `employee_tempid` varchar( 50  )  NOT  NULL ,
 `transid_new` varchar( 15  )  NOT  NULL default  '',
 `postdate_new` date NOT  NULL default  '0000-00-00',
 `xtnd_rundate_new` date NOT  NULL default  '0000-00-00',
 `item_purchased` varchar( 150  )  NOT  NULL default  '',
 `ncasnum` varchar( 15  )  NOT  NULL default  '',
 `center` varchar( 15  )  NOT  NULL default  '',
 `old_center` varchar( 15  )  NOT  NULL ,
 `park_recondate` date NOT  NULL default  '0000-00-00',
 `budget2controllers` date NOT  NULL default  '0000-00-00',
 `post2ncas` date NOT  NULL default  '0000-00-00',
 `company` varchar( 10  )  NOT  NULL default  '',
 `projnum` varchar( 15  )  NOT  NULL default  '',
 `equipnum` varchar( 15  )  NOT  NULL default  '',
 `budget_ok` char( 1  )  NOT  NULL default  'n',
 `reconciled` char( 1  )  NOT  NULL default  '',
 `reconcilement_date` date NOT  NULL default  '0000-00-00',
 `recon_complete` char( 1  )  NOT  NULL default  '',
 `deadline_ok` char( 1  )  NOT  NULL default  'y',
 `ncas_description` varchar( 50  )  NOT  NULL default  '',
 `report_date` date NOT  NULL default  '0000-00-00',
 `ca` varchar( 30  )  NOT  NULL default  '',
 `count_amount` varchar( 30  )  NOT  NULL default  '',
 `ca_count_posted` varchar( 30  )  NOT  NULL default  '',
 `ca_count_unposted` decimal( 5, 0  )  NOT  NULL default  '0',
 `f_year` varchar( 5  )  NOT  NULL default  '',
 `ncas_yn` char( 1  )  NOT  NULL default  'n',
 `travel` char( 1  )  NOT  NULL default  'n',
 `transid_date_count` char( 1  )  NOT  NULL default  'n',
 `caa` varchar( 60  )  NOT  NULL default  '',
 `charge_year` varchar( 10  )  NOT  NULL default  '',
 `pce_match` char( 1  )  NOT  NULL default  'n',
 `pa_number` varchar( 10  )  NOT  NULL default  '',
 `re_number` varchar( 10  )  NOT  NULL default  '',
 `last_name` varchar( 35  )  NOT  NULL default  '',
 `first_name` varchar( 35  )  NOT  NULL default  '',
 `utility` char( 1  )  NOT  NULL default  'n',
 `code_1099` varchar( 4  )  NOT  NULL default  '',
 `id1646` varchar( 20  )  NOT  NULL default  '',
 `document_location` varchar( 75  )  NOT  NULL default  '',
 `document_location_fa` varchar( 75  )  NOT  NULL ,
 `fas_num` varchar( 20  )  NOT  NULL ,
 `contract_num` varchar( 10  )  NOT  NULL ,
 `center_dncr` char( 1  )  NOT  NULL default  'y',
 `id` int( 10  )  unsigned NOT  NULL  auto_increment ,
 PRIMARY  KEY (  `id`  ) ,
 UNIQUE  KEY  `trans_id` (  `trans_id` ,  `trans_date`  ) ,
 KEY  `transid_new` (  `transid_new`  ) ,
 KEY  `amount` (  `amount`  ) ,
 KEY  `pa_number` (  `pa_number`  ) ,
 KEY  `re_number` (  `re_number`  ) ,
 KEY  `location` (  `location`  ) ,
 KEY  `admin_num` (  `admin_num`  ) ,
 KEY  `parkcode` (  `parkcode`  ) ,
 KEY  `center` (  `center`  ) ,
 KEY  `report_date` (  `report_date`  ) ,
 KEY  `pcard_num` (  `pcard_num`  ) ,
 KEY  `ncasnum` (  `ncasnum`  ) ,
 KEY  `ca` (  `ca`  ) ,
 KEY  `transid_new_2` (  `transid_new`  ) ,
 KEY  `amount_2` (  `amount`  ) ,
 KEY  `ca_2` (  `ca`  ) ,
 KEY  `pa_number_2` (  `pa_number`  ) ,
 KEY  `re_number_2` (  `re_number`  ) ,
 KEY  `location_2` (  `location`  ) ,
 KEY  `admin_num_2` (  `admin_num`  ) ,
 KEY  `parkcode_2` (  `parkcode`  ) ,
 KEY  `center_2` (  `center`  ) ,
 KEY  `report_date_2` (  `report_date`  ) ,
 KEY  `pcard_num_2` (  `pcard_num`  ) ,
 KEY  `ncasnum_2` (  `ncasnum`  ) ,
 KEY  `old_center` (  `old_center`  )  ) ENGINE  =  MyISAM  DEFAULT CHARSET  = latin1;
";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


$query2=" INSERT INTO `$db`.`$ta$ct`
SELECT *
FROM `budget`.`$ta` ;";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$query3="ALTER TABLE `$db`.`$ta$ct`
ADD INDEX ( `transid_new` ),
ADD INDEX ( `amount` ),
ADD INDEX ( `ca` ),
ADD INDEX ( `pa_number` ),
ADD INDEX ( `re_number` ),
ADD INDEX ( `location` ),
ADD INDEX ( `admin_num` ),
ADD INDEX ( `parkcode` ),
ADD INDEX ( `center` ),
ADD INDEX ( `report_date` ),
ADD INDEX ( `pcard_num` ),
ADD INDEX ( `ncasnum` );";


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