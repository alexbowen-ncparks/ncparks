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
//echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;

$line_num_beg_bal2=str_replace(",","",$line_num_beg_bal);

$line_num_beg_bal2=str_replace("$","",$line_num_beg_bal2);

$total_paid_old_method2=str_replace(",","",$total_paid_old_method);

$total_paid_old_method2=str_replace("$","",$total_paid_old_method2);



$Lname=substr($tempid,0,-4);
//echo "tempid=$tempid";
//echo "Lname=$Lname";

//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;

//echo "buof_count=$buof_count<br />";  exit;

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
          set division='dpr',park='$park',center='$center',contract_num='$contract_num',po_num='$po_num',vendor='$vendor',fid_num='$fid_num',group_num='$group_num',remit_address='$remit_address',purpose='$purpose',line_num='$line_num',buy_entity='$buy_entity',company='$company',ncas_account='$ncas_account',contract_administrator='$contract_administrator',line_num_beg_bal='$line_num_beg_bal2',total_paid_old_method='$total_paid_old_method2',line_num_beg_bal_verified_by='$tempid',line_num_beg_bal_verified_date='$system_entry_date',total_paid_old_method_verified_by='$tempid',total_paid_old_method_verified_date='$system_entry_date'  
          where id='$id' ";	
	

//echo "query12=$query12<br />"; exit;	
	
	
$result12=mysqli_query($connection,$query12) or die ("Couldn't execute query 12. $query12");

if($buof_count==1)
{

$query13="delete from service_contracts_invoices
          where scid='$id' and invoice_old_method='y' ";	

$result13=mysqli_query($connection,$query13) or die ("Couldn't execute query 13. $query13");


$query14="insert into service_contracts_invoices
          set scid='$id',invoice_num='unknown',invoice_amount='$total_paid_old_method2',invoice_old_method='y',line_num_beg_bal='$line_num_beg_bal2',ncas_account='$ncas_account',park='$park',center='$center',company='$company',service_period='All Invoices prior to New Online method',cashier='$tempid',cashier_date='$system_entry_date',manager='$tempid',manager_date='$system_entry_date',puof='$tempid',puof_date='$system_entry_date',cashier_approved='y',park_approved='y',buof='$tempid',buof_date='$system_entry_date',remit_address='$remit_address'  ";	

$result14=mysqli_query($connection,$query14) or die ("Couldn't execute query 14. $query14");

}




echo "update successful";



header("location: payment_form.php?report_type=$report_type&id=$id&mess=y");





?>