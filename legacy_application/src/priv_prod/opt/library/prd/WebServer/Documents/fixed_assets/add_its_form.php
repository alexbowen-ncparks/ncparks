<?php
$sql="SHOW COLUMNS from its_items"; //echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_assoc($result))
	{
	$COLS[0][$row['Field']]="";
	@$col++;
	}

$c=0;

// RESET
if($_POST['reset']=="Reset"){unset($_POST);}

$size_array=array("id"=>"3","purchase_price"=>"10","date_received"=>"14");
$skip_add=array("id");
echo "<form method='POST' action='add_it.php'>";
echo "<table border='1' cellpadding='3' align='center'>";
echo "<tr><td colspan='3' align='center' font color='cyan'><h3>Add an item to the DPR IT Inventory</h3></font></td></tr>";
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
	$test=${$fld."_array"};
	if(is_array($test))
		{
		echo "<td>
		<select name='$fld' required><option></option>";
		foreach($test as $k=>$v)
			{
			echo "<option $s='$v'>$v</option>";
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
	echo "<td colspan='2'><input type='text' name='$fld' value='$value' size='$size' required></td>";
	echo "</tr>";
	}

echo "<tr><td colspan='2' align='center'>
<input type='submit' name='add' value='Add'>
</td></tr>";
	
echo "</table></form></html>";
?>