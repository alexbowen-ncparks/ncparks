<?php
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../include/auth.inc");
//echo "<pre>";print_r($_REQUEST);exit;
//print_r($_SESSION);
//echo "</pre>";
//exit;
extract($_REQUEST);

 foreach ($transfer_request as $key => $value) {
 $value=str_replace(",","",$value);// remove any commas 1,000 => 1000
 $clean_array[$key]=$value;
}

$today=date(Ymd);
echo "<table align='center'><tr><th><font size='10' color='brown'>UNDER Construction: $today</font></th><tr></table>";
echo "<pre>";print_r($clean_array);echo "</pre>";
echo "<pre>";print_r($center_request);echo "</pre>";

if(round(array_sum($clean_array),2)!=0){
$t=round(array_sum($clean_array),2); echo "Transfer amounts do not equal zero. They equal $t  Click your browser's back button and make sure any request for additional funds in an account is offset by a reduction elsewhere.";exit;}

echo "<br>t=$t";

echo "num_rows=$num_rows<br />";
echo "budget_group=$budget_group<br />";
echo "fiscal_year=$fiscal_year<br />";

for($j=0;$j<$num_rows;$j++){
//$query2=$query1;
//$comment_note2=addslashes($comment_note[$j]);
	//$query2.=" comment_note='$comment_note[$j]',";
	//$query2.=" status='$status[$j]'";
	//$query2.=" where comment_id='$comment_id[$j]'";
		

//$result=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");
echo "center_request=$center_request[$j]"; echo "  clean_array=$clean_array[$j]";echo "<br />";
}	

exit;


 foreach ($clean_array as $key => $value) {

//	$value=str_replace(",","",$value);// remove any commas 1,000 => 1000
 $sql="INSERT opexpense_transfers_4 SET f_year='$_REQUEST[f_year]', transfer_date='$_REQUEST[today]', center='$_REQUEST[center]', ncas_number='$key',transfer_request='$value', user_id='$user_id', source='$source'";
	
//	echo "t=$t<br /><br />$sql<br>"; exit;
	
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql") or die ("Couldn't execute query line 29. $sql".mysqli_error());

}// end for

//exit;

/*Update other Tables */

/*
 $query = "update opexpense_transfers_4
set status='processed'
where 1;";
 $result = @mysqli_query($connection, $query,$connection);

 $query = "delete from opexpense_transfers_4
where transfer_request='0';";
 $result = @mysqli_query($connection, $query,$connection) or die ("Couldn't execute query line 45. $query".mysqli_error());

 $query = "delete from budget_center_allocations
where budget_group='operating_expenses'
and fy_req='$f_year'
and allocation_justification='opex_transfer';
";
 $result = @mysqli_query($connection, $query,$connection) or die ("Couldn't execute query line 49. $query".mysqli_error());

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
'operating_expenses',
''
from opexpense_transfers_4
where 1
and f_year=
'$f_year'
group by id;
";
 $result = @mysqli_query($connection, $query,$connection) or die ("Couldn't execute query line 56. $query".mysqli_error());

$center=$_REQUEST['center'];

 header("Location: /budget/a/current_year_budget.php?budget_group_menu=operating_expenses&center=$center&submit=Submit");
 
 */
?>