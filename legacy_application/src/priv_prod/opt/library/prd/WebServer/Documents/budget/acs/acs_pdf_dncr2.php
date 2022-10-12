<?php
// ini_set('display_errors,',1);

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database 

//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
if(isset($vendor_number))
	{
	$vendor_number=trim($vendor_number);
	$select="SELECT * From cid_vendor_invoice_payments ";
	$where="where cid_vendor_invoice_payments.vendor_number='$vendor_number' AND due_date='$due_date'";
	}
else{

if($prepared_by=="Barbara Adams"||$prepared_by=="Pamela Laurence"){
$pb="(prepared_by='Barbara Adams' OR prepared_by='Pamela Laurence')";}
else
{$pb="prepared_by='$prepared_by'";}

$vendor_name=urldecode($vendor_name);
$vendor_name=addslashes($vendor_name);  // necessary since vendor_name was sent urlencoded and not escaped in no_inject.php
$select="SELECT cid_vendor_invoice_payments.*,coa.park_acct_desc
From cid_vendor_invoice_payments ";
$where="where vendor_name='$vendor_name' AND due_date='$due_date' AND $pb";
}
$JOIN="LEFT JOIN coa on cid_vendor_invoice_payments.ncas_account = coa.ncasnum";

$sql = "$select
$JOIN
$where
group by id, ncas_invoice_number
order by ncas_invoice_number
";
// echo "$sql"; //exit;

$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");

while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[$row['ncas_invoice_number']][]=$row;
	}

$count=count($ARRAY);
// echo "$count $sql <pre>"; print_r($ARRAY); echo "</pre>";  exit;

if($count>1)
	{
	include("acs_pdf_dncr3.php");
	}
	else
	{
	include("acs_pdf_dncr1.php");
	}

?>