<?php
date_default_timezone_set('America/New_York');
$current_year=date("Y");

ini_set('display_errors',1);
if(empty($_SESSION))
	{
	session_start();
	$level=$_SESSION['system_plan']['level'];
	}
	
if($_SESSION['system_plan']['level']<1)
	{echo "You must first login to the Division Personnel/Park Info <a href='https://10.35.152.9/divper/'>database</a>.<br /><br />Select the Land Acreage option under the \"Contact Info\" pull-down.";}
	{echo "You must first login to the Division Personnel/Park Info <a href='https://10.35.152.9/divper/'>database</a>.<br /><br />Select the Land Acreage option under the \"Contact Info\" pull-down.";}

$database="dpr_system";
include("../../include/iConnect.inc"); // database connection parameters

mysqli_select_db($connection,$database);
include("menu.php");

echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;

if(empty($year))
	{
	$year=date("Y");
	}
// get years
$sql="SELECT distinct year
from acreage 
where 1 
";
$result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$temp_years[]=$row['year'];
	}
$temp_years=array_reverse($temp_years);

$sql="SELECT distinct unit_type
from acreage 
where 1 
";
$result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$temp_unit_type[]=$row['unit_type'];
	}

	$var_fld="fee_simple_acres";
	$sum_fld="sum(fee_simple_acres) as var_acres";
	$sum_fld.=", sum(conservation_easement_acres) as con_var_acres";
	$sum_fld.=", sum(system_area_acres) as var_system_acres";
	$sum_fld.=", sum(system_length_miles) as var_length_miles";
	
// Get total system acres
$var_and="";
if(!empty($unit_type))
	{
	$var_and="and unit_type='$unit_type'";
	}
$sql="SELECT unit, unit_code, year,concat(year, lpad(month,2,'0'), lpad(day,2,'0')) as max, $sum_fld
from acreage 
where 1 and year='$year' and month='01'  and day='01'
$var_and
group by unit_code,  max
ORDER BY FIELD(unit_type,'SP','SRA','SNA','SL','SR','ST'), unit, concat(year, lpad(month,2,'0'), lpad(day,2,'0')) desc
";
// echo "$sql";
$result = @mysqli_QUERY($connection,$sql) or die(mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[$row['unit']][][$row['max']]=array($row['var_acres'], $row['con_var_acres'], $row['var_system_acres'], $row['var_length_miles']);
	}
// echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

foreach($ARRAY AS $unit=>$array)
	{
	foreach($array[0] as $date=>$array1)
		{
		$new_ARRAY_fee_acres[$unit]=$array1[0];
		$new_ARRAY_conservation_acres[$unit]=$array1[1];
		$new_ARRAY_system_acres[$unit]=$array1[2];
		$new_ARRAY_system_miles[$unit]=$array1[3];
		}
	}
// echo "<pre>"; print_r($new_ARRAY_system_acres); echo "</pre>";  exit;
$skip=array();
echo "<form action=\"acreage.php\" method=\"post\" id=\"form1\">
</form>";

$c=count($ARRAY);
$sum_fee_acres=number_format(array_sum($new_ARRAY_fee_acres),3);
$sum_conservation_acres=number_format(array_sum($new_ARRAY_conservation_acres),3);
$sum_system_acres=number_format(array_sum($new_ARRAY_system_acres),3);
$sum_system_miles=number_format(array_sum($new_ARRAY_system_miles),3);

echo "<form method='post'><table id='acreage'><tr>
<td>$c Units
Year:<select name='year' onchange=\"this.form.submit()\";>";
foreach($temp_years as $k=>$v)
	{
	if($year==$v){$s="selected";}else{$s="";}
	echo "<option value='$v' $s>$v</option>\n";
	}
echo "</select></td>
<td>Unit Type: <select name='unit_type' onchange=\"this.form.submit()\";><option value=\"\" selected></option>\n";
foreach($temp_unit_type as $k=>$v)
	{
	if($unit_type==$v){$s="selected";}else{$s="";}
	echo "<option value='$v' $s>$v</option>\n";
	}
echo "</td>";
echo "<td><button style='color: magenta; font-size: 16px;' type='submit' form='form1' value='Submit'>RESET</button>
</td></tr>
<tr><td>Total Fee Simple: $sum_fee_acres</td><td>Total Conservation Easement: $sum_conservation_acres</td>
<td>Total System Acres: $sum_system_acres</td>
<td>Total System Miles: $sum_system_miles</td>
</tr>";

echo "</table></form></html>";