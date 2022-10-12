<?php
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/auth.inc");
//echo "<pre>";print_r($_REQUEST);
////print_r($_SESSION);
////echo "</pre>";
//exit;
extract($_REQUEST);

//echo "<pre>";print_r($transfer_request);echo "</pre>";
//exit;
if(round(array_sum($transfer_request),2)!=0){
$t=round(array_sum($transfer_request),2); echo "Transfer amounts do not equal zero. They equal $t. <br /><br />Click your browser's back button and make sure any request for additional funds in one park is offset by an equal reduction elsewhere.";exit;}
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
	
//echo "<br />$sql<br />"; exit;
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


/*
$query = "SELECT `cy`,`py1`,`py2`,`py3` from fiscal_year where report_year='$f_year' ";
$result = @mysqli_query($connection, $query);
$row=mysqli_fetch_array($result);
extract($row);
*/

/*
echo "<br />Line 126: query=$query<br />";

echo "<br />cy=$cy<br>";
echo "<br />py1=$py1<br />";  
echo "<br />py2=$py2<br />";  
echo "<br />py3=$py3<br />"; 

*/
//exit;



/*
$sql="SELECT DATE_FORMAT(max(acctdate),'Report Date: %c/%e/%Y') as maxDate, DATE_FORMAT(max(acctdate),'%Y%m%d') as maxDate1 FROM `exp_rev` WHERE 1 and f_year='$cy' ";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 0. $sql");
$row=mysqli_fetch_array($result);
extract($row);
*/

/*
echo "<br />Line 142: $sql<br>";
echo "<br />maxDate=$maxDate<br />";  
echo "<br />maxDate1=$maxDate1<br />"; 

*/
//exit;

/*
$range_start_LY=("20".substr($py1,0,2).'0701');
$range_end_LY=(substr($maxDate1,0,4)-1).substr($maxDate1,4,4);
*/

/*
echo "<br />range_start_LY=$range_start_LY<br />";  
echo "<br />range_end_LY=$range_end_LY<br />"; 

*/
//exit;


/*


$query = "truncate table `act3`";
$result = @mysqli_query($connection, $query);
//echo "$query<br><br>";


 $query = "INSERT INTO act3( ncasnum,center,amount_PY3, amount_PY2, amount_PY1, amount_CY, allocation_amount,f_year )
SELECT acct, center, sum( debit - credit ), '', '', '', '', f_year
FROM `exp_rev`
WHERE 1 AND f_year = '$py3'
GROUP BY acct, center";
$result = @mysqli_query($connection, $query);
//if($showSQL=="1"){echo "$query<br><br>";}
//echo "$query<br><br>AND fund = '1280' ";


 $query = "INSERT INTO act3( ncasnum,center,amount_PY3, amount_PY2, amount_PY1, amount_CY, allocation_amount, f_year)
SELECT acct, center, '',sum( debit - credit ),'','','', f_year
FROM `exp_rev`
WHERE 1 AND f_year = '$py2'
GROUP BY acct, center";
 $result = @mysqli_query($connection, $query);
//if($showSQL=="1"){echo "$query<br><br>";}
//echo "$query<br><br>AND fund = '1280' ";


 $query = "INSERT INTO act3( ncasnum,center,amount_PY3, amount_PY2, amount_PY1, amount_CY, allocation_amount, f_year)
SELECT acct, center, '','',sum( debit - credit ),'','', f_year
FROM `exp_rev`
WHERE 1 AND f_year = '$py1'
GROUP BY acct, center";
$result = @mysqli_query($connection, $query);
//if($showSQL=="1"){echo "$query<br><br>";}
//echo "$query<br><br>AND fund = '1280' ";




 $query = "INSERT INTO act3( ncasnum,center,amount_PY3, amount_PY2, amount_PY1, amount_CY, allocation_amount,authorized_budget_cy,f_year,amount_LYTT )
SELECT acct, center, '','','','','','','',sum(debit-credit)
FROM `exp_rev`
WHERE 1 AND f_year = '$py1'
and acctdate >='$range_start_LY' and acctdate <= '$range_end_LY'
GROUP BY acct, center";
$result = @mysqli_query($connection, $query);
//echo "$query<br><br>AND fund = '1280' ";


$query = "INSERT INTO act3( ncasnum,center,amount_PY3, amount_PY2, amount_PY1, amount_CY, allocation_amount, f_year)
SELECT acct , center, '','','',sum( debit - credit ),'', f_year
FROM `exp_rev`
WHERE 1  AND f_year = '$cy'
GROUP BY acct, center";
$result = @mysqli_query($connection, $query);
//if($showSQL=="1"){echo "$query<br><br>";}
//echo "$query<br><br>AND exp_rev.fund = '1280' ";


 $query = "INSERT INTO act3( ncasnum,center,amount_PY3, amount_PY2, amount_PY1, amount_CY, allocation_amount, f_year)
SELECT ncas_acct,center,'','','','',sum( allocation_amount ), fy_req
FROM `budget_center_allocations`
WHERE 1 AND fy_req='$cy'
GROUP BY ncas_acct,center";
$result = @mysqli_query($connection, $query);

*/



////echo "<br />Line 96"; exit;

//extract($_REQUEST);
// header("Location: /budget/a/current_year_budget_div.php?budget_group_menu=$budget_group&dist=$dist&f_year=$f_year&submit=Submit");




 header("Location: /budget/a/op_exp_transfer_dist.php?budget_group_menu=$budget_group&dist=$dist&f_year=$f_year&submit=Submit");
?>