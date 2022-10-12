<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

$query="select cy,py1 from fiscal_year where energy_update_year='y' ";
//echo "<br />line 21: query=$query<br />";

$result = mysqli_query($connection, $query) or die ("Couldn't execute query .  $query");

$row=mysqli_fetch_array($result);
extract($row);

//echo "<br />cy=$cy<br />";
//echo "<br />py1=$py1<br />";



$query3a="select max(system_entry_date) as 'last_update', max(cvip_id) as 'last_cdcs' from energy1 where ncas_account='532210' ";
		  
$result3a = mysqli_query($connection, $query3a) or die ("Couldn't execute query 3a.  $query3a");

$row3a=mysqli_fetch_array($result3a);
extract($row3a);

//echo "<br />last_update=$last_update<br />";
//echo "<br />last_cdcs=$last_cdcs<br />";

//exit;



$query1="insert into energy1(
ncas_account,
prepared_by,
ncas_invoice_date,
datesql,
system_entry_date,
ncas_invoice_number,
ncas_invoice_amount,
invoice_total,
vendor_name,
vendor_number,
group_number,
parkcode,
ncas_center,
energy_group,
energy_subgroup,
cdcs_uom,
energy_quantity,
cvip_id)
select
ncas_account,
prepared_by,
ncas_invoice_date,
datesql,
system_entry_date,
ncas_invoice_number,
ncas_invoice_amount,
invoice_total,
vendor_name,
vendor_number,
group_number,
parkcode,
ncas_center,
energy_group,
energy_subgroup,
cdcs_uom,
energy_quantity,
id
from cid_vendor_invoice_payments
WHERE (ncas_center like '1280%' or ncas_center like '1680%')
and ncas_account='532210'
and id > '$last_cdcs'
";

//echo "query1=$query1";exit;

$result1=mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");


$query2="update energy1
set f_year='1314'
where datesql >= '20130701'
and datesql <= '20140630';";

$result2=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");


$query2a="update energy1
set f_year='1415'
where datesql >= '20140701'
and datesql <= '20150630';";

$result2a=mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a. $query2a");


$query2b="update energy1
set f_year='1516'
where datesql >= '20150701'
and datesql <= '20160630';";

$result2b=mysqli_query($connection, $query2b) or die ("Couldn't execute query 2b. $query2b");


$query2b="update energy1
set f_year='1617'
where datesql >= '20160701'
and datesql <= '20170630';";

$result2b=mysqli_query($connection, $query2b) or die ("Couldn't execute query 2b. $query2b");


$query2b="update energy1
set f_year='1718'
where datesql >= '20170701'
and datesql <= '20180630';";

$result2b=mysqli_query($connection, $query2b) or die ("Couldn't execute query 2b. $query2b");


$query2b="update energy1
set f_year='1819'
where datesql >= '20180701'
and datesql <= '20190630';";

$result2b=mysqli_query($connection, $query2b) or die ("Couldn't execute query 2b. $query2b");



$query2b="update energy1
set f_year='1920'
where datesql >= '20190701'
and datesql <= '20200630';";

$result2b=mysqli_query($connection, $query2b) or die ("Couldn't execute query 2b. $query2b");



$query2b="update energy1
set f_year='2021'
where datesql >= '20200701'
and datesql <= '20210630';";

$result2b=mysqli_query($connection, $query2b) or die ("Couldn't execute query 2b. $query2b");



$query2b="update energy1
set f_year='2122'
where datesql >= '20210701'
and datesql <= '20220630';";

$result2b=mysqli_query($connection, $query2b) or die ("Couldn't execute query 2b. $query2b");



$query2b="update energy1
set f_year='2223'
where datesql >= '20220701'
and datesql <= '20230630';";

$result2b=mysqli_query($connection, $query2b) or die ("Couldn't execute query 2b. $query2b");





$query3="update energy1 
set account_number=
SUBSTRING(ncas_invoice_number, 1, CHAR_LENGTH(ncas_invoice_number) - 5)
where account_number='' and cvip_id > '$last_cdcs'
and ncas_account='532210' 
 ";

$result3=mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");


$query5a="update energy1 set account_number_lastcha=right(account_number,1) where f_year='$cy' ";

$result5a=mysqli_query($connection, $query5a) or die ("Couldn't execute query 5a. $query5a");







$query3a="update energy1 
set account_number=
SUBSTRING(ncas_invoice_number, 1, CHAR_LENGTH(ncas_invoice_number) - 6)
where cvip_id > '$last_cdcs'
and ncas_account='532210' 
and account_number_lastcha = '/' ";

$result3a=mysqli_query($connection, $query3a) or die ("Couldn't execute query 3a. $query3a");








$query4="update energy1
set calyear1=mid(dateSQL,1,4),
month1=mid(dateSQL,5,2),
day1=mid(dateSQL,7,2)
where 1 ";

$result4=mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");



$query5="update energy1,energy_report_electricity_accounts
set energy1.valid_account='y'
where energy1.ncas_account='532210'
and energy1.ncas_center=energy_report_electricity_accounts.ncas_center_new
and energy1.account_number=energy_report_electricity_accounts.electricity_account_number
and energy1.f_year='$cy'
and energy_report_electricity_accounts.f_year='$cy' ;";

$result5=mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");


/*
$query5a="update energy1 set account_number_lastcha=right(account_number,1) where f_year='$f_year' ";

$result5a=mysqli_query($connection, $query5a) or die ("Couldn't execute query 5a. $query5a");
*/


$query6="update energy1,center
set energy1.center_code=center.parkcode
where energy1.ncas_center=center.new_center; ";

$result6=mysqli_query($connection, $query6) or die ("Couldn't execute query 6. $query6");


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


////mysql_close();
header("location:step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");


 
 ?>