<?php
if($level<3)
	{
	if($level==2)
		{}
	if($level==1)
		{
		if(!empty($_SESSION['fixed_assets']['accessPark']))
			{
			$multi_park=explode(",",$_SESSION['fixed_assets']['accessPark']);
			echo "<pre>"; print_r($multi_park); echo "</pre>"; // exit;
			}
		}
	}
// called from surplus_equip_form.php   line ~72
$skip=array("id","source","ts","fn_unique","pasu_name","disu_name","chop_date","chop_name");
$c=count($ARRAY);

echo "<table cellpadding='5'><tr><td colspan='8'>$c items in the process of being surplused</td></tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld, $skip)){continue;}
			echo "<th>$fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld, $skip)){continue;}
		if($fld=="location")
			{
			
			$value="<a href='mailto:$email?subject=Interested in Surplus Item&body=$body'>view</a> $value";
			}
			
		if($fld=="photo_upload" and !empty($value))
			{$value="<a href='$value' target='_blank'>view</a>";}
			
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";
 
 ?>