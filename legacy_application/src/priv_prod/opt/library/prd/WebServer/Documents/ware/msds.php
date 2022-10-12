<?php
$database="ware";
include("../../include/auth.inc");
$title="Warehouse Inventory";
	include("../_base_top.php");
	
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, $database)
   or die ("Couldn't select database $database");

$sql="SELECT t1.product_number, t2.product_title, t1.link 
from msds as t1 
left join base_inventory as t2 on t1.product_number=t2.product_number
where 1
order by t2.sort_order"; //echo "$sql";
$result=MYSQLI_QUERY($connection,$sql);
while ($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}

$skip=array();
$c=count($ARRAY);
echo "<table><tr><td>$c items</td></tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			echo "<th>$fld</th>";
			}
		echo "</tr>";
		}
	if(fmod($index,2)==0){$tr=" bgcolor='#F0F0B2'";}else{$tr="";}
	echo "<tr$tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if($fld=="product_number")
			{
			$value="<a href='view_item.php?product_number=$value' target='_blank'>$value</a>";
			}
		if($fld=="link")
			{$value="<a href='$value' target='_blank'>SDS</a>";}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";
echo "</form></html>";
?>