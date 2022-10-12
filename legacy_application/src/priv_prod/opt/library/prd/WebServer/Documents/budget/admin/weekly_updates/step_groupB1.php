<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters


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
$query1="create database $db_backup";
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


//Table backup
$query2="create table $db_backup.authorized_budget
(
`budget_code` varchar( 15 ) NOT NULL default '',
`FUND` varchar( 12 ) NOT NULL default '',
`ACCOUNT` varchar( 20 ) NOT NULL default '',
`DESCRIPTION` varchar( 30 ) NOT NULL default '',
`CERTIFIED` decimal( 12, 2 ) NOT NULL default '0.00',
`AUTHORIZED` decimal( 12, 2 ) NOT NULL default '0.00',
`current_month` decimal( 12, 2 ) NOT NULL default '0.00',
`ytd` decimal( 12, 2 ) NOT NULL default '0.00',
`unexpend_cert` decimal( 12, 2 ) NOT NULL default '0.00',
`unrealize_auth` decimal( 12, 2 ) NOT NULL default '0.00',
`encumbrance` decimal( 12, 2 ) NOT NULL default '0.00',
`rate` decimal( 12, 2 ) NOT NULL default '0.00',
`XTND_DATE` date NOT NULL default '0000-00-00',
`f_year` varchar( 10 ) NOT NULL default '',
`acct_cat` char( 3 ) NOT NULL default '',
`AB_ID` int( 12 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `AB_ID` ) ,
KEY `ACCOUNT` ( `ACCOUNT` )
) ENGINE = MyISAM ";

mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


//Table backup
$query3="create table $db_backup.bd725_dpr
(
`BC` varchar( 15 ) NOT NULL default '',
`FUND` varchar( 15 ) NOT NULL default '',
`Fund_Descript` varchar( 50 ) NOT NULL default '',
`Account` varchar( 15 ) NOT NULL default '',
`Account_Descript` varchar( 50 ) NOT NULL default '',
`total_budget` decimal( 12, 2 ) NOT NULL default '0.00',
`unallotted` decimal( 12, 2 ) NOT NULL default '0.00',
`total_allotments` decimal( 12, 2 ) NOT NULL default '0.00',
`current` decimal( 12, 2 ) NOT NULL default '0.00',
`ytd` decimal( 12, 2 ) NOT NULL default '0.00',
`ptd` decimal( 12, 2 ) NOT NULL default '0.00',
`allotment_balance` decimal( 12, 2 ) NOT NULL default '0.00',
`f_year` varchar( 15 ) NOT NULL default '',
`match_center_table` char( 1 ) NOT NULL default '',
`match_coa` char( 1 ) NOT NULL default '',
`cash_type` varchar( 15 ) NOT NULL default '',
`receipt_amt` decimal( 12, 2 ) NOT NULL default '0.00',
`disburse_amt` decimal( 12, 2 ) NOT NULL default '0.00',
`xtnd_rundate` date NOT NULL default '0000-00-00',
`id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `id` ) ,
KEY `Account` ( `Account` )
) ENGINE = MyISAM ";

mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

//Table backup
$query4="create table $db_backup.budget_center_allocations
(
`center` varchar( 8 ) NOT NULL default '',
`ncas_acct` varchar( 10 ) NOT NULL default '',
`fy_req` varchar( 4 ) NOT NULL default '',
`equipment_request` char( 1 ) NOT NULL default '',
`user_id` varchar( 20 ) NOT NULL default '',
`allocation_level` varchar( 30 ) NOT NULL default '',
`allocation_amount` decimal( 12, 2 ) NOT NULL default '0.00',
`allocation_justification` varchar( 50 ) NOT NULL default '',
`allocation_date` date NOT NULL default '0000-00-00',
`budget_group` varchar( 30 ) NOT NULL default '',
`entrydate` date NOT NULL default '0000-00-00',
`comments` varchar( 50 ) NOT NULL default '',
`id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `id` )
) ENGINE = MyISAM ";

mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

//Table backup
$query5="create table $db_backup.cab_dpr
(
`BC` varchar( 15 ) NOT NULL default '',
`BC_Descript` varchar( 50 ) NOT NULL default '',
`Fund` varchar( 15 ) NOT NULL default '',
`Fund_Descript` varchar( 50 ) NOT NULL default '',
`Acct` varchar( 15 ) NOT NULL default '',
`Acct_Descript` varchar( 50 ) NOT NULL default '',
`Certified` decimal( 12, 2 ) NOT NULL default '0.00',
`Authorized` decimal( 12, 2 ) NOT NULL default '0.00',
`Curr_Month` decimal( 12, 2 ) NOT NULL default '0.00',
`YTD` decimal( 12, 2 ) NOT NULL default '0.00',
`Unexpended` decimal( 12, 2 ) NOT NULL default '0.00',
`Unrealized` decimal( 12, 2 ) NOT NULL default '0.00',
`Encumbrances` decimal( 12, 2 ) NOT NULL default '0.00',
`F_Year` varchar( 15 ) NOT NULL default '',
`DPR` char( 1 ) NOT NULL default '',
`cash_type` varchar( 15 ) NOT NULL default '',
`receipt_amt` decimal( 12, 2 ) NOT NULL default '0.00',
`disburse_amt` decimal( 12, 2 ) NOT NULL default '0.00',
`xtnd_rundate` date NOT NULL default '0000-00-00',
`match_coa` char( 1 ) NOT NULL default '',
`id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `id` ) ,
KEY `Acct` ( `Acct` )
) ENGINE = MyISAM ";

mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");

//Table backup
$query6="CREATE TABLE $db_backup.cid_vendor_invoice_payments (
`prefix` char( 2 ) NOT NULL default '',
`ncas_number` varchar( 20 ) NOT NULL default '',
`ncas_account` varchar( 14 ) NOT NULL default '',
`ncas_accrual_code` varchar( 10 ) NOT NULL default '',
`ncas_budget_code` varchar( 10 ) NOT NULL default '',
`ncas_buy_entity` varchar( 10 ) NOT NULL default '',
`approved_by` varchar( 30 ) NOT NULL default '',
`approved_date` varchar( 15 ) NOT NULL default '',
`prepared_by` varchar( 30 ) NOT NULL default '',
`prepared_date` varchar( 15 ) NOT NULL default '',
`comments` varchar( 100 ) NOT NULL default '',
`ncas_company` varchar( 10 ) NOT NULL default '',
`ncas_county_code` varchar( 10 ) NOT NULL default '',
`refund_code` varchar( 6 ) NOT NULL default '',
`ncas_credit` char( 1 ) NOT NULL default '',
`ncas_invoice_date` varchar( 12 ) NOT NULL default '',
`dateSQL` varchar( 8 ) NOT NULL default '',
`system_entry_date` date NOT NULL default '0000-00-00',
`due_date` varchar( 15 ) NOT NULL default '',
`fas_num` varchar( 20 ) NOT NULL default '',
`ncas_freight` decimal( 12, 2 ) NOT NULL default '0.00',
`ncas_invoice_number` varchar( 35 ) NOT NULL default '',
`new_vendor` varchar( 30 ) NOT NULL default '',
`project_number` varchar( 20 ) NOT NULL default '',
`ncas_invoice_amount` decimal( 12, 2 ) NOT NULL default '0.00',
`invoice_total` decimal( 12, 2 ) NOT NULL default '0.00',
`po` char( 1 ) NOT NULL default '',
`fy` varchar( 5 ) NOT NULL default '',
`po_line1` varchar( 16 ) NOT NULL default '',
`po_line2` varchar( 16 ) NOT NULL default '',
`posted` char( 1 ) NOT NULL default '',
`amt1` varchar( 16 ) NOT NULL default '',
`amt2` varchar( 16 ) NOT NULL default '',
`amt3` varchar( 16 ) NOT NULL default '',
`ncas_po_number` varchar( 20 ) NOT NULL default '',
`part_pay` char( 1 ) NOT NULL default '',
`ncas_remit_code` varchar( 75 ) NOT NULL default '',
`vendor_name` varchar( 75 ) NOT NULL default '',
`vendor_address` text NOT NULL ,
`pay_entity` varchar( 8 ) NOT NULL default '',
`vendor_number` varchar( 40 ) NOT NULL default '',
`group_number` varchar( 8 ) NOT NULL default '',
`user_id` varchar( 30 ) NOT NULL default '',
`parkcode` varchar( 8 ) NOT NULL default '',
`ncas_fund` varchar( 14 ) NOT NULL default '',
`ncas_rcc` varchar( 14 ) NOT NULL default '',
`ncas_center` varchar( 14 ) NOT NULL default '',
`sheet` smallint( 6 ) NOT NULL default '0',
`dateCreate` timestamp( 14 ) NOT NULL ,
`check_num` varchar( 25 ) NOT NULL default '',
`pcard_holder` tinytext NOT NULL ,
`pcard_sum` text NOT NULL ,
`pcard_just` text NOT NULL ,
`TAX_Hwy_Use_AMT` decimal( 12, 2 ) NOT NULL default '0.00',
`acct6` varchar( 15 ) NOT NULL default '',
`ciaa` varchar( 60 ) NOT NULL default '',
`caa6` varchar( 40 ) NOT NULL default '',
`CIA` varchar( 40 ) NOT NULL default '',
`CI` varchar( 30 ) NOT NULL default '',
`CA` varchar( 30 ) NOT NULL default '',
`er_num` varchar( 10 ) NOT NULL default '',
`post2ncas` char( 1 ) NOT NULL default 'n',
`f_year` varchar( 5 ) NOT NULL default '',
`controller_approve` char( 1 ) NOT NULL default '',
`ciaa_count` int( 10 ) NOT NULL default '0',
`ere_postdate` date NOT NULL default '0000-00-00',
`caa` varchar( 40 ) NOT NULL default '',
`caa_count` int( 10 ) NOT NULL default '0',
`ere_id` int( 10 ) NOT NULL default '0',
`temp_match` char( 1 ) NOT NULL default '',
`purchased_by` varchar( 40 ) NOT NULL default '',
`items_purchased` varchar( 100 ) NOT NULL default '',
`park_location` varchar( 75 ) NOT NULL default '',
`received_by` varchar( 40 ) NOT NULL default '',
`temp_match2` char( 1 ) NOT NULL default '',
`charge_year` varchar( 10 ) NOT NULL default '',
`energy_group` varchar( 50 ) NOT NULL default '',
`energy_subgroup` varchar( 50 ) NOT NULL default '',
`cdcs_uom` varchar( 20 ) NOT NULL default '',
`energy_quantity` decimal( 12, 2 ) NOT NULL default '0.00',
`pa_number` varchar( 10 ) NOT NULL default '',
`re_number` varchar( 10 ) NOT NULL default '',
`funding_source` varchar( 12 ) NOT NULL default '',
`id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `id` ) ,
UNIQUE KEY `vendor_number` ( `vendor_number` , `ncas_invoice_amount` , `ncas_invoice_date` , `ncas_rcc` , `ncas_invoice_number` , `po_line1` , `er_num` , `ncas_credit` ) ,
KEY `vendor_name` ( `vendor_name` ) ,
KEY `due_date` ( `due_date` ) ,
KEY `prepared_by` ( `prepared_by` ) ,
KEY `ncas_account` ( `ncas_account` ) ,
KEY `parkcode` ( `parkcode` ) ,
KEY `ciaa` ( `ciaa` ) ,
KEY `caa6` ( `caa6` ) ,
KEY `CIA` ( `CIA` ) ,
KEY `CI` ( `CI` ) ,
KEY `CA` ( `CA` ) ,
KEY `caa` ( `caa` ) ,
KEY `ncas_invoice_number` ( `ncas_invoice_number` )
) ENGINE = MyISAM ";

mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");


//Table backup
$query7="create table $db_backup.equipment_request_3
(
`location` varchar( 15 ) NOT NULL default '',
`equipment_description` text NOT NULL ,
`justification` text NOT NULL ,
`funding_source` varchar( 15 ) NOT NULL default '',
`disu_ranking` varchar( 10 ) NOT NULL default '',
`requested_amount` decimal( 12, 2 ) NOT NULL default '0.00',
`district_approved` char( 1 ) NOT NULL default 'u',
`section_approved` char( 1 ) NOT NULL default '',
`division_approved` char( 1 ) NOT NULL default 'u',
`original_approved` char( 1 ) NOT NULL default '',
`purchaser` varchar( 50 ) NOT NULL default '',
`date_approved` varchar( 50 ) NOT NULL default '',
`ordered_amount` decimal( 12, 2 ) NOT NULL default '0.00',
`pricing_source` varchar( 100 ) NOT NULL default '',
`pay_center` varchar( 15 ) NOT NULL default '',
`ncas_account` varchar( 15 ) NOT NULL default 'na',
`f_year` varchar( 10 ) NOT NULL default '',
`er_num` int( 11 ) NOT NULL default '0',
`status` varchar( 15 ) NOT NULL default 'active',
`order_complete` char( 1 ) NOT NULL default 'n',
`Paid_in_Full` char( 1 ) NOT NULL default 'n',
`disu_priority` varchar( 15 ) NOT NULL default '',
`comments` varchar( 100 ) NOT NULL default '',
`receive_complete` char( 1 ) NOT NULL default 'n',
`district` varchar( 20 ) NOT NULL default '',
`center_code` varchar( 15 ) NOT NULL default '',
`original_amount` decimal( 12, 2 ) NOT NULL default '0.00',
`allocation_type` varchar( 30 ) NOT NULL default '',
`system_entry_date` date NOT NULL default '0000-00-00',
`pasu_priority` varchar( 15 ) NOT NULL default '',
`user_id` varchar( 30 ) NOT NULL default '',
`unit_quantity` int( 5 ) NOT NULL default '0',
`category` varchar( 50 ) NOT NULL default '',
`unit_cost` decimal( 12, 2 ) NOT NULL default '0.00',
`po_number` varchar( 20 ) NOT NULL default '',
`valid_acct` char( 1 ) NOT NULL default '',
`valid_center` char( 1 ) NOT NULL default '',
`equipment_type` varchar( 20 ) NOT NULL default '',
`puof_approved` char( 1 ) NOT NULL default 'u',
`itma_approved` char( 1 ) NOT NULL default 'u',
`pasu_ranking` tinyint( 4 ) NOT NULL default '0',
`payments_entered` decimal( 12, 2 ) NOT NULL default '0.00',
`order_number` int( 10 ) NOT NULL default '0',
`email_confirmation` varchar( 40 ) NOT NULL default '',
`bo_comments` text NOT NULL ,
`id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `id` ) ,
UNIQUE KEY `er_num_2` ( `er_num` ) ,
KEY `er_num` ( `er_num` )
) ENGINE = MyISAM PACK_KEYS =1";

mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");


//Table backup
$query8="create table $db_backup.exp_rev_extract
(
`center` varchar( 12 ) NOT NULL default '',
`fund` varchar( 12 ) NOT NULL default '',
`acctdate` date NOT NULL default '0000-00-00',
`invoice` varchar( 100 ) NOT NULL default '',
`pe` varchar( 10 ) NOT NULL default '',
`description` varchar( 75 ) NOT NULL default '',
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
`cvip_match` char( 1 ) NOT NULL default 'n',
`ciaa_count` int( 10 ) NOT NULL default '0',
`cvip_sed` date NOT NULL default '0000-00-00',
`cvip_id` varchar( 30 ) NOT NULL default '',
`parkcode` varchar( 10 ) NOT NULL default '',
`account_description` varchar( 75 ) NOT NULL default '',
`cvip_one` char( 1 ) NOT NULL default '',
`caa` varchar( 50 ) NOT NULL default '',
`caa_count` int( 10 ) NOT NULL default '0',
`whid` int( 12 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `whid` ) ,
KEY `center` ( `center` ) ,
KEY `fund` ( `fund` ) ,
KEY `acctdate` ( `acctdate` ) ,
KEY `description` ( `description` ) ,
KEY `acct` ( `acct` ) ,
KEY `f_year` ( `f_year` ) ,
KEY `dist` ( `dist` ) ,
KEY `caa6` ( `caa6` ) ,
KEY `ciad` ( `ciad` ) ,
KEY `month` ( `month` ) ,
KEY `month_2` ( `month` ) ,
KEY `calyear` ( `calyear` )
) ENGINE = MyISAM ";

mysqli_query($connection, $query8) or die ("Couldn't execute query 8.  $query8");

//Table backup
$query9="create table $db_backup.partf_fund_trans
(
`trans_type` varchar( 30 ) NOT NULL default '',
`proj_out` varchar( 4 ) NOT NULL default '0.00',
`fund_out` varchar( 10 ) NOT NULL default '0.00',
`proj_in` varchar( 4 ) NOT NULL default '',
`fund_in` varchar( 10 ) NOT NULL default '',
`amount` decimal( 14, 2 ) NOT NULL default '0.00',
`trans_date` varchar( 15 ) NOT NULL default '',
`post_date` varchar( 15 ) NOT NULL default '',
`comments` text NOT NULL ,
`posted` char( 1 ) NOT NULL default '',
`post_yn` char( 1 ) NOT NULL default '',
`trans_num` varchar( 25 ) NOT NULL default '',
`trans_source` varchar( 20 ) NOT NULL default '',
`ncas_in` varchar( 20 ) NOT NULL default '',
`ncas_out` varchar( 20 ) NOT NULL default '',
`grant_rec_name` varchar( 50 ) NOT NULL default '',
`grant_rec_vendor` varchar( 30 ) NOT NULL default '',
`grant_PO` varchar( 25 ) NOT NULL default '',
`grant_num` varchar( 20 ) NOT NULL default '',
`bo_2_denr_req_date` varchar( 15 ) NOT NULL default '',
`datenew` date NOT NULL default '0000-00-00',
`datemod` timestamp( 14 ) NOT NULL ,
`blank_field` varchar( 10 ) NOT NULL default '',
`amount2` decimal( 12, 2 ) NOT NULL default '0.00',
`fid` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `fid` ) ,
KEY `proj_out` ( `proj_out` ) ,
KEY `proj_in` ( `proj_in` ) ,
KEY `trans_type` ( `trans_type` ) ,
KEY `post_date` ( `post_date` )
) ENGINE = MyISAM" ;

mysqli_query($connection, $query9) or die ("Couldn't execute query 9.  $query9");


//Table backup
$query10="create table $db_backup.partf_payments
(
`company` varchar( 6 ) NOT NULL default '',
`fund` varchar( 10 ) NOT NULL default '',
`center` varchar( 10 ) NOT NULL default '',
`account` varchar( 15 ) NOT NULL default '',
`datePost` varchar( 14 ) NOT NULL default '0000-00-00',
`checknum` varchar( 12 ) NOT NULL default '',
`invoice` varchar( 40 ) NOT NULL default '',
`amount` decimal( 12, 2 ) NOT NULL default '0.00',
`vendornum` varchar( 15 ) NOT NULL default '',
`groupnum` varchar( 4 ) NOT NULL default '',
`vendorname` varchar( 60 ) NOT NULL default '',
`proj_num` varchar( 12 ) NOT NULL default 'na',
`contract_num` varchar( 10 ) NOT NULL default 'na',
`contract_amt` decimal( 11, 2 ) NOT NULL default '0.00',
`charg_proj_num` varchar( 4 ) NOT NULL default 'na',
`noncon_amt` decimal( 10, 2 ) NOT NULL default '0.00',
`dateInvoice` varchar( 15 ) NOT NULL default '',
`datenew` varchar( 15 ) NOT NULL default '',
`pcard_num` varchar( 10 ) NOT NULL default '',
`pcard_name` varchar( 25 ) NOT NULL default '',
`pcard_vendor` varchar( 35 ) NOT NULL default '',
`pcard_descr` varchar( 35 ) NOT NULL default '',
`trans_id` varchar( 20 ) NOT NULL default '',
`purch_descr_input` varchar( 35 ) NOT NULL default '',
`trans_id_9` varchar( 10 ) NOT NULL default '',
`PE` varchar( 10 ) NOT NULL default '',
`f_year` varchar( 10 ) NOT NULL default '',
`record_complete` char( 1 ) NOT NULL default 'n',
`CIAD` varchar( 50 ) NOT NULL default '',
`ACCT6` varchar( 15 ) NOT NULL default '',
`CAA6` varchar( 40 ) NOT NULL default '',
`CIAA` varchar( 60 ) NOT NULL default '',
`CIA` varchar( 40 ) NOT NULL default '',
`ci` varchar( 30 ) NOT NULL default '',
`ca` varchar( 30 ) NOT NULL default '',
`ci_match` varchar( 30 ) NOT NULL default 'na',
`ca_match` varchar( 30 ) NOT NULL default 'na',
`pcard_postdate` varchar( 15 ) NOT NULL default '',
`pcard_transdate` varchar( 15 ) NOT NULL default '',
`caa6_count` decimal( 12, 0 ) NOT NULL default '0',
`center_description` varchar( 40 ) NOT NULL default '',
`section` varchar( 30 ) NOT NULL default '',
`center_vendor` varchar( 75 ) NOT NULL default '',
`f_year_funded` varchar( 10 ) NOT NULL default '',
`project_category` varchar( 5 ) NOT NULL default '',
`projcat2` char( 2 ) NOT NULL default '',
`xtid` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `xtid` ) ,
KEY `proj_num` ( `proj_num` ) ,
KEY `charg_proj_num` ( `charg_proj_num` ) ,
KEY `company` ( `company` ) ,
KEY `datenew` ( `datenew` ) ,
KEY `CIAD` ( `CIAD` ) ,
KEY `CAA6` ( `CAA6` ) ,
KEY `CIAA` ( `CIAA` ) ,
KEY `CIA` ( `CIA` ) ,
KEY `ci` ( `ci` ) ,
KEY `ca` ( `ca` ) ,
KEY `f_year` ( `f_year` ) ,
KEY `projcat` ( `projcat2` )
) ENGINE = MyISAM ";

mysqli_query($connection, $query10) or die ("Couldn't execute query 10.  $query10");


//Table backup
$query11="create table $db_backup.pcard_extract
(
`center` varchar( 12 ) NOT NULL default '',
`fund` varchar( 12 ) NOT NULL default '',
`acctdate` varchar( 8 ) NOT NULL default '',
`invoice` varchar( 100 ) NOT NULL default '',
`pe` varchar( 10 ) NOT NULL default '',
`description` varchar( 30 ) NOT NULL default '',
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
`pcard_num` varchar( 10 ) NOT NULL default '',
`pcard_user` varchar( 30 ) NOT NULL default '',
`pcard_vendor` varchar( 40 ) NOT NULL default '',
`pcard_post_date` varchar( 15 ) NOT NULL default '',
`pcard_trans_id` varchar( 15 ) NOT NULL default '',
`pcard_trans_date` varchar( 15 ) NOT NULL default '',
`pcard_company` varchar( 10 ) NOT NULL default '',
`pcard_center` varchar( 15 ) NOT NULL default '',
`pcard_amount` decimal( 12, 2 ) NOT NULL default '0.00',
`pcard_acct6` varchar( 10 ) NOT NULL default '',
`pcard_item_description` varchar( 40 ) NOT NULL default '',
`count_caa6` decimal( 10, 0 ) NOT NULL default '0',
`pcard_trans_newdate` varchar( 15 ) NOT NULL default '',
`calendar_acctdate` varchar( 15 ) NOT NULL default '',
`record_complete` char( 1 ) NOT NULL default 'n',
`pcard_num_full` varchar( 25 ) NOT NULL default '',
`count_transid` int( 10 ) NOT NULL default '0',
`correct_transid` varchar( 15 ) NOT NULL default '',
`id` int( 12 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `id` ) ,
KEY `center` ( `center` ) ,
KEY `fund` ( `fund` ) ,
KEY `acctdate` ( `acctdate` ) ,
KEY `description` ( `description` ) ,
KEY `acct` ( `acct` ) ,
KEY `f_year` ( `f_year` ) ,
KEY `dist` ( `dist` ) ,
KEY `caa6` ( `caa6` ) ,
KEY `ciad` ( `ciad` ) ,
KEY `pcard_trans_id` ( `pcard_trans_id` )
) ENGINE = MyISAM ";

mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11");


//Table backup
$query12="create table $db_backup.pcard_unreconciled
(
`location` varchar( 10 ) NOT NULL default '',
`admin_num` varchar( 10 ) NOT NULL default '',
`post_date` varchar( 15 ) NOT NULL default '',
`trans_date` varchar( 15 ) NOT NULL default '',
`amount` decimal( 12, 2 ) NOT NULL default '0.00',
`vendor_name` varchar( 40 ) NOT NULL default '',
`address` varchar( 40 ) NOT NULL default '',
`trans_id` varchar( 20 ) NOT NULL default '',
`pcard_num` varchar( 30 ) NOT NULL default '',
`xtnd_rundate` varchar( 15 ) NOT NULL default '',
`transdate_new` date NOT NULL default '0000-00-00',
`parkcode` varchar( 10 ) NOT NULL default '',
`cardholder` varchar( 75 ) NOT NULL default '',
`transid_new` varchar( 15 ) NOT NULL default '',
`postdate_new` date NOT NULL default '0000-00-00',
`xtnd_rundate_new` date NOT NULL default '0000-00-00',
`item_purchased` varchar( 100 ) NOT NULL default '',
`ncasnum` varchar( 15 ) NOT NULL default '',
`center` varchar( 15 ) NOT NULL default '',
`park_recondate` date NOT NULL default '0000-00-00',
`budget2controllers` date NOT NULL default '0000-00-00',
`post2ncas` date NOT NULL default '0000-00-00',
`company` varchar( 10 ) NOT NULL default '',
`projnum` varchar( 15 ) NOT NULL default '',
`equipnum` varchar( 15 ) NOT NULL default '',
`budget_ok` char( 1 ) NOT NULL default 'n',
`reconciled` char( 1 ) NOT NULL default '',
`reconcilement_date` date NOT NULL default '0000-00-00',
`recon_complete` char( 1 ) NOT NULL default '',
`ncas_description` varchar( 50 ) NOT NULL default '',
`report_date` date NOT NULL default '0000-00-00',
`ca` varchar( 30 ) NOT NULL default '',
`count_amount` varchar( 30 ) NOT NULL default '',
`ca_count_posted` varchar( 30 ) NOT NULL default '',
`ca_count_unposted` decimal( 5, 0 ) NOT NULL default '0',
`f_year` varchar( 5 ) NOT NULL default '',
`ncas_yn` char( 1 ) NOT NULL default 'n',
`travel` char( 1 ) NOT NULL default 'n',
`transid_date_count` char( 1 ) NOT NULL default 'n',
`caa` varchar( 60 ) NOT NULL default '',
`charge_year` varchar( 10 ) NOT NULL default '',
`pce_match` char( 1 ) NOT NULL default 'n',
`pa_number` varchar( 10 ) NOT NULL default '',
`re_number` varchar( 10 ) NOT NULL default '',
`last_name` varchar( 35 ) NOT NULL default '',
`first_name` varchar( 35 ) NOT NULL default '',
`utility` char( 1 ) NOT NULL default 'n',
`code_1099` varchar( 4 ) NOT NULL default '',
`id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `id` ) ,
UNIQUE KEY `trans_id` ( `trans_id` , `trans_date` ) ,
KEY `transid_new` ( `transid_new` ) ,
KEY `amount` ( `amount` ) ,
KEY `center_amount` ( `ca` ) ,
KEY `pa_number` ( `pa_number` ) ,
KEY `re_number` ( `re_number` ) ,
KEY `location` ( `location` ) ,
KEY `admin_num` ( `admin_num` ) ,
KEY `parkcode` ( `parkcode` ) ,
KEY `center` ( `center` ) ,
KEY `report_date` ( `report_date` ) ,
KEY `pcard_num` ( `pcard_num` ) ,
KEY `ncasnum` ( `ncasnum` )
) ENGINE = MyISAM" ;

mysqli_query($connection, $query12) or die ("Couldn't execute query 12.  $query12");


//Table backup
$query13="create table $db_backup.warehouse_billings_2
(
`InvoiceNum` varchar( 24 ) NOT NULL default '',
`Center` varchar( 10 ) NOT NULL default '',
`ProductNum_0405` varchar( 8 ) NOT NULL default '',
`ProductName` varchar( 30 ) NOT NULL default '',
`Price` decimal( 8, 2 ) NOT NULL default '0.00',
`Quantity` int( 9 ) NOT NULL default '0',
`PricexQuantity` decimal( 12, 2 ) NOT NULL default '0.00',
`acct` varchar( 15 ) NOT NULL default '',
`Date_mmmyy` varchar( 8 ) NOT NULL default '',
`post_date` varchar( 10 ) NOT NULL default '',
`f_year` varchar( 10 ) NOT NULL default '',
`invoice_new` varchar( 100 ) NOT NULL default '',
`wbid` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `wbid` ) ,
KEY `Center` ( `Center` ) ,
KEY `NcasNum` ( `acct` )
) ENGINE = MyISAM ";

mysqli_query($connection, $query13) or die ("Couldn't execute query 13.  $query13");

//Table backup
$query14="
create table $db_backup.xtnd_ci_monthly
(
`bc` varchar( 10 ) NOT NULL default '',
`fund` varchar( 10 ) NOT NULL default '',
`fund_des` varchar( 50 ) NOT NULL default '',
`ncasnum` varchar( 14 ) NOT NULL default '',
`ncasnum_des` varchar( 30 ) NOT NULL default '',
`budget_amt` decimal( 12, 2 ) NOT NULL default '0.00',
`unalloted` decimal( 12, 2 ) NOT NULL default '0.00',
`alloted` decimal( 12, 2 ) NOT NULL default '0.00',
`current_exp` decimal( 12, 2 ) NOT NULL default '0.00',
`ytd_exp` decimal( 12, 2 ) NOT NULL default '0.00',
`ptd_exp` decimal( 12, 2 ) NOT NULL default '0.00',
`allotment_bal` decimal( 12, 2 ) NOT NULL default '0.00',
`acct_cat` char( 3 ) NOT NULL default '',
`ytd_post_date` date NOT NULL default '0000-00-00',
`revenues` decimal( 12, 2 ) NOT NULL default '0.00',
`expenditures` decimal( 12, 2 ) NOT NULL default '0.00',
`funding_receipt` decimal( 12, 2 ) NOT NULL default '0.00',
`funding_disburse` decimal( 12, 2 ) NOT NULL default '0.00',
`cash_type` varchar( 15 ) NOT NULL default '',
`valid_acct` char( 1 ) NOT NULL default '',
`id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `id` )
) ENGINE = MyISAM ";

mysqli_query($connection, $query14) or die ("Couldn't execute query 14.  $query14");


//Table backup
$query15="create table $db_backup.xtnd_po_encumbrances
(
`center` varchar( 15 ) NOT NULL default '',
`buying_entity` varchar( 10 ) NOT NULL default '',
`po_number` varchar( 20 ) NOT NULL default '',
`blanket_release_number` varchar( 20 ) NOT NULL default '',
`po_line_number` varchar( 10 ) NOT NULL default '',
`vendor_short_name` varchar( 30 ) NOT NULL default '',
`first_line_item_description` varchar( 100 ) NOT NULL default '',
`PO_remaining_encumbrance` decimal( 12, 2 ) NOT NULL default '0.00',
`PO_line_entered_date` varchar( 15 ) NOT NULL default '',
`acct` varchar( 15 ) NOT NULL default '',
`balance_date` varchar( 15 ) NOT NULL default '',
`datenew` varchar( 15 ) NOT NULL default '',
`ponum_line` varchar( 30 ) NOT NULL default '',
`enter_date_new` date NOT NULL default '0000-00-00',
`id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `id` ) ,
KEY `po_number` ( `po_number` ) ,
KEY `ponum_line` ( `ponum_line` )
) ENGINE = MyISAM ";

mysqli_query($connection, $query15) or die ("Couldn't execute query 15.  $query15");

//Table backup
$query16="create table $db_backup.manual_allocations_3
(
`allocation_number` varchar( 10 ) NOT NULL default '',
`allocation_amount` decimal( 12, 2 ) NOT NULL default '0.00',
`center` varchar( 15 ) NOT NULL default '',
`ncas_number` varchar( 15 ) NOT NULL default '',
`f_year` varchar( 10 ) NOT NULL default '',
`allocation_date` date NOT NULL default '0000-00-00',
`justification` varchar( 255 ) NOT NULL default '',
`approved` char( 1 ) NOT NULL default 'n',
`budget_group` varchar( 30 ) NOT NULL default '',
`cash_type` varchar( 20 ) NOT NULL default '',
`id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `id` ) ,
KEY `f_year` ( `f_year` )
) ENGINE = MyISAM PACK_KEYS =0";


mysqli_query($connection, $query16) or die ("Couldn't execute query 16.  $query16");

//Table backup
$query17="create table $db_backup.opexpense_request_3
(
`park` varchar( 15 ) NOT NULL default '',
`Increase_Justification` text NOT NULL ,
`requested_increase` decimal( 12, 2 ) NOT NULL default '0.00',
`district_change` decimal( 12, 2 ) NOT NULL default '0.00',
`division_change` decimal( 12, 2 ) NOT NULL default '0.00',
`division_approved` char( 1 ) NOT NULL default 'u',
`Center` varchar( 15 ) NOT NULL default '',
`acct` varchar( 15 ) NOT NULL default '',
`f_year` varchar( 10 ) NOT NULL default '',
`status` varchar( 15 ) NOT NULL default 'pending',
`district_approved` char( 1 ) NOT NULL default 'u',
`district` varchar( 15 ) NOT NULL default '',
`id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `id` ) ,
UNIQUE KEY `center_acct_fyear` ( `Center` , `acct` , `f_year` ) ,
KEY `f_year` ( `f_year` )
) ENGINE = MyISAM ";

mysqli_query($connection, $query17) or die ("Couldn't execute query 17.  $query17");

//Table backup
$query18="create table $db_backup.approved_grants_3
(
`park` varchar( 15 ) NOT NULL default '',
`Increase_Justification` text NOT NULL ,
`requested_increase` decimal( 12, 2 ) NOT NULL default '0.00',
`district_change` decimal( 12, 2 ) NOT NULL default '0.00',
`division_change` decimal( 12, 2 ) NOT NULL default '0.00',
`division_approved` char( 1 ) NOT NULL default 'u',
`Center` varchar( 15 ) NOT NULL default '',
`acct` varchar( 15 ) NOT NULL default '',
`f_year` varchar( 10 ) NOT NULL default '',
`status` varchar( 15 ) NOT NULL default 'pending',
`district_approved` char( 1 ) NOT NULL default 'u',
`district` varchar( 15 ) NOT NULL default '',
`id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `id` ) ,
UNIQUE KEY `center_acct_fyear` ( `Center` , `acct` , `f_year` ) ,
KEY `f_year` ( `f_year` )
) ENGINE = MyISAM" ;


mysqli_query($connection, $query18) or die ("Couldn't execute query 18.  $query18");



//Table backup
$query19="create table $db_backup.opexpense_transfers_4
(
`transfer_request` decimal( 12, 2 ) NOT NULL default '0.00',
`center` varchar( 15 ) NOT NULL default '',
`ncas_number` varchar( 15 ) NOT NULL default '',
`f_year` varchar( 10 ) NOT NULL default '',
`transfer_date` date NOT NULL default '0000-00-00',
`status` varchar( 15 ) NOT NULL default 'not_processed',
`user_id` varchar( 30 ) NOT NULL default '',
`source` varchar( 15 ) NOT NULL default '',
`id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `id` )
) ENGINE = MyISAM" ;

mysqli_query($connection, $query19) or die ("Couldn't execute query 19.  $query19");

//Table backup
$query20="create table $db_backup.exp_rev_down
(
`center` varchar( 12 ) NOT NULL default '',
`fund` varchar( 12 ) NOT NULL default '',
`acctdate` varchar( 8 ) NOT NULL default '',
`invoice` varchar( 100 ) NOT NULL default '',
`pe` varchar( 10 ) NOT NULL default '',
`description` varchar( 30 ) NOT NULL default '',
`debit` decimal( 12, 2 ) NOT NULL default '0.00',
`credit` decimal( 12, 2 ) NOT NULL default '0.00',
`sys` varchar( 12 ) NOT NULL default '',
`acct` varchar( 16 ) NOT NULL default '',
`f_year` varchar( 4 ) NOT NULL default '',
`dist` varchar( 4 ) NOT NULL default '',
`whid` int( 12 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `whid` ) ,
KEY `center` ( `center` ) ,
KEY `fund` ( `fund` ) ,
KEY `acctdate` ( `acctdate` ) ,
KEY `description` ( `description` ) ,
KEY `acct` ( `acct` ) ,
KEY `f_year` ( `f_year` ) ,
KEY `dist` ( `dist` )
) ENGINE = MyISAM ";

mysqli_query($connection, $query20) or die ("Couldn't execute query 20.  $query20");


//Table backup
$query21="
create table $db_backup.exp_rev_20100421
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

mysqli_query($connection, $query21) or die ("Couldn't execute query 21.  $query21");

//Table backup
$query22="create table $db_backup.partf_projects
(
`projNum` varchar( 4 ) NOT NULL default '',
`projYN` char( 1 ) NOT NULL default '',
`reportDisplay` char( 1 ) NOT NULL default '',
`projCat` char( 2 ) NOT NULL default '',
`projSCnum` varchar( 10 ) NOT NULL default '',
`projDENRnum` varchar( 11 ) NOT NULL default '',
`Center` varchar( 10 ) NOT NULL default '',
`budgCode` varchar( 5 ) NOT NULL default '',
`comp` varchar( 4 ) NOT NULL default '',
`projsup` varchar( 35 ) NOT NULL default '',
`manager` varchar( 30 ) NOT NULL default '',
`fundMan` varchar( 35 ) NOT NULL default '',
`YearFundC` varchar( 4 ) NOT NULL default '',
`YearFundF` varchar( 6 ) NOT NULL default '',
`fullname` varchar( 35 ) NOT NULL default '',
`dist` varchar( 20 ) NOT NULL default '',
`county` varchar( 25 ) NOT NULL default '',
`section` varchar( 25 ) NOT NULL default '',
`park` varchar( 4 ) NOT NULL default '',
`projName` varchar( 255 ) NOT NULL default '',
`active` char( 1 ) NOT NULL default '',
`startDate` varchar( 14 ) NOT NULL default '',
`pj_timestamp` timestamp( 14 ) NOT NULL ,
`endDate` varchar( 14 ) NOT NULL default '',
`trackEndDate` varchar( 14 ) NOT NULL default '',
`statusProj` varchar( 7 ) NOT NULL default '',
`percentCom` char( 3 ) NOT NULL default '',
`statusPer` varchar( 6 ) NOT NULL default 'ns',
`comments` text NOT NULL ,
`commentsI` text NOT NULL ,
`dateadded` varchar( 14 ) NOT NULL default '',
`brucefy` varchar( 5 ) NOT NULL default '',
`proj_man` char( 3 ) NOT NULL default '',
`secondCounty` varchar( 15 ) NOT NULL default '',
`div_app_amt` decimal( 12, 2 ) NOT NULL default '0.00',
`res_proj` char( 1 ) NOT NULL default '',
`partfyn` char( 1 ) NOT NULL default '',
`partf_approv_num` varchar( 4 ) NOT NULL default '',
`femayn` char( 1 ) NOT NULL default '',
`fema_proj_num` varchar( 6 ) NOT NULL default '',
`mult_proj` char( 1 ) NOT NULL default '',
`bond_fund` char( 1 ) NOT NULL default '',
`state_appro` char( 1 ) NOT NULL default '',
`reserve_proj` char( 1 ) NOT NULL default '',
`cwmtf_fund` char( 1 ) NOT NULL default '',
`design` char( 3 ) NOT NULL default '0',
`construction` char( 3 ) NOT NULL default '0',
`showpa` char( 1 ) NOT NULL default '',
`user_id` varchar( 35 ) NOT NULL default '',
`project_center_year_type` varchar( 60 ) NOT NULL default '',
`center_year_type` varchar( 30 ) NOT NULL default '',
`app_amt_052307` decimal( 12, 2 ) NOT NULL default '0.00',
`gis_tract_num` varchar( 50 ) NOT NULL default '',
`loi_lt` varchar( 30 ) NOT NULL default '',
`spo_number` varchar( 30 ) NOT NULL default '',
`acres` decimal( 12, 4 ) NOT NULL default '0.0000',
`est_amt` decimal( 12, 2 ) NOT NULL default '0.00',
`po1_po2` varchar( 30 ) NOT NULL default '',
`cos` varchar( 30 ) NOT NULL default '',
`closed` varchar( 30 ) NOT NULL default '',
`land_status` varchar( 30 ) NOT NULL default '',
`centers_used` varchar( 75 ) NOT NULL default '',
`partfid` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `partfid` ) ,
UNIQUE KEY `projNum` ( `projNum` ) ,
KEY `park` ( `park` ) ,
KEY `manager` ( `manager` ) ,
KEY `projCat` ( `projCat` ) ,
KEY `budgCode` ( `budgCode` )
) ENGINE = MyISAM COMMENT = 'flds statusProj, percentComm not used'";

mysqli_query($connection, $query22) or die ("Couldn't execute query 22.  $query22");


//Table backup
$query23="create table $db_backup.xtnd_vendor_payments
(
`company` varchar( 10 ) NOT NULL default '',
`fund` varchar( 10 ) NOT NULL default '',
`rcc` varchar( 10 ) NOT NULL default '',
`account` varchar( 15 ) NOT NULL default '',
`date` varchar( 15 ) NOT NULL default '',
`checknum` varchar( 20 ) NOT NULL default '',
`invoice` varchar( 50 ) NOT NULL default '',
`amount` decimal( 12, 2 ) NOT NULL default '0.00',
`vendor_num` varchar( 15 ) NOT NULL default '',
`group_num` varchar( 10 ) NOT NULL default '',
`vendor_name` varchar( 75 ) NOT NULL default '',
`po_number` varchar( 30 ) NOT NULL default '',
`po_line` varchar( 10 ) NOT NULL default '',
`center` varchar( 20 ) NOT NULL default '',
`f_year` varchar( 5 ) NOT NULL default '',
`datenew` varchar( 8 ) NOT NULL default '',
`xtnd_date` date NOT NULL default '0000-00-00',
`id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `id` ) ,
KEY `po_number` ( `po_number` )
) ENGINE = MyISAM ";

mysqli_query($connection, $query23) or die ("Couldn't execute query 23.  $query23");


//Table backup
$query24="create table $db_backup.beacon_payments
(
`location_id` varchar( 30 ) NOT NULL default '',
`location_name` varchar( 75 ) NOT NULL default '',
`employee_id` varchar( 20 ) NOT NULL default '',
`employee_name` varchar( 75 ) NOT NULL default '',
`account` varchar( 15 ) NOT NULL default '',
`account_name` varchar( 75 ) NOT NULL default '',
`amount` decimal( 12, 2 ) NOT NULL default '0.00',
`org_unit` varchar( 30 ) NOT NULL default '',
`payment_date` date NOT NULL default '0000-00-00',
`f_year` varchar( 4 ) NOT NULL default '',
`center` varchar( 30 ) NOT NULL default '',
`source` varchar( 30 ) NOT NULL default '',
`temp_payroll_valid` char( 1 ) NOT NULL default 'n',
`location_id_last4` varchar( 10 ) NOT NULL default '',
`dpr_employee` char( 1 ) NOT NULL default '',
`employee_number_center` varchar( 70 ) NOT NULL default '',
`valid_entry` char( 1 ) NOT NULL default '',
`position_number` varchar( 50 ) NOT NULL default '',
`center_code` varchar( 4 ) NOT NULL default '',
`posnum_center` varchar( 60 ) NOT NULL default '',
`correcting_entry` char( 1 ) NOT NULL default 'n',
`adjustment_number` varchar( 10 ) NOT NULL default '',
`adjustment_date` date NOT NULL default '0000-00-00',
`adjustment_type` varchar( 30 ) NOT NULL default '',
`hrdb` char( 1 ) NOT NULL default 'n',
`id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `id` ) ,
KEY `employee_number_center` ( `employee_number_center` ) ,
KEY `center` ( `center` ) ,
KEY `posnum_center` ( `posnum_center` ) ,
KEY `employee_id` ( `employee_id` )
) ENGINE = MyISAM" ;

mysqli_query($connection, $query24) or die ("Couldn't execute query 24.  $query24");


//Table backup
$query25="create table $db_backup.coa
(
`ncasNum` varchar( 20 ) NOT NULL default '',
`description` varchar( 75 ) NOT NULL default '',
`park_acct_desc` varchar( 75 ) NOT NULL default '',
`acct_cat` char( 3 ) NOT NULL default '',
`cash_type` varchar( 10 ) NOT NULL default '',
`acct_group` varchar( 100 ) NOT NULL default '',
`comment` text NOT NULL ,
`track_rcc` char( 1 ) NOT NULL default 'n',
`series` char( 3 ) NOT NULL default '',
`valid_cdcs` char( 1 ) NOT NULL default 'n',
`valid_osc` char( 1 ) NOT NULL default 'n',
`valid_div` char( 1 ) NOT NULL default 'n',
`valid_ci` char( 1 ) NOT NULL default 'n',
`valid_1280` char( 1 ) NOT NULL default '',
`dateM` timestamp( 14 ) NOT NULL ,
`fseries` varchar( 4 ) NOT NULL default '',
`fseries_descript` varchar( 50 ) NOT NULL default '',
`acct_cat_group` varchar( 50 ) NOT NULL default '',
`budget_group` varchar( 30 ) NOT NULL default '',
`IT` char( 1 ) NOT NULL default 'n',
`ZBA` char( 1 ) NOT NULL default 'n',
`repair` char( 1 ) NOT NULL default 'n',
`contract` char( 1 ) NOT NULL default 'n',
`travel` char( 1 ) NOT NULL default 'n',
`description2` varchar( 75 ) NOT NULL default '',
`user_id2` varchar( 40 ) NOT NULL default '',
`view` char( 3 ) NOT NULL default '',
`cab_bd725` char( 1 ) NOT NULL default '',
`track_center` char( 1 ) NOT NULL default 'n',
`energy` char( 1 ) NOT NULL default 'n',
`utility` char( 1 ) NOT NULL default 'n',
`carol_class` varchar( 20 ) NOT NULL default '',
`useful_life_years` varchar( 5 ) NOT NULL default '',
`taxable` char( 1 ) NOT NULL default 'n',
`coaid` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `coaid` ) ,
UNIQUE KEY `ncasNum` ( `ncasNum` ) ,
KEY `budget_group` ( `budget_group` )
) ENGINE = MyISAM ";

mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");


//Table backup
$query26="create table $db_backup.center
(
`rcc` varchar( 4 ) NOT NULL default '',
`fund` varchar( 5 ) NOT NULL default '',
`center` varchar( 8 ) NOT NULL default '',
`center_desc` varchar( 50 ) NOT NULL default '',
`budCode` varchar( 15 ) NOT NULL default '',
`company` varchar( 4 ) NOT NULL default '',
`actCenterYN` char( 1 ) NOT NULL default '',
`XTND_cip` char( 1 ) NOT NULL default '',
`CYinitFund` varchar( 4 ) NOT NULL default '',
`parkCode` varchar( 4 ) NOT NULL default '',
`dist` varchar( 5 ) NOT NULL default '',
`section` varchar( 20 ) NOT NULL default '',
`division` varchar( 15 ) NOT NULL default '',
`stateParkYN` char( 1 ) NOT NULL default '',
`CenterMan` varchar( 35 ) NOT NULL default '',
`distMan` varchar( 35 ) NOT NULL default '',
`sectMan` varchar( 35 ) NOT NULL default '',
`divMan` varchar( 35 ) NOT NULL default '',
`center_num_name_year` varchar( 75 ) NOT NULL default '',
`f_year_funded` varchar( 10 ) NOT NULL default '',
`section_district` varchar( 50 ) NOT NULL default '',
`match_cibd725_table` char( 1 ) NOT NULL default '',
`XTND_location` varchar( 15 ) NOT NULL default '',
`TYPE` varchar( 15 ) NOT NULL default '',
`OD_OK` char( 1 ) NOT NULL default 'n',
`OA_name` varchar( 50 ) NOT NULL default '',
`centerman_email` varchar( 50 ) NOT NULL default '',
`OA_email` varchar( 50 ) NOT NULL default '',
`section_park_center` varchar( 50 ) NOT NULL default '',
`part_fun_perc` decimal( 5, 4 ) NOT NULL default '0.0000',
`fema_fun_perc` decimal( 5, 4 ) NOT NULL default '0.0000',
`bond_fun_perc` decimal( 5, 4 ) NOT NULL default '0.0000',
`appr_fun_perc` decimal( 5, 4 ) NOT NULL default '0.0000',
`cwmt_fun_perc` decimal( 5, 4 ) NOT NULL default '0.0000',
`ci_perc` decimal( 5, 4 ) NOT NULL default '0.0000',
`de_perc` decimal( 5, 4 ) NOT NULL default '0.0000',
`en_perc` decimal( 5, 4 ) NOT NULL default '0.0000',
`er_perc` decimal( 5, 4 ) NOT NULL default '0.0000',
`la_perc` decimal( 5, 4 ) NOT NULL default '0.0000',
`mi_perc` decimal( 5, 4 ) NOT NULL default '0.0000',
`mm_perc` decimal( 5, 4 ) NOT NULL default '0.0000',
`tm_perc` decimal( 5, 4 ) NOT NULL default '0.0000',
`project_type` varchar( 20 ) NOT NULL default '',
`ceid` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `ceid` ) ,
UNIQUE KEY `center` ( `center` ) ,
KEY `CenterMan` ( `CenterMan` ) ,
KEY `fund` ( `fund` )
) ENGINE = MyISAM ";

mysqli_query($connection, $query26) or die ("Couldn't execute query 26.  $query26");

//Table backup
$query27="create table $db_backup.reversions
(
`account` varchar( 75 ) NOT NULL default '',
`account_description` varchar( 75 ) NOT NULL default '',
`authorized` decimal( 12, 2 ) NOT NULL default '0.00',
`spent` decimal( 12, 2 ) NOT NULL default '0.00',
`balance` decimal( 12, 2 ) NOT NULL default '0.00',
`reversions` decimal( 12, 2 ) NOT NULL default '0.00',
`new_balances` decimal( 12, 2 ) NOT NULL default '0.00',
`valid_account` char( 1 ) NOT NULL default '',
`f_year` varchar( 4 ) NOT NULL default '',
`fund` varchar( 4 ) NOT NULL default '',
`budget_group` varchar( 30 ) NOT NULL default '',
`old_amount` decimal( 12, 2 ) NOT NULL default '0.00',
`change_amount` decimal( 12, 2 ) NOT NULL default '0.00',
`id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `id` ) ,
UNIQUE KEY `account` ( `account` , `f_year` )
) ENGINE = MyISAM ";

mysqli_query($connection, $query27) or die ("Couldn't execute query 27.  $query27");

//Table backup
$query28="create table $db_backup.purchase_request_3
(
`location` varchar( 15 ) NOT NULL default '',
`purchase_description` text NOT NULL ,
`justification` text NOT NULL ,
`funding_source` varchar( 15 ) NOT NULL default '',
`disu_ranking` varchar( 10 ) NOT NULL default '',
`requested_amount` decimal( 12, 2 ) NOT NULL default '0.00',
`district_approved` char( 1 ) NOT NULL default 'u',
`section_approved` char( 1 ) NOT NULL default 'u',
`division_approved` char( 1 ) NOT NULL default 'u',
`original_approved` char( 1 ) NOT NULL default '',
`purchaser` varchar( 50 ) NOT NULL default '',
`date_approved` varchar( 50 ) NOT NULL default '',
`ordered_amount` decimal( 12, 2 ) NOT NULL default '0.00',
`pricing_source` varchar( 100 ) NOT NULL default '',
`pay_center` varchar( 15 ) NOT NULL default '',
`ncas_account` varchar( 15 ) NOT NULL default 'na',
`f_year` varchar( 10 ) NOT NULL default '',
`pa_number` int( 11 ) NOT NULL default '0',
`status` varchar( 15 ) NOT NULL default 'active',
`order_complete` char( 1 ) NOT NULL default 'n',
`Paid_in_Full` char( 1 ) NOT NULL default 'n',
`disu_priority` varchar( 15 ) NOT NULL default '',
`comments` varchar( 100 ) NOT NULL default '',
`receive_complete` char( 1 ) NOT NULL default 'n',
`district` varchar( 20 ) NOT NULL default '',
`center_code` varchar( 15 ) NOT NULL default '',
`original_amount` decimal( 12, 2 ) NOT NULL default '0.00',
`allocation_type` varchar( 30 ) NOT NULL default '',
`system_entry_date` date NOT NULL default '0000-00-00',
`pasu_priority` varchar( 15 ) NOT NULL default '',
`user_id` varchar( 30 ) NOT NULL default '',
`unit_quantity` int( 5 ) NOT NULL default '0',
`category` varchar( 50 ) NOT NULL default '',
`unit_cost` decimal( 12, 2 ) NOT NULL default '0.00',
`po_number` varchar( 20 ) NOT NULL default '',
`valid_acct` char( 1 ) NOT NULL default '',
`valid_center` char( 1 ) NOT NULL default '',
`purchase_type` varchar( 20 ) NOT NULL default '',
`puof_approved` char( 1 ) NOT NULL default 'u',
`itma_approved` char( 1 ) NOT NULL default 'u',
`pasu_ranking` tinyint( 4 ) NOT NULL default '0',
`payments_entered` decimal( 12, 2 ) NOT NULL default '0.00',
`order_number` int( 10 ) NOT NULL default '0',
`email_confirmation` varchar( 40 ) NOT NULL default '',
`bo_comments` text NOT NULL ,
`report_date` date NOT NULL default '0000-00-00',
`purchase_date` date NOT NULL default '0000-00-00',
`section` varchar( 30 ) NOT NULL default '',
`disu_comments` text NOT NULL ,
`account_description` varchar( 75 ) NOT NULL default '',
`osbm_approved` char( 1 ) NOT NULL default 'u',
`re_number` varchar( 10 ) NOT NULL default '',
`center_description` varchar( 50 ) NOT NULL default '',
`id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `id` ) ,
UNIQUE KEY `pa_number` ( `pa_number` ) ,
KEY `pa_number_2` ( `pa_number` )
) ENGINE = MyISAM PACK_KEYS =1";

mysqli_query($connection, $query28) or die ("Couldn't execute query 28.  $query28");


//Table backup
$query29="create table $db_backup.pcard_utility_xtnd_1646
(
`card4` varchar( 10 ) NOT NULL default '',
`last_name` varchar( 30 ) NOT NULL default '',
`vendor` varchar( 75 ) NOT NULL default '',
`postdate` varchar( 20 ) NOT NULL default '',
`transid` varchar( 20 ) NOT NULL default '',
`transdate` varchar( 20 ) NOT NULL default '',
`company` varchar( 10 ) NOT NULL default '',
`account` varchar( 15 ) NOT NULL default '',
`center` varchar( 15 ) NOT NULL default '',
`trans_amount` decimal( 12, 2 ) NOT NULL default '0.00',
`xtnd_date` date NOT NULL default '0000-00-00',
`f_year` varchar( 4 ) NOT NULL default '',
`id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `id` )
) ENGINE = MyISAM ";

mysqli_query($connection, $query29) or die ("Couldn't execute query 29.  $query29");

$query30="update budget.weekly_updates_steps_detail set status='complete' 
          where step_group='b' and step_num='1' ";
		  
		  
mysqli_query($connection, $query30) or die ("Couldn't execute query 30.  $query30");
////mysql_close();

header("location: step_groupb.php?fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");

?>