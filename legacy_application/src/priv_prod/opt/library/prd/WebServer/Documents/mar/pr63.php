<?php
$war_db="le";
$db = mysqli_select_db($connection,$war_db)       or die ("Couldn't select database");

unset($ARRAY_prev);
$sql="SELECT t4.district, t1.id,t1.ci_num, t1.parkcode, concat(t1.incident_code,'-',t1.incident_name) as incident, t1.loc_name,t1.date_occur, t2.disposition_desc, t1.pasu_approve, t1.dist_approve, t1.le_approve
FROM pr63 as t1
LEFT JOIN disposition as t2 on t1.disposition=t2.disposition_code
LEFT JOIN dpr_system.parkcode_names as t4 on t1.parkcode=t4.park_code
where date_occur >= '$last_week' and date_occur <= '$today'
order by t4.district, t1.parkcode,t1.incident_code"; //echo $sql;
$result = @MYSQLI_QUERY($connection,$sql) or die(mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_prev[]=$row;
	}
$c_prev=count($ARRAY_prev);


$exclude=array("id","enterBy","dist","dateToday");


echo "<div id='pr63_prev' style='display: none'>";
	echo "<table border='1' cellpadding='3'><tr><th colspan='9'>$c_prev PR-63s in the previous 7 days</th></tr>";
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
			if($fld=="ci_num")
				{
				$value=$ARRAY_prev[$index]['id'];
				echo "<td><a href='https://10.35.152.9/le/pr63_form.php?id=$value' target='_blank'>$value</a></td>";
				echo "<td><a href='https://10.35.152.9/le/pr63_form.php?id=$value' target='_blank'>$value</a></td>";
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