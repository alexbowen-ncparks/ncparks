<?php

// file added th_20220226

include("menu.php");

$file=$_SERVER['PHP_SELF'];

include("../../include/iConnect.inc");
include("../../include/get_parkcodes_dist.php");
mysqli_select_db($connection,'fire');

$sql="SELECT t1.*, t2.unit_name, t2.acres
from after_action as t1
left join units as t2 on t1.unit_id=t2.unit_id
where 1 order by t1.park_code";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query. $sql ".mysqli_error($connection));
if(mysqli_num_rows($result)>0)
	{
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	}
// echo "<pre>"; print_r($ARRAY); echo "</pre>";
$skip=array();
$c=count($ARRAY);
echo "<table cellpadding ='5'><tr><td>$c</td></tr>";
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
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if($fld=="unit_id" and $level>3)
			{
			$value="<a href='units.php?unit_id=$value' target='_blank'>Edit Unit</a>";
			}
		if($fld=="action_review_link")
			{
			$value="<a href='$value' target='_blank'>Link</a>";
			}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";
?>