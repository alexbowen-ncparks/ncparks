<?php
$war_db="dprcoe";
$db = mysqli_select_db($connection,$war_db)       or die ("Couldn't select database");

$sql="SELECT * 
FROM event 
where dateE >= '$last_week' and dateE <= '$today'
order by dateE, park"; //echo $sql;
$result = @MYSQLI_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_prev[]=$row;
	}
$c_prev=count($ARRAY_prev);

$sql="SELECT * 
FROM event 
where dateE >= '$today' and dateE <= '$next_week'
order by dateE, park"; //echo $sql;
$result = @MYSQLI_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_next[]=$row;
	}
$c_next=count($ARRAY_next);

$exclude=array("eid","enterBy","dist","dateToday");

if($level<6){$exclude[]="eid";}

echo "<table><tr><td>Calendar of Events: ";

// Last Week
echo "<a onclick=\"toggleDisplay('coe_prev');\" href=\"javascript:void('')\">Toggle Previous 7 Days</a>";
echo "<div id='coe_prev' style='display: none'>";
	echo "<table border='1'><tr><th colspan='3'>$c_prev Events</th></tr>";
	foreach($ARRAY_prev AS $index=>$array)
		{
		if($index==0)
			{
			echo "<tr>";
			if(!in_array("eid",$exclude))
				{echo "<td>Edit</td>";}
			
			foreach($ARRAY_prev[0] AS $fld=>$value)
				{
				if(in_array($fld,$exclude)){continue;}
				echo "<th>$fld</th>";
				}
			echo "</tr>";
			}
		echo "<tr>";
		foreach($array as $fld=>$value)
			{
			if(in_array($fld,$exclude)){continue;}
			if($fld=="eid"){echo "<td><a href='reference.php?edit=$value'>$value</a></td>";}
			if($fld=="title"){$value="<b>$value</b>";}
			echo "<td valign='top'>$value</td>";
			}
		echo "</tr>";
		}
	echo "</table>";
echo "</div>";
echo "</td>";

echo "<td>&nbsp;</td>";


echo "<td>";
// Next Week
echo "<a onclick=\"toggleDisplay('coe_next');\" href=\"javascript:void('')\">Toggle Next 7 Days</a>";
echo "<div id='coe_next' style='display: none'>";
	echo "<table border='1'><tr><th colspan='3'>$c_prev Events</th></tr>";
	foreach($ARRAY_next AS $index=>$array)
		{
		if($index==0)
			{
			echo "<tr>";
			if(!in_array("eid",$exclude))
				{echo "<td>Edit</td>";}
			foreach($ARRAY_next[0] AS $fld=>$value)
				{
				if(in_array($fld,$exclude)){continue;}
				echo "<th>$fld</th>";
				}
			echo "</tr>";
			}
		echo "<tr>";
		foreach($array as $fld=>$value)
			{
			if($fld=="eid"){echo "<td><a href='reference.php?edit=$value'>$value</a></td>";}
			if(in_array($fld,$exclude)){continue;}
			echo "<td valign='top'>$value</td>";
			}
		echo "</tr>";
		}
	echo "</table>";
echo "</div>";

echo "</td></tr></table>";
?>