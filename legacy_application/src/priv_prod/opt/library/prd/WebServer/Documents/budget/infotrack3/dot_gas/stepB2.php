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



$query1="insert into dot_gas_detail(document_number,posting_date,document_date,wbs_element,co_object_name,cost_element,cost_element_name,material,material_description,
               total_quantity,bill_amount,key_number,partner_object,description)
select document_number,posting_date,document_date,wbs_element,co_object_name,cost_element,cost_element_name,material,material_description,
               total_quantity,val_coarea_crcy,key_number,partner_object,description
from dot_gas_import where 1 and document_number != '' and document_number not like '%document%'  ";
			 
mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

//echo "line 49 ok <br />"; exit;

//echo "query1<br />";



$query2="update dot_gas_detail
set ncas_account='533320',energy_group='diesel_fuel',energy_subgroup='all',cdcs_uom='dsl',energy_quantity=total_quantity
where material_description like '%diesel%'
and valid='n' ";
			 
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


//echo "query2<br />";



$query3="update dot_gas_detail
set ncas_account='533310',energy_group='gasoline',energy_subgroup='E10',cdcs_uom='E10',energy_quantity=total_quantity
where material_description not like '%diesel%'
and valid='n' ";
			 
mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");



//echo "query3<br />";


$query4="update budget.dot_gas_detail,fuel.vehicle
set budget.dot_gas_detail.center_code_fdb=fuel.vehicle.center_code
where budget.dot_gas_detail.key_number=fuel.vehicle.dot_key
and valid='n' ";
			 
mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

//echo "line 86 ok <br />"; exit;


//echo "query4<br />";



//echo "query4a<br />";



$query5="update dot_gas_detail,dot_gas_keys2
set dot_gas_detail.center_code_tammy=dot_gas_keys2.location_new
where dot_gas_detail.key_number=dot_gas_keys2.key_num 
and dot_gas_keys2.key_count='1' ";
			 
mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");



//echo "query5<br />";




$query6="update dot_gas_detail
set center_code_temp=center_code_fdb
where center_code_fdb != '' ";
			 
mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");



//echo "query6<br />";


$query7="update dot_gas_detail
set center_code_temp = center_code_tammy
where center_code_temp = '' ";
			 
mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");


$query7a="update dot_gas_detail,center
          set dot_gas_detail.cc_temp_valid='y'
		  where dot_gas_detail.center_code_temp=center.parkcode
		  and center.fund='1280' ";
			 
mysqli_query($connection, $query7a) or die ("Couldn't execute query 7a.  $query7a");

/*
$query7a1="update dot_gas_detail
          set dot_gas_detail.cc_temp_valid='y'
		  where center_code_temp='brya' ";
			 
mysqli_query($connection, $query7a1) or die ("Couldn't execute query 7a1.  $query7a1");
*/


$query7b="select count(id) as 'incomplete_records' 
          from dot_gas_detail
		  where cc_temp_valid='n'
		   ";

		  
//echo "query7b=$query7b <br />";		  

$result7b = mysqli_query($connection, $query7b) or die ("Couldn't execute query 7b.  $query7b");

$row7b=mysqli_fetch_array($result7b);
extract($row7b);


//echo "incomplete_records=$incomplete_records <br />";  exit;

//if($incomplete_records != '0') {$icr='y';} else {$icr='n';)


if($incomplete_records == '0') {include("stepB2a.php");} //All records have Center Values
if($incomplete_records != '0') {include("stepB2b.php");} //1+ Records are missing Center Values




 ?>




















