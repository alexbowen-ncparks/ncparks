<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}



$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/authBUDGET.inc");
include("../../../include/activity.php");
extract($_REQUEST);
//session_start();
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

if(!is_array($radioFlds)){$radioFlds=array();}


if($_SESSION['budget']['level']<5){
$sql="select start_date,end_date from budget_transfer_acceptable_dates where budget_group='operating_expenses'";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
$row=mysqli_fetch_array($result);
extract($row);
$today=date("Y-m-d");
if($today>$end_date){echo "Transfer feature is currently unavailable. All Transfers must occur between $start_date and $end_date.";exit;}
}

 
$user_id=$_SESSION['budget']['tempID'];
$parseCenter=explode("-",$center);
$center=$parseCenter[0];
//echo "<pre>";print_r($_REQUEST);print_r($_SESSION);echo "</pre>";//exit;
// Construct Query to be passed to Excel Export
foreach($_REQUEST as $k => $v)
	{
	if($v and $k!="PHPSESSID"){@$varQuery.=$k."=".$v."&";}
	}
   @$varQuery.="rep=excel";    

if(@$rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=equipment_division.xls');
include("equipment_division_header.php");
}

// Get max Date from Exp_Rev
$sql="select max(acctdate) as maxDate from exp_rev where 1";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
$row=mysqli_fetch_array($result);
extract($row);

// Make f_year
if(@$f_year==""){include("../~f_year.php");}


//if(@$rep==""){include_once("../menu.php");}
//if(@$rep==""){include_once("../menu3_js.php");}
include("../../budget/menu1314_v3.php");
$today=date('Ymd');
// *********** Level > 3 ************
if($_SESSION['budget']['level']>3)
	{//print_r($_REQUEST);EXIT;
	
	if(@$rep=="")
		{
		if(@$showSQL==1){$p="method='POST'";}else{$p="";}
		echo "<hr><table align='center'><form action='op_exp_transfer.php' $p>";
		
		// Menu 1
		echo "<tr><td align='center'>f_year <input type='text' name='f_year' value='$f_year' size='5' READONLY></td>";
		   
		// Menu 2
		//echo "<td align='center'>today <input type='text' name='today' value='$today' size='10'></td>";
		
		// Menu 3
		$sql="select distinct(act3.center) as center_codeMenu,parkCode as pc
		from act3
		LEFT JOIN center on act3.center=center.center
		where 1 and act3.center like '1280%' order by pc";
		$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
		while ($row=mysqli_fetch_array($result)){
		extract($row);$menuArray[]=$center_codeMenu;$parkCodeArray[]=$pc;}
		
		echo "<td align='center'>Center <select name=\"center\"><option selected></option>";
		for ($n=0;$n<count($menuArray);$n++){
		if($center==$menuArray[$n] and $center!=""){$s="selected";}else{$s="value";}
		$con=$menuArray[$n];
				echo "<option $s='$con'>$menuArray[$n]-$parkCodeArray[$n]</option>\n";
			   }
		   echo "</select></td>";
		   
		   echo "<td>&nbsp;&nbsp;&nbsp;<input type='checkbox' name='showSQL' value='1'>Show SQL
		<input type='submit' name='submit' value='Submit'>";
		echo "</form></td><form><td><input type='submit' name='reset' value='Reset'></td></form><td><a href='op_exp_transfer.php?$varQuery'>Excel</a></td></tr></table>";
		}
	}// end Level > 3
else
	{
	//$center=$_SESSION[budget][centerSess];
	$whereFilter.=" and opexpense_transfers_4_form.center='$center'";}

if($submit!="Submit"){exit;}
//exit;
// ********* Body Queries ***************
 $query = "truncate table budget1_unposted";
    $result = @mysqli_query($connection, $query,$connection);
if(@$showSQL=="1"){echo "<br><br>$query<br><br>";}
//echo "$query<br>";//exit;

 $query = "insert into budget1_unposted(
center,
account,
vendor_name,
transaction_date,
transaction_number,
transaction_amount,
transaction_type,
source_table,
source_id)
select
ncas_center,
ncas_account,
vendor_name,
datesql,
ncas_invoice_number,
ncas_invoice_amount,'cdcs','cid_vendor_invoice_payments',id
from cid_vendor_invoice_payments
where 1
and post2ncas != 'y'
and ncas_credit != 'x' 
group by id";
    $result = @mysqli_query($connection, $query,$connection) or die ("Couldn't execute query line 100. $query".mysqli_error());
if(@$showSQL=="1"){echo "$query<br><br>";}
//echo "$query<br>";//exit;

 $query = "insert into budget1_unposted( center, account, vendor_name, transaction_date, transaction_number, transaction_amount, transaction_type, source_table, source_id) select ncas_center, ncas_account, vendor_name, datesql, ncas_invoice_number, -ncas_invoice_amount,'cdcs','cid_vendor_invoice_payments',id from cid_vendor_invoice_payments where 1 and post2ncas != 'y' and ncas_credit = 'x' group by id;
";
    $result = @mysqli_query($connection, $query,$connection);
if(@$showSQL=="1"){echo "$query<br><br>";}
//echo "$query<br>";//exit;


 $query = "insert into budget1_unposted(
center,
account,
vendor_name,
transaction_date,
transaction_number,
transaction_amount,
transaction_type,
source_table,
source_id)
select
center,
ncasnum,
concat('pcard','-',cardholder,'-',vendor_name,'-',trans_date),
transdate_new,
transid_new,
sum(amount),'pcard','pcard_unreconciled',id
from pcard_unreconciled where 1
and ncas_yn != 'y' group by id";
    $result = @mysqli_query($connection, $query,$connection) or die ("Couldn't execute query line 133. $query".mysqli_error());
if(@$showSQL=="1"){echo "$query<br><br>";}
//echo "$query<br>";//exit;

 $query = "insert into budget1_unposted(
center,
account,
vendor_name,
transaction_date,
transaction_number,
transaction_amount,
transaction_type,
source_table,
source_id)
select center,
ncasnum,
concat(postitle,'-',posnum,'-',tempid),
datework,'na',
sum(rate*hr1311), 'seapay','seapay_unposted',
prid
from seapay_unposted 
where 1
group by prid;";
    $result = @mysqli_query($connection, $query,$connection) or die ("Couldn't execute query line 156. $query".mysqli_error());
if(@$showSQL=="1"){echo "$query<br><br>";}
//echo "$query<br>";//exit;



 $query = "truncate table opexpense_transfers_4_form;";
    $result = @mysqli_query($connection, $query,$connection);
if(@$showSQL=="1"){echo "$query<br><br>";}
//echo "$query<br>";//exit;

 $query = "insert into opexpense_transfers_4_form
(center,
ncas_number,
f_year,
py_amount,
allocation_amount,
cy_actual,
transfer_request)
select
center,
act3.ncasnum,
'$f_year',
sum(amount_py1) as 'py_amount',
'',
sum(amount_cy) as 'amount_cy',
''
from act3
left join coa on act3.ncasnum=coa.ncasnum
where 1 and coa.budget_group='operating_expenses'
group by center,act3.ncasnum;";
//echo "$query<br>";//exit;

 $result = @mysqli_query($connection, $query,$connection);
if(@$showSQL=="1"){echo "$query<br><br>";}

 $query = "insert into opexpense_transfers_4_form
(center,
ncas_number,
f_year,
py_amount,
allocation_amount,
cy_actual,
transfer_request)
select
center,
ncas_acct,
fy_req,
'',
sum(allocation_amount) as 'allocation_amount',
'',
''
from budget_center_allocations
left join coa on budget_center_allocations.ncas_acct=coa.ncasnum
where 1 and coa.budget_group='operating_expenses' and fy_req='$f_year'
group by center,ncas_acct;";
//echo "$query<br>";//exit;

 $result = @mysqli_query($connection, $query,$connection) or die ("Couldn't execute query line 211. $query".mysqli_error());
if(@$showSQL=="1"){echo "$query<br><br>";}


 $query = "insert into opexpense_transfers_4_form
(center,
ncas_number,
f_year,
py_amount,
allocation_amount,
cy_actual,
transfer_request)
select
center,ncas_number,
f_year,'','','',transfer_request
from opexpense_transfers_4
left join coa on opexpense_transfers_4.ncas_number=coa.ncasnum
where 1 and coa.budget_group='operating_expenses'
and f_year=
'$f_year'
and status='not_processed'
group by center,ncas_number;";
//echo "$query<br>";//exit;

 $result = @mysqli_query($connection, $query,$connection) or die ("Couldn't execute query line 237. $query".mysqli_error());
if(@$showSQL=="1"){echo "$query<br><br>";}

 $query = "insert into opexpense_transfers_4_form
(center,
ncas_number,
f_year,
cy_unposted)
select
center,
account,
'$f_year',
sum(transaction_amount)
from
budget1_unposted
left join coa on budget1_unposted.account=coa.ncasnum
where 1 and coa.budget_group='operating_expenses'
group by center,account;";
//echo "$query<br>";//exit;

 $result = @mysqli_query($connection, $query,$connection) or die ("Couldn't execute query line 260. $query".mysqli_error());
if(@$showSQL=="1"){echo "$query<br><br>";}

$headerArray=array("center_code","center","dist","section","ncas_number","acct_description","cy_budget","cy_actual","cy_unposted","available_balance","transfer_request");

if($level>3){
$decimalFlds=array("cy_budget","cy_actual","cy_available", "transfer_request");

}

/*select query for center budgets*/

 $query = "select center.parkcode as 'center_code',
opexpense_transfers_4_form.center,
center.dist,
center.section,
opexpense_transfers_4_form.ncas_number,
coa.park_acct_desc as 'acct_description',
sum(py_amount+allocation_amount) as 'cy_budget',
sum(cy_actual) as 'cy_actual',
sum(cy_unposted) as 'cy_unposted',
sum(py_amount+allocation_amount-cy_actual-cy_unposted) as 'available_balance',
sum(transfer_request) as 'transfer_request'
from opexpense_transfers_4_form
left join coa on opexpense_transfers_4_form.ncas_number=coa.ncasnum
left join center on opexpense_transfers_4_form.center=center.center
where 1
and opexpense_transfers_4_form.center='$center'
group by opexpense_transfers_4_form.center,opexpense_transfers_4_form.ncas_number
order by opexpense_transfers_4_form.ncas_number;";
//echo "$query<br>";//exit;

if(@$showSQL=="1"){echo "$query<br>";}
if($level<3)
	{
	$ex="<a href='op_exp_transfer.php?$varQuery'>Excel</a>";
	}
	else
	{$ex="";}
if(@$rep!="excel")
	{
	$goBack="<tr><td colspan='10' align='center'><font size='+1'>Report date: <font color='purple'>$maxDate</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$ex</td><td>Result: <input name='sum' id='sum' type=text size='9' readonly></td></tr>";
	}

echo "<table border='1'>$goBack";

$count=count($headerArray);
for($i=0;$i<$count;$i++)
	{
	$h=$headerArray[$i];
	@$header.="<th>".$h."</th>";
	}

echo "<tr>$header</tr>";

$resultFinal = mysqli_query($connection, $query)  or die ("Couldn't execute query line 289. $query".mysqli_error());
//$num=mysqli_num_rows($result);

while($row=mysqli_fetch_array($resultFinal)){
$b[]=$row;
}// end while
//echo "<pre>";print_r($b);echo "</pre>";exit;

if($level>4){

$decimalFlds=array("cy_budget","cy_actual","cy_unposted", "available_balance");

// Make all Fields editable except those unset
//if($edit){$editFlds=$headerArray;unset($editFlds[0],$editFlds[8],$editFlds[9],$editFlds[14],$editFlds[16],$editFlds[17]);}

$editFlds=array("transfer_request");

echo "<form action='op_exp_transfer_update.php' method='POST'>";
	for($i=0;$i<count($b);$i++){
$x=2;
$r=fmod($i,$x);if($r==0){$bc=" bgcolor='aliceblue'";}else{$bc="";}
echo "<tr$bc>";
	for($j=0;$j<count($headerArray);$j++){
	$var=$b[$i][$headerArray[$j]];
	if($headerArray[$j]=="ncas_number"){$KEY=$var;}
	if($var<0){$f1="<font color='red'>";$f2="</font>";}else{$f1="";$f2="";}
	
	if(@in_array($headerArray[$j],$decimalFlds))
		{
		$a="<td align='right'>";
		@$totArray[$headerArray[$j]]+=$var;
		$var=number_format($var,2);
		}
		else{$a="<td>";}
			
		if(in_array($headerArray[$j],$editFlds))
			{
			if(@in_array($headerArray[$j],$radioFlds))
			{
				if($var=="y")
				{$ckY="checked";$ckN="";}else{$ckN="checked";$ckY="";}
	
			echo "<td align='center'>
			<font color='green'>Y</font><input type='radio' name='$headerArray[$j][$KEY]' value='y'$ckY>
			 <font color='red'>N</font><input type='radio' name='$headerArray[$j][$KEY]' value='n'$ckN></td>";
			 }
	else
				
				{echo "<td bgcolor='beige' align='center'><input type='text' name='$headerArray[$j][$KEY]' value='$var' size='10' onchange=add()></td>";}
				
				}else{echo "$a$f1$var$f2</td>";
			}	
	}
	
echo "</tr>";
	$x++;}
}// end if
else{

//$radioFlds=array("district_approved","division_approved","order_complete","receive_complete","paid_in_full");

$decimalFlds=array("cy_budget","cy_actual","posted_balance","cy_available");

// Make all Fields editable except those unset
//if($edit){$editFlds=$headerArray;unset($editFlds[0],$editFlds[8],$editFlds[9],$editFlds[14],$editFlds[16],$editFlds[17]);}

$editFlds=array("transfer_request");


echo "<form action='op_exp_transfer_update.php' method='POST'>";
	for($i=0;$i<count($b);$i++){
$x=2;
$r=fmod($i,$x);if($r==0){$bc=" bgcolor='aliceblue'";}else{$bc="";}
echo "<tr$bc>";
	for($j=0;$j<count($headerArray);$j++){
	$var=$b[$i][$headerArray[$j]];$fieldName=$headerArray[$j];
	if($headerArray[$j]=="ncas_number"){$KEY=$var;}
	if($var<0){$f1="<font color='red'>";$f2="</font>";}else{$f1="";$f2="";}
	
	if(in_array($headerArray[$j],$decimalFlds)){
	$a="<td align='right'>";$totArray[$headerArray[$j]]+=$var;
	$var=number_format($var,2);
			}else{$a="<td>";}
			
			if(in_array($headerArray[$j],$editFlds)){
			if(in_array($headerArray[$j],$radioFlds)){
	if($var=="y")
{$ckY="checked";$ckN="";}else{$ckN="checked";$ckY="";}

echo "<td align='right'>
<font color='green'>Y</font><input type='radio' name='$headerArray[$j][$key]' value='y'$ckY>
 <font color='red'>N</font><input type='radio' name='$headerArray[$j][$key]' value='n'$ckN></td>";}
else
			
			{echo "<td bgcolor='beige' align='center'><input type='text' name='$headerArray[$j][$KEY]' value='$var' size='10' onchange=add()></td>";}
			
			
			}else{echo "$a$f1$var$f2</td>";}
	$x++;}
	
echo "</tr>";
	}
}

echo "<tr>";
	for($j=0;$j<count($headerArray);$j++)
		{
		if(@$totArray[$headerArray[$j]]){
		$var=$totArray[$headerArray[$j]];
		if($var<0){$f1="<font color='red'>";$f2="</font>";}else{$f1="";$f2="";}
		$v=number_format($var,2);
		echo "<td align='right'><b>$v</b></td>";}else{echo "<td></td>";}
		}

if($level>0 and @$doNotUpdate==""){
echo "</tr>$header
<tr><td colspan='10' align='right'>
<input type='hidden' name='source' value='park'>
<input type='hidden' name='user_id' value='$user_id'>
<input type='hidden' name='today' value='$today'>
<input type='hidden' name='f_year' value='$f_year'>
<input type='hidden' name='center' value='$center'>
<input type='submit' name='submit' value='Update'>
</td>
</form>";
}

/*
 $query = "update lock_tables set op_exp_transfer=''";
if(@$showSQL=="1"){echo "<br><br>$query<br><br>";}
 $result = @mysqli_query($connection, $query,$connection);
 */

echo "</tr></table></body></html>";

/* not used
function numFormat($nf){
$nf=number_format($nf,2);
return $nf;}
*/
?>



