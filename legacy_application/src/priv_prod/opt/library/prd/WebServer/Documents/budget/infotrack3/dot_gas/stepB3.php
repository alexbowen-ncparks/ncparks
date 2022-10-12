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

/*
$database="divper";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

$sql = "SELECT Nname,Fname,Lname,phone From empinfo where tempID='$tempid'";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$row=mysqli_fetch_array($result);
extract($row);

$prepared_by=$Fname." ".$Lname;

$received_by=$prepared_by;
*/


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

$query1="SELECT sum(bill_amount) as 'bill_total' from dot_gas_detail where valid='n'     ";
		 
//echo "query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);  //bill_total=912.94



//exit;

//echo "query1<br />";

$query2="update dot_gas_detail
         set admin_per_comp=bill_amount/$bill_total
		 where 1 ;";
		 
//echo "query2=$query2<br />";		 

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


$query3="update dot_gas_detail
         set admin_fee_allocation=admin_fee*admin_per_comp
		 where 1 ;";
		 
//echo "query2=$query2<br />";		 

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");


$query4="select sum(admin_fee_allocation) as 'admin_fee_total'
         from dot_gas_detail
		 where 1 ;";
		 
//echo "query2=$query2<br />";		 

$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

$row4=mysqli_fetch_array($result4);

extract($row4);  


$query5="select id as 'adjust_id',admin_fee
         from dot_gas_detail
		 where 1 
		 order by admin_fee_allocation desc
		 limit 1 ";
		 
//echo "query2=$query2<br />";		 

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");

$row5=mysqli_fetch_array($result5);

extract($row5);  // adjust_id=22 admin_fee=59.90

$admin_adjust=$admin_fee-$admin_fee_total;
$admin_adjust=round($admin_adjust,2);
//echo "admin_fee_total=$admin_fee_total <br />"; 
//echo "admin_adjust=$admin_adjust <br />";  //exit;


$query6="update dot_gas_detail
         set admin_fee_allocation=admin_fee_allocation+$admin_adjust
         where id='$adjust_id'		 ";
		 
//echo "query2=$query2<br />";		 

$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");



//echo "update successful"; exit;

$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
		 
		 
//echo "query23a=$query23a<br />"; exit;		 
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");



//exit;


{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&report=y&report_type=form ");}















 ?>




















