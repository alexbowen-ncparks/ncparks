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
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters
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
WHERE ncas_center like '1280%'
and ncas_account='532230'
and id > '$last_cdcs'
";

//echo "query1=$query1";exit;

$result1=mysql_query($query1) or die ("Couldn't execute query 1. $query1");


$query2="update energy1
set f_year='1314'
where datesql >= '20130701'
and datesql <= '20140630';";

$result2=mysql_query($query2) or die ("Couldn't execute query 2. $query2");


$query2a="update energy1
set f_year='1415'
where datesql >= '20140701'
and datesql <= '20150630';";

$result2a=mysql_query($query2a) or die ("Couldn't execute query 2a. $query2a");


$query3="update energy1 
set account_number=
SUBSTRING(ncas_invoice_number, 1, CHAR_LENGTH(ncas_invoice_number) - 5)
where account_number='' and cvip_id > '$last_cdcs'
and ncas_account='532230' ";

$result3=mysql_query($query3) or die ("Couldn't execute query 3. $query3");


$query4="update energy1
set calyear1=mid(dateSQL,1,4),
month1=mid(dateSQL,5,2),
day1=mid(dateSQL,7,2)
where 1 ";

$result4=mysql_query($query4) or die ("Couldn't execute query 4. $query4");



$query5="update energy1,energy_report_water_accounts
set energy1.valid_account='y'
where energy1.ncas_account='532230'
and energy1.ncas_center=energy_report_water_accounts.ncas_center
and energy1.account_number=energy_report_water_accounts.water_account_number
and energy1.f_year='$f_year'
and energy_report_water_accounts.f_year='$f_year' ;";

$result5=mysql_query($query5) or die ("Couldn't execute query 5. $query5");


$query6="update energy1,center
set energy1.center_code=center.parkcode
where energy1.ncas_center=center.center; ";

$result6=mysql_query($query6) or die ("Couldn't execute query 6. $query6");

{header("location: energy_reporting.php?f_year=$f_year&egroup=water&report=cdcs&valid_account=n");}

 
 ?>




















