<?php
session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://legacypriv36.dev.dpr.ncparks.gov/login_form.php?db=budget");
}
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];

echo "<pre>";print_r($_REQUEST);"</pre>"; 
//exit;

extract($_REQUEST);
$f_year2=$f_year;



//echo $concession_location;
/*
if($level=='5' and $tempID !='Dodd3454')
{
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
}
*/
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;

//echo "f_year2=$f_year2<br />"; //exit;


//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
//include("../../budget/~f_year.php");
$query1="select building_name,address,city,ncas_center
         from energy_report_electricity_accounts
		 where f_year='$f_year2' and park='$park' and valid_account='y' LIMIT 1 ";
		 
//echo "<br /><br />query1=$query1<br /><br />";		 
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);//brings back max (end_date) as $end_date		 

//echo "<br />building_name=$building_name<br />address=$address<br />city=$city<br />ncas_center=$ncas_center<br />";

//exit;		


$query1a="update energy1 set account_number='$account_number' where id='$energy1_id' ";
		 
//echo "<br /><br />query1a=$query1a<br /><br />";

//exit;		 
$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");




 

$query2="insert ignore into energy_report_electricity_accounts
         set f_year='$f_year2',division='parks',park='$park',electricity_account_number='$account_number',
		 building_name='$building_name',address='$address',city='$city',vendor_name='$vendor',ncas_center='$ncas_center',ncas_center_new='$new_center',valid_account='y' ";

echo "<br /><br />query2=$query2<br /><br />";	

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");



//exit;


$query3="update energy1,energy_report_electricity_accounts
set energy1.valid_account='y'
where energy1.ncas_account='532210'
and energy1.ncas_center=energy_report_electricity_accounts.ncas_center
and energy1.account_number=energy_report_electricity_accounts.electricity_account_number
and energy1.f_year='$f_year2'
and energy_report_electricity_accounts.f_year='$f_year2' ;";

//echo "<br />query3=$query3<br />";  //exit;

$result3=mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");


$query4="update energy1,energy_report_electricity_accounts
set energy1.valid_account='y'
where energy1.ncas_account='532210'
and energy1.ncas_center=energy_report_electricity_accounts.ncas_center_new
and energy1.account_number=energy_report_electricity_accounts.electricity_account_number
and energy1.f_year='$f_year2'
and energy_report_electricity_accounts.f_year='$f_year2' ;";

//echo "<br />query4=$query4<br />";  exit;


$result4=mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");



$query4a="select count(account_number) as 'electric_account_count'
          from energy1
		  where f_year='$f_year2'
		  and parkcode='$park'
		  and energy_group='electricity'
		  and account_number='$account_number' ";
		 
echo "<br />query4a=$query4a<br /><br /><br />";
//exit;	


$result4a = mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");
//echo "<br />electricity_accounts.php LINE 32<br />";
//exit;

$row4a=mysqli_fetch_array($result4a);
extract($row4a);//brings back max (end_date) as $end_date

//echo "<br />electric_account_count=$electric_account_count <br /><br />";

$query4b="update energy_report_electricity_accounts
          set record_match='$electric_account_count',energy1_match='y'
		  where electricity_account_number='$account_number'
		  and f_year='$f_year2'
          and park='$park' "; 
		 
//echo "<br />query4b=$query4b <br /><br /><br />";		 
$result4b= mysqli_query($connection, $query4b) or die ("Couldn't execute query 4b  $query4b");



//exit;

{header("location: energy_reporting.php?f_year=$f_year2&egroup=electricity&report=cdcs&valid_account=n&center_code=$park");}



?>
