<?php
// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;

include("menu.php");  // includes connection and db select

include("../../include/iConnect.inc");
mysqli_select_db($connection, "photo_point");

$table="photo_point";
$file=$_SERVER['PHP_SELF'];

$skip=array("submit");
if(!EMPTY($_POST['submit']))
	{
	$clause="where ";
	foreach($_POST AS $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if(!empty($value))
			{
			if($fld=="pp_name")
				{
				$exp=explode("_",$value);
				$value=$exp[1];
				if(empty($_POST['park_code']))
					{
					$clause.="park_code='".$exp[0
					]."' and ";
					}
				}
			if($fld=="burn_unit")
				{
				$exp=explode("_",$value);
				$value=$exp[1];
				if(empty($_POST['park_code']))
					{
					$clause.="park_code='".$exp[0]."' and burn_unit='".$exp[1]."'";
					}
				continue;
				}
			$clause.=$fld."='".$value."' and ";
			}
		}
	$clause=rtrim($clause," and ");
	$sql="SELECT * 
	from photo_point 
	$clause
	";
// 	echo "$sql";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. $sql ".mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;	
		}
	}
//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

echo "<div align='center'>";

$c=count($ARRAY);
echo "<table border='1' cellpadding='3'><tr><td colspan='14'>$c Photo Points for $clause</td></tr>";
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
		if($fld=="unit_id"){$value="<a href='pp_units.php?unit_id=$value' target='_blank'>[ $value ]</a>";}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";
echo "</div></body></html>";
?>