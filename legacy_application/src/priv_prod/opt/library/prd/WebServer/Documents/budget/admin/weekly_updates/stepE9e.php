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
//echo "end_date=$end_date"; //exit;
//Tables used:
//budget.cab_dpr,budget.coa,budget.authorized_budget,budget.valid_fund_accounts,
//budget.project_steps_detail,budget.project_steps

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

$query1="SELECT paydate FROM beacon_paydates where 1 ";
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
$row1=mysqli_fetch_array($result1);
extract($row1);
//echo "paydate=$paydate";exit;


$query1a="insert into budget.beacon_payments_ws(
          location_id,location_name,employee_id,employee_name,account,account_name,amount,org_unit)
		  select
		  location_id,location_name,employee_id,employee_name,account,account_name,amount,org_unit
		  from beacon_payments_temp
		  where 1; ";
		  
mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");		  

 

$query2="update beacon_payments_ws set location_id=trim(location_id),
location_name=trim(location_name),
employee_id=trim(employee_id),
employee_name=trim(employee_name),
account=trim(account),
account_name=trim(account_name),
amount=trim(amount),
org_unit=trim(org_unit),
payment_date=trim(payment_date),
f_year=trim(f_year);";
			 
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$query3="update beacon_payments_ws
set payment_date=
'$paydate'
where f_year=''
and payment_date='0000-00-00';
";
			 
mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$query4="update beacon_payments_ws
set f_year=
'$fiscal_year'
where f_year='';
";
			 
mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

$query5="update beacon_payments_ws
set center=concat('1280',mid(location_id,3,4))
where 1
and center='';
";
			 
mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");

$query6=" update beacon_payments_ws,center 
 set beacon_payments_ws.center_code=center.parkcode 
 where beacon_payments_ws.center=center.center; 
";
			 
mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$query7="update beacon_payments_ws
set location_id_last4=mid(location_id,7,4)
where 1
and location_id_last4='';
";
			 
mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");

$query8="update beacon_payments_ws
set temp_payroll_valid='y'
where account='50131000'
and payment_date='$paydate' ;
";
			 
mysqli_query($connection, $query8) or die ("Couldn't execute query 8.  $query8");

$query9="update beacon_payments_ws
set dpr_employee='y'
where dpr_employee='';
";
			 
mysqli_query($connection, $query9) or die ("Couldn't execute query 9.  $query9");

$query10="insert ignore into beacon_payments_invalid_employees(
employee_id,
employee_name,
center,
center_code)
select distinct employee_id,employee_name,center,center_code
from beacon_payments_ws
where temp_payroll_valid='y'
and location_id_last4='0000'
and dpr_employee != 'y';
";
			 
mysqli_query($connection, $query10) or die ("Couldn't execute query 10.  $query10");

$query11="update beacon_payments_ws,beacon_payments_invalid_employees
set beacon_payments_ws.dpr_employee='n'
where beacon_payments_ws.employee_id=
beacon_payments_invalid_employees.employee_id
and beacon_payments_ws.center=
beacon_payments_invalid_employees.center
and beacon_payments_ws.payment_date=
'$paydate'
;
";
			 
mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11");

$query12="update beacon_payments_ws
set valid_entry='y'
where temp_payroll_valid='y'
and location_id_last4='0000'
and dpr_employee='y'
and payment_date=
'$paydate'
;
";
			 
mysqli_query($connection, $query12) or die ("Couldn't execute query 12.  $query12");

$query13="update beacon_payments_ws
set valid_entry='n'
where valid_entry !='y'
and payment_date=
'$paydate'
;
";
			 
mysqli_query($connection, $query13) or die ("Couldn't execute query 13.  $query13");



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




















