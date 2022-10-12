<?php
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/auth.inc");
//echo "<pre>";print_r($_REQUEST); 
//print_r($_SESSION);
//echo "</pre>";
//exit;
extract($_REQUEST);

//echo "<pre>";print_r($transfer_request);echo "</pre>";
if(round(array_sum($transfer_request),2)!=0){
$t=round(array_sum($transfer_request),2); echo "Transfer amounts do not equal zero. They equal $t. <br /><br />Click your browser's back button and make sure any request for additional funds in one park is offset by an equal reduction elsewhere.";exit;}

 foreach ($transfer_request as $key => $value) {

	$value=str_replace(",","",$value);// remove any commas 1,000 => 1000
	if($value==""){continue;}
 $sql="INSERT payroll_temporary_transfers_4 SET f_year='$_REQUEST[f_year]', transfer_date='$_REQUEST[today]', center='$key', ncas_number='531311',transfer_request='$value', user_id='$user_id', source='$source'";
	
//echo "$sql<br />"; exit;
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");

}// end for

//exit;
$f_year=$_REQUEST['f_year'];

 $sql="update payroll_temporary_transfers_4
set status='processed'
where 1;
";
//echo "$sql<br />";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");



$sql="update payroll_temporary_transfers_4,coa
set payroll_temporary_transfers_4.budget_group=coa.budget_group
where payroll_temporary_transfers_4.ncas_number=coa.ncasnum
;
";
//echo "$sql<br />";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");









 $sql="delete from payroll_temporary_transfers_4
where transfer_request='0';
";
//echo "$sql<br />";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");

//echo "<br />Line 43 successful</br>"; exit;

 $sql="delete from budget_center_allocations
where budget_group='payroll_temporary'
and fy_req=
'$f_year'
and allocation_justification='payroll_temp_transfer';
";
//echo "$sql<br />";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");

 $sql="insert into budget_center_allocations(
center,
ncas_acct,
fy_req,
equipment_request,
user_id,
allocation_level,
allocation_amount,
allocation_justification,
allocation_date,
budget_group,
entrydate
)

select
center,
ncas_number,
f_year,
'',
'',
source,
sum(transfer_request),
'payroll_temp_transfer',
transfer_date,
budget_group,
transfer_date
from payroll_temporary_transfers_4
where 1
and f_year=
'$f_year'
group by id
;
";
//echo "$sql<br />";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");

//exit;
extract($_REQUEST);
 header("Location: /budget/a/current_year_budget_div.php?budget_group_menu=payroll_temporary&dist=$dist&f_year=$f_year&submit=Submit");
?>