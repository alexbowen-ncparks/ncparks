<?php
$war_db="dprcal";
$db = mysqli_select_db($connection,$war_db)       or die ("Couldn't select database");

unset($ARRAY_next);
$sql="SELECT t1.tid, t4.district, t1.park, t1.title, t1.dateFind, t1.activity
FROM train as t1
LEFT JOIN dpr_system.parkcode_names as t4 on t1.park=t4.park_code
where dateFind >= '$today' and dateFind <= '$next_35'
order by t4.district, t1.park, t1.dateFind desc"; //echo $sql;
$result = @MYSQLI_QUERY($connection,$sql) or die(mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_next[]=$row;
	}
if(count(@$ARRAY_next)<1)
	{
	$ARRAY_next=array();
	$c_next=0;
	}
	else
	{$c_next=count($ARRAY_next);}


$exclude=array("enterBy","dist","dateToday");

if($level<4){$exclude[]="tid";}

echo "<div id='train' style='display: none'>";
	echo "<table border='1' cellpadding='3'><tr><th colspan='7'>$c_next Classes in the next 35 days</th></tr>";
	foreach($ARRAY_next AS $index=>$array)
		{
		if($index==0)
			{
			echo "<tr>";
			if(!in_array("tid",$exclude))
				{echo "<td>View</td>";}
			
			foreach($ARRAY_next[0] AS $fld=>$value)
				{
				if(in_array($fld,$exclude)){continue;}
				echo "<th>$fld</th>";
				}
			echo "</tr>";
			}
		if(fmod($index,2)==0){$tr=" bgcolor='aliceblue'";}else{$tr="";}
		echo "<tr$tr>";
		foreach($array as $fld=>$value)
			{
			if(in_array($fld,$exclude)){continue;}
			if($fld=="tid"){echo "<td><a href='/dprcal/trainDetail.php?tid=$value' target='_blank'>$value</a></td>";}
			if($fld=="title"){$value="<b>$value</b>";}
			echo "<td valign='top' align='left'>$value</td>";
			}
		echo "</tr>";
		}
	echo "</table>";
echo "</div>";

?>