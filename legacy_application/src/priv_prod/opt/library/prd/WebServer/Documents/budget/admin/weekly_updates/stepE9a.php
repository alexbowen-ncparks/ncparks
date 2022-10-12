<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
$end_date=str_replace("-","",$end_date);

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
//echo "end_date=$end_date"; exit;
//Tables used:
//budget.cab_dpr,budget.coa,budget.authorized_budget,budget.valid_fund_accounts,
//budget.project_steps_detail,budget.project_steps

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

$query1="insert into xtnd_vendor_payments(
         company,fund,rcc,account,date,checknum,invoice,amount,vendor_num,group_num,
		 vendor_name,po_number)
		 select
		 company,fund,rcc,account,date,checknum,invoice,amount,vendor_num,group_num,
		 vendor_name,po_number
		 from xtnd_vendor_payments_temp
		 where 1; ";

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$query1a="update xtnd_vendor_payments set company=trim(company),
fund=trim(fund),
rcc=trim(rcc),
account=trim(account),
date=trim(date),
checknum=trim(checknum),
invoice=trim(invoice),
amount=trim(amount),
vendor_num=trim(vendor_num),
group_num=trim(group_num),
vendor_name=trim(vendor_name),
po_number=trim(po_number),
po_line=trim(po_line),
center=trim(center),
f_year=trim(f_year),
xtnd_date=trim(xtnd_date),
id=trim(id);";
			 
mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");

$query2="delete from budget.xtnd_vendor_payments
where f_year=''
and account not like '53%'
and account not like '43%';
";
			 
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$query3="update budget.xtnd_vendor_payments
set f_year=
'$fiscal_year'
where f_year='';
";
			 
mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$query4="update budget.xtnd_vendor_payments
set xtnd_date=
'$end_date'
where f_year=
'$fiscal_year';";
			 
mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

$query5="update xtnd_vendor_payments
set center=concat(fund,rcc)
where 1;
";
			 
mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");

$query6="update xtnd_vendor_payments
set datenew=concat(mid(date,7,4),mid(date,1,2),mid(date,4,2))
where f_year=
'$fiscal_year';";
			 
mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

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




















