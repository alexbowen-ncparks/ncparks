<?php
//echo "<pre>"; print_r($arrayNODI); echo "</pre>";  exit;

if(isset($_POST))
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	}
$d_dist="NODI";
$dist_array=${"array".$d_dist};
$clause="(";
foreach($dist_array as $k=>$v)
	{
	$clause.="location='DPR".strtoupper($v)."' or ";
	}
$clause=rtrim($clause," or ").")";

mysqli_select_db($connection,"fixed_assets") or die ("Couldn't select database $database");

$sql="SELECT *
from surplus_track
where 1 and $clause and disu_date='0000-00-00'
";
//	echo "$sql"; exit;
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
if(mysqli_num_rows($result)<1)
	{
	echo "No items from $location awaiting Surplus action."; exit;
	}
while ($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}

$skip=array("id","ts","source","fn_unique","fas_num","serial_num","model_num","disu_date","disu_name","chop_date","chop_name");	
$c=count($ARRAY);

echo "<form method='POST' action='d_surplus.php'>";
echo "<table border='1' cellpadding='5'>
<tr><td colspan='8' align='left'><font color='green' size='+2'>$c items</font></td></tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			if($fld=="condition")
				{
				echo "<th>$fld</th>";
				echo "<th>disu_approve</th>";
				continue;
				}
			echo "<th>$fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if($fld=="photo_upload")
			{
			if(!empty($value))
				{
				$ph="http://www.dpr.ncparks.gov/fixed_assets/".$value;
				$value="<a href='$ph' target='_blank'>photo</a>";
				}
				else
				{$value="";}
			}
			
		if($fld=="condition")
			{
			echo "<td align='left'>$value</td>";
			$id=$ARRAY[$index]['id'];
				echo "<th><input type='checkbox' name='disu_approve[]' value='$id'></th>";
			continue;
			}
		echo "<td align='left'>$value</td>";
		}
	echo "</tr>";
	}
echo "<tr><td colspan='8' align='center'>
<input type='submit' name='submit' value='Update'>
</td></tr>";
echo "</table></form></body></html>";
 
 
 
 ?>