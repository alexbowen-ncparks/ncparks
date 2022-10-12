<?php
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}

$level=$_SESSION['budget']['level'];
// print_r($_SESSION);


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 

include("../../../include/auth.inc");

//include("../../../include/activity.php");
extract($_REQUEST);
$beacnum=$_SESSION['budget']['beacon_num'];
if($beacnum=='60033226')
{
echo "<pre>"; print_r($_SESSION);
echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
}

if(@$Submit=="Delete")
	{
	$sql = "DELETE from cid_vendor_invoice_payments where id='$id'";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	include("../menu.php");
	echo "Invoice was deleted.";
	exit;
	}

if(@$submit_acs=="Submit" || @$submit_acs=="Update"){
// echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
include("acsAdd.php");
exit;}

if(@$submit_acs=="Preview"){
include("acs_pdf.php");
exit;}

$message="Pay Invoice";
//$addMessage=" &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; The <font color='brown'>first report</font> is now available. Select the \"Reports\" option from the \"Invoices\" menu.";

$formType="Submit";

if(@$id)
	{
	
	$passID=$id;// necessary since id will being overwritten
	$sql = "SELECT * From cid_vendor_invoice_payments where id='$id'";
		//	echo "$sql";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_array($result);
	extract($row);
	$ncas4=substr($ncas_account,0,4);
	if($ncas4==5345 or $ncas4==5346 or $ncas4==5347){$ncas_fixed_asset='y';}
	$system_entry_date2=str_replace("-","",$system_entry_date);
	if(@$ncas_fixed_asset=='y'  and $system_entry_date2 > '20100815' and $document_location=="")
	{
	$vendor_name=urlencode($vendor_name);
	header("location: document_add.php?&id=$id&vendor_name=$vendor_name&ncas_invoice_number=$ncas_invoice_number");exit;}
	
	$message="Invoice $ncas_invoice_number for $invoice_total has been entered.";
	$pass_pa_re_number=$pa_number."*".$re_number;
	//$pass_funding_source=$funding_source;
	$passReceived_by=$received_by;
	$passPrepared_by=$prepared_by;
	$passApproved_by=$approved_by;
	
	if($energy_group!=""){
			$sql = "select
	UPPER(concat(energy_group,'-',energy_subgroup,'-',unit_of_measure)) as 'passEnergy_type'
	from energy
	where 1 and energy_group='$energy_group' and energy_subgroup='$energy_subgroup' and cdcs_uom='$cdcs_uom'";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_array($result); extract($row);
			}
	//$passEnergy_type=$energy_group."-".$energy_subgroup."-".$cdcs_uom;
	
	if(@$submit_acs=="Duplicate"){
	//$ncas_invoice_number="";
	$ncas_invoice_amount="";$ncas_freight="";$invoice_total="";$po_line1="";$document_location="";
	$message="Invoice has been duplicated.";
	$formType="Submit";}else{$formType="Update";}
	
	// Make link(s) to ACS records
	$sql1 = "SELECT id as linkID,invoice_total as linkAmt From cid_vendor_invoice_payments
	where vendor_number='$vendor_number' AND due_date='$due_date' AND prepared_by='$prepared_by'
	order by invoice_total";
	
	//echo "$sql";exit;
	$result1 = mysqli_query($connection, $sql1) or die ("Couldn't execute query. $sql1");
	$num=mysqli_num_rows($result1);
	if($num>1){
	$links="$num invoices on this ACS => ";
	while($row1=mysqli_fetch_array($result1)){
	extract($row1);$linkID="[<a href='acs.php?id=$linkID'>$linkAmt</a>]";
	$links.=$linkID." ";}
	}
	}

include("../menu.php");
//echo "<pre>";print_r($_REQUEST);
//print_r($_SESSION);echo "</pre>";//EXIT;

$userName=@$_SESSION['budget']['acsName'];
if(!$userName)
	{
	mysqli_select_db($connection, "divper"); // database 
	$userID=$_SESSION['budget']['tempID'];
	$sql = "SELECT Nname,Fname,Lname From empinfo where tempID='$userID'";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_array($result);
	extract($row);
	if($Nname){$Fname=$Nname;}
	$userName=$Fname." ".$Lname;
	$_SESSION['budget']['acsName']=$userName;
	}

include("../../../include/parkcountyRCC.inc");
$parkcodeACS=$_SESSION['budget']['select'];

if(empty($parkcode)){$parkcode=$parkcodeACS;}

mysqli_select_db($connection, $database); // database 
// used to get a park's ncas_rcc

/*
if($beacnum=='60033226' or $beacnum=='60032988')
{
$sql = "SELECT new_rcc as 'rcc' From center where parkCode='$parkcode' and fund='1280'";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_array($result)){
$parkRCC[$parkcode]=$row['rcc'];
}
if(!@$ncas_budget_code){$ncas_budget_code="14800";}
if(!@$ncas_fund){$ncas_fund="1680";}
if(!@$ncas_company){$ncas_company="4601";}
}

if($beacnum!='60033226' and $beacnum!='60032988')
{
$sql = "SELECT rcc From center where parkCode='$parkcode' and fund='1280'";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_array($result)){
$parkRCC[$parkcode]=$row['rcc'];
}
}

*/

$sql = "SELECT rcc From center where parkCode='$parkcode' and fund='1280'";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_array($result)){
$parkRCC[$parkcode]=$row['rcc'];
}





$prev3month=date("Y-m-d", mktime(0,0,0,(date('m')-3),date('d'),date('Y')));

// Get values for various pulldown menus
$sql = "SELECT DISTINCT received_by From cid_vendor_invoice_payments where parkcode='$parkcode' and received_by !='' and system_entry_date>'$prev3month'
order by received_by";
//echo "$sql";exit;
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_array($result)){
$receive[]=$row['received_by'];
}
$sql = "SELECT DISTINCT prepared_by From cid_vendor_invoice_payments where parkcode='$parkcode' and prepared_by !=''  and system_entry_date>'$prev3month'
order by prepared_by";
//echo "$sql";exit;
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_array($result)){
$prepare[]=$row['prepared_by'];
}
$sql = "SELECT DISTINCT approved_by From cid_vendor_invoice_payments where parkcode='$parkcode' and approved_by !=''  and system_entry_date>'$prev3month'
order by approved_by";
//echo "$sql";exit;
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_array($result)){
$approve[]=$row['approved_by'];
}

$pcard[]="";
$sql = "SELECT DISTINCT concat_ws('-',concat_ws(', ',last_name,first_name),card_number,admin) as nameCard,location
From budget.pcard_users where parkcode='$parkcode' and act_id='y' order by last_name";
//echo "$sql";exit;
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_array($result)){
extract($row);if($location=="1669"){$nameCard.="-CI";}
$pcard[]=strtoupper($nameCard);
}

$sql = "select
concat(energy_group,'-',energy_subgroup,'-',unit_of_measure) as 'energy_type'
from energy
where 1
group by concat(energy_group,energy_subgroup)
order by energy_group,energy_subgroup";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_array($result)){
$energy_type[]=strtoupper($row['energy_type']);
}
//echo "<pre>"; print_r($energy_type); echo "</pre>";  exit;

/*
$sql = "SELECT concat( center_code, '*', pa_number, '*', re_number ) as app, concat( pa_number, '*', re_number ) as app_menu
FROM approved_re
WHERE 1 
ORDER BY center_code, pa_number";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_array($result)){
$APPROVAL[]=strtoupper($row['app']);
$APPROVAL_menu[]=strtoupper($row['app_menu']);
}
//echo "<pre>"; print_r($APPROVAL); echo "</pre>";  exit;
*/

$sql = "SELECT DISTINCT ncas_account as OK_account
FROM `pa_approval_exceptions` 
WHERE 1";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_array($result)){
$approved_accounts[]=strtoupper($row['OK_account']);
}
//echo "<pre>"; print_r($approved_accounts); echo "</pre>";  exit;

$sql = "select funding_source
from project_valid_funding_sources
where 1
order by funding_source;";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_array($result)){
$funding_source_menu[]=strtoupper($row['funding_source']);
}
//echo "<pre>"; print_r($approved_accounts); echo "</pre>";  exit;


$testMonth=date('n');
if($testMonth >0 and $testMonth<7){$year1=date('Y')-1;}
if($testMonth >6){$year1=date('Y');}
$currYearMonth=$year1."-07-00";

$sql = "SELECT max( sheet )  AS sheetMax
FROM cid_vendor_invoice_payments
WHERE parkcode =  '$parkcode' AND system_entry_date  >  '$currYearMonth'
GROUP  BY parkcode";
//echo "$sql";//exit;
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$row=mysqli_fetch_array($result);
extract($row);

if(!@$ncas_date_entered){$ncas_date_entered=date("m/d/Y");}

if(!isset($addMessage)){$addMessage="";}
if(!isset($links)){$links="";}
echo "<body><table cellpadding='1'><tr><td> </td><td><font color='green'>$message</font>$addMessage<br>$links</td></tr>";

if(@$new_vendor){$nvCK='checked';}else{$nvCK='';}
if(@$ncas_credit){$crCK='checked';}else{$crCK='';}
if(@$part_pay){$ppCK='checked';}else{$ppCK='';}

if(!@$due_date){$due_date="will be calculated";}
if(!@$parkcode){$parkcode=$parkcodeACS;}else{$parkcode=strtoupper($parkcode);}
if(!@$ncas_rcc){$ncas_rcc=@$parkRCC[$parkcodeACS];}
if(!@$ncas_county_code){$ncas_county_code=@$parkCounty[$parkcodeACS];}
if(!@$prefix){$prefix="53";}
if(!@$ncas_budget_code){$ncas_budget_code="14300";}
if(!@$ncas_fund){$ncas_fund="1280";}
if(!@$ncas_company){$ncas_company="1601";}
if(!@$prepared_by){$prepared_by=$userName;}
if(!@$prepared_date){$prepared_date=$ncas_date_entered;}
if(!@$sheet){$sheet=$sheetMax+1;}

$pay_center=$ncas_fund.$ncas_rcc;

if($level>2){$sheet="";}
if(!isset($num_invoice)){$num_invoice=1;}
if($level<4){$RO="READONLY";}else{$RO="";}
if(!isset($sed)){$sed="";}
if(!isset($check_num)){$check_num="";}
echo "<form name='acsForm' action='acs.php' method='POST'>
$sed
<tr><td><font color='purple'>parkcode</font></td><td><input type='text' name='parkcode' value='$parkcode' size='5'> park ACS# <input type='text' name='sheet' value='$sheet' size='5'> check# <input type='text' name='check_num' value='$check_num' size='15'>&nbsp;&nbsp;&nbsp;&nbsp;Num. Invoices <input type='text' name='num_invoice' value='$num_invoice' size='3'$RO></td></tr>";

if(!isset($vendor_number)){$vendor_number="";}
echo "<tr><td>vendor_number</td><td><input type='button' value='Get Vendor Info' onclick=\"return popitup('vendor.php?parkcode=$parkcode')\"> <input name='vendor_number' type='text' value='$vendor_number' size='40'> New Vendor <input type='checkbox' name='new_vendor' value='x'$nvCK>
</td></tr>";

//$vendor_name=stripslashes(@$vendor_name);
//$vendor_name=stripslashes(@$vendor_name);
echo "<tr><td>vendor_name</td><td><textarea name='vendor_name' cols='45' rows='1'>$vendor_name</textarea>";

if(!isset($group_number)){$group_number="";}
if(!isset($vendor_address)){$vendor_address="";}

$vendor_address=str_replace("\\r\\n","\n",$vendor_address);

if(!isset($pay_entity)){$pay_entity="";}
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; group_number <input type='text' name='group_number' value='$group_number' size='5'></td></tr>

<tr><td>vendor_address</td><td><textarea name='vendor_address' cols='45' rows='3'>$vendor_address</textarea>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; pay_entity <input type='text' name='pay_entity' value='$pay_entity' size='5'></td></tr>";

if(!isset($ncas_invoice_number)){$ncas_invoice_number="";}
if(!isset($ncas_invoice_date)){$ncas_invoice_date="";}
if(!isset($ncas_invoice_amount)){$ncas_invoice_amount="";}
echo "<tr><td><font color='purple'>invoice_number</font></td><td><input type='text' name='ncas_invoice_number' value='$ncas_invoice_number' size='30'></td></tr><tr><td><font color='purple'>invoice_date</font></td><td><input type='text' name='ncas_invoice_date' value='$ncas_invoice_date' size='12' maxlength='10'> (m/d/yyyy) &nbsp;&nbsp;due_date <input type='text' name='due_date' value='$due_date' size='14'> (m/d/yyyy) 
</td></tr>

<tr><td><font color='purple'>invoice_amount</font></td><td><input type='text' name='ncas_invoice_amount' value='$ncas_invoice_amount' size='15'
	 onChange=\"copyData1(this,document.acsForm.invoice_total)\"
    onKeyUp=\"copyData1(this,document.acsForm.invoice_total)\">
&nbsp;&nbsp; include freight charge, if any.";
  /*  <input type='text' name='ncas_freight' value='$ncas_freight' size='7'
	 onChange=\"copyData2(this,document.acsForm.invoice_total)\"
    onKeyUp=\"copyData2(this,document.acsForm.invoice_total)\">
    */

if(!isset($invoice_total)){$invoice_total="";}
if(!isset($refund_code)){$refund_code="";}
echo "</td></tr><tr><td>invoice_total</td><td><input type='text' name='invoice_total' value='$invoice_total' size='15'> credit <input type='checkbox' name='ncas_credit' value='x'$crCK> refund_code <input type='text' name='refund_code' value='$refund_code' size='5'>";

if(!isset($passEnergy_type)){$passEnergy_type="";}
echo " Energy Type <select name='energy'>\n";
 echo "<option value=''>\n"; 
for($j=0;$j<count($energy_type);$j++)
{
if($energy_type[$j]==$passEnergy_type){$v="selected";}else{$v="value";}
     echo "<option $v='$energy_type[$j]'>$energy_type[$j]\n";
}

echo "</select>";
if(!isset($energy_quantity)){$energy_quantity="";}
echo " energy_quantity <input type='text' name='energy_quantity' value='$energy_quantity' size='10'></td>
</tr>";
/* 
*/
if(!isset($ncas_number)){$ncas_number="";}
echo "<tr><td><font color='purple'>ncas_prefix</font></td><td><input type='text' name='prefix' value='$prefix' size='2'>&nbsp;&nbsp;&nbsp;<font color='purple'>ncas_number</font><input type='text' name='ncas_number' value='$ncas_number' size='10'>";

//<img src='new.gif'>-->

if(!isset($er_num)){$er_num="";}
echo " &nbsp;&nbsp; <input type=\"button\" value=\"View Account Numbers\" onClick=\"return popitup('acctNum.php')\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type='text' name='er_num' value='$er_num' size='5' READONLY> Equip. Request Number &nbsp;&nbsp; <input type=\"button\" value=\"Approved Equipment list\" onClick=\"return popitup('equipList.php?pay_center=$pay_center')\"></td></tr>";

echo "<tr><td></td><td>PA Approval Numbers are not required at this time.</td></tr>";
/*
echo "<tr><td></td><td>
<font color='brown'>PA Approval Number:</font> ";
//uses $APPROVAL array
echo " <select name='pa_re_number'>\n";
 echo "<option value=''>\n"; 
foreach($APPROVAL as $k=>$v)
{
if($APPROVAL_menu[$k]==$pass_pa_re_number){$o="selected";}else{$o="value";}
     echo "<option $o='$v'>$v</option>";
}
//<img src='new.gif'>
echo "</select>";
echo "</td></tr>";

    echo "<tr><td></td><td>pre-approved accounts: ";
  foreach($approved_accounts as $val){echo "$val, ";}
  echo "</td></tr>";
*/

if(@$ncas_number){
$fullNC=$prefix.$ncas_number;
$sql=" Select park_acct_desc from coa where ncasnum='$fullNC'";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$row=mysqli_fetch_array($result);extract($row);
echo "<tr><td></td><td><font color='red'>$park_acct_desc</font></td></tr>";
}

if(!isset($ncas_buy_entity)){$ncas_buy_entity="";}
if(!isset($fy)){$fy="";}
if(!isset($ncas_po_number)){$ncas_po_number="";}
echo "</table>

<table border='1'>
<tr><td width='100' align='right'>for POs &nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;buy_entity <input type='text' name='ncas_buy_entity' value='$ncas_buy_entity' size='5'> FY:<input type='text' name='fy' value='$fy' size='6'> po_number<input type='text' name='ncas_po_number' value='$ncas_po_number' size='14'> part_pay <input type='checkbox' name='part_pay' value='x'$ppCK></td></tr>";

if(!isset($po_line1)){$po_line1="";}
if(!isset($project_number)){$project_number="";}
echo "
<tr><td>
 &nbsp;&nbsp; <input type=\"button\" value=\"View POs\" onClick=\"return popitup('po.php?parkcode=$parkcode&po_number=$ncas_po_number')\">
</td><td> PO Line#: <input type='text' name='po_line1' value='$po_line1' size='7'> <font size='-1'>Enter amount for this PO Line# in the invoice_amount field. Create a separate record for each PO Line# paid.</font></td></tr>
</table>

<table>
<tr><td><input type=\"button\" value=\"PARTF Project Info\" onClick=\"return popitup('partf.php?parkcode=$parkcode')\"></td>
<td>project_number <input name='project_number' type='text' value='$project_number' size='8' READONLY> <font size='-2'>Project number must be entered using Project Info button.</font>
<br>company <input name='ncas_company' type='text' value='$ncas_company' size='8' READONLY>
<br>budget_code <input name='ncas_budget_code' type='text' value='$ncas_budget_code' size='8' READONLY>";
if($level>1){$nfro="";}else{$nfro="READONLY";}
echo "<br>ncas_fund <input name='ncas_fund' type='text' value='$ncas_fund' size='8' $nfro>&nbsp;&nbsp;&nbsp;&nbsp;

funding_source <select name='funding_source'>\n";
 echo "<option value=''>\n"; 

if(!isset($funding_source)){$funding_source="";}
foreach($funding_source_menu as $k=>$v)
	{
	if($v==$funding_source){$o="selected";}else{$o="value";}
		 echo "<option $o='$v'>$v</option>";
	}
//<img src='new.gif'>
echo "</select> (Only used for certain PARTF Funds)
</td></tr>";

if(@$project_number){$ncas_rcc="";}
if(!isset($ncas_remit_code)){$ncas_remit_code="";}
if(!isset($ncas_accrual_code)){$ncas_accrual_code="";}
if(!isset($comments)){$comments="";}
if(!isset($fas_num)){$fas_num="";}
echo "<tr><td align='right'>rcc</td><td><input type='text' name='ncas_rcc' value='$ncas_rcc' size='4'> county_code <input type='text' name='ncas_county_code' value='$ncas_county_code' size='4'></td></tr>

<tr><td align='right'>remit_code</td><td><textarea name='ncas_remit_code' cols='55' rows='2'>$ncas_remit_code</textarea>&nbsp;&nbsp;&nbsp;accrual_code <input type='text' name='ncas_accrual_code' value='$ncas_accrual_code' size='4'></td></tr>

<tr><td align='right'>comments</td><td><textarea name='comments' cols='55' rows='2'>$comments</textarea>&nbsp;&nbsp;&nbsp; ";
if($level > 2)
{
echo "fas_num<input type='text' name='fas_num' value='$fas_num' size='12'>";
}
if($level < 3)
{
echo "fas_num<input type='text' name='fas_num' value='$fas_num' size='12' readonly='readonly'>";
}
echo "</td></tr>";


echo "</table>";

echo "<table>";
//
echo "<tr><td><font color='purple'>received_by</font></td><td><select name='received_by'>\n";
 echo "<option value=''>\n";
if(!isset($passReceived_by)){$passReceived_by="";}
for($j=0;$j<count($receive);$j++)
	{
	if($receive[$j]==$passReceived_by){$v="selected";}else{$v="value";}
		 echo "<option $v='$receive[$j]'>$receive[$j]\n";
	}

echo "</select><input type='text' name='received_byAlt' value=''></td></tr>";

echo "<tr><td><font color='purple'>prepared_by</font></td><td><select name='prepared_by'>\n";
 echo "<option value=''>\n"; 
 
$k=count($prepare);
$pbAlt="";
if(!isset($passPrepared_by)){$passPrepared_by="";}
for($j=0;$j<$k;$j++)
	{
	if($prepare[$j]==$passPrepared_by){$v="selected";}else{$v="value";}
		 echo "<option $v='$prepare[$j]'>$prepare[$j]\n";
	}
if($k<1){$pbAlt=$prepared_by;}
echo "</select><input type='text' name='prepared_byAlt' value='$pbAlt'>&nbsp;&nbsp;&nbsp;  prepared_date: <input type='text' name='prepared_date' value='$prepared_date'></td></tr>";

if(!isset($passApproved_by)){$passApproved_by="";}
echo "<tr><td><font color='purple'>approved_by</font></td><td><select name='approved_by'>\n";
 echo "<option value=''>\n"; 
for($j=0;$j<count($approve);$j++)
	{
	if($approve[$j]==$passApproved_by){$v="selected";}else{$v="value";}
		 echo "<option $v='$approve[$j]'>$approve[$j]\n";
	}

if(!isset($approved_date)){$approved_date="";}
echo "</select><input type='text' name='approved_byAlt' value=''>&nbsp;&nbsp;&nbsp;  approved_date:<input type='text' name='approved_date' value='$approved_date'></td></tr>";

if(!@$system_entry_date){$system_entry_date=date("Y-m-d");}

if(!isset($document_location)){$document_location="";}
if(!isset($system_entry_date)){$system_entry_date="";}
if(!isset($passID)){$passID="";}
echo "</table><table><tr><td width='100'>
<input type='hidden' name='m' value='invoices'>
<input type='hidden' name='document_location' value='$document_location'>
<input type='hidden' name='system_entry_date' value='$system_entry_date'>";
echo "<input type='hidden' name='id' value='$passID'>";
echo "<input type='submit' name='submit_acs' value='$formType'></form>";
?>

<script language="JavaScript" type="text/javascript">
var frmvalidator  = new Validator("acsForm");
  frmvalidator.addValidation("parkcode","req","Please enter the Park Code");
  frmvalidator.addValidation("ncas_invoice_number","req","Please enter an Invoice Number");
  frmvalidator.addValidation("ncas_invoice_date","req","Please enter the Invoice Date");
  frmvalidator.addValidation("ncas_invoice_amount","req","Please enter the Invoice Amount");
  frmvalidator.addValidation("ncas_number","req","Please enter the NCAS Account Number");

</script>

<?php
echo "</td>";

if(@$submit_acs=="Submit"||$formType=="Update")
	{
	if(@$m=="invoices"){
	$warning="<font color='red'>Warning: NEVER</font> use this Form to lookup OLD Invoices in order to pay NEW Invoices to the same Vendor
	<br/><br /><font color='green'>ALWAYS</font> pay NEW Invoices using a Blank Form by accessing the Pay Invoices menu";}
	
	else{
	echo "<td width='100'>
	<form action='/budget/acs/acs.php' method='POST'>
	<input type='hidden' name='m' value='invoices'>
	<input type='hidden' name='id' value='$passID'>
	<input type='submit' name='submit_acs' value='Duplicate'>
	</form></td>";}
	
	$vendor_nameURL=urlencode($vendor_name);
	
	
	echo "<td>";
	if($project_number!=""){
	echo "<form action='/budget/acs/acs_ci_pdf.php'>";}else
	{
	echo "<form action='/budget/acs/acs_pdf.php'>";
	}
	
	echo "<input type='hidden' name='m' value='invoices'>
	<input type='hidden' name='vendor_name' value='$vendor_nameURL'>
	<input type='hidden' name='due_date' value='$due_date'>
	<input type='hidden' name='prepared_by' value='$passPrepared_by'>
	<input type='submit' name='submit_acs' value='Preview'> Click browser's back button after Preview.</form></td></tr>";
	if($document_location != ""){echo "<tr><td><a href='$document_location'>View Invoice Document</a></td></tr>";}
if(!isset($warning)){$warning="";}
	echo "<tr><td>&nbsp;</td></tr><tr><td><form action='/budget/acs/acs.php'>
	<input type='hidden' name='m' value='invoices'>
	<input type='hidden' name='id' value='$passID'><input type='submit' name='Submit' value='Delete' onClick=\"return confirmLink()\"></td>
	<td>$warning</td></tr>
	</form>";
	}
echo "</table></body></html>";
?>