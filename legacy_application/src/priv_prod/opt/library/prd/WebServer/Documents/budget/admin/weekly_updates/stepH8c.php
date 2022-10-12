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
//$start_date=str_replace("-","",$start_date);
//$end_date=str_replace("-","",$end_date);
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date";
//$end_date_p1=$end_date-1;
//echo "<br />"; 
//echo "end_date_p1=$end_date_p1";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);
$end_date_p1=$end_date-1;


$query1="truncate table cvip_unmatched;
";
mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

$query2="insert into cvip_unmatched
(
center,
park,
account,
vendor,
invoice,
amount,
cvip_id,ncasnum,
system_entry_date,
ncas_invoice_date
)
select 
cid_vendor_invoice_payments.ncas_center,
center.parkcode,
concat(coa.ncasnum,'-',coa.park_acct_desc) as 'account',
cid_vendor_invoice_payments.vendor_name,
cid_vendor_invoice_payments.ncas_invoice_number,
cid_vendor_invoice_payments.ncas_invoice_amount,
cid_vendor_invoice_payments.id,
cid_vendor_invoice_payments.ncas_account,
cid_vendor_invoice_payments.system_entry_date,
cid_vendor_invoice_payments.ncas_invoice_date
from cid_vendor_invoice_payments
left join center on cid_vendor_invoice_payments.ncas_center=center.center
left join coa on cid_vendor_invoice_payments.ncas_account=coa.ncasnum
where 1
and cid_vendor_invoice_payments.post2ncas != 'y'
and cid_vendor_invoice_payments.temp_match != 'y'
and system_entry_date <=
'$end_date_p1'
and ncas_account like '53%'
and ncas_center != '1932'
order by ncas_center,cid_vendor_invoice_payments.vendor_name;
";
mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");

$query3="update cvip_unmatched,cid_vendor_invoice_payments
set cvip_unmatched.amount= -(cvip_unmatched.amount)
where cvip_unmatched.cvip_id=cid_vendor_invoice_payments.id
and cid_vendor_invoice_payments.ncas_credit='x';
";
mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");



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

























