<?php
date_default_timezone_set('America/New_York');
extract($_POST);
echo "<html><body><table border='1' bgcolor='beige' align='center'>
<tr><td colspan='3' align='center'>Data common to all invoices on Code Sheet</td></tr>";

if(!$go_multi)
	{
	//$excludeArray=array("ncas_invoice_number","ncas_invoice_date","po_line1","ncas_invoice_amount","ncas_credit","ncas_company","ncas_account","ncas_rcc","ncas_fund","accrual_code","invoice_total","ncas_number","prefix","ncas_accrual_code");
	
	$showOnFormArray=array("ncas_invoice_number","ncas_invoice_date","po_line1","ncas_invoice_amount","ncas_credit","ncas_company","ncas_account","ncas_rcc", "ncas_fund","accrual_code","invoice_total","ncas_number","prefix","ncas_accrual_code");
	
	//print_r($multiArray);//exit;
	foreach($multiArray as $k=>$v){
		if($v!="" AND !in_array($k,$showOnFormArray)){
		$t=fmod($m1,3);
		if($t==0){$tr="<tr>";}else{$tr="";}
		if($t==2){$tr1="<tr>";}else{$tr1="";}
			//$common[$k]=addslashes($v);
			$common[$k]=($v);
		echo "$tr<td>$k = $v</td>$tr1";
			$m1++;
		}
	}
	//echo "<pre>";print_r($common);echo "</pre>";//exit;
	//$singleCommon=implode("~",$common);
	echo "</table>";
	
	
	//<th>Account</th>
	echo "<form action='acs_multi.php' method='POST'><table border='1' align='center'>
	<tr><td colspan='12' align='center'><font color='purple'>Data for each invoice on Code Sheet</font></td></tr>
	<tr><th>Invoice Number</th>
	<th>Invoice Date</th>
	<th>Fund</th>
	<th>RCC</th>
	<th>Amount</th>
	<th>Prefix</th>
	<th>NCAS Number</th>
	<th>PO Line</th>
	<th>Freight</th>
	<th>Credit</th>
	<th>Company</th>
	<th>Accrual Code</th></tr>";
	
	//if($m2==1){$fld8=$multiArray['ncas_account'];}else{$fld8="";}
	for($m2=1;$m2<=$branch;$m2++)
		{
		if($m2==1){$fld1=$multiArray['ncas_invoice_number'];}//else{$fld1="";}
		if($m2==1){$fld2=$multiArray['ncas_invoice_date'];}//else{$fld2="";}
		if($m2==1){$fld11=$multiArray['ncas_fund'];}//else{$fld2="";}
		if($m2==1){$fld9=$multiArray['ncas_rcc'];}else{$fld9="";}
		if($m2==1){$fld3=$multiArray['po_line1'];}else{$fld3="";}
		if($m2==1){$fld4=$multiArray['ncas_invoice_amount'];}else{$fld4="";}
		if($m2==1){$fld12=$multiArray['prefix'];}//else{$fld12="";}
		if($m2==1){$fld13=$multiArray['ncas_number'];}else{$fld13="";}
		if($m2==1){$fld5=$multiArray['ncas_freight'];}else{$fld5="";}
		if($m2==1){$fld6=$multiArray['ncas_credit'];}else{$fld6="";}
		if($m2==1){$fld7=$multiArray['ncas_company'];}//else{$fld7="";}
		if($m2==1){$fld10=$multiArray['ncas_accrual_code'];}else{$fld10="";}
		
		//<td><input type='text' name='ncas_account[]' value='$fld8' size='8'></td>
		echo "<tr>
		<td><font color='blue'>$m2</font> <input type='text' name='ncas_invoice_number[]' value='$fld1'></td>
		<td><input type='text' name='ncas_invoice_date[]' value='$fld2' size='10'></td>
		<td><input type='text' name='ncas_fund[]' value='$fld11' size='5'></td>
		<td><input type='text' name='ncas_rcc[]' value='$fld9' size='5'></td>
		<td><input type='text' name='ncas_invoice_amount[]' value='$fld4' size='10'></td>
		<td><input type='text' name='prefix[]' value='$fld12' size='3'></td>
		<td><input type='text' name='ncas_number[]' value='$fld13' size='10'></td>
		<td><input type='text' name='po_line1[]' value='$fld3' size='8'></td>
		<td><input type='text' name='ncas_freight[]' value='$fld5' size='7'></td>
		<td><input type='text' name='ncas_credit[]' value='$fld6' size='3'></td>
		<td><input type='text' name='ncas_company[]' value='$fld7' size='10'></td>
		<td><input type='text' name='ncas_accrual_code[]' value='$fld10' size='10'></td>
		</tr>";
		}
	
	echo "<tr><td colspan='10' align='center'>";
	//print_r($common);exit;
	foreach($common as $k=>$v){echo "<input type='hidden' name=\"passCommon[$k]\" value=\"$v\">";}
	
	echo "<input type='hidden' name='go_multi' value='yes'>
	<input type='hidden' name='due_date' value='$due_date'>
	<input type='submit' name='submit_acs' value='Add'>
	</td></tr>";	
	echo "</form></body></html>";
	exit;
	}

// *********************** Add records

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 

if($go_multi and $submit_acs=="Add")
	{
	//echo "<pre>";print_r($_POST);echo "</pre>";
	
	$boilerPlate=explode("~",$_POST['passCommon']);
	$parkcode=$passCommon['parkcode'];
	
	 function DateAdd($v,$d=null , $f="m/d/Y")
		{
		$d=($d?$d:date("m/d/Y")); 
		return date($f,strtotime($v." days",strtotime($d))); 
		}
	 $ncas_invoice_date=$POST['ncas_invoice_date'][0];
	if(!$due_date||$due_date=="will be calculated")
		{
		$due_date="due_date='".DateAdd(14,$ncas_invoice_date)."-".$parkcode."'";
		}
		else
		{$due_date="due_date='".$due_date."'";}
	
	$excludeThese=array("go_multi","passCommon","due_date","submit_acs");
	
	foreach($_POST as $k=>$v){$fldArray[]=$k;}
	
	//echo "<pre>";print_r($_POST);echo "</pre>";

	foreach($passCommon as $key=>$value)
		{
		@$boilerString.=", ".$key."='".mysqli_real_escape_string($value)."'";
		}
	
	//$c=count($fldArray);
	for($j=0;$j<count($_POST['ncas_invoice_number']);$j++)
		{
		$stringSet="";
		foreach($fldArray as $k=>$v)
			{
			if(in_array($v,$excludeThese)){continue;}
			$val=$_POST[$v][$j];
			if($_POST['ncas_invoice_amount'][$j]!="")
				{$stringSet.=$v."='".$val."', ";}
			}
		if(!empty($stringSet))
			{
			$query = "INSERT into cid_vendor_invoice_payments SET $stringSet $due_date, ncas_center=concat(ncas_fund,ncas_rcc), invoice_total=(ncas_invoice_amount+ncas_freight), ncas_account=concat(prefix,ncas_number)";
			$query.=$boilerString;
			//echo "$query<br /><br />";
			}
		$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query".mysqli_error());
		$id=mysql_insert_id();
		}// end $j
	
	}


header("Location: /budget/acs/acs.php?id=$id&num_invoice=$branch");

?>