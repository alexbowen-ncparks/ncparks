<?php

	
// Get total system acres
$ARRAY=array();
if(!empty($unit_type))
	{
	$var_and="and unit_type='$unit_type'";
	}
$sql="SELECT concat(unit_code,unit_type) as unit_con, unit, unit_code, year,concat(year, lpad(month,2,'0'), lpad(day,2,'0')) as max, $sum_fld
from acreage 
where 1 and year='$year' 
$var_and
group by unit_con,  max
ORDER BY FIELD(unit_type,'SP','SRA','SNA','SL','SR','ST'), unit, concat(year, lpad(month,2,'0'), lpad(day,2,'0')) desc
";
// echo "$sql<br /><br />";
$result = @mysqli_QUERY($connection,$sql) or die(mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[$row['unit']][][$row['max']]=array($row['var_acres'], $row['con_var_acres'], $row['var_system_acres'], $row['var_length_miles']);
	}
$num_rows=count($ARRAY);
// echo "<pre>"; print_r($ARRAY); echo "</pre>";  //exit;

$new_ARRAY_fee_acres=array();
$new_ARRAY_conservation_acres=array();
$new_ARRAY_system_acres=array();
$new_ARRAY_system_miles=array();

$new_ARRAY_fee_acres_land=array();
$new_ARRAY_fee_acres_water=array();
$new_ARRAY_land_unit_acres=array();

foreach($ARRAY AS $unit=>$array)
	{
	foreach($array[0] as $date=>$array1)
		{
		$new_ARRAY_fee_acres[$unit]=$array1[0];
		// necessary since fee simple for a SL is 0 to avoid double counting of SP/SNA and SL
		if($unit_type=="SL")
			{
			$total_water_units++;
			$new_ARRAY_fee_acres[$unit]=$array1[2];
			$new_ARRAY_fee_acres_water[$unit]=$array1[2];
			}
// 		$land_unit_array=array("SP","SRA","SNA","SR","ST");
		if(in_array($unit_type, $land_unit_array))
			{
			$total_land_units++;
			$new_ARRAY_fee_acres_land[$unit]=$array1[0];
// 			$new_ARRAY_land_unit_acres[$unit]=$array1[0];
			}
		
// 		if($unit_type!="SR" and $unit_type!="ST")
// 			{
// 			}
		
		$new_ARRAY_conservation_acres[$unit]=$array1[1];
		$new_ARRAY_system_acres[$unit]=$array1[2];
		$new_ARRAY_system_miles[$unit]=$array1[3];
		}
	}
// echo "<pre>"; print_r($new_ARRAY_system_acres); echo "</pre>";  exit;

// $land_unit_array=array("SP","SRA","SNA","SR","ST");
// $water_unit_array=array("SL");

$skip=array();
echo "<form action=\"acreage.php\" method=\"post\" id=\"form1\">
</form>";



$total_class_0+=$num_rows;
$grand_total_0+=$num_rows;

// $total_class_water+=$num_rows;
$grand_total_land+=array_sum($new_ARRAY_fee_acres_land);
$grand_total_water+=array_sum($new_ARRAY_fee_acres_water);
// $grand_total_land_acres+=array_sum($new_ARRAY_land_unit_acres);

$total_class_1+=array_sum($new_ARRAY_fee_acres);
$grand_total_1+=array_sum($new_ARRAY_fee_acres);

$total_class_2+=array_sum($new_ARRAY_conservation_acres);
$grand_total_2+=array_sum($new_ARRAY_conservation_acres);

$total_class_3+=array_sum($new_ARRAY_system_acres);
$grand_total_3+=array_sum($new_ARRAY_system_acres);

$total_class_4+=array_sum($new_ARRAY_system_miles);
$grand_total_4+=array_sum($new_ARRAY_system_miles);

$sum_fee_acres=number_format(array_sum($new_ARRAY_fee_acres),3);
$sum_conservation_acres=number_format(array_sum($new_ARRAY_conservation_acres),3);
$sum_system_acres=number_format(array_sum($new_ARRAY_system_acres),3);
$sum_system_miles=number_format(array_sum($new_ARRAY_system_miles),3);

echo "<form action=\"acreage.php\" method=\"post\" id=\"form1\">
</form>";

if($unit_type=="SP")
	{
echo "<form method='post'><table id='acreage'><tr>
<td>Year: <select name='year' onchange=\"this.form.submit()\";>";
foreach($temp_years as $k=>$v)
	{
	if($year==$v){$s="selected";}else{$s="";}
	echo "<option value='$v' $s>$v</option>\n";
	}
echo "</select></td>";
echo "<td colspan='4'>&nbsp;&nbsp;&nbsp;<button style='color: green; font-size: 16px;' type='submit' form='form1' value='Submit'>System Table</button></td></tr>";

	echo "<tr><td></td>
	<th>Units</th>
	<th>Total Fee Simple</th>
	<th>Total Conservation Easement</th>
	<th>Total System Acres</th>
	<th>Total System Miles</th>
	</tr>
	";
	}
	
$unit_type_name=$name_unit_type[$unit_type]."s";
echo "<tr><td>$unit_type_name</td>
<td align='right'>$num_rows</td>
<td>$sum_fee_acres</td>
<td> $sum_conservation_acres</td>
<td> $sum_system_acres</td>
<td> $sum_system_miles</td>
</tr>";

echo "</form></html>";