<?php

	$sql="select *
	from void_purchase 
	where 1 "; 
	//echo "$sql<br /><br />c=$clause<br />";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
	if(mysqli_num_rows($result)<1)
		{
		echo "No voided purchases found."; exit;
		}
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}

		
// Display results
	$c=count($ARRAY);
echo "<table border='1'><tr><td colspan='3'><font color='red' size='+1'>Void Purchases: $c</font></td></tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			echo "<th>$fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";
echo "</body></html>";
?>