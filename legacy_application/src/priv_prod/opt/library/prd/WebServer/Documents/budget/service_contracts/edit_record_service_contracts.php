<?php



session_start();



$active_file=$_SERVER['SCRIPT_NAME'];



$level=$_SESSION['budget']['level'];

$posTitle=$_SESSION['budget']['position'];

$tempid=$_SESSION['budget']['tempID'];

$beacnum=$_SESSION['budget']['beacon_num'];

$concession_location=$_SESSION['budget']['select'];

$concession_center=$_SESSION['budget']['centerSess'];







extract($_REQUEST);

//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

$fee_amount=str_replace(",","",$fee_amount);

$fee_amount=str_replace("$","",$fee_amount);


//echo "<pre>";print_r($_SERVER);"</pre>";//exit;

//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

//echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;


$Lname=substr($tempid,0,-4);
//echo "tempid=$tempid";
//echo "Lname=$Lname";

//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

$database="budget";
$db="budget";
//include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
//mysqli_select_db($connection, $database); // database
mysqli_select_db($connection,$database); // database
//include("../../../include/activity.php");// database connection parameters
include("../../../include/activity_new.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");


  
		   
$query12="update service_contracts
          set division='dpr',park='$park',center='$center',type='$type',contract_num='$contract_num',po_num='$po_num',vendor='$vendor',monthly_cost='$monthly_cost',yearly_cost='$yearly_cost',original_contract_date='$original_contract_date',original_contract_date2='$original_contract_date2',first_renewal_requested='$first_renewal_requested',first_renewal_date='$first_renewal_date',first_renewal_date2='$first_renewal_date2',second_renewal_requested='$second_renewal_requested',second_final_renewal_date='$second_final_renewal_date',second_final_renewal_date2='$second_final_renewal_date2',comments='$comments',entered_by='$Lname',active='$active',purpose='$purpose',contract_administrator='$contract_administrator',remit_address='$remit_address',fid_num='$fid_num',group_num='$group_num',line_num='$line_num',company='$company',ncas_account='$ncas_account',line_num_beg_bal='$line_num_beg_bal',buy_entity='$buy_entity'  
          where id='$id' ";	

//echo "query12=$query12<br />"; exit;
		  
$result12=mysqli_query($connection,$query12) or die ("Couldn't execute query 12. $query12");

//echo "update successful";


header("location: service_contracts.php?parkS=$park&edit_id=$id");





?>