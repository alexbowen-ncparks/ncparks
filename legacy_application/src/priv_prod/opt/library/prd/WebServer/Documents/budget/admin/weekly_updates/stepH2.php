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

/*
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

*/


$query1=" update cid_vendor_invoice_payments 
 set post2ncas='n' 
 where post2ncas=''; 
";
mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

$query2=" update cid_vendor_invoice_payments 
 set ncas_center=concat(ncas_fund,ncas_rcc) 
 where 1 
 and ncas_center=''; 
";
mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");

$query3="update cid_vendor_invoice_payments
set ciaa=concat(ncas_center,'-',ncas_invoice_number,'-',ncas_invoice_amount,'-',ncas_account)
where 1 and ciaa='';
";
mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");

$query4="CREATE TABLE `ciaa_count` (
`ciaa` VARCHAR( 75 ) NOT NULL ,
`ciaa_count` VARCHAR( 10 ) NOT NULL 
);
";

mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");

$query4a="insert into ciaa_count(ciaa,ciaa_count)
select ciaa,count(ciaa)
from cid_vendor_invoice_payments
where 1
and cid_vendor_invoice_payments.post2ncas != 'y'
group by ciaa;
";

mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a. $query4a");


$query5="update cid_vendor_invoice_payments,ciaa_count
set cid_vendor_invoice_payments.ciaa_count=ciaa_count.ciaa_count
where cid_vendor_invoice_payments.ciaa=ciaa_count.ciaa
and cid_vendor_invoice_payments.post2ncas != 'y';
";
mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");

$query6="update cid_vendor_invoice_payments
set caa=concat(ncas_center,'-',ncas_invoice_amount,'-',ncas_account)
where 1 and caa='';
";
mysqli_query($connection, $query6) or die ("Couldn't execute query 6. $query6");

$query7="CREATE TABLE `budget`.`caa_count_cvip` (
`caa` varchar( 40 ) NOT NULL default '',
`caa_count` int( 10 ) NOT NULL default '0',
`id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `id` ) ,
KEY `ciaa` ( `caa` )
) ENGINE = MyISAM ;
";

mysqli_query($connection, $query7) or die ("Couldn't execute query 7. $query7");

$query7a="insert into caa_count_cvip(caa,caa_count)
select caa,count(caa)
from cid_vendor_invoice_payments
where 1
and cid_vendor_invoice_payments.post2ncas != 'y'
group by caa;
";

mysqli_query($connection, $query7a) or die ("Couldn't execute query 7a. $query7a");

$query8="update cid_vendor_invoice_payments,caa_count_cvip
set cid_vendor_invoice_payments.caa_count=caa_count_cvip.caa_count
where cid_vendor_invoice_payments.caa=caa_count_cvip.caa
and cid_vendor_invoice_payments.post2ncas != 'y';
";
mysqli_query($connection, $query8) or die ("Couldn't execute query 8. $query8");

$query9="drop table ciaa_count;
";
mysqli_query($connection, $query9) or die ("Couldn't execute query 9. $query9");

$query10="drop table caa_count_cvip;
";
mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

/*
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

*/


?>