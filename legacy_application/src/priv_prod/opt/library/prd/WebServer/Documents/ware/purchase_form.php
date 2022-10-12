<?php

// get fiscal year using file from budget
include("../budget/~f_year.php");
//	echo "p=$f_year $pf_year";

$sql="SHOW COLUMNS from purchase"; //echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_assoc($result))
	{
	$COLS[0][$row['Field']]="";
	@$col++;
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

$size_array=array("supplier_id"=>"3","vendor"=>"50", "ware_product_title"=>"80","supplier_add_2"=>"50" ,"supplier_website"=>"80");
$skip_add=array("supplier_id","purchase_id","receive_date","receive_by","receive_quantity","line_amount_received","receipt_complete");
$required_array=array("purchase_date","vendor","ware_product_number","vendor_product_price", "order_quantity");
$readonly_array=array("purchase_by","line_amount_ordered");

echo "<form id='add_form' method='POST' action='purchase.php'>";
echo "<table border='1' cellpadding='3' align='center'>";

echo "<tr><td colspan='3' align='center' font color='blue'><h3><font color='cyan'>Add a Purchase</font></h3></td></tr>";
foreach($COLS[0] AS $fld=>$value)
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
		
	if($fld=="fiscal_year")
		{
		echo "<td colspan='2'><input type='text' name='$fld' value='$f_year' size='$size' readonly></td>";
		continue;
		}
	if($fld=="purchase_by")
		{
		if(empty($value))
			{$value=$_SESSION['ware']['full_name'];}
		echo "<td colspan='2'><input type='text' name='$fld' value='$value' size='$size'  $ro  $req></td>";
		continue;
		}
	if($fld=="purchase_date")
		{
		echo "<td colspan='2'><input id='datepicker1' type='text' name='$fld' value='$value' size='$size' $req></td>";
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
		echo "<td colspan='2'><input id='$fld' type='text' name='$fld' value='$value' size='$size' $req ></td></tr>";
		continue;
		}
	
	if($fld=="ware_product_number")
		{
		echo "<td colspan='2'><div id=\"ajaxDiv\">Select a Product Title and the Product Number will be displayed.</div></td></tr>";
	//	echo "<td colspan='2'><input id='$fld' type='text' name='$fld' value='$value' size='$size' $req >
	//	ajax <div id=\"ajaxDiv\">Your result will display here</div></td></tr>";
		continue;
		}
	if($fld=="ware_product_title")
		{
		echo "<td colspan='2'><input id='$fld' type='text' name='$fld' value=\"$value\" onchange=\"ajaxFunction()\" size='$size' $req >
		</td></tr>";
		continue;
		}
	
	$js="";
	$com="";
	if($fld=="order_quantity")
		{
		$js="onchange=\"amt_ordered()\"";
		$size='10';
		$com="Do not enter any ,";
		}
	if($fld=="vendor_product_price")
		{
		$js="onchange=\"amt_ordered()\"";
		$size='10';
		$com="Do not enter any $ or ,";
		}
	echo "<td colspan='2'><input id='$fld' type='text' name='$fld' value='$value' size='$size' $req $ro $js> $com</td>";
	echo "</tr>";
	}

		echo "
		<script>
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
<input type='submit' name='var_purchase' value='Add Purchase'>
</td></tr>";
	
echo "</table></form></html>";
?>