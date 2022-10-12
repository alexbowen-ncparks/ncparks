<?php

if(empty($loss_id))
	{$loss_id=$_GET['loss_id'];}	
$sql="SELECT * from loss where loss_id='$loss_id'"; //echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}

/*
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

*/
 mysqli_free_result($result);
	
// RESET
if(@$_POST['reset']=="Reset"){unset($_POST);}

$size_array=array("loss_id"=>"3","vendor"=>"50", "product_number"=>"10","product_title"=>"60");
$skip_add=array("supplier_id","purchase_id");
$required_array=array("purchase_date","vendor","ware_product_number","vendor_product_price", "order_quantity");
$readonly_array=array("entered_by","entry_date","product_number");

echo "<form id='loss_form' method='POST' action='loss.php'>";
echo "<table border='1' cellpadding='3' align='center'>";

echo "<tr><td colspan='3' align='center' font color='blue'><h3><font color='orange'>Update a Loss</font></h3></td></tr>";
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
		

	if($fld=="loss_description")
		{
		echo "<td colspan='2'><textarea id='$fld' name='$fld' rows='5' cols='40'>$value</textarea></td></tr>";
		continue;
		}

	
	echo "<td colspan='2'><input id='$fld' type='text' name='$fld' value=\"$value\" size='$size' $req $ro></td>";
	echo "</tr>";
	}
		
echo "<tr><td colspan='3' align='center'>
<input type='submit' name='submit' value='Update Loss' style=\"background-color:green; color:white; font-size:110%; padding:2px\">
</td></tr>";
	
echo "</table></form></html>";
?>