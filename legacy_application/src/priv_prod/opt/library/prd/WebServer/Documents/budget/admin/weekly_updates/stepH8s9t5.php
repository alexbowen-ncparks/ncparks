<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<h2><font color='red'>FIX Query Tony 4/19/13</font></h2>";
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
//echo "fiscal_year=$fiscal_year<br />start_date=$start_date<br />end_date=$end_date";exit;
//$start_date=str_replace("-","",$start_date);
//$end_date=str_replace("-","",$end_date);
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date"; exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;


$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);




//$fiscal_year="1314";

//echo "fiscal_year=$fiscal_year";exit;

$query13="update vmc_posted7_v2,cid_vendor_invoice_payments
set vmc_posted7_v2.cvip_comments=cid_vendor_invoice_payments.comments
where vmc_posted7_v2.center=cid_vendor_invoice_payments.ncas_center
and
vmc_posted7_v2.acct=cid_vendor_invoice_payments.ncas_account
and
vmc_posted7_v2.amount=cid_vendor_invoice_payments.ncas_invoice_amount
and
vmc_posted7_v2.cvip_id=cid_vendor_invoice_payments.id
and vmc_posted7_v2.f_year='$fiscal_year'
and vmc_posted7_v2.acctdate >= '$start_date'
and vmc_posted7_v2.acctdate <= '$end_date';";
//echo "query13=$query13";echo "<br />";exit;
$result13=mysqli_query($connection, $query13) or die ("Couldn't execute query 13. $query13");



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