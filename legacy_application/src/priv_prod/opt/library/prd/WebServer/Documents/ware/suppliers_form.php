<?php
$sql="SHOW COLUMNS from base_supplier"; //echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_assoc($result))
	{
	$COLS[0][$row['Field']]="";
	@$col++;
	}

// RESET
if(@$_POST['reset']=="Reset"){unset($_POST);}

$size_array=array("supplier_id"=>"3","supplier_name"=>"80", "supplier_add_1"=>"50","supplier_add_2"=>"50" ,"supplier_website"=>"80");
$skip_add=array("supplier_id");
$required_array=array("supplier_name","supplier_add_1","supplier_city","supplier_state", "supplier_zip");

echo "<form method='POST' action='add_supplier.php'>";
echo "<table border='1' cellpadding='3' align='center'>";
echo "<tr><td colspan='3' align='center' font color='cyan'><h3>Add a Supplier to the DPR Warehouse Inventory</h3></font></td></tr>";
foreach($COLS[0] AS $fld=>$value)
	{
	if(in_array($fld,$skip_add)){continue;}
	echo "<tr>";
	$fld_1=str_replace("supplier_","",$fld);
	echo "<th>$fld_1</th>";
	
	if(array_key_exists($fld, $size_array))
		{$size=$size_array[$fld];}
		else
		{$size='30';}
		
	if($fld=="supplier_state")
		{
		include("../../include/state_array.php");
		echo "<td>
		<select name='$fld' required><option></option>";
		foreach($array_of_states as $k=>$v)
			{
			if($v==$_POST[$fld]){$s="selected";}else{$s="";}
			echo "<option value='$v' $s>$k</option>";
			}
		echo "</select></td>";
		continue;
		}
	if($fld=="supplier_comments")
		{
		echo "<td colspan='2'><textarea name='$fld' rows='5' cols='40'>$value</textarea></td></tr>";
		continue;
		}
	if(in_array($fld,$required_array)){$req="required";}else{$req="";}
	
	echo "<td colspan='2'><input type='text' name='$fld' value='$value' size='$size' $req></td>";
	echo "</tr>";
	}

echo "<tr><td colspan='3' align='center'>
<input type='submit' name='add' value='Add'>
</td></tr>";
	
echo "</table></form></html>";
?>