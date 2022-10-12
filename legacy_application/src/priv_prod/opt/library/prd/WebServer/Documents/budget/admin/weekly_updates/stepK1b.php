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
$query1="truncate table energy_532210_electricity_usage; ";

$result1=mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


$query2="insert into energy_532210_electricity_usage(division,ncas_center,centerpark,utility_account_number,building_name,address,city,vendor_name)
select 'parks & recreation',ncas_center,centerpark,ncas_invoice_number2,'none','none','none','none'
from energy_controllers_3
where ncas_account='532210' and energy_group='electricity' and cdcs_uom='kwh'
and f_year='$fiscal_year'
group by ncas_center,centerpark,ncas_invoice_number2
order by ncas_center,centerpark,ncas_invoice_number2; ";

$result2=mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


$query3="update energy_532210_electricity_usage
set f_year='$fiscal_year'
where 1; ";

$result3=mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");


$query4="update energy_532210_electricity_usage,energy_controllers_3
set energy_532210_electricity_usage.july=energy_controllers_3.uom_quantity
where energy_532210_electricity_usage.ncas_center=energy_controllers_3.ncas_center
and energy_532210_electricity_usage.centerpark=energy_controllers_3.centerpark
and energy_532210_electricity_usage.utility_account_number=energy_controllers_3.ncas_invoice_number2
and energy_controllers_3.ncas_account='532210'
and energy_controllers_3.energy_group='electricity'
and energy_controllers_3.cdcs_uom='kwh'
and energy_controllers_3.f_year='$fiscal_year'
and energy_controllers_3.month1='07'; ";

$result4=mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");


$query5="update energy_532210_electricity_usage,energy_controllers_3
set energy_532210_electricity_usage.august=energy_controllers_3.uom_quantity
where energy_532210_electricity_usage.ncas_center=energy_controllers_3.ncas_center
and energy_532210_electricity_usage.centerpark=energy_controllers_3.centerpark
and energy_532210_electricity_usage.utility_account_number=energy_controllers_3.ncas_invoice_number2
and energy_controllers_3.ncas_account='532210'
and energy_controllers_3.energy_group='electricity'
and energy_controllers_3.cdcs_uom='kwh'
and energy_controllers_3.f_year='$fiscal_year'
and energy_controllers_3.month1='08'; ";

$result5=mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");


$query6="update energy_532210_electricity_usage,energy_controllers_3
set energy_532210_electricity_usage.september=energy_controllers_3.uom_quantity
where energy_532210_electricity_usage.ncas_center=energy_controllers_3.ncas_center
and energy_532210_electricity_usage.centerpark=energy_controllers_3.centerpark
and energy_532210_electricity_usage.utility_account_number=energy_controllers_3.ncas_invoice_number2
and energy_controllers_3.ncas_account='532210'
and energy_controllers_3.energy_group='electricity'
and energy_controllers_3.cdcs_uom='kwh'
and energy_controllers_3.f_year='$fiscal_year'
and energy_controllers_3.month1='09'; ";

$result6=mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");


$query7="update energy_532210_electricity_usage,energy_controllers_3
set energy_532210_electricity_usage.october=energy_controllers_3.uom_quantity
where energy_532210_electricity_usage.ncas_center=energy_controllers_3.ncas_center
and energy_532210_electricity_usage.centerpark=energy_controllers_3.centerpark
and energy_532210_electricity_usage.utility_account_number=energy_controllers_3.ncas_invoice_number2
and energy_controllers_3.ncas_account='532210'
and energy_controllers_3.energy_group='electricity'
and energy_controllers_3.cdcs_uom='kwh'
and energy_controllers_3.f_year='$fiscal_year'
and energy_controllers_3.month1='10'; ";

$result7=mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");


$query8="update energy_532210_electricity_usage,energy_controllers_3
set energy_532210_electricity_usage.november=energy_controllers_3.uom_quantity
where energy_532210_electricity_usage.ncas_center=energy_controllers_3.ncas_center
and energy_532210_electricity_usage.centerpark=energy_controllers_3.centerpark
and energy_532210_electricity_usage.utility_account_number=energy_controllers_3.ncas_invoice_number2
and energy_controllers_3.ncas_account='532210'
and energy_controllers_3.energy_group='electricity'
and energy_controllers_3.cdcs_uom='kwh'
and energy_controllers_3.f_year='$fiscal_year'
and energy_controllers_3.month1='11';
";

$result8=mysqli_query($connection, $query8) or die ("Couldn't execute query 8.  $query8");


$query9="update energy_532210_electricity_usage,energy_controllers_3
set energy_532210_electricity_usage.december=energy_controllers_3.uom_quantity
where energy_532210_electricity_usage.ncas_center=energy_controllers_3.ncas_center
and energy_532210_electricity_usage.centerpark=energy_controllers_3.centerpark
and energy_532210_electricity_usage.utility_account_number=energy_controllers_3.ncas_invoice_number2
and energy_controllers_3.ncas_account='532210'
and energy_controllers_3.energy_group='electricity'
and energy_controllers_3.cdcs_uom='kwh'
and energy_controllers_3.f_year='$fiscal_year'
and energy_controllers_3.month1='12';
";

$result9=mysqli_query($connection, $query9) or die ("Couldn't execute query 9.  $query9");


$query10="update energy_532210_electricity_usage,energy_controllers_3
set energy_532210_electricity_usage.january=energy_controllers_3.uom_quantity
where energy_532210_electricity_usage.ncas_center=energy_controllers_3.ncas_center
and energy_532210_electricity_usage.centerpark=energy_controllers_3.centerpark
and energy_532210_electricity_usage.utility_account_number=energy_controllers_3.ncas_invoice_number2
and energy_controllers_3.ncas_account='532210'
and energy_controllers_3.energy_group='electricity'
and energy_controllers_3.cdcs_uom='kwh'
and energy_controllers_3.f_year='$fiscal_year'
and energy_controllers_3.month1='01';
";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10.  $query10");


$query11="update energy_532210_electricity_usage,energy_controllers_3
set energy_532210_electricity_usage.february=energy_controllers_3.uom_quantity
where energy_532210_electricity_usage.ncas_center=energy_controllers_3.ncas_center
and energy_532210_electricity_usage.centerpark=energy_controllers_3.centerpark
and energy_532210_electricity_usage.utility_account_number=energy_controllers_3.ncas_invoice_number2
and energy_controllers_3.ncas_account='532210'
and energy_controllers_3.energy_group='electricity'
and energy_controllers_3.cdcs_uom='kwh'
and energy_controllers_3.f_year='$fiscal_year'
and energy_controllers_3.month1='02';
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11");


$query12="update energy_532210_electricity_usage,energy_controllers_3
set energy_532210_electricity_usage.march=energy_controllers_3.uom_quantity
where energy_532210_electricity_usage.ncas_center=energy_controllers_3.ncas_center
and energy_532210_electricity_usage.centerpark=energy_controllers_3.centerpark
and energy_532210_electricity_usage.utility_account_number=energy_controllers_3.ncas_invoice_number2
and energy_controllers_3.ncas_account='532210'
and energy_controllers_3.energy_group='electricity'
and energy_controllers_3.cdcs_uom='kwh'
and energy_controllers_3.f_year='$fiscal_year'
and energy_controllers_3.month1='03';
";

$result12=mysqli_query($connection, $query12) or die ("Couldn't execute query 12.  $query12");


$query13="update energy_532210_electricity_usage,energy_controllers_3
set energy_532210_electricity_usage.april=energy_controllers_3.uom_quantity
where energy_532210_electricity_usage.ncas_center=energy_controllers_3.ncas_center
and energy_532210_electricity_usage.centerpark=energy_controllers_3.centerpark
and energy_532210_electricity_usage.utility_account_number=energy_controllers_3.ncas_invoice_number2
and energy_controllers_3.ncas_account='532210'
and energy_controllers_3.energy_group='electricity'
and energy_controllers_3.cdcs_uom='kwh'
and energy_controllers_3.f_year='$fiscal_year'
and energy_controllers_3.month1='04';
";

$result13=mysqli_query($connection, $query13) or die ("Couldn't execute query 13.  $query13");


$query14="update energy_532210_electricity_usage,energy_controllers_3
set energy_532210_electricity_usage.may=energy_controllers_3.uom_quantity
where energy_532210_electricity_usage.ncas_center=energy_controllers_3.ncas_center
and energy_532210_electricity_usage.centerpark=energy_controllers_3.centerpark
and energy_532210_electricity_usage.utility_account_number=energy_controllers_3.ncas_invoice_number2
and energy_controllers_3.ncas_account='532210'
and energy_controllers_3.energy_group='electricity'
and energy_controllers_3.cdcs_uom='kwh'
and energy_controllers_3.f_year='$fiscal_year'
and energy_controllers_3.month1='05';
";

$result14=mysqli_query($connection, $query14) or die ("Couldn't execute query 14.  $query14");


$query15="update energy_532210_electricity_usage,energy_controllers_3
set energy_532210_electricity_usage.june=energy_controllers_3.uom_quantity
where energy_532210_electricity_usage.ncas_center=energy_controllers_3.ncas_center
and energy_532210_electricity_usage.centerpark=energy_controllers_3.centerpark
and energy_532210_electricity_usage.utility_account_number=energy_controllers_3.ncas_invoice_number2
and energy_controllers_3.ncas_account='532210'
and energy_controllers_3.energy_group='electricity'
and energy_controllers_3.cdcs_uom='kwh'
and energy_controllers_3.f_year='$fiscal_year'
and energy_controllers_3.month1='06';
";

$result15=mysqli_query($connection, $query15) or die ("Couldn't execute query 15.  $query15");


$query16="update energy_532210_electricity_usage
set total_kwh_usage_12_months=
july+august+september+october+november+december+january+february+march+april+may+june
where 1 ;
";

$result16=mysqli_query($connection, $query16) or die ("Couldn't execute query 16.  $query16");


$query17="delete from energy_report_electricity_usage
where f_year='$fiscal_year';
";

$result17=mysqli_query($connection, $query17) or die ("Couldn't execute query 17.  $query17");

$query18="insert into energy_report_electricity_usage
(f_year,division,park,electricity_account_number,building_name,july,august,september,october,november,december,
january,february,march,april,may,june,total_usage_kwh,total_cost_dollars,average_rate)
select f_year,'parks',centerpark,utility_account_number,building_name,
july,august,september,october,november,december,january,february,march,april,may,june,
total_kwh_usage_12_months,total_cost_12_months,kwh_avg_rate_12_months
from energy_532210_electricity_usage
where f_year='$fiscal_year';
";

$result18=mysqli_query($connection, $query18) or die ("Couldn't execute query 18.  $query18");

$query19="update energy_report_electricity_usage,center
set energy_report_electricity_usage.building_name=center.park_name
where energy_report_electricity_usage.park=center.parkcode
and center.center like '1280%'
and actcenteryn='y'
and energy_report_electricity_usage.f_year='$fiscal_year';
";

$result19=mysqli_query($connection, $query19) or die ("Couldn't execute query 19.  $query19");



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

























