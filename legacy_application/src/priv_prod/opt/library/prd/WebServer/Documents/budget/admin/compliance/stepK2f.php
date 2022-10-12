<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;
$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);
$today_date=date("Ymd");
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date";//exit;
//echo "<br />"; 
//echo "today_date=$today_date";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
$query1="update energy_report_water_cost,energy_report_water_usage
set energy_report_water_cost.total_usage_gal=energy_report_water_usage.total_usage_gal
where energy_report_water_cost.park=energy_report_water_usage.park
and energy_report_water_cost.water_account_number=energy_report_water_usage.water_account_number
and energy_report_water_cost.f_year='$fiscal_year'
and energy_report_water_usage.f_year='$fiscal_year';
";

$result1=mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


$query2="update energy_report_water_cost
set average_rate=total_cost_dollars/(total_usage_gal/1000)
where f_year='$fiscal_year';
";

$result2=mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


$query3="update energy_report_water_usage,energy_report_water_cost
set energy_report_water_usage.total_cost_dollars=energy_report_water_cost.total_cost_dollars
where energy_report_water_usage.park=energy_report_water_cost.park
and energy_report_water_usage.water_account_number=energy_report_water_cost.water_account_number
and energy_report_water_usage.f_year='$fiscal_year'
and energy_report_water_cost.f_year='$fiscal_year';
";

$result3=mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");


$query4="update energy_report_water_usage
set average_rate=total_cost_dollars/(total_usage_gal/1000)
where f_year='$fiscal_year';
";

$result4=mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

$query5="update energy_report_water_rate,energy_report_water_usage
set energy_report_water_rate.total_usage_gal=energy_report_water_usage.total_usage_gal
where energy_report_water_rate.park=energy_report_water_usage.park
and energy_report_water_rate.water_account_number=energy_report_water_usage.water_account_number
and energy_report_water_rate.f_year='$fiscal_year'
and energy_report_water_usage.f_year='$fiscal_year';
";

$result5=mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");

$query6="update energy_report_water_rate,energy_report_water_cost
set energy_report_water_rate.total_cost_dollars=energy_report_water_cost.total_cost_dollars
where energy_report_water_rate.park=energy_report_water_cost.park
and energy_report_water_rate.water_account_number=energy_report_water_cost.water_account_number
and energy_report_water_rate.f_year='$fiscal_year'
and energy_report_water_cost.f_year='$fiscal_year';
";

$result6=mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$query7="update energy_report_water_rate
set average_rate=total_cost_dollars/(total_usage_gal/1000)
where f_year='$fiscal_year';
";

$result7=mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");


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

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&report_type=energy_reporting");}




?>

























