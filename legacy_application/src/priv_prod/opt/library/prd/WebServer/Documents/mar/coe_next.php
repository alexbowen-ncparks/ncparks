<?php
$war_db="dprcoe";
$db = mysqli_select_db($connection,$war_db)       or die ("Couldn't select database");

$sql="SELECT t1.eid as id, t4.district, t1.park, t1.title, t1.dateE, concat(left(t1.content,100),'....') as description, t1.ann_100
FROM event as t1
LEFT JOIN dpr_system.parkcode_names as t4 on t1.park=t4.park_code
where dateE >= '$today' and dateE <= '$next_week'
order by district, park, dateE desc"; //echo $sql;
$result = @MYSQLI_QUERY($connection,$sql) or die(mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_next[]=$row;
	}
$c_next=count($ARRAY_next);

$exclude=array("enterBy","dist","dateToday");

echo "<div id='coe_next' style='display: none'>";
	echo "<table border='1' cellpadding='3'><tr><th colspan='7'>$c_next Events in the next 7 days</th></tr>";
	foreach($ARRAY_next AS $index=>$array)
		{
		if($index==0)
			{
			echo "<tr>";
			foreach($ARRAY_next[0] AS $fld=>$value)
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
				echo "<td><a href='/dprcoe/edit.php?eid=$value' target='_blank'>$value</a></td>";
				continue;
				}
			if($fld=="title"){$value="<b>$value</b>";}
			echo "<td valign='top' align='left'>$value</td>";
			}
		echo "</tr>";
		}
	echo "</table>";
echo "</div>";

?>