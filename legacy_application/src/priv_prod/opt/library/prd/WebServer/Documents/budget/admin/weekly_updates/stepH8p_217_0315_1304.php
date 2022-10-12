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
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

$today_date=date("Ymd");
//echo "<br />$today_date"; exit;
$query1="CREATE TABLE `budget`.`cid_vendor_invoice_payments_$today_date`
(  `prefix` char( 2  )  NOT  NULL default  '',
 `ncas_number` varchar( 20  )  NOT  NULL default  '',
 `ncas_account` varchar( 14  )  NOT  NULL default  '',
 `ncas_accrual_code` varchar( 10  )  NOT  NULL default  '',
 `ncas_budget_code` varchar( 10  )  NOT  NULL default  '',
 `ncas_buy_entity` varchar( 10  )  NOT  NULL default  '',
 `approved_by` varchar( 30  )  NOT  NULL default  '',
 `approved_date` varchar( 15  )  NOT  NULL default  '',
 `prepared_by` varchar( 30  )  NOT  NULL default  '',
 `prepared_date` varchar( 15  )  NOT  NULL default  '',
 `comments` text NOT  NULL ,
 `ncas_company` varchar( 10  )  NOT  NULL default  '',
 `ncas_county_code` varchar( 10  )  NOT  NULL default  '',
 `refund_code` varchar( 6  )  NOT  NULL default  '',
 `ncas_credit` char( 1  )  NOT  NULL default  '',
 `ncas_invoice_date` varchar( 12  )  NOT  NULL default  '',
 `dateSQL` varchar( 8  )  NOT  NULL default  '',
 `system_entry_date` date NOT  NULL default  '0000-00-00',
 `due_date` varchar( 15  )  NOT  NULL default  '',
 `fas_num` varchar( 20  )  NOT  NULL default  '',
 `ncas_freight` decimal( 12, 2  )  NOT  NULL default  '0.00',
 `ncas_invoice_number` varchar( 35  )  NOT  NULL default  '',
 `new_vendor` varchar( 30  )  NOT  NULL default  '',
 `project_number` varchar( 20  )  NOT  NULL default  '',
 `ncas_invoice_amount` decimal( 12, 2  )  NOT  NULL default  '0.00',
 `invoice_total` decimal( 12, 2  )  NOT  NULL default  '0.00',
 `po` char( 1  )  NOT  NULL default  '',
 `fy` varchar( 5  )  NOT  NULL default  '',
 `po_line1` varchar( 16  )  NOT  NULL default  '',
 `po_line2` varchar( 16  )  NOT  NULL default  '',
 `posted` char( 1  )  NOT  NULL default  '',
 `amt1` varchar( 16  )  NOT  NULL default  '',
 `amt2` varchar( 16  )  NOT  NULL default  '',
 `amt3` varchar( 16  )  NOT  NULL default  '',
 `ncas_po_number` varchar( 20  )  NOT  NULL default  '',
 `part_pay` char( 1  )  NOT  NULL default  '',
 `ncas_remit_code` varchar( 75  )  NOT  NULL default  '',
 `vendor_name` varchar( 75  )  NOT  NULL default  '',
 `vendor_address` text NOT  NULL ,
 `pay_entity` varchar( 8  )  NOT  NULL default  '',
 `vendor_number` varchar( 40  )  NOT  NULL default  '',
 `group_number` varchar( 8  )  NOT  NULL default  '',
 `user_id` varchar( 30  )  NOT  NULL default  '',
 `parkcode` varchar( 8  )  NOT  NULL default  '',
 `ncas_fund` varchar( 14  )  NOT  NULL default  '',
 `ncas_rcc` varchar( 14  )  NOT  NULL default  '',
 `ncas_center` varchar( 14  )  NOT  NULL default  '',
 `sheet` smallint( 6  )  NOT  NULL default  '0',
 `dateCreate` timestamp NOT  NULL  default CURRENT_TIMESTAMP  on  update  CURRENT_TIMESTAMP ,
 `check_num` varchar( 25  )  NOT  NULL default  '',
 `pcard_holder` tinytext NOT  NULL ,
 `pcard_sum` text NOT  NULL ,
 `pcard_just` text NOT  NULL ,
 `TAX_Hwy_Use_AMT` decimal( 12, 2  )  NOT  NULL default  '0.00',
 `acct6` varchar( 15  )  NOT  NULL default  '',
 `ciaa` varchar( 60  )  NOT  NULL default  '',
 `caa6` varchar( 40  )  NOT  NULL default  '',
 `CIA` varchar( 40  )  NOT  NULL default  '',
 `CI` varchar( 30  )  NOT  NULL default  '',
 `CA` varchar( 30  )  NOT  NULL default  '',
 `er_num` varchar( 10  )  NOT  NULL default  '',
 `post2ncas` char( 1  )  NOT  NULL default  'n',
 `f_year` varchar( 5  )  NOT  NULL default  '',
 `controller_approve` char( 1  )  NOT  NULL default  '',
 `ciaa_count` int( 10  )  NOT  NULL default  '0',
 `ere_postdate` date NOT  NULL default  '0000-00-00',
 `caa` varchar( 40  )  NOT  NULL default  '',
 `caa_count` int( 10  )  NOT  NULL default  '0',
 `ere_id` int( 10  )  NOT  NULL default  '0',
 `temp_match` char( 1  )  NOT  NULL default  '',
 `purchased_by` varchar( 40  )  NOT  NULL default  '',
 `items_purchased` varchar( 100  )  NOT  NULL default  '',
 `park_location` varchar( 75  )  NOT  NULL default  '',
 `received_by` varchar( 40  )  NOT  NULL default  '',
 `temp_match2` char( 1  )  NOT  NULL default  '',
 `charge_year` varchar( 10  )  NOT  NULL default  '',
 `energy_group` varchar( 50  )  NOT  NULL default  '',
 `energy_subgroup` varchar( 50  )  NOT  NULL default  '',
 `cdcs_uom` varchar( 20  )  NOT  NULL default  '',
 `energy_quantity` decimal( 12, 2  )  NOT  NULL default  '0.00',
 `pa_number` varchar( 10  )  NOT  NULL default  '',
 `re_number` varchar( 10  )  NOT  NULL default  '',
 `funding_source` varchar( 12  )  NOT  NULL default  '',
 `document_location` varchar( 75  )  NOT  NULL default  '',
 `document_location_fa` varchar( 75  )  NOT  NULL ,
 `1099_code` varchar( 5  )  NOT  NULL default  '',
 `id` int( 10  )  unsigned NOT  NULL  auto_increment ,
 PRIMARY  KEY (  `id`  ) ,
 UNIQUE  KEY  `vendor_number` (  `vendor_number` ,  `ncas_invoice_amount` ,  `ncas_invoice_date` ,  `ncas_rcc` ,  `ncas_invoice_number` ,  `po_line1` ,  `er_num` ,  `ncas_credit` ,  `ncas_account` ,  `ncas_fund`  ) ,
 KEY  `vendor_name` (  `vendor_name`  ) ,
 KEY  `due_date` (  `due_date`  ) ,
 KEY  `prepared_by` (  `prepared_by`  ) ,
 KEY  `ncas_account` (  `ncas_account`  ) ,
 KEY  `parkcode` (  `parkcode`  ) ,
 KEY  `ciaa` (  `ciaa`  ) ,
 KEY  `caa6` (  `caa6`  ) ,
 KEY  `CIA` (  `CIA`  ) ,
 KEY  `CI` (  `CI`  ) ,
 KEY  `CA` (  `CA`  ) ,
 KEY  `caa` (  `caa`  ) ,
 KEY  `ncas_invoice_number` (  `ncas_invoice_number`  )  ) ENGINE  =  MyISAM  DEFAULT CHARSET  = latin1;


 ";
//echo "<br />$query1";//exit;
mysql_query($query1) or die ("Couldn't execute query 1. $query1");

$query2="INSERT INTO `budget`.`cid_vendor_invoice_payments_$today_date`
SELECT *
FROM `budget`.`cid_vendor_invoice_payments` ;";
//echo "<br />$query2";//exit;
mysql_query($query2) or die ("Couldn't execute query 2. $query2");



$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysql_query($query23a) or die ("Couldn't execute query 23a.  $query23a");

$query24="select * from budget.project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result24=mysql_query($query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysql_num_rows($result24);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num24==0)

{$query25="update budget.project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysql_query($query25) or die ("Couldn't execute query 25.  $query25");}
mysql_close();

if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}




?>

























