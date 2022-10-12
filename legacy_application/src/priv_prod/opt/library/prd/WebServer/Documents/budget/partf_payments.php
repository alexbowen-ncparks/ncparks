<?php
//These are placed outside of the webserver directory for security

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
session_start();
include("../../include/activity.php");
extract($_REQUEST);
//print_r($_SESSION);//EXIT;
?>
<script language="JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
function confirmLink()
{
 bConfirm=confirm('Are you sure you want to delete this record?')
 return (bConfirm);
}
//-->
</script>

<?php
include("menu.php");
echo "<html><header></header<title></title><body>";

echo "<table><form action='partf_payments.php'>
<tr>
<td>Company:  <input type='text' name='company' size='5' value='$comp'></td>
<td>Acct:  <input type='text' name='acct' size='15' value='$acct'></td>
<td>Fund:  <input type='text' name='fund' size='10' value='$fund'></td>
<td>Center: <input type='text' name='center' size='10' value='$center'></td>
</tr>
<tr>
<td>datenew:  <input type='text' name='datenew' size='15' value='$datenew'></td>
<td>Check #:  <input type='text' name='checknum' size='15' value='$checknum'></td>
<td>Invoice:  <input type='text' name='invoice' size='15' value='$invoice'></td>
</tr>
<tr>
<td>Amount:  <input type='text' name='amount' size='12' value='$invoice'></td>
<td>Vendor #:  <input type='text' name='vendornum' size='12' value='$vendornum'></td>
<td>
Group #:  <input type='text' name='groupnum' size='5' value='$groupnum'>
</tr>
<tr>
<td>Vendor Name:  <input type='text' name='vendorname' size='30' value='$vendorname'></td>
<td>Project #:  <input type='text' name='proj_num' size='5' value='$proj_num'></td>
<td>Contract #:  <input type='text' name='contract_num' size='15' value='$contract_num'></td>
</tr>
<tr>
<td>Contract/Proj. #:  <input type='text' name='conpro_num' size='10' value='$conpro_num'></td>
<td>Contract Amt:  <input type='text' name='contract_amt' size='10' value='$contract_amt'></td>
<td>Non-Contract Amt:  <input type='text' name='noncon_amt' size='10' value='$contract_amt'></td>
</tr>
<tr>
<td>sec_proj_req:  <input type='text' name='sec_proj_req' size='10' value='$sec_proj_num'></td>
<td>Secon. Proj. #:  <input type='text' name='sec_proj_num' size='10' value='$sec_proj_num'></td>
<td>charg_proj_num  #:  <input type='text' name='charg_proj_num' size='10' value='$conpro_num'></td>
</tr>
<tr>
<td>Misc. <input type='text' name='misc' size='38' value='$misc'></td>
</tr>
</table>
<table align='center'>
<tr>
<td><input type='submit' name='submit' value='Find'></td></form>
<form action='partf_payments_add.php'>
<td><input type='submit' name='submit' value='Add'></td></form>
<form action='partf_payments.php'>
<td><input type='submit' name='reset' value='Reset'></form</td>";

echo "</table></body></html>";

// ***** Pick display function and set sql statement

$co=count($_REQUEST); //print_r($_REQUEST);//echo "c=$co";exit;
$from="* From partf_payments";
if($co>0){$where=" WHERE 1";}else{exit;}
if($company!=""){$where.=" and company='$company'";}
if($acct!=""){$where.=" and account='$acct'";}
if($center!=""){$where.=" and center='$center'";}
if($fund!=""){$where.=" and fund='$fund'";}
//if($datePost!=""){$where.=" and datePost='$datePost'";}
if($datenew!=""){$where.=" and datenew='$datenew'";}
if($checknum!=""){$where.=" and checknum='$checknum'";}
if($invoice!=""){$where.=" and invoice='$invoice'";}
if($amount!=""){$where.=" and amount='$amount'";}
if($vendornum!=""){$where.=" and vendornum='$vendornum'";}
if($groupnum!=""){$where.=" and groupnum='$groupnum'";}
if($vendorname!=""){$where.=" and vendorname LIKE '%$vendorname%'";}
//if($proj_num!=""){$where.=" and proj_num='$proj_num'";

if($proj_num!=""){$where.=" and proj_num='$proj_num'";
$from="DISTINCT partf_payments.*,park as projPark From partf_payments LEFT JOIN partf_projects on partf_projects.projNum=partf_payments.proj_num";}

if($charg_proj_num!=""){$where.=" and charg_proj_num='$charg_proj_num'";
//$from="DISTINCT partf_payments.*,park as projPark,partf_payments.projname From partf_payments LEFT JOIN partf_projects on partf_projects.projNum=partf_payments.charg_proj_num";
$from="DISTINCT partf_payments.*,park as projPark From partf_payments LEFT JOIN partf_projects on partf_projects.projNum=partf_payments.charg_proj_num";
}

if($contract_num!=""){$where.=" and contract_num='$contract_num'";}
if($conpro_num!=""){$where.=" and conpro_num='$conpro_num'";}
if($contract_amt!=""){$where.=" and contract_amt='$contract_amt'";}
if($sec_proj_num!=""){$where.=" and sec_proj_num='$sec_proj_num'";}

if($groupBY!=""){$g="Group by account";}

if($where==" WHERE 1"){exit;}


include_once("partf_paymentsHeader.php");include_once("functionpartf_payments.php");

$sql1 = "SELECT $from $where $g";

echo "$sql1<br>";//exit;

$val=array_values($_REQUEST);$fld=array_keys($_REQUEST);
for($i=0;$i<$co;$i++){
if($val[$i]!="" AND $val[$i]!="Find" AND $fld[$i]!="PHPSESSID"){$item.=" ".$fld[$i]."=".$val[$i];}
}
$item=strtoupper($item);
if($sql1){
$result = mysqli_query($connection, $sql1) or die ("Couldn't execute query. $sql1");
$num=mysqli_num_rows($result);
if($num>1){echo "<font color='green'>$num Items for $item</font><hr>";
}

$var=$_SESSION[budget][select];

// Park Level access
if($var==$park){$accessLevel="2";}else
{$accessLevel="1";}

// District wide access
if($_SESSION[budget][level]=="2"){
include_once("../../include/parkcodesDiv.inc");
$a="array";$b="$var";$distArray=${$a.$b};
if(in_array($park,$distArray)){$accessLevel="2";}else
{$accessLevel="1";}
}

// ******** display comes from functionpartf_payments.php

// System wide access
if($_SESSION[budget][level]=="4"){$accessLevel="2";}else{$accessLevel=1;}

switch($accessLevel){
	case "1":
while ($row=mysqli_fetch_array($result))
{extract($row);
$con=$con+$contract_amt;
$nc=$nc+($amount - $contract_amt);
$tot=$tot+$amount;
//echo "<pre>";print_r($row);echo "</pre>";//exit;
itemShow($company,$fund,$center,$account,$datePost,$checknum,$invoice,$amount,$vendornum,$groupnum,$vendorname,$proj_num,$contract_num,$conpro_num,$contract_amt,$noncon_amt,$sec_proj_req,$sec_proj_num,$charg_proj_num,dateInvoice,$datenew,$xtid,$projPark);}
	break;
	case "2":
while ($row=mysqli_fetch_array($result))
{extract($row);
$con=$con+$contract_amt;
$nc=$nc+($amount - $contract_amt);
$tot=$tot+$amount;
itemShow($company,$fund,$center,$account,$datePost,$checknum,$invoice,$amount,$vendornum,$groupnum,$vendorname,$proj_num,$contract_num,$conpro_num,$contract_amt,$noncon_amt,$sec_proj_req,$sec_proj_num,$charg_proj_num,$dateInvoice,$datenew,$xtid,$projPark);}
	break;
	default:
	echo "Access denied";exit;
	}// end Switch

}
$tot=number_format($tot,2);
$nc=number_format($nc,2);
$con=number_format($con,2);

if($tot<=0){
$t="Total of <font color='red'>$tot</font>";}else
{$t="Total of $tot";}

if($con>0){
$con="Contract Total of <font color='green'>$con</font>";}else
{$con="Contract Total of $con";}

if($nc>0){
$c="Non-contract Total of <font color='blue'>$nc</font>";}else
{$c="Non-contract Total of $nc";}
echo "<font color='purple'>$projPark</font> $projName [$t] = [$con] + [$c]";
?>