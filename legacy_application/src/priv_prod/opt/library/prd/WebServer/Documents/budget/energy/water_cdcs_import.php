<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>"; 
//exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

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
and ncas_account='532230'
and id > '$last_cdcs'
";

//echo "query1=$query1"; exit;

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


$query2c="update energy1
set f_year='1819'
where datesql >= '20180701'
and datesql <= '20190630';";

$result2c=mysqli_query($connection, $query2c) or die ("Couldn't execute query 2c. $query2c");


$query2c="update energy1
set f_year='1920'
where datesql >= '20190701'
and datesql <= '20200630';";

$result2c=mysqli_query($connection, $query2c) or die ("Couldn't execute query 2c. $query2c");

//echo "<br />Line 123: query2c=$query2c<br />";
//exit;


$query2d="update energy1
set f_year='2021'
where datesql >= '20200701'
and datesql <= '20210630';";

$result2d=mysqli_query($connection, $query2d) or die ("Couldn't execute query 2d. $query2d");


$query2e="update energy1
set f_year='2122'
where datesql >= '20210701'
and datesql <= '20220630';";

$result2e=mysqli_query($connection, $query2e) or die ("Couldn't execute query 2e. $query2e");


$query2f="update energy1
set f_year='2223'
where datesql >= '20220701'
and datesql <= '20230630';";

$result2f=mysqli_query($connection, $query2f) or die ("Couldn't execute query 2f. $query2f");


$query2g="update energy1
set f_year='2324'
where datesql >= '20230701'
and datesql <= '20240630';";

$result2g=mysqli_query($connection, $query2g) or die ("Couldn't execute query 2g. $query2g");


$query2h="update energy1
set f_year='2425'
where datesql >= '20240701'
and datesql <= '20250630';";

$result2h=mysqli_query($connection, $query2h) or die ("Couldn't execute query 2h. $query2h");


$query3="update energy1 
set account_number=
SUBSTRING(ncas_invoice_number, 1, CHAR_LENGTH(ncas_invoice_number) - 5)
where account_number='' and cvip_id > '$last_cdcs'
and ncas_account='532230' ";

$result3=mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");


$query4="update energy1
set calyear1=mid(dateSQL,1,4),
month1=mid(dateSQL,5,2),
day1=mid(dateSQL,7,2)
where 1 ";

$result4=mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");



$query5="update energy1,energy_report_water_accounts
set energy1.valid_account='y'
where energy1.ncas_account='532230'
and energy1.ncas_center=energy_report_water_accounts.ncas_center
and energy1.account_number=energy_report_water_accounts.water_account_number
and energy1.f_year='$f_year'
and energy_report_water_accounts.f_year='$f_year' ;";

$result5=mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");



$query5a="update energy1,energy_report_water_accounts
set energy1.valid_account='y'
where energy1.ncas_account='532230'
and energy1.ncas_center=energy_report_water_accounts.ncas_center_new
and energy1.account_number=energy_report_water_accounts.water_account_number
and energy1.f_year='$f_year'
and energy_report_water_accounts.f_year='$f_year' ;";

$result5a=mysqli_query($connection, $query5a) or die ("Couldn't execute query 5a. $query5a");



$query6="update energy1,center
set energy1.center_code=center.parkcode
where energy1.ncas_center=center.center; ";

$result6=mysqli_query($connection, $query6) or die ("Couldn't execute query 6. $query6");



$query6a="update energy1,center
set energy1.center_code=center.parkcode
where energy1.ncas_center=center.new_center; ";

$result6a=mysqli_query($connection, $query6a) or die ("Couldn't execute query 6a. $query6a");







{header("location: energy_reporting.php?f_year=$f_year&egroup=water&report=cdcs&valid_account=n");}

 
 ?>