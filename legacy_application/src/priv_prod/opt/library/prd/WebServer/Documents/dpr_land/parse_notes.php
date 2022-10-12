<?php
ini_set('display_errors',1);
$database="dpr_land";
include("../../include/auth.inc");

include("../../include/iConnect.inc");

mysqli_select_db($connection,$database);

include("../_base_top.php");

$sql="SELECT * from land_notes where land_asset_ID='1891'";
$result=mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
	
$skip=array();
$c=count($ARRAY);
echo "<table><tr><td>$c</td></tr>";
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
		
	if($fld=="Notes")
		{
		if($array['Notes']!="")
			{
			$track_id=$array['land_asset_ID'];
			}
			else
			{
			continue;
			$id=$array['id'];
			// $sql="UPDATE  land_notes 
// 	 		set `land_asset_ID`='$track_id' where `id`='$id'
// 			";
// 	 		$result=mysqli_query($connection,$sql);
			//$value=$track_id;
			}
			$value=str_replace("|","<br />",$value);
		}
	
// 	if($fld=="Notes")
// 		{
// 		$value=str_replace("|","<br />",$value);
// 		}	
		
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";
?>