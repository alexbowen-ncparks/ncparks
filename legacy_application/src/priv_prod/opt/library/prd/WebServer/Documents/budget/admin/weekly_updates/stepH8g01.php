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
//echo "end_date=$end_date";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

$query1="truncate table budget1_unposted_weekly;
";
mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

$query2="
insert into budget1_unposted_weekly( center, account, vendor_name, transaction_date, transaction_number, 
transaction_amount, transaction_type, source_table, source_id,system_entry_date ) 
select ncas_center, ncas_account, vendor_name, datesql, ncas_invoice_number, 
ncas_invoice_amount,'cdcs','cid_vendor_invoice_payments', id,system_entry_date 
from cid_vendor_invoice_payments where 1 and post2ncas != 'y' and ncas_credit != 'x' group by id;
";
mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");

$query3="
insert into budget1_unposted_weekly( center, account, vendor_name, transaction_date, transaction_number,
 transaction_amount, transaction_type, source_table, source_id,system_entry_date ) 
 select ncas_center, ncas_account, vendor_name, datesql, ncas_invoice_number, -ncas_invoice_amount, 
 'cdcs', 'cid_vendor_invoice_payments', id, system_entry_date 
 from cid_vendor_invoice_payments where 1 and post2ncas != 'y' and ncas_credit = 'x' group by id; 
";
mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");

$query4="
insert into budget1_unposted_weekly( center, account, vendor_name, transaction_date, 
transaction_number, transaction_amount, transaction_type, source_table, source_id,system_entry_date )
 select center, ncasnum, concat('pcard','-',cardholder,'-',vendor_name,'-',trans_date),
 transdate_new, transid_new, sum(amount),'pcard','pcard_unreconciled', id,xtnd_rundate_new 
 from pcard_unreconciled where 1 and ncas_yn != 'y' group by id;
";
mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");

$query5="
update budget1_unposted_weekly,coa set budget1_unposted_weekly.budget_group=coa.budget_group 
where budget1_unposted_weekly.account=coa.ncasnum;
";
mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");

$query6="
update budget1_unposted_weekly,center set budget1_unposted_weekly.park=center.parkcode 
where budget1_unposted_weekly.center=center.center;
";
mysqli_query($connection, $query6) or die ("Couldn't execute query 6. $query6");


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

























