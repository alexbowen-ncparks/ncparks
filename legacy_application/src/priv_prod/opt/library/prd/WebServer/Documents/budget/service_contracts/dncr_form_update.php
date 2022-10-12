<?php


session_start();



$active_file=$_SERVER['SCRIPT_NAME'];



$level=$_SESSION['budget']['level'];

$posTitle=$_SESSION['budget']['position'];

$tempid=$_SESSION['budget']['tempID'];

$beacnum=$_SESSION['budget']['beacon_num'];

$concession_location=$_SESSION['budget']['select'];

$concession_center=$_SESSION['budget']['centerSess'];

$system_entry_date=date("Ymd");

extract($_REQUEST);
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;




$Lname=substr($tempid,0,-4);
//echo "tempid=$tempid";
//echo "Lname=$Lname";

//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");


if($role=='cashier')
{
		   
$query12="update service_contracts_invoices
          set cashier='$tempid',cashier_date='$system_entry_date',cashier_approved='y' 
          where id='$id' ";	
	

//echo "query12=$query12<br />"; exit;	
	
	
$result12=mysqli_query($connection, $query12) or die ("Couldn't execute query 12. $query12");

}

if($role=='manager')
{
		   
$query12="update service_contracts_invoices
          set manager='$tempid',manager_date='$system_entry_date',park_approved='y' 
          where id='$id' ";	
	

//echo "query12=$query12<br />"; exit;	
	
	
$result12=mysqli_query($connection, $query12) or die ("Couldn't execute query 12. $query12");

}



if($role=='puof')
{
		   
$query12="update service_contracts_invoices
          set puof='$tempid',puof_date='$system_entry_date',park_approved='y' 
          where id='$id' ";	
	

//echo "query12=$query12<br />"; exit;	
	
	
$result12=mysqli_query($connection, $query12) or die ("Couldn't execute query 12. $query12");

}



if($role=='buof')
{
		   
$query12="update service_contracts_invoices
          set buof='$tempid',buof_date='$system_entry_date',park_approved='y' 
          where id='$id' ";	
	

//echo "query12=$query12<br />"; exit;	
	
	
$result12=mysqli_query($connection, $query12) or die ("Couldn't execute query 12. $query12");

}





echo "update successful";



header("location: all_invoices.php?report_type=reports&id=$scid");





?>