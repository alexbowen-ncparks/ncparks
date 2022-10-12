<?php
//session_start();

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}

$database="budget";
$db="budget";
include("../../../include/auth.inc");
//echo "<pre>";print_r($_SESSION);echo "</pre>"; //exit;
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../include/activity.php");

//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
$dbTable="partf_payments";
$file="park_project_balances.php";
$fileMenu="park_project_balances_menu.php";

//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];// now set in authBUDGET.inc

extract($_REQUEST);
$distPark=strtoupper($parkcode);
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database

// ******** Display posted_expenses by project number ***********
if($expense=="1"){

$sql="SELECT proj_num, center, datenew, invoice, vendorname, pcard_vendor, pcard_name, account, coa.park_acct_desc AS  'acct_desc', amount, purch_descr_input AS  'purch_desc'
FROM partf_payments
LEFT  JOIN coa ON partf_payments.account = coa.ncasnum
WHERE proj_num =  '$projnum'
ORDER  BY  `center` , datenew DESC";

$result = mysql_query($sql) or die ("Couldn't execute query 0. $sql");
//if(@$showSQL=="1"){echo "$sql<br><br>";}

echo "<table align='center' border='1'>
<tr><th>Project Number</th><th>Center</th><th>Date</th><th>Invoice</th><th>Vendor Name</th><th>Pcard Vendor</th><th>Pcard name</th><th>Account</th><th>Account Desc.</th><th>Amount</th><th>Purchase Desc.</th></tr>";
$i=0;
while($row=mysql_fetch_array($result)){
extract($row);
$amountF=number_format($amount,2);

if($i!=0 AND $ckCenter!=$center){
$subCenterF=number_format($subCenter,2);
echo "<tr><td colspan='9' align='right'><b>Subtotal for Center $ckCenter:</b></td><td  align='right'>$subCenterF</td></tr>";

$subCenter="";
echo "<tr><td>$proj_num</td><td>$center</td><td>$datenew</td><td>$invoice</td><td>$vendorname</td><td>$pcard_vendor</td><td>$pcard_name</td><td>$account</td><td>$acct_desc</td><td align='right'>$amountF</td><td>$purch_desc</td></tr>";}

else{
echo "<tr><td>$proj_num</td><td>$center</td><td>$datenew</td><td>$invoice</td><td>$vendorname</td><td>$pcard_vendor</td><td>$pcard_name</td><td>$account</td><td>$acct_desc</td><td align='right'>$amountF</td><td>$purch_desc</td></tr>";}
$i++;
$ckCenter=$center;
$subCenter=$subCenter+$amount;
$total=$total+$amount;
}// end while

$subCenterF=number_format($subCenter,2);
$totalF=number_format($total,2);
echo "<tr><td colspan='9' align='right'><b>Subtotal for Center $ckCenter:</b></td><td  align='right'>$subCenterF</td></tr>
<tr><td colspan='9' align='right'><b>Grand Total:</b></td><td  align='right'>$totalF</td></tr>";

echo "<tr><td colspan='11' align='center'>Click your browser's back button to return to Project Balances.</td></table>";
exit;}


// ******** Display posted_expenses by project number ***********
if($expense=="2"){

$sql="select
center,
project_number,
vendor_name,
transaction_date,
transaction_number,
transaction_type,
transaction_amount,
source_id
from project_unposted1
where project_number='$projnum'
";

$result = mysql_query($sql) or die ("Couldn't execute query 0. $sql");
//if(@$showSQL=="1"){echo "$sql<br><br>";}

echo "<table align='center' border='1'>
<tr><th>center</th><th>project_number</th><th>vendor_name</th><th>transaction_date</th><th>transaction_number</th><th>transaction_type</th><th>transaction_amount</th><th>source_id</th></tr>";
$i=0;
while($row=mysql_fetch_array($result)){
extract($row);
$transaction_amountF=number_format($transaction_amount,2);

if($i!=0 AND $ckCenter!=$center){
$subCenterF=number_format($subCenter,2);
echo "<tr><td colspan='9' align='right'><b>Subtotal for Center $ckCenter:</b></td><td  align='right'>$subCenterF</td></tr>";

$subCenter="";
echo "<tr><td>$center</td><td>$project_number</td><td>$vendor_name</td><td>$transaction_date</td><td>$transaction_number</td><td>$transaction_type</td><td align='right'>$transaction_amount</td><td>$source_id</td></tr>";}

else{
echo "<tr><td>$center</td><td>$project_number</td><td>$vendor_name</td><td>$transaction_date</td><td>$transaction_number</td><td>$transaction_type</td><td align='right'>$transaction_amount</td><td>$source_id</td></tr>";}
$i++;
$ckCenter=$center;
$subCenter=$subCenter+$transaction_amount;
$total=$total+$transaction_amount;
}// end while

$subCenterF=number_format($subCenter,2);
$totalF=number_format($total,2);
echo "<tr bgcolor='aliceblue'><td colspan='6' align='right'><b>Subtotal for Center $ckCenter:</b></td><td  align='right'>$subCenterF</td></tr>
<tr><td colspan='6' align='right'><b>Grand Total:</b></td><td  align='right'><b>$totalF</b></td></tr>";

echo "<tr><td colspan='11' align='center'>Click your browser's back button to return to Project Balances.</td></table>";
exit;}

// ******** Edit/Update Status ***********
if($submit=="Update"){
$system_entry_date=date("Ymd");
if($statusPer=='FI'){$statusper_fi_date=$system_entry_date;}
if($statusPer!='FI'){$statusper_fi_date='0000-00-00';}

//Adds "Date Complete stamp" when User is updating Project Status with $statusPer==FI

$query="UPDATE `partf_projects` set statusper='$statusPer', statusper_fi_date='$statusper_fi_date' WHERE projnum='$projnum'";

//echo "$query";exit;
$result = mysql_query($query) or die ("Couldn't execute query 0. $query");
if($cen){
header("Location: /budget/b/prtf_center_budget_a.php?center=$cen&submit=Submit");}
else{
header("Location: park_project_balances.php?parkcode=$park");}
}

if($status=="1"){
$s_array=array("OH","IP","FI","NS","CA","TR");

$sql="SELECT * FROM `partf_projects` WHERE projnum='$projnum'";
$result = mysql_query($sql) or die ("Couldn't execute query 0. $sql");
$row=mysql_fetch_array($result);extract($row);
echo "<form action='park_project_balances.php'><table align='center' border='1'>
<tr><th>Project Number</th><th>Park</th><th>Project Name</th><th>Project Status</th></tr>
<tr><td align='center'>$projNum</td><td>$park</td><td>$projName</td>

<td align='center'><select name='statusPer'>\n";
for($i=0;$i<count($s_array);$i++)
{
 if($statusPer==$s_array[$i]){$v="selected";}else{$v="value";}
     echo "<option $v='$s_array[$i]'>$s_array[$i]\n";
}
echo "</select></td></tr>
<tr><td colspan='4' align='center'>
<input type='hidden' name='park' value='$park'>
<input type='hidden' name='projnum' value='$projnum'>
<input type='hidden' name='cen' value='$cen'>
<input type='submit' name='submit' value='Update'>
</table></form>";
exit;}

// **************  Show Results ***************
// Get most recent date from Exp_Rev
$sql="SELECT DATE_FORMAT(max(datenew),'Report Date: %c/%e/%y') as maxDate FROM `partf_payments` WHERE 1";
$result = mysql_query($sql) or die ("Couldn't execute query 0. $sql");
$row=mysql_fetch_array($result);
extract($row);

if($rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=prtf_center_budget.xls');
}


// ******** Show Results ***********

if($rep==""){
//echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
$varQuery=$_SERVER['QUERY_STRING'];
include("$fileMenu");
if($varQuery){echo "<a href='park_project_balances.php?$varQuery&rep=excel'>Excel Export</a>";}
}

$WHERE="where 1 and projyn='y'";

// Determine access
if($level>2)
{$WHERE.=" and park='$parkcode'";}

if($level==2)
	{
	include_once("../../../include/get_parkcodes.php");
	$parkList=$_SESSION['budget']['select'];// Get district
	$da=${"array".$parkList};// print_r($da);exit;
	if(in_array($parkList,$da)){
	$parkcode=strtoupper($parkcode);
	if(in_array($parkcode,$da)){
	$WHERE.=" and park='$parkcode'";}else{echo "<br>No access for $parkcode";exit;}
	}else{echo "<br><br>You do not have access privileges for this database [$db] report at $level $posTitle. Contact Tom Howard tom.howard@ncmail.net if you wish to gain access.<br>park_project_balances.php<br>budget.php<br>dist=$parkList $distPark";exit;}
	}

mysql_select_db($database, $connection); // database
if($level==1){
$parkcode=strtoupper($parkcode);$parkcodePass=$parkcode;
$a=array("prtf_center_budget","park_project_balances");
if(is_array($_SESSION['budget']['report'])){$b0=$_SESSION['budget']['report'][0]; $b1=$_SESSION['budget']['report'][1];}
else{$b0=$_SESSION['budget']['report'];}
if(in_array($b0,$a) or in_array($b1,$a)){
//Workaround for NERI/MOJE

if($_SESSION['budget']['select']=="NERI" and ($parkcode=="NERI" or $parkcode=="MOJE"))
{}
elseif($_SESSION['budget']['select']=="JORD" and ($parkcode=="JORD" or $parkcode=="DERI"))
{}
//{// pass parkcode
//}


else
{
$temp=$_SESSION['budget']['tempID'];$parkcode=$_SESSION['budget']['select'];
if($_SESSION['budget']['manager']){$parkcode=$parkcodePass;}}

//$access="and partf_projects.park='$parkcode'";

$WHERE.=" and park='$parkcode'";
}else
{
$rep=$_SESSION['budget']['report'];echo "You do not have access privileges for this database [$db] report at $level $posTitle. Contact Tom Howard tom.howard@ncmail.net if you wish to gain access.<br><br>budget.php<br>";print_r($a);print_r($_SESSION['budget']['report']);exit;}
}

if($parkcode!=""){

if($statusFilter!=""){$statusA=explode(",",$statusFilter);
for($sf=0;$sf<count($statusA);$sf++){
if($sf==0){$whereSF="and (statusper='$statusA[$sf]'";}
$whereSF.=" OR statusper='$statusA[$sf]'";}
$whereSF.=")";
}

//1
 $query = "truncate table budget.project_unposted1;
";
    $result = @MYSQL_QUERY($query,$connection);
if(@$showSQL=="1"){echo "<br><br>$query<br><br>";}

//2
 $query = "insert into project_unposted1( center, project_number,account, vendor_name, transaction_date, transaction_number, transaction_type, transaction_amount,source_id,parkcode) select ncas_center, project_number,ncas_account, vendor_name, datesql, ncas_invoice_number,'cdcs', ncas_invoice_amount, id,'' from cid_vendor_invoice_payments where 1 and post2ncas != 'y' and ncas_credit != 'x' group by id;
";
    $result = @MYSQL_QUERY($query,$connection);
if(@$showSQL=="1"){echo "<br><br>$query<br><br>";}

//3
 $query = "insert into project_unposted1( center, project_number,account, vendor_name, transaction_date, transaction_number, transaction_type, transaction_amount,source_id,parkcode) select ncas_center, project_number,ncas_account, vendor_name, datesql, ncas_invoice_number,'cdcs', -ncas_invoice_amount, id,'' from cid_vendor_invoice_payments where 1 and post2ncas != 'y' and ncas_credit = 'x' group by id;
";
    $result = @MYSQL_QUERY($query,$connection);
if(@$showSQL=="1"){echo "<br><br>$query<br><br>";}

//4
 $query = "insert into project_unposted1(center, project_number,account, vendor_name, transaction_date, transaction_number, transaction_type, transaction_amount,source_id,parkcode  ) select center, projnum,ncasnum, concat('pcard','-',cardholder,'-',vendor_name,'-',trans_date), transdate_new, transid_new, 'pcard',sum(amount), id,'' from pcard_unreconciled where 1 and ncas_yn != 'y' group by id;
";
    $result = @MYSQL_QUERY($query,$connection);
if(@$showSQL=="1"){echo "<br><br>$query<br><br>";}

//5
 $query = "update project_unposted1,partf_projects
set project_unposted1.parkcode=partf_projects.park
where project_unposted1.project_number=partf_projects.projnum
and partf_projects.projyn='y';
";
    $result = @MYSQL_QUERY($query,$connection);
if(@$showSQL=="1"){echo "<br><br>$query<br><br>";}

 $query = "update partf_projects
set project_center_year_type=concat(projnum,'-',center,'-',yearfundf,'-',projcat)
where 1";
    $result = @MYSQL_QUERY($query,$connection);
if(@$showSQL=="1"){echo "<br><br>$query<br><br>";}
    
 $query = "truncate table park_project_balances";
    $result = @MYSQL_QUERY($query,$connection);
if(@$showSQL=="1"){echo "$query<br><br>";}

 $query = "insert into park_project_balances(projnum,approved,expenses)
select projnum,sum(div_app_amt),''
from partf_projects
$WHERE
group by projnum;";
  $result = @MYSQL_QUERY($query,$connection);
if(@$showSQL=="1"){echo "$query<br><br>";}
 $af=mysql_affected_rows();
if($af==0){echo "No project found for $query";exit;}

//echo "<br>$query<br>";
 $query = "insert into park_project_balances(projnum,approved,expenses)
select proj_num, '', sum(amount)
from partf_payments
left join partf_projects on partf_payments.proj_num=partf_projects.projnum
$WHERE
group by partf_payments.proj_num";
   $result = @MYSQL_QUERY($query,$connection);
if(@$showSQL=="1"){echo "$query<br><br>";}

 $query = "insert into park_project_balances(projnum,approved,expenses,unposted_expenses) 
select
project_number,'','',sum(transaction_amount)
from project_unposted1
where project_number != ''
and parkcode='$parkcode'
group by project_number;
";
   $result = @MYSQL_QUERY($query,$connection);
if(@$showSQL=="1"){echo "$query<br><br>";}

 $query = "select park,projname,partf_projects.project_center_year_type, sum(approved) as 'approved', sum(expenses) as 'posted_expenses',sum(unposted_expenses) as 'unposted_expenses',sum(approved-expenses-unposted_expenses) as 'balance', statusper as 'status',partf_projects.projnum
from park_project_balances
left join partf_projects on park_project_balances.projnum=partf_projects.projnum
where 1 $whereSF
group by park_project_balances.projnum
order by partf_projects.center,partf_projects.projnum";
   $result = @MYSQL_QUERY($query,$connection);
if(@$showSQL=="1"){echo "$query<br><br>";}
   
//echo "<tr><td colspan='9'>$query</td></tr>";

echo "<table border='1' cellpadding='3' align='center'>";
echo "<tr><td colspan='9' align='center'>Park Project Balances using PARTF_Payments <font color='red'>$maxDate</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' value='Status Codes' onclick=\"return popitup('terminology.php')\"></td></tr>
<tr><th>park</th><th>projname</th><th>project<br>center<br>year<br>type</th><th>approved</th><th>posted_expenses</th><th>unposted_expenses</th><th>balance</th><th>status</th>";
echo "</tr>";
while($row = mysql_fetch_array($result)){
extract($row);
$approvedF=number_format($approved,2);
//$pm_link="<a href='prtf_pm_allocation.php?projnum=$projnum'>".number_format($pm_allocation,2)."</a>";
$posted_expensesF=number_format($posted_expenses,2);
$unposted_expensesF=number_format($unposted_expenses,2);
$balanceF=number_format($balance,2);
$manager=strtolower($manager);
$park=strtoupper($park);
$project_center_year_type=strtolower($project_center_year_type);
echo "<tr>";
echo "<td>$park</td><td>$projname</td><td>$project_center_year_type</td><td align='right'>$approvedF</td>";

$posted_expense_link="<a href='park_project_balances.php?projnum=$projnum&expense=1'>".$posted_expensesF."</a>";
echo "<td align='right'>$posted_expense_link</td>";

$unposted_expense_link="<a href='park_project_balances.php?projnum=$projnum&expense=2'>".$unposted_expensesF."</a>";
echo "<td align='right'>$unposted_expense_link</td>";

if($balance<0){$color="red";}else{$color="black";}
echo "<td align='right'><font color='$color'>$balanceF</font></td>";

if($level>3)
	{
	$status_link="<a href='park_project_balances.php?projnum=$projnum&status=1'>".$status."</a>";
	}


if($level==1)
	{
	$t=explode("-",$project_center_year_type);
	if(($t[3]=="mm"||$t[3]=="tm"||$t[3]=="er"||$t[3]=="de") AND $status !="FI")
		{
		$status_link="<a href='park_project_balances.php?projnum=$projnum&status=1'>".$status."</a>";
		}
		else
		{
		$status_link="$status";
		}
	}

if($level==2)
	{
	$t=explode("-",$project_center_year_type);	
	if($t[3]=="mm"||$t[3]=="tm"||$t[3]=="er"||$t[3]=="de")
		{
		$status_link="<a href='park_project_balances.php?projnum=$projnum&status=1'>".$status."</a>";
		}
		else
		{
		$status_link="$status";
		}
	}

echo "<td align='center'>$status_link</td>";
echo "</tr>";

$total_approved=$total_approved+$approved;
$total_pm=$total_pm+@$pm_allocation;
$total_posted_expenses+=$posted_expenses;
$total_unposted_expenses+=$unposted_expenses;
$total_balance=@$total_balance+$balance;
}// end while
$total_approved=number_format($total_approved,2);
$total_pm=number_format($total_pm,2);
$total_posted_expenses=number_format($total_posted_expenses,2);
$total_unposted_expenses=number_format($total_unposted_expenses,2);
$total_balance=number_format($total_balance,2);
echo "<tr>
<td colspan='4' align='right'><b>$total_approved</b></td>";
//echo "<td align='right'><b>$total_pm</b></td>";
echo "<td align='right'><b>$total_posted_expenses</b></td>
<td align='right'><b>$total_unposted_expenses</b></td>
<td align='right'><b>$total_balance</b></td>
</tr>
<tr><th>park</th><th>projname</th><th>project<br>center<br>year<br>type</th><th>approved</th><th>posted_expenses</th><th>unposted_expenses</th><th>balance</th><th>status</th></tr></table>";

}// end if

echo "</div></body></html>";

?>