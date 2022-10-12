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

$query0="SELECT paydate FROM beacon_paydates where 1 ";
$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");
$row0=mysqli_fetch_array($result0);
extract($row0);
//echo "paydate=$paydate";exit;


$query1=" update beacon_payments_ws,center 
 set beacon_payments_ws.center_code=center.parkcode 
 where beacon_payments_ws.center=center.center; 
";
			 
mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$query2="update beacon_payments_ws
set employee_number_center=
concat(employee_id,'-',center)
where 1;
";
			 
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$query3=" update beacon_payments_ws 
 set position_number=concat(center_code,'_unidentified_payments') where payment_date= 
'$paydate'
 ; 
";
			 
mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$query4=" update beacon_payments_ws 
 set posnum_center=concat(position_number,'-',center) 
 where valid_entry='y' 
and payment_date=
'$paydate'
;
";
			 
mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");


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




















