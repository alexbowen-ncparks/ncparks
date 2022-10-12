<?php
ini_set('display_errors',1);
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/authBUDGET.inc");
echo "<pre>";print_r($_REQUEST);exit;
//print_r($_SESSION);
//echo "</pre>";exit;

if(@$submit=="Add"){
$clause="INSERT into equipment_request_3 set ";
 foreach ($_REQUEST as $key => $value) {
	if($key!="submit" AND $key!="PHPSESSID" AND $key!="passQuery"){
	$val=addslashes($value);
$clause.=$key."='".$val."',";}
}
$sql="SELECT max(er_num) as er_num from equipment_request_3";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
$row=mysqli_fetch_array($result);$n=$row[er_num]+1;
$clause.="er_num=".$n;

$result = mysqli_query($connection, $clause) or die ("Couldn't execute query 1. $clause");
//echo "$clause";
 header("Location: /budget/aDiv/equipment_division.php?$passQuery");
exit;
}

//echo "hello";
if(@$submit=="Update"){
 foreach ($_REQUEST as $key => $value) {
	if($key!="submit" AND $key!="PHPSESSID" AND $key!="f_year" AND $key!="center" AND $key!="passQuery"){
 foreach ($value as $er_num => $val){//rearrange by er_num
	$newKey[$er_num][$key]=$val;}
	}
 }
//echo "<pre>";print_r($newKey);echo "</pre>";exit;
 
 foreach ($newKey as $key => $value) {
 $clause="UPDATE equipment_request_3 SET ";
 foreach ($value as $fld => $val){
	$val=str_replace(",","",$val);// remove any commas 1,000 => 1000
	if(($fld=="order_complete"||$fld=="receive_complete"||$fld=="paid_in_full")  and $newKey[$key][ordered_amount]=="0.00"){$val="n";}// never allow y 

if($fld=="ordered_amount" and $newKey[$key]['order_complete']=="n")
{$val="0.00";}// never allow > 0

	if($fld=="unit_cost"){$un=$val;}
	if($fld=="unit_quantity"){$uq=$val;}
	if($fld=="requested_amount"){$val=$un*$uq;}
	
 $clause.=$fld."='".$val."',";
	}
// Rename some fields and remove trailing comma
	$clause.="where er_num='".$key."'";
		$n=",where";$w=" where";
	$clause=str_replace($n,$w,$clause);
//	echo "$clause<br><br>";
	$sql="$clause";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
 }
// exit;

extract($_REQUEST);

if($level>4){
if($f_year==""){include("../~f_year.php");}

$sql="delete from budget_center_allocations
where budget_group='operating_expenses'
and fy_req=
'$f_year'
and allocation_justification='approved_equipment_purchase';
";
//	echo "$sql<br><br>";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 2. $sql");

$d=date("Ymd");
$sql="insert into budget_center_allocations(center,ncas_acct,fy_req,equipment_request,user_id,allocation_level,allocation_amount,allocation_justification,allocation_date,budget_group,entrydate,comments)
select 
pay_center,
'533900',
'$f_year',
'',
'',
'budget_office',
-sum(requested_amount),
'approved_equipment_purchase',
system_entry_date,
'operating_expenses',
'$d',
concat('er',er_num) as 'er_num'
from equipment_request_3
where 1
and f_year=
'$f_year'
and division_approved='y'
and ncas_account like '534%'
and status='active'
and funding_source='opex_transfer'
group by id;
";

//	echo "$sql<br><br>";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 3. $sql");

$sql="delete from budget_center_allocations
where budget_group='equipment'
and fy_req=
'$f_year'
and allocation_justification='approved_equipment_purchase';
";

//	echo "$sql<br><br>";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");

$sql="insert into budget_center_allocations(center,ncas_acct,fy_req,equipment_request,user_id,allocation_level,allocation_amount,allocation_justification,allocation_date,budget_group,entrydate,comments)
select pay_center,ncas_account,f_year,'','','division', sum(ordered_amount),'approved_equipment_purchase','system_entry_date','equipment',
'$d',concat('er',er_num) as 'er_num'
from equipment_request_3
where 1
and f_year=
'$f_year'
and division_approved='y'
and order_complete='y'
and ncas_account like '534%'
and status='active'
group by er_num;
";

//	echo "$sql<br><br>";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 5. $sql");

$sql="insert into budget_center_allocations(center,ncas_acct,fy_req,equipment_request,user_id,allocation_level,allocation_amount,allocation_justification,allocation_date,budget_group,entrydate)
select pay_center,ncas_account,f_year,'','','division',sum(unit_quantity*unit_cost),'approved_equipment_purchase','system_entry_date','equipment',
'$d'
from equipment_request_3
where 1
and f_year=
'$f_year'
and division_approved='y'
and order_complete='n'
and ncas_account like '534%'
and status='active'
group by er_num;
";

//	echo "$sql<br><br>";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 6. $sql");

}
//exit;
 header("Location: /budget/aDiv/equipment_division.php?$passQuery");
 }
?>