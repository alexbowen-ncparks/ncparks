<?php
	
$sql="SHOW COLUMNS from loss"; //echo "$sql";
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

$size_array=array("loss_id"=>"3","vendor"=>"50", "product_title"=>"100");
$skip_add=array("supplier_id","loss_id","receive_date","receive_by","receive_quantity","line_amount_received","receipt_complete");
$required_array=array("loss_date","product_title", "loss_quantity", "loss_description");
$readonly_array=array("entered_by","entry_date");

echo "<form id='loss_form' method='POST' action='loss.php'>";
echo "<table border='1' cellpadding='3' align='center'>";

echo "<tr><td colspan='3' align='center' font color='blue'><h3><font color='cyan'>Add a Loss</font></h3></td></tr>";
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
		
	if($fld=="entered_by")
		{
		if(empty($value))
			{$value=$_SESSION['ware']['full_name'];}
		echo "<td colspan='2'><input type='text' name='$fld' value='$value' size='$size'  $ro  $req></td>";
		continue;
		}
	if($fld=="entry_date")
		{
		if(empty($value))
			{$value=date("Y-m-d");}
		echo "<td colspan='2'><input type='text' name='$fld' value='$value' size='$size' $req $ro></td>";
		continue;
		}
	if($fld=="loss_description")
		{
		echo "<td colspan='2'><textarea id='$fld' name='$fld' rows='5' cols='40' $req>$value</textarea></td></tr>";
		continue;
		}
		
	
	if($fld=="product_number")
		{
		echo "<td colspan='2'><div id=\"ajaxDiv\">Select a Product Title and the Product Number will be displayed.</div></td></tr>";
	//	echo "<td colspan='2'><input id='$fld' type='text' name='$fld' value='$value' size='$size' $req >
	//	ajax <div id=\"ajaxDiv\">Your result will display here</div></td></tr>";
		continue;
		}
	if($fld=="product_title")
		{
		echo "<td colspan='2'><input id='$fld' type='text' name='$fld' value=\"$value\" onchange=\"ajaxFunction()\" size='$size' $req >
		</td></tr>";
		continue;
		}
	
	echo "<td colspan='2'><input id='$fld' type='text' name='$fld' value='$value' size='$size' $req $ro></td>";
	echo "</tr>";
	}

		echo "
		<script>
		$(function()
			{
			$( \"#product_title\" ).autocomplete({
			source: [ $source_product ]
				});
			});
		</script>";
		
echo "<tr><td colspan='3' align='center'>
<input type='submit' name='submit' value='Add Loss'>
</td></tr>";
	
echo "</table></form></html>";
?>