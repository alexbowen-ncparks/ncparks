<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}


extract($_REQUEST);
session_start();

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 

include("../../../include/activity.php");

date_default_timezone_set('America/New_York');

//echo "<pre>";print_r($_REQUEST);echo "</pre>";
//print_r($_SESSION);
//echo "<pre>";print_r($_SERVER);echo "</pre>";
$parkcodeACS=$_SESSION['budget']['select'];
$centerCode=$_SESSION['budget']['centerSess'];
$level=$_SESSION['budget']['level'];

if($level<2)
	{
	if(!isset($findCenter)){$findCenter="";}
	if(strlen($findCenter)>4){
	$payType="Pay Location";
	$limitCenter=" AND ncas_center ='$findCenter'";
	$addFld=", parkcode as PARKCODE";
	}
	else{
	$payType="Pay Location";
	$limitCenter=" AND parkcode ='$findCenter'";
	$addFld=", parkcode as PARKCODE";
		}
	}

$payType="Pay Location";
$addFld=",parkcode as PARKCODE";

if(@$overrideCenter!="" and @$overrideLocation!="")
	{
	Echo "Enter only either parkcode or center";
	header();
	exit;
	}

if(@$overrideCenter!=""){
$payType="Pay Location";
$limitCenter=" AND ncas_center ='$overrideCenter'";
$addFld=",parkcode as PARKCODE";
}

if(@$overrideLocation!=""){
$limitCenter=" AND parkcode ='$overrideLocation'";
}

if(@$_REQUEST['parkcode']==""){$limit="LIMIT 500";}

if(empty($message)){$message="Find Invoice";}

function makeQuery(&$item1,$key){
global $query,$fields;
$tempArray=array("pcard_holder","vendor_name","approved_by","prepared_by");
if($item1 AND in_array($key,$fields))
	{
	$item1=addslashes($item1);
	if(in_array($key,$tempArray))
		{$query.=" and ".$key." like '%".$item1."%'";}
		else
		{$query.=" and ".$key."='".$item1."'";}
	}
}

$passQuery="submit_acs=Find";
function passQuery(&$item1,$key){
global $passQuery,$fields;
if($item1 AND in_array($key,$fields)){
	$passQuery.="&".$key."=".$item1;
	}// end if item1
}// end function

if(@$submit_acs=="Find")
	{
	$sql = "SHOW COLUMNS from cid_vendor_invoice_payments";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	while($row=mysqli_fetch_array($result)){
	$fields[]=$row[0];
	}
	
	$findArray=$_REQUEST;
	
	array_walk($findArray, 'makeQuery');
	$WHERE="Where 1 ".$query;
	
	array_walk($findArray, 'passQuery');
	$passQ=$passQuery;
	
	if(@$limitFY){
	$passQ.="&limitFY=x";
	$testMonth=date('n');$today=date('Y')."";
	if($testMonth >0 and $testMonth<8){$year2=date('Y')-1;}
	else{$year2=date('Y');}
	$fy=$year2."0700";$WHERE.=" AND dateSQL > $fy";}
	//echo "$testMonth $today $year1 $year2";exit;
	
	if(isset($limit_proj_num))
		{
		$passQ.="&limit_proj_num=x";
		$WHERE.=" AND project_number !=''";
		}
	
	
	if(isset($limitCenter)){
	$WHERE.=$limitCenter;}
	
	if(isset($s) AND $s=="vn")
		{
		$orderby="order by vendor_name";
		}
		else
		{
		// Default
		$orderby="order by id desc";
		}
	
	$sql = "SELECT * $addFld
	From cid_vendor_invoice_payments
	$WHERE $orderby $limit";
	
	//echo "<br>$sql<br>$passQ";EXIT;
	//echo "$sql<br>";//EXIT;
	
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	$num=mysqli_num_rows($result);
	if($num<1){Header("Location: acsFind.php?m=invoices&message=Nothing Found.");exit;}
	
	echo "<table border='1'><tr><td colspan='9' align='center'><font color='purple'>$num Invoices were found.</font></td></tr>
	<tr><th>$payType</th><th>Pay Center</th></th><th>ncas invoice number</th><th>ncas account</th><th>project number</th>
	<th><a href='acsFind.php?$passQ&s=vn&m=invoices'>vendor_name</a></th>
	<th>ncas invoice date</th>
	<th>invoice total</th><th>posted</th><th></th><th>prepared by</th><th>approved by</th></tr>";
	
	$total_invoice_total="";
	while($row=mysqli_fetch_array($result))
		{
		extract($row);
		
		if($ncas_credit=="x")
			{
			$total_invoice_total-=$invoice_total;
			$invoice_total="-".$invoice_total;
			}
			else
			{
			$total_invoice_total+=$invoice_total;
			}
		
		
		echo "<tr><td align='center'>$PARKCODE</td><td>$ncas_center</td><td>$ncas_invoice_number</td><td>$ncas_account</td>
		<td>$project_number</td>
		<td>$vendor_name</td><td align='center'>$ncas_invoice_date</td><td align='right'>$invoice_total</td>
		<td align='center'>$post2ncas"; if($level==5){echo "<br /><a href='acs_post_update.php?id=$id&post2ncas=$post2ncas' target='_blank'>Change</a>";} echo "</td>";
		
		echo "<td><a href='acs.php?id=$id&m=invoices'>View</a></td><td>$prepared_by</td><td>$approved_by</td></tr>";
		}
	$tot=number_format($total_invoice_total,2);
	echo "<tr><td align='right' colspan='7'>$tot</td></tr>";
	echo "</table>";
	exit;
	}

include("../menu.php");
//session_start();
//echo "<pre>";print_r($_REQUEST);print_r($_SESSION);echo "</pre>";//EXIT;

$userName=@$_SESSION['budget']['acsName'];
if(!$userName)
	{
	$userID=$_SESSION['budget']['tempID'];
	$sql = "SELECT Nname,Fname,Lname
	From divper.empinfo 
	where tempID='$userID'";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_array($result);
	extract($row);
	if($Nname){$Fname=$Nname;}
	$userName=$Fname." ".$Lname;
	$_SESSION['budget']['acsName']=$userName;
	}

//These are placed outside of the webserver directory for security
//include("../../../include/connectBUDGET.inc");// database connection parameters

//include("/budget/parkRCC.inc");
//$parkcodeACS=$_SESSION[budget][select];

$testMonth=date('n');
if($testMonth >0 and $testMonth<8){$year1=date('Y')-1;$year2=date('Y');}
else{$year1=date('Y');$year2=date('Y')+1;}

$fy=$year1."-".$year2;

echo "<html><header>
</header><body><table cellpadding='1'><tr><td> </td><td><font color='green' size='+1'>$message</font></td></tr>";

echo "<form name=\"acsForm\" action='acsFind.php' method='POST'>";

if($level==1){
echo "<tr><td>invoices entered by: <input type='radio' name='findCenter' value='$parkcodeACS' checked>$parkcodeACS</td></tr>";}

if($level>1){echo "<tr><td>invoices entered by parkcode:</td><td><input type='text' name='overrideLocation' value='' size='6'></td></tr>";
echo "<tr><td>OR</td></tr>";}

if($level==1){
echo "<tr><td>invoices charged to: <input type='radio' name='findCenter' value='$centerCode'>$centerCode</td></tr>";}

if($level>1){echo "<td>invoices charged to center:</td><td><input type='text' name='overrideCenter' value='' size='10'></td></tr>";}

echo "<tr><td>____________________________</td><td>____________________________________</td></tr>";


if(!isset($vendor_number)){$vendor_number="";}
if(!isset($vendor_name)){$vendor_name="";}
if(!isset($ncas_invoice_number)){$ncas_invoice_number="";}
if(!isset($sheet)){$sheet="";}
if(!isset($ncas_invoice_date)){$ncas_invoice_date="";}
if(!isset($ncas_invoice_amount)){$ncas_invoice_amount="";}
if(!isset($ncas_freight)){$ncas_freight="";}
if(!isset($invoice_total)){$invoice_total="";}
if(!isset($crCK)){$crCK="";}
if(!isset($refund_code)){$refund_code="";}
if(!isset($ncas_number)){$ncas_number="";}
if(!isset($er_num)){$er_num="";}
if(!isset($project_number)){$project_number="";}
if(!isset($ncas_remit_code)){$ncas_remit_code="";}
if(!isset($comments)){$comments="";}
if(!isset($pcard_holder)){$pcard_holder="";}
if(!isset($ncas_county_code)){$ncas_county_code="";}
if(!isset($ncas_company)){$ncas_company="";}
if(!isset($ncas_rcc)){$ncas_rcc="";}
if(!isset($ncas_fund)){$ncas_fund="";}
if(!isset($fas_num)){$fas_num="";}
if(!isset($ncas_accrual_code)){$ncas_accrual_code="";}
if(!isset($ncas_po_number)){$ncas_po_number="";}
if(!isset($prepared_by)){$prepared_by="";}
if(!isset($approved_by)){$approved_by="";}
if(!isset($passID)){$passID="";}
echo "<tr><td>vendor_number</td><td><input name=\"vendor_number\" type=\"text\" value=\"$vendor_number\">
</td></tr>";

// <img src=\"new.gif\" width=\"24\" height=\"12\">

echo "<tr><td>vendor_name</td><td><input type='text' name='vendor_name' value='$vendor_name' size='45'></td></tr>

<tr><td>ncas_invoice_number</td><td><input type='text' name='ncas_invoice_number' value='$ncas_invoice_number'>&nbsp;&nbsp;&nbsp;&nbsp; Park ACS# <input type='text' name='sheet' value='$sheet' size='8'></td></tr><tr><td>ncas_invoice_date</td><td><input type='text' name='ncas_invoice_date' value='$ncas_invoice_date' size='12' maxlength='10'> (m/d/y)</td></tr>

<tr><td>ncas_invoice_amount</td><td><input type='text' name='ncas_invoice_amount' value='$ncas_invoice_amount' size='15'>
&nbsp;&nbsp;ncas_freight <input type='text' name='ncas_freight' value='$ncas_freight' size='7'></td></tr>
    
<tr><td>invoice_total</td><td><input type='text' name='invoice_total' value='$invoice_total' size='15'> ncas_credit <input type='checkbox' name='ncas_credit' value='x'$crCK> refund_code <input type='text' name='refund_code' value='$refund_code' size='5'></td></tr>
<tr><td>ncas_number</td><td><input type='text' name='ncas_number' value='$ncas_number' size='7'>&nbsp;&nbsp;&nbsp;&nbsp;Equip_Request # <input type='text' name='er_num' value='$er_num' size='7'></td></tr>

<tr><td>project_number</td><td><input type='text' name='project_number' value='$project_number' size='5'> <input type='checkbox' name='limit_proj_num' value='x'> Limit to PARTF Projects</td></tr>

<tr><td>ncas_remit_code</td><td><textarea name='ncas_remit_code' cols='55' rows='2'>$ncas_remit_code</textarea></td></tr><tr><td>comments</td><td><textarea name='comments' cols='55' rows='2'>$comments</textarea></td></tr>";

echo "<tr><td>pcard_holder</td><td><textarea name='pcard_holder' cols='55' rows='1'>$pcard_holder</textarea></td></tr>";

/*
<tr><td>pcard_sum</td><td><textarea name='pcard_sum' cols='55' rows='2'>$pcard_sum</textarea></td></tr><tr><td>pcard_just</td><td><textarea name='pcard_just' cols='55' rows='2'>$pcard_just</textarea></td></tr>";
*/

echo "<tr><td>ncas_county_code</td><td><input type='text' name='ncas_county_code' value='$ncas_county_code' size='4'> ncas_company <input type='text' name='ncas_company' value='$ncas_company' size='5'>
 ncas_rcc <input type='text' name='ncas_rcc' value='$ncas_rcc' size='4'> ncas_fund <input type='text' name='ncas_fund' value='$ncas_fund' size='5'></td></tr>

<tr><td>fas_num</td><td><input type='text' name='fas_num' value='$fas_num' size='12'> ncas_accrual_code <input type='text' name='ncas_accrual_code' value='$ncas_accrual_code' size='4'></td></tr>

<tr><td>ncas_po_number</td><td> <input type='text' name='ncas_po_number' value='$ncas_po_number' size='14'></td></tr>

<tr><td>prepared_by</td><td> <input type='text' name='prepared_by' value='$prepared_by' size='14'> approved_by <input type='text' name='approved_by' value='$approved_by' size='14'></td></tr>

<tr><td colspan='2'>limit to this FY $fy<input type='checkbox' name='limitFY' value='x' checked>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type='hidden' name='m' value='invoices'>
<input type='hidden' name='id' value='$passID'>
<input type='submit' name='submit_acs' value='Find'></form></td></tr>

</form>
</table></body></html>";
?>