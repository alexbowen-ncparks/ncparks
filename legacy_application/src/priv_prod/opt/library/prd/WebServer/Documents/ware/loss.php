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


// ADD
if(!empty($_POST) AND @$_POST['submit']=="Add Loss")
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
   	$skip_update=array("submit");
   	
	foreach($_POST as $fld=>$val)
		{
		if(in_array($fld, $skip_update)){continue;}
// 		$val=mysqli_real_escape_string($connection, $val);
		if($fld=="product_title")
			{
			$exp=explode("*",$val);
			$val=$exp[0];
			@$clause.="product_number='".$exp[1]."', ";
			}
		@$clause.=$fld."='".$val."', ";
		}
	$clause=rtrim($clause, ", ");
	$sql="insert into loss set $clause";
//	echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
	$loss_id=mysqli_insert_id($connection);
	$_REQUEST['submit']="Edit Loss";
	}
	
//	echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
// Update
if(!empty($_POST) AND $_POST['submit']=="Update Loss")
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
   	$skip_update=array("submit","loss_id");
   	$loss_id=$_POST['loss_id'];
	foreach($_POST as $fld=>$val)
		{
		if(in_array($fld, $skip_update)){continue;}
// 		$val=mysqli_real_escape_string($connection, $val);
		
		@$clause.=$fld."='".$val."', ";
		}
	$clause=rtrim($clause, ", ");
	$sql="UPDATE loss set $clause WHERE loss_id='$loss_id'";
//	echo "After insert send user to All purchases which needs to be developed<br />";
//	echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	
	}
		
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

echo "<table border='1' cellpadding='5' align='center'>";
echo "<tr><td align='center'>
<form action='loss.php'>
<input type='submit' name='submit' value=\"Add a Loss\" style=\"background-color:cyan;font-size: 115%;\" >
</form></td>
<td><form action='loss.php'>
<input type='submit' name='submit' value=\"View Losses\" style=\"background-color:orange;font-size: 115%;\">
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

</script>
";
echo "<title>NC DPR Warehouse Losses</title><body>";

IF($_REQUEST['submit']=="Add a Loss" or $_REQUEST['submit']=="Add Loss")
	{include("loss_form.php");}
IF($_REQUEST['submit']=="Edit Loss" or $_REQUEST['submit']=="Update Loss")
	{include("edit_loss_form.php");}
IF($_REQUEST['submit']=="View Losses" or $_REQUEST['submit']=="Search")
	{include("view_loss_form.php");}

?>