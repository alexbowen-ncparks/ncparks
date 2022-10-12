<?php
$war_db="inspect";
$db = mysqli_select_db($connection,$war_db)       or die ("Couldn't select database");

unset($ARRAY_prev);
$sql="SELECT t4.district, t1.id, t1.parkcode, t1.id_inspect, t1.date_inspect
FROM document as t1
LEFT JOIN dpr_system.parkcode_names as t4 on t1.parkcode=t4.park_code
where date_inspect >= '$last_week' and date_inspect <= '$today'
order by t4.district, t1.parkcode, t1.id_inspect"; //echo $sql;
$result = @MYSQLI_QUERY($connection,$sql) or die(mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_prev[]=$row;
	}
$c_prev=count($ARRAY_prev);


$exclude=array("enterBy","dist","dateToday");


echo "<div id='safety' style='display: none'>";
	echo "<table border='1' cellpadding='3'><tr><th colspan='6'>$c_prev Safety Inspections in the previous 7 days</th></tr>";
	foreach($ARRAY_prev AS $index=>$array)
		{
		if($index==0)
			{
			echo "<tr>";
			foreach($ARRAY_prev[0] AS $fld=>$value)
				{
				if(in_array($fld,$exclude)){continue;}
				if($fld=="id")
					{echo "<td>View</td>";}
					else
					{echo "<td>$fld</td>";}
				}
			echo "</tr>";
			}
		if(fmod($index,2)==0){$tr=" bgcolor='aliceblue'";}else{$tr="";}
		echo "<tr$tr>";
		foreach($array as $fld=>$value)
			{
			if(in_array($fld,$exclude)){continue;}
			if($fld=="id")
				{
				$parkcode=$ARRAY_prev[$index]['parkcode'];
				$subunit=$ARRAY_prev[$index]['id_inspect'];
				echo "<td><a href='/inspect/park_entry.php?parkcode=$parkcode&subunit=$subunit' target='_blank'>$value</a></td>";
				continue;
				}
			if($fld=="incident"){$value="<b>$value</b>";}
			echo "<td valign='top' align='left'>$value</td>";
			}
		echo "</tr>";
		}
	echo "</table>";
echo "</div>";
?>