<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
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

$query1A="update energy1
set valid_energy_group='y'
where f_year='1314'
and valid_account='y'
and ncas_account='532210'
and energy_group='electricity'
and cdcs_uom='kwh';";
$result1A=mysqli_query($connection, $query1A) or die ("Couldn't execute query 1A.  $query1A");


$query1B="update energy1
set valid_energy_group='y'
where f_year='1314'
and valid_account='y'
and ncas_account='532220'
and energy_group='natural_gas'
and cdcs_uom='btu';";
$result1B=mysqli_query($connection, $query1B) or die ("Couldn't execute query 1B.  $query1B");


$query1C="update energy1
set valid_energy_group='y'
where f_year='1314'
and valid_account='y'
and ncas_account='532220'
and energy_group='propane'
and cdcs_uom='gal';";
$result1C=mysqli_query($connection, $query1C) or die ("Couldn't execute query 1C.  $query1C");


$query1D="update energy1
set valid_energy_group='y'
where f_year='1314'
and valid_account='y'
and ncas_account='532230'
and energy_group='water'
and cdcs_uom='gal';";
$result1D=mysqli_query($connection, $query1D) or die ("Couldn't execute query 1D.  $query1D");



$query1="truncate table energy_controllers_3; ";
$result1=mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


$query2="insert into energy_controllers_3(
ncas_center,
centerpark,
ncas_account,
energy_group,
cdcs_uom,
ncas_invoice_number2,
vendor_name,
calyear1,
month1,
f_year,
record_count,
dollar_amount,
uom_quantity)
select
ncas_center,
center_code,
ncas_account,
energy_group,
cdcs_uom,
account_number,
vendor_name,
calyear1,
month1,
f_year,
count(id) as 'record_count',
sum(ncas_invoice_amount) as 'dollar_amount',
sum(energy_quantity) as 'uom_quantity'
from energy1
where 1 
and valid_account='y'
and valid_energy_group='y'
and f_year='1314'
and ncas_center like '1280%'
group by ncas_center,center_code,ncas_account,energy_group,cdcs_uom,account_number,calyear1,month1;
";
$result2=mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

/*
$query3="update energy_controllers_3
set f_year='1314'
where calyear1 = '2013' and month1 >= '07' ;
";

$result3=mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");


$query4="update energy_controllers_3
set f_year='1314'
where calyear1 = '2014' and month1 <= '06' ;
";

$result4=mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
*/


/*
$query5="update energy_controllers_3
set f_year='1415'
where calyear1 = '2014' and month1 >= '07' ;
";

$result5=mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");


$query6="update energy_controllers_3
set f_year='1415'
where calyear1 = '2015' and month1 <= '06' ;
";

$result6=mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");
*/

$query7="update energy_controllers_3
set avg_rate=dollar_amount/uom_quantity
where 1 and energy_group != 'water'; ";

$result7=mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");


$query8="update energy_controllers_3
set avg_rate=dollar_amount/(uom_quantity/1000)
where energy_group = 'water'; ";

$result8=mysqli_query($connection, $query8) or die ("Couldn't execute query 8.  $query8");


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

























