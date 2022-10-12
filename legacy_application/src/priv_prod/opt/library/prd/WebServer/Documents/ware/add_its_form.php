<?php
$sql="SHOW COLUMNS from base_inventory"; //echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_assoc($result))
	{
	$COLS[0][$row['Field']]="";
	@$col++;
	}
//echo "<pre>"; print_r($COLS); echo "</pre>"; // exit;
$c=0;

// RESET
if(@$_POST['reset']=="Reset"){unset($_POST);}

$size_array=array("id"=>"3","sort_order"=>"5","purchase_price"=>"10","date_received"=>"14");
$skip_add=array("id","photo");
$required_array=array("product_title","sold_by_unit","funding_account","current_cost");
$submit_array=array("item_group","sub_group_1","sub_group_2");
echo "<form method='POST' action='add_it.php'>";
echo "<table border='1' cellpadding='3' align='center'>";
echo "<tr><td colspan='3' align='center' font color='cyan'><h3>Add an item to the DPR Warehouse Inventory</h3></font></td></tr>";
foreach($COLS[0] AS $fld=>$value)
	{
	if(in_array($fld,$skip_add)){continue;}
	echo "<tr>";
	$fld_1=str_replace("_"," ",$fld);
	echo "<th>$fld_1</th>";
	
	if(array_key_exists($fld, $size_array))
		{$size=$size_array[$fld];}
		else
		{$size='30';}
	@$test=${$fld."_array"};
	if(is_array($test))
		{
		$var_select="<select name='$fld' required><option></option>";
		if(in_array($fld, $submit_array))
			{
			$req="required";
			if($fld=="sub_group_2" || $fld=="sub_group_1"){$req="";}
			$var_select="<select name='$fld' onchange=\"this.form.submit()\" $req><option></option>";
			}
		echo "<td>
		$var_select";
		foreach($test as $k=>$v)
			{
			if($v==$_POST[$fld]){$s="selected";}else{$s="";}
			echo "<option value='$v' $s>$v</option>";
			}
		$alt_fld="alt_".$fld;
		echo "</select></td>";
		if($fld!="type")
			{
			echo "<td><input type='text' name='$alt_fld' value=\"\"'></td>";
			}
		echo "</tr>";
		continue;
		}
	if($fld=="date_received")
		{
		echo "<td><input type='text' id='datepicker1' name='$fld' value='$value' size='$size' required></td></tr>";
		continue;
		}
	if($fld=="comments")
		{
		echo "<td colspan='2'><textarea name='$fld' rows='5' cols='40'>$value</textarea></td></tr>";
		continue;
		}
	if($fld=="product_description")
		{
		echo "<td colspan='2'><textarea name='$fld' rows='3' cols='40' required>$value</textarea></td></tr>";
		continue;
		}
	if($fld=="product_link_1" or $fld=="product_link_2")
		{
		echo "<td colspan='2'><textarea name='$fld' rows='2' cols='40'>$value</textarea></td></tr>";
		continue;
		}
	if($fld=="hide")
		{
		$value==""?$ck="":$ck="checked";
		echo "<td colspan='2'><input type='checkbox' name='$fld' value=\"x\" $ck> from field staff.</td></tr>";
		continue;
		}
	if(in_array($fld,$required_array)){$req="required";}else{$req="";}
	if($fld=="product_number")
		{$value=$new_product_number;}
	
	if($fld=="sort_order")
		{
		if(!isset($sort_order_min)){$sort_order_min="";}
		if(!isset($sort_order_max)){$sort_order_max="";}
		$note="<font size='-1'>1.00, 1.01, 1.10, 1.11</font> min=$sort_order_min max=$sort_order_max";
		if(!empty($_POST['sort_order'])){$value=$_POST['sort_order'];}
		}else{$note="";}
		
	echo "<td colspan='2'><input type='text' name='$fld' value='$value' size='$size' $req> $note</td>";
	echo "</tr>";
	}

echo "<tr><td colspan='3' align='center'>
<input type='submit' name='add' value='Add'>
</td></tr>";

echo "<tr><td colspan='3' align='center'>
After adding the product we will associate it with the supplier or suppliers.
</td></tr>";
	
echo "</table></form></html>";
?>