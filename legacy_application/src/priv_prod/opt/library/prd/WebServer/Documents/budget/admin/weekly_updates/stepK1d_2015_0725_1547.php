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
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
$query1="truncate table energy_532210_electricity_rate;
";

$result1=mysql_query($query1) or die ("Couldn't execute query 1.  $query1");


$query2="insert into energy_532210_electricity_rate(division,ncas_center,centerpark,utility_account_number,building_name,address,city,vendor_name)
select 'parks & recreation',ncas_center,centerpark,ncas_invoice_number2,'none','none','none','none'
from energy_controllers_3
where ncas_account='532210' and energy_group='electricity' and cdcs_uom='kwh'
group by ncas_center,centerpark,ncas_invoice_number2
order by ncas_center,centerpark,ncas_invoice_number2;
";

$result2=mysql_query($query2) or die ("Couldn't execute query 2.  $query2");


$query3="update energy_532210_electricity_rate
set f_year='1314' where 1; ";

$result3=mysql_query($query3) or die ("Couldn't execute query 3.  $query3");


$query4="update energy_532210_electricity_rate,energy_controllers_3
set energy_532210_electricity_rate.july=energy_controllers_3.avg_rate
where energy_532210_electricity_rate.ncas_center=energy_controllers_3.ncas_center
and energy_532210_electricity_rate.centerpark=energy_controllers_3.centerpark
and energy_532210_electricity_rate.utility_account_number=energy_controllers_3.ncas_invoice_number2
and energy_controllers_3.ncas_account='532210'
and energy_controllers_3.energy_group='electricity'
and energy_controllers_3.cdcs_uom='kwh'
and energy_controllers_3.f_year='1314'
and energy_controllers_3.month1='07';
";

$result4=mysql_query($query4) or die ("Couldn't execute query 4.  $query4");


$query5="update energy_532210_electricity_rate,energy_controllers_3
set energy_532210_electricity_rate.august=energy_controllers_3.avg_rate
where energy_532210_electricity_rate.ncas_center=energy_controllers_3.ncas_center
and energy_532210_electricity_rate.centerpark=energy_controllers_3.centerpark
and energy_532210_electricity_rate.utility_account_number=energy_controllers_3.ncas_invoice_number2
and energy_controllers_3.ncas_account='532210'
and energy_controllers_3.energy_group='electricity'
and energy_controllers_3.cdcs_uom='kwh'
and energy_controllers_3.f_year='1314'
and energy_controllers_3.month1='08';
";

$result5=mysql_query($query5) or die ("Couldn't execute query 5.  $query5");


$query6="update energy_532210_electricity_rate,energy_controllers_3
set energy_532210_electricity_rate.september=energy_controllers_3.avg_rate
where energy_532210_electricity_rate.ncas_center=energy_controllers_3.ncas_center
and energy_532210_electricity_rate.centerpark=energy_controllers_3.centerpark
and energy_532210_electricity_rate.utility_account_number=energy_controllers_3.ncas_invoice_number2
and energy_controllers_3.ncas_account='532210'
and energy_controllers_3.energy_group='electricity'
and energy_controllers_3.cdcs_uom='kwh'
and energy_controllers_3.f_year='1314'
and energy_controllers_3.month1='09';
";

$result6=mysql_query($query6) or die ("Couldn't execute query 6.  $query6");


$query7="update energy_532210_electricity_rate,energy_controllers_3
set energy_532210_electricity_rate.october=energy_controllers_3.avg_rate
where energy_532210_electricity_rate.ncas_center=energy_controllers_3.ncas_center
and energy_532210_electricity_rate.centerpark=energy_controllers_3.centerpark
and energy_532210_electricity_rate.utility_account_number=energy_controllers_3.ncas_invoice_number2
and energy_controllers_3.ncas_account='532210'
and energy_controllers_3.energy_group='electricity'
and energy_controllers_3.cdcs_uom='kwh'
and energy_controllers_3.f_year='1314'
and energy_controllers_3.month1='10';
";

$result7=mysql_query($query7) or die ("Couldn't execute query 7.  $query7");


$query8="update energy_532210_electricity_rate,energy_controllers_3
set energy_532210_electricity_rate.november=energy_controllers_3.avg_rate
where energy_532210_electricity_rate.ncas_center=energy_controllers_3.ncas_center
and energy_532210_electricity_rate.centerpark=energy_controllers_3.centerpark
and energy_532210_electricity_rate.utility_account_number=energy_controllers_3.ncas_invoice_number2
and energy_controllers_3.ncas_account='532210'
and energy_controllers_3.energy_group='electricity'
and energy_controllers_3.cdcs_uom='kwh'
and energy_controllers_3.f_year='1314'
and energy_controllers_3.month1='11';
";

$result8=mysql_query($query8) or die ("Couldn't execute query 8.  $query8");


$query9="update energy_532210_electricity_rate,energy_controllers_3
set energy_532210_electricity_rate.december=energy_controllers_3.avg_rate
where energy_532210_electricity_rate.ncas_center=energy_controllers_3.ncas_center
and energy_532210_electricity_rate.centerpark=energy_controllers_3.centerpark
and energy_532210_electricity_rate.utility_account_number=energy_controllers_3.ncas_invoice_number2
and energy_controllers_3.ncas_account='532210'
and energy_controllers_3.energy_group='electricity'
and energy_controllers_3.cdcs_uom='kwh'
and energy_controllers_3.f_year='1314'
and energy_controllers_3.month1='12';
";

$result9=mysql_query($query9) or die ("Couldn't execute query 9.  $query9");


$query10="update energy_532210_electricity_rate,energy_controllers_3
set energy_532210_electricity_rate.january=energy_controllers_3.avg_rate
where energy_532210_electricity_rate.ncas_center=energy_controllers_3.ncas_center
and energy_532210_electricity_rate.centerpark=energy_controllers_3.centerpark
and energy_532210_electricity_rate.utility_account_number=energy_controllers_3.ncas_invoice_number2
and energy_controllers_3.ncas_account='532210'
and energy_controllers_3.energy_group='electricity'
and energy_controllers_3.cdcs_uom='kwh'
and energy_controllers_3.f_year='1314'
and energy_controllers_3.month1='01';
";

$result10=mysql_query($query10) or die ("Couldn't execute query 10.  $query10");


$query11="update energy_532210_electricity_rate,energy_controllers_3
set energy_532210_electricity_rate.february=energy_controllers_3.avg_rate
where energy_532210_electricity_rate.ncas_center=energy_controllers_3.ncas_center
and energy_532210_electricity_rate.centerpark=energy_controllers_3.centerpark
and energy_532210_electricity_rate.utility_account_number=energy_controllers_3.ncas_invoice_number2
and energy_controllers_3.ncas_account='532210'
and energy_controllers_3.energy_group='electricity'
and energy_controllers_3.cdcs_uom='kwh'
and energy_controllers_3.f_year='1314'
and energy_controllers_3.month1='02';
";

$result11=mysql_query($query11) or die ("Couldn't execute query 11.  $query11");


$query12="update energy_532210_electricity_rate,energy_controllers_3
set energy_532210_electricity_rate.march=energy_controllers_3.avg_rate
where energy_532210_electricity_rate.ncas_center=energy_controllers_3.ncas_center
and energy_532210_electricity_rate.centerpark=energy_controllers_3.centerpark
and energy_532210_electricity_rate.utility_account_number=energy_controllers_3.ncas_invoice_number2
and energy_controllers_3.ncas_account='532210'
and energy_controllers_3.energy_group='electricity'
and energy_controllers_3.cdcs_uom='kwh'
and energy_controllers_3.f_year='1314'
and energy_controllers_3.month1='03';
";

$result12=mysql_query($query12) or die ("Couldn't execute query 12.  $query12");


$query13="update energy_532210_electricity_rate,energy_controllers_3
set energy_532210_electricity_rate.april=energy_controllers_3.avg_rate
where energy_532210_electricity_rate.ncas_center=energy_controllers_3.ncas_center
and energy_532210_electricity_rate.centerpark=energy_controllers_3.centerpark
and energy_532210_electricity_rate.utility_account_number=energy_controllers_3.ncas_invoice_number2
and energy_controllers_3.ncas_account='532210'
and energy_controllers_3.energy_group='electricity'
and energy_controllers_3.cdcs_uom='kwh'
and energy_controllers_3.f_year='1314'
and energy_controllers_3.month1='04';
";

$result13=mysql_query($query13) or die ("Couldn't execute query 13.  $query13");


$query14="update energy_532210_electricity_rate,energy_controllers_3
set energy_532210_electricity_rate.may=energy_controllers_3.avg_rate
where energy_532210_electricity_rate.ncas_center=energy_controllers_3.ncas_center
and energy_532210_electricity_rate.centerpark=energy_controllers_3.centerpark
and energy_532210_electricity_rate.utility_account_number=energy_controllers_3.ncas_invoice_number2
and energy_controllers_3.ncas_account='532210'
and energy_controllers_3.energy_group='electricity'
and energy_controllers_3.cdcs_uom='kwh'
and energy_controllers_3.f_year='1314'
and energy_controllers_3.month1='05';
";

$result14=mysql_query($query14) or die ("Couldn't execute query 14.  $query14");


$query15="update energy_532210_electricity_rate,energy_controllers_3
set energy_532210_electricity_rate.june=energy_controllers_3.avg_rate
where energy_532210_electricity_rate.ncas_center=energy_controllers_3.ncas_center
and energy_532210_electricity_rate.centerpark=energy_controllers_3.centerpark
and energy_532210_electricity_rate.utility_account_number=energy_controllers_3.ncas_invoice_number2
and energy_controllers_3.ncas_account='532210'
and energy_controllers_3.energy_group='electricity'
and energy_controllers_3.cdcs_uom='kwh'
and energy_controllers_3.f_year='1314'
and energy_controllers_3.month1='06';
";

$result15=mysql_query($query15) or die ("Couldn't execute query 15.  $query15");


$query16="update energy_532210_electricity_rate
set total_rate_12_months=
july+august+september+october+november+december+january+february+march+april+may+june
where 1;
";

$result16=mysql_query($query16) or die ("Couldn't execute query 16.  $query16");


$query16a="update energy_532210_electricity_rate
set julc='1'
where july != '0';
";

$result16a=mysql_query($query16a) or die ("Couldn't execute query 16a.  $query16a");


$query16b="update energy_532210_electricity_rate
set augc='1'
where august != '0';
";

$result16b=mysql_query($query16b) or die ("Couldn't execute query 16b.  $query16b");

$query16c="update energy_532210_electricity_rate
set sepc='1'
where september != '0';
";

$result16c=mysql_query($query16c) or die ("Couldn't execute query 16c.  $query16c");

$query16d="update energy_532210_electricity_rate
set octc='1'
where october != '0';
";

$result16d=mysql_query($query16d) or die ("Couldn't execute query 16d.  $query16d");

$query16e="update energy_532210_electricity_rate
set novc='1'
where november != '0';
";

$result16e=mysql_query($query16e) or die ("Couldn't execute query 16e.  $query16e");

$query16f="update energy_532210_electricity_rate
set decc='1'
where december != '0';
";

$result16f=mysql_query($query16f) or die ("Couldn't execute query 16f.  $query16f");

$query16g="update energy_532210_electricity_rate
set janc='1'
where january != '0';
";

$result16g=mysql_query($query16g) or die ("Couldn't execute query 16g.  $query16g");


$query16h="update energy_532210_electricity_rate
set febc='1'
where february != '0';
";

$result16h=mysql_query($query16h) or die ("Couldn't execute query 16h.  $query16h");


$query16i="update energy_532210_electricity_rate
set marc='1'
where march != '0';
";

$result16i=mysql_query($query16i) or die ("Couldn't execute query 16i.  $query16i");

$query16j="update energy_532210_electricity_rate
set aprc='1'
where april != '0';
";

$result16j=mysql_query($query16j) or die ("Couldn't execute query 16j.  $query16j");


$query16k="update energy_532210_electricity_rate
set mayc='1'
where may != '0';
";

$result16k=mysql_query($query16k) or die ("Couldn't execute query 16k.  $query16k");


$query16m="update energy_532210_electricity_rate
set junc='1'
where june != '0';
";

$result16m=mysql_query($query16m) or die ("Couldn't execute query 16m.  $query16m");


$query16n="update energy_532210_electricity_rate
set nonzero_count=(julc+augc+sepc+octc+novc+decc+janc+febc+marc+aprc+mayc+junc)
where 1;
";

$result16n=mysql_query($query16n) or die ("Couldn't execute query 16n.  $query16n");

$query16p="update energy_532210_electricity_rate
set kwh_avg_rate_12_months=total_rate_12_months/nonzero_count
where 1;
";

$result16p=mysql_query($query16p) or die ("Couldn't execute query 16p.  $query16p");


$query17="delete from energy_report_electricity_rate
where f_year='1314';
";

$result17=mysql_query($query17) or die ("Couldn't execute query 17.  $query17");


$query18="insert into energy_report_electricity_rate
(f_year,division,park,electricity_account_number,building_name,july,august,september,october,november,december,
january,february,march,april,may,june,nonzero_count,total_rate_12_months,average_rate,total_usage_kwh,total_cost_dollars)
select f_year,'parks',centerpark,utility_account_number,building_name,
july,august,september,october,november,december,january,february,march,april,may,june,
nonzero_count,total_rate_12_months,kwh_avg_rate_12_months,total_kwh_usage_12_months,total_cost_12_months
from energy_532210_electricity_rate
where f_year='1314';
";

$result18=mysql_query($query18) or die ("Couldn't execute query 18.  $query18");

$query19="update energy_report_electricity_rate,center
set energy_report_electricity_rate.building_name=center.park_name
where energy_report_electricity_rate.park=center.parkcode
and center.center like '1280%'
and actcenteryn='y'
and energy_report_electricity_rate.f_year='1314';
";

$result19=mysql_query($query19) or die ("Couldn't execute query 19.  $query19");



$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysql_query($query23a) or die ("Couldn't execute query 23a.  $query23a");

$query24="select * from budget.project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result24=mysql_query($query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysql_num_rows($result24);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num24==0)

{$query25="update budget.project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysql_query($query25) or die ("Couldn't execute query 25.  $query25");}
mysql_close();

if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}




?>

























