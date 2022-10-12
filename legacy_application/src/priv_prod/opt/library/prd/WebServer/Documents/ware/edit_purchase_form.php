<?php

// ADD
if(!empty($_POST) AND $_POST['var_purchase']=="Update Purchase")
	{
	echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
   	$skip_update=array("submit","supplier_id","purchase_id");
   	
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
	$sql="UPDATE purchase set $clause WHERE purchase_id='$purchase_id'";
//	echo "After insert send user to All purchases which needs to be developed<br />";
	echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	$supplier_id=mysqli_insert_id($connection);
	header("Location: edit_purchase_form.php?purchase_id=$purchase_id");
	exit;
	}
	
if(empty($purchase_id))
	{$purchase_id=$_GET['purchase_id'];}	
$sql="SELECT * from purchase where purchase_id='$purchase_id'"; //echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}

$sql="SELECT supplier_id, supplier_name from base_supplier"; //echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
$source_name="";
while($row=mysqli_fetch_assoc($result))
	{
	$val=$row['supplier_name']."*".$row['supplier_id'];
	$source_name.="\"".$val."\",";
	}
	
$sql="SELECT product_number, product_title from base_inventory"; //echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
$source_product="";
while($row=mysqli_fetch_assoc($result))
	{
	$pt=str_replace("'","\'",$row['product_title']);
//	$pt=$row['product_title'];
	$pt=str_replace("\"","\\\"",$pt);
	$val=$pt."*".$row['product_number'];
//	$val=$pt;
	$source_product.="\"".$val."\",";
	}
//	echo "$source_product";
 mysqli_free_result($result);
	
// RESET
if(@$_POST['reset']=="Reset"){unset($_POST);}

$size_array=array("supplier_id"=>"3","vendor"=>"50", "ware_product_number"=>"10","supplier_add_2"=>"50" ,"ware_product_title"=>"60");
$skip_add=array("supplier_id","purchase_id");
$required_array=array("purchase_date","vendor","ware_product_number","vendor_product_price", "order_quantity");
$readonly_array=array("purchase_by","line_amount_ordered","line_amount_received", "receipt_complete", "order_quantity", "vendor_product_price","ware_product_number", "ware_product_title", "purchase_date", "purchase_number", "vendor", "receive_by");

echo "<form id='add_form' method='POST' action='purchase.php'>";
echo "<table border='1' cellpadding='3' align='center'>";

echo "<tr><td colspan='3' align='center' font color='blue'><h3><font color='orange'>Update a Purchase</font></h3></td></tr>";
foreach($ARRAY[0] AS $fld=>$value)
	{
	if(in_array($fld,$skip_add)){continue;}
	echo "<tr>";
	$fld_1=str_replace("supplier_","",$fld);
	echo "<th>$fld_1</th>";
	
	if(in_array($fld,$required_array)){$req="required";}else{$req="";}
	if(in_array($fld,$readonly_array)){$ro="readonly";}else{$ro="";}
	
	if(array_key_exists($fld, $size_array))
		{$size=$size_array[$fld];}
		else
		{$size='30';}
		
	if($fld=="receive_by")
		{
		if(empty($value))
			{$value=$_SESSION['ware']['full_name'];}
		echo "<td colspan='2'><input id='datepicker1' type='text' name='$fld' value='$value' size='$size'  $ro  $req></td>";
		continue;
		}
	if($fld=="purchase_date")
		{
		echo "<td colspan='2'><input id='datepicker1' type='text' name='$fld' value='$value' size='$size' $req $ro></td>";
		continue;
		}
	if($fld=="receive_date")
		{
		echo "<td colspan='2'><input id='datepicker2' type='text' name='$fld' value='$value' size='$size' $req></td>";
		continue;
		}
	if($fld=="purchase_comments")
		{
		echo "<td colspan='2'><textarea id='$fld' name='$fld' rows='5' cols='40'>$value</textarea></td></tr>";
		continue;
		}
		
	if($fld=="vendor")
		{
		echo "<td colspan='2'><input id='$fld' type='text' name='$fld' value='$value' size='$size' $req $ro></td></tr>";
		continue;
		}
	
	if($fld=="ware_product_number")
		{
		echo "<td colspan='2'><input id='$fld' type='text' name='$fld' value='$value' size='$size' $req $ro></td></tr>";
		continue;
		}
	if($fld=="ware_product_title")
		{
		echo "<td colspan='2'><input id='$fld' type='text' name='$fld' value=\"$value\" onchange=\"ajaxFunction()\" size='$size' $req $ro>
		</td></tr>";
		continue;
		}
	
	$js="";
	$com="";
	$pre="";
	if($fld=="order_quantity")
		{
		$js="onchange=\"amt_ordered()\"";
		$size='10';
	//	$com="Do not enter any ,";
		}
	if($fld=="receive_quantity")
		{
		$js="onchange=\"amt_received()\"";
		$size='10';
	//	$com="Do not enter any ,";
		}
	if($fld=="vendor_product_price")
		{
		$pre="$";
		$js="onchange=\"amt_ordered()\"";
		$size='10';
	//	$com="Do not enter any $ or ,";
		}
	if($fld=="line_amount_ordered")
		{
		$pre="$";
		}
	if($fld=="line_amount_received")
		{
		$pre="$";
		}
	echo "<td colspan='2'>$pre<input id='$fld' type='text' name='$fld' value='$value' size='$size' $req $ro $js> $com</td>";
	echo "</tr>";
	}
/*
		
*/
		echo "<script>
		$(function()
			{
			$( \"#vendor\" ).autocomplete({
			source: [ $source_name ]
				});
			});
		</script>
		<script>
		$(function()
			{
			$( \"#ware_product_title\" ).autocomplete({
			source: [ $source_product ]
				});
			});
		</script>";
		
echo "<tr><td colspan='3' align='center'>
<input type='hidden' name='purchase_id' value='$purchase_id'>
<input type='submit' name='var_purchase' value='Void Purchase' style=\"background-color:red; color:white\" onclick=\"return confirm('Are you sure you want to Void this purchase?')\">
<input type='submit' name='var_purchase' value='Update Purchase' style=\"background-color:green; color:white; font-size:110%; padding:2px\">
</td></tr>";
	
echo "</table></form></html>";
?>