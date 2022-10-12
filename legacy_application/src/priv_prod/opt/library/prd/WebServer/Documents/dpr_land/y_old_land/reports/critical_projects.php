<?php
ini_set('display_errors',1);
$database="dpr_land";
include("../../../include/auth.inc");
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
include("../../../include/iConnect.inc");

mysqli_select_db($connection,$database);

include("../.././/_base_top.php");
echo "<style>
.head {
font-size: 22px;
color: #999900;
}
table.alternate {
    border: 1px solid #8e8e6e; 
	margin: 5px 5px 5px 5px;
	background-color:#eeeedd;
	border-collapse:collapse;
  color: black;
}

.count
{
text-align: center;
-webkit-column-span: all; /* Chrome, Safari, Opera */
    column-span: all;
}

.th {
    border: 1px solid black; 
    	padding: 4px;
}
.td {
    border: 1px solid black; 
    	padding: 4px;
}
table.alternate tr:nth-child(odd) td{
background-color: #ddddbb;
}
table.alternate tr:nth-child(even) td{
background-color: #eeeedd;
}
</style>";

$sql="SELECT t1.land_assets_id, concat(t3.park_abbreviation,'-',t1.county_id,'-',t1.land_assets_id) as 'File Number', t2.county_name, t1.common_name, t1.spo_working_file_number, t1.estimated_purchase_price, t1.acreage, t1.critical, t3.park_abbreviation
from land_assets as t1 
left join county_name as t2 on t1.county_id=t2.county_id 
left join park_name as t3 on t1.park_id=t3.park_id 
WHERE t1.critical='1'
order by concat(t3.park_abbreviation,'-',t1.county_id,'-',t1.land_assets_id)
";
// echo "$sql";
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	foreach($row as $k=>$v)
		{
		if($k=="estimated_purchase_price" and $v<1){continue;}
		$park_cost_array[$row['park_abbreviation']][$row['land_assets_id']]=$row['estimated_purchase_price'];
		$park_acres_array[$row['park_abbreviation']][$row['land_assets_id']]=$row['acreage'];
		}
	}
//  echo "<pre>"; print_r($park_cost); echo "</pre>"; // exit;
// $test=array_sum($park_cost_array['BULA']);  echo "t=$test";
echo "<div>";
$skip=array("land_assets_id","park_abbreviation");
$c=count($ARRAY);
echo "<table class='alternate'><tr><td class='count'>$c records</td></tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			$var_header[]="<th class='th'>$fld</th>";
			}
		$header_str=implode("",$var_header);
		echo "$header_str</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		$park_code=$array['park_abbreviation'];
		$park_cost_tot=array_sum($park_cost_array[$park_code]);
		$park_acres_tot=array_sum($park_acres_array[$park_code]);
		if($fld=="File Number")
			{
		$link="/dpr_land/view_form.php?select_table=land_assets&land_assets_id=".$array['land_assets_id'];
			$value="<a href='$link'>$value</a>";
			}
		if($fld=="estimated_purchase_price" and $value>0)
			{
			$value=number_format($value,2);
			}
		if($fld=="acreage" and $value>0)
			{
			$value=number_format($value,4);
			}
			
		echo "<td class='td'>$value</td>";
		}
		$count_park=0;
		if($park_code!=@$ARRAY[$index+1]['park_abbreviation'])
			{
			$count_park=count($park_acres_array[$park_code]);
			@$gtp+=$park_cost_tot;
			@$gta+=$park_acres_tot;
			$cost_val="$".number_format($park_cost_tot, 2);
			$acres_val=number_format($park_acres_tot,3);
			echo "</tr><tr><td colspan='5' align='right'><strong>$park_code $cost_val</strong></td>
			<td align='center' colspan='2'><strong>$acres_val</strong> acres</td></tr>";
			if((fmod($index,20)==0 and $index>0) or $count_park>20)
				{
				echo "<tr>$header_str</tr>";
				}
			}
	
	echo "</tr>";
	}

$grand_total_price="$".number_format($gtp, 2);
$grand_total_acres=number_format($gta, 2);
echo "<tr><td colspan='5' align='right'><strong>Grand Total: $grand_total_price</strong></td>
<td colspan='2' align='center'><strong>Grand Total Acres: $grand_total_acres</strong></td></tr>";
echo "</table>";
echo "</div>";
?>