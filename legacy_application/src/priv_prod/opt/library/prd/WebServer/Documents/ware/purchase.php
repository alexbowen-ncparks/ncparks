<?php
ini_set('display_errors',1);

$database="ware";
	$title="Warehouse Inventory";

include("../_base_top.php");
	
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
//echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
date_default_timezone_set('America/New_York');

include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, $database)
       or die ("Couldn't select database $database");
       
$level=$_SESSION['ware']['level'];

if($level<1){exit;}

// VOID
if(!empty($_POST) AND @$_POST['var_purchase']=="Void Purchase")
	{
	//	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	$skip_update=array("var_purchase");
	$fld_list="(`purchase_id`, `purchase_date`, `purchase_number`, `purchase_by`, `receive_date`, `receive_by`, `vendor`, `ware_product_title`, `supplier_id`, `ware_product_number`, `vendor_product_price`, `order_quantity`, `receive_quantity`, `line_amount_ordered`, `line_amount_received`, `receipt_complete`, `purchase_comments`)";

	$pi=$_POST['purchase_id'];
	$sql="insert into void_purchase $fld_list 
	SELECT * FROM purchase where purchase_id='$pi'";
	//	echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
	$sql="DELETE FROM purchase where purchase_id='$pi'";
	//	echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
	$_POST['submit']="Search";
	$_REQUEST['submit']="Purchases Voided";
	}

// ADD
if(!empty($_POST) AND @$_POST['var_purchase']=="Add Purchase")
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
   	$skip_update=array("submit","supplier_id","ware_product_number","var_purchase");
   	
	foreach($_POST as $fld=>$val)
		{
		if(in_array($fld, $skip_update)){continue;}
// 		$val=mysqli_real_escape_string($connection, $val);
		if($fld=="ware_product_title")
			{
			$exp=explode("*",$val);
			$val=$exp[0];
			$clause.="ware_product_number='".$exp[1]."', ";
			}
		if($fld=="vendor")
			{
			$exp=explode("*",$val);
			$val=$exp[0];
			$clause.="supplier_id='".$exp[1]."', ";
			}
		@$clause.=$fld."='".$val."', ";
		}
	$clause=rtrim($clause, ", ");
	$sql="insert into purchase set $clause";
//	echo "After insert send user to All purchases which needs to be developed<br />";
//	echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
	$purchase_id=mysqli_insert_id($connection);
	$_REQUEST['submit']="Edit Purchase";
	}
	
		
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

echo "<table border='1' cellpadding='5' align='center'>";
echo "<tr><td align='center'>
<form action='purchase.php'>
<input type='submit' name='submit' value=\"Add a Purchase\" style=\"background-color:cyan;font-size: 115%;\" >
</form></td>
<td><form action='purchase.php'>
<input type='submit' name='submit' value=\"View Purchases\" style=\"background-color:orange;font-size: 115%;\">
</form></td>
<td><form action='purchase.php'>
<input type='submit' name='submit' value=\"Purchases Voided\" style=\"background-color:pink;font-size: 115%;\">
</form></td>
</tr></table>";

if(empty($_REQUEST['submit']))
	{exit;}

// js functions
echo "
<script type=\"text/javascript\">
function amt_ordered(){
var price=document.getElementById('vendor_product_price').value;
var quant=document.getElementById('order_quantity').value;
document.getElementById('line_amount_ordered').value= (quant * price).toFixed(2);
}

function amt_received(){
var price=document.getElementById('vendor_product_price').value;
var quant=document.getElementById('receive_quantity').value;
document.getElementById('line_amount_received').value= (quant * price).toFixed(2);
}
</script>
";
echo "<title>NC DPR Warehouse Purchases</title><body>";

IF($_REQUEST['submit']=="Add a Purchase" or $_REQUEST['submit']=="Add Purchase")
	{include("purchase_form.php");}
IF($_REQUEST['submit']=="Edit Purchase" or $_REQUEST['submit']=="Update Purchase")
	{include("edit_purchase_form.php");}
IF($_REQUEST['submit']=="View Purchases" or $_REQUEST['submit']=="Search")
	{include("view_purchase_form.php");}
IF($_REQUEST['submit']=="Purchases Voided")
	{include("view_void_form.php");}


?>