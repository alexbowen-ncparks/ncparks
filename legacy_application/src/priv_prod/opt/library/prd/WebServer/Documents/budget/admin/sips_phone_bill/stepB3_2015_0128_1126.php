<?php
//ini_set('display_errors',1);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
$end_date=str_replace("-","",$end_date);
//echo $end_date; exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
//echo "tempid=$tempid<br />";



$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters




$query18="insert into cid_vendor_invoice_payments
(prefix,ncas_number,ncas_account,ncas_budget_code,prepared_by,prepared_date,ncas_company,ncas_invoice_date,datesql,system_entry_date,
 due_date,ncas_invoice_number,ncas_invoice_amount,invoice_total,ncas_remit_code,vendor_name,vendor_address,
 pay_entity,vendor_number,group_number,user_id,parkcode,ncas_fund,ncas_rcc,ncas_center,received_by)
 
 select prefix,ncas_number,ncas_account,ncas_budget_code,prepared_by,prepared_date,ncas_company,ncas_invoice_date,datesql,system_entry_date,
 due_date,ncas_invoice_number,sum(ncas_invoice_amount),sum(invoice_total),ncas_remit_code,vendor_name,vendor_address,
 pay_entity,vendor_number,group_number,user_id,parkcode,ncas_fund,ncas_rcc,ncas_center,received_by
 
 from sips_phone_bill4
 where 1
 group by ncas_account,ncas_center
 order by ncas_account,ncas_center
 "; 
 
	
$result18=mysql_query($query18) or die ("Couldn't execute query 18.  $query18");


$query18a="insert ignore into sips_phone_bill4_perm
(center,account,service,invoice_num,invoice_date,amount,playstation,prefix,ncas_number,ncas_account,ncas_budget_code,prepared_by,prepared_date,ncas_company,ncas_invoice_date,datesql,system_entry_date,
 due_date,ncas_invoice_number,ncas_invoice_amount,invoice_total,ncas_remit_code,vendor_name,vendor_address,
 pay_entity,vendor_number,group_number,user_id,parkcode,ncas_fund,ncas_rcc,ncas_center,received_by)
 
 select center,account,service,invoice_num,invoice_date,amount,playstation,prefix,ncas_number,ncas_account,ncas_budget_code,prepared_by,prepared_date,ncas_company,ncas_invoice_date,datesql,system_entry_date,due_date,ncas_invoice_number,sum(ncas_invoice_amount),sum(invoice_total),ncas_remit_code,vendor_name,vendor_address, pay_entity,vendor_number,group_number,user_id,parkcode,ncas_fund,ncas_rcc,ncas_center,received_by 
 from sips_phone_bill4
 where 1 group by id
 "; 
 
		 

$result18a=mysql_query($query18a) or die ("Couldn't execute query 18a.  $query18a");





/*
$query16b="";

$result16b=mysql_query($query16b) or die ("Couldn't execute query 16b.  $query16b");



$query16c="";

$result16c=mysql_query($query16c) or die ("Couldn't execute query 16c.  $query16c");


$query16d="";

$result16d=mysql_query($query16d) or die ("Couldn't execute query 16d.  $query16d");


$query16e="";

$result16e=mysql_query($query16e) or die ("Couldn't execute query 16e.  $query16e");


*/



$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysql_query($query23a) or die ("Couldn't execute query 23a.  $query23a");

/*

$query24="select * from budget.project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result24=mysql_query($query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysql_num_rows($result24);
//echo "num24=$num24";exit;
//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num24==0)

{$query25="update budget.project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysql_query($query25) or die ("Couldn't execute query 25.  $query25");}

*/
mysql_close();
/*
if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0) 
//{echo "num24 not equal to zero";}
*/
{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&report=y&report_type=form ");}

 ?>




















