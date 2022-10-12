<?php
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/auth.inc");
echo "<pre>";print_r($_REQUEST);
////print_r($_SESSION);
////echo "</pre>";
//exit;
extract($_REQUEST);

//echo "<pre>";print_r($transfer_request);echo "</pre>"; exit;
if(round(array_sum($transfer_request),2)!=0){
$t=round(array_sum($transfer_request),2); echo "Transfer amounts do not equal zero. They equal $t. <br /><br />Click your browser's back button and make sure any request for additional funds in one park is offset by an equal reduction elsewhere.";exit;}


//exit;

/*
if($budget_group=='operating_expenses'){$ncas_default='533900';}
if($budget_group=='opex-repairs_building'){$ncas_default='532310';}
if($budget_group=='opex-repairs_equipment'){$ncas_default='532332';}
if($budget_group=='opex-repairs_vehicles'){$ncas_default='532331';}
if($budget_group=='opex-services'){$ncas_default='532184';}
if($budget_group=='opex-supplies_admin'){$ncas_default='532840';}
if($budget_group=='opex-supplies_facility'){$ncas_default='533210';}
if($budget_group=='opex-supplies_safety'){$ncas_default='533150';}
if($budget_group=='opex-supplies_vehicles'){$ncas_default='533330';}
if($budget_group=='opex-utilities'){$ncas_default='532210';}
if($budget_group=='payroll_temporary'){$ncas_default='531311';}
if($budget_group=='payroll_temporary_receipt'){$ncas_default='531312';}
*/


if($budget_group=='opex-other_services'){$ncas_default='532184';}
if($budget_group=='opex-outside_vendor_repairs'){$ncas_default='532310';}
if($budget_group=='opex-supplies_purchased_by_dpr'){$ncas_default='533110';}



if($budget_group=='opex-utilities'){$ncas_default='532210';}
if($budget_group=='payroll_temporary'){$ncas_default='531311';}
if($budget_group=='payroll_temporary_receipt'){$ncas_default='531312';}








 foreach ($transfer_request as $key => $value) {

	$value=str_replace(",","",$value);// remove any commas 1,000 => 1000
	if($value==""){continue;}
 $sql="INSERT into opexpense_transfers_4 
       SET f_year='$_REQUEST[f_year]', transfer_date='$_REQUEST[today]', center='$key', ncas_number='$ncas_default',transfer_request='$value', user_id='$user_id', source='$source',budget_group='$budget_group' ";
	
//echo "<br />$sql<br />"; //exit;
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");

}// end for

//exit;
$f_year=$_REQUEST['f_year'];

 $sql="update opexpense_transfers_4
set status='processed'
where 1;
";
////echo "$sql<br />";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");

 $sql="delete from opexpense_transfers_4
where transfer_request='0';
";
////echo "<br />$sql<br />";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");


//echo "<br />Line 46"; exit;



 $sql="delete from budget_center_allocations
where budget_group='$budget_group'
and fy_req=
'$f_year'
and allocation_justification='opex_transfer';
";
////echo "$sql<br />";
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
'opex_transfer',
transfer_date,
budget_group,
''
from opexpense_transfers_4
where 1
and f_year='$f_year' and budget_group='$budget_group'
group by id
;
";
////echo "$sql<br />";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");

//exit;

////echo "<br />Line 96"; exit;

extract($_REQUEST);
 header("Location: /budget/a/op_exp_transfer_region.php?budget_group_menu=$budget_group&submit=Submit");
 

 
 
?>