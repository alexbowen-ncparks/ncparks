<?php
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/auth.inc");
//echo "<pre>";print_r($_REQUEST);exit;
//print_r($_SESSION);
//echo "</pre>";
//exit;
extract($_REQUEST);

 foreach ($transfer_request as $key => $value) {
 $value=str_replace(",","",$value);// remove any commas 1,000 => 1000
 $clean_array[$key]=$value;
}

//echo "<pre>";print_r($clean_array);echo "</pre>";

if(round(array_sum($clean_array),2)!=0){
$t=round(array_sum($clean_array),2); echo "Transfer amounts do not equal zero. They equal $t  Click your browser's back button and make sure any request for additional funds in an account is offset by a reduction elsewhere.";exit;}

//echo "<br>t=$t";exit;


 foreach ($clean_array as $key => $value) {

//	$value=str_replace(",","",$value);// remove any commas 1,000 => 1000
 $sql="INSERT into opexpense_transfers_4 SET f_year='$_REQUEST[f_year]', transfer_date='$_REQUEST[today]', center='$_REQUEST[center]', ncas_number='$key',budget_group='$budget_group',transfer_request='$value', user_id='$user_id', source='$source'";
	
//	echo "t=$t<br /><br />$sql<br>"; exit;
	
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql") or die ("Couldn't execute query line 29. $sql".mysqli_error());

}// end for

//exit;

/*Update other Tables */
 $query = "update opexpense_transfers_4
set status='processed'
where 1;";
 $result = @mysqli_query($connection, $query);

 $query = "delete from opexpense_transfers_4
where transfer_request='0';";
 $result = @mysqli_query($connection, $query) or die ("Couldn't execute query line 45. $query".mysqli_error());

 $query = "delete from budget_center_allocations
where budget_group='$budget_group'
and fy_req='$f_year'
and allocation_justification='opex_transfer';
";
 $result = @mysqli_query($connection, $query) or die ("Couldn't execute query line 49. $query".mysqli_error());

 $query = "insert into budget_center_allocations(
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
'$budget_group',
''
from opexpense_transfers_4
where 1
and f_year='$f_year'
and budget_group='$budget_group'
group by id;
";
 $result = @mysqli_query($connection, $query) or die ("Couldn't execute query line 56. $query".mysqli_error());

$center=$_REQUEST['center'];

 header("Location: /budget/a/current_year_budget.php?budget_group_menu=$budget_group&center=$center&submit=Submit");
?>