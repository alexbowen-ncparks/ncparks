<?php
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$multi_park=explode(",",$_SESSION['ware']['accessPark']);
@$temp_parkCode=$_SESSION[$database]['temp_parkCode'];
//echo "$temp_parkCode<pre>"; print_r($multi_park); echo "</pre>"; // exit;

// $val contains the current cost
$cc="$";
$id=$row['id'];
$product_number=$row['product_number'];
$sold_by_unit=$row['sold_by_unit'];
$sbu=$sold_by_unit;
$plural=array("Box");
if($sbu!="Each")
	{in_array($sold_by_unit,$plural)?$sbu=" of ".$sbu."es":$sbu=" of ".$sbu."s";}
	else
	{$sbu="";}
?>
<script>
function item_tot(cost)
	{
	var n=document.cart.quantity.value;
	var tot=(n*cost).toFixed(2);
	document.cart.total_cost.value=tot;
	}
</script>

<?php
$cart="<form name='cart' action='base_inventory.php' method='POST'>
Number$sbu: <input type='text' name='quantity' value=\"\" size='6' onchange=\"item_tot($val);\" required>
<input type='hidden' name='id' value='$id'>
<input type='hidden' name='product_number' value='$product_number'>
<input type='hidden' name='sold_by_unit' value='$sold_by_unit'>
<input type='hidden' name='price' value='$val'>";
if(count($multi_park)>1)
	{
	$cart.="<select name='park_code' required><option value=''></option>\n";
	foreach($multi_park as $k=>$v)
		{
		if($v==$temp_parkCode){$s="selected";}else{$s="";}
		$cart.="<option value=\"$v\" $s>$v</option>\n";
		}
	$cart.="</select>";
	$cart.="<input type='hidden' name='park_code' value='$temp_parkCode'> for <font color='green' size='+1'>$temp_parkCode RCC $temp_rcc</font> 
	<b>Total for item:</b> $<input type='text' name='total_cost' value=\"\" size='9'>";
	$cart.=" <input type='submit' name='cart' value=\"Add to Cart\" style=\"background-color:#c00; color:#fff;  font-size:14px;\">
	</form>";
	}
	else
	{
	$cart.="<input type='hidden' name='park_code' value='$temp_parkCode'> for <font color='green' size='+1'>$temp_parkCode RCC $temp_rcc</font> 
	<b>Total for item:</b> $<input type='text' name='total_cost' value=\"\" size='9'>";
	$cart.=" <input type='submit' name='cart' value=\"Add to Cart\" style=\"background-color:#c00; color:#fff;  font-size:14px;\">
	</form>";
	}



?>