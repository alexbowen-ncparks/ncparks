<?php
date_default_timezone_set('America/New_York');
$current_year=date("Y");

$name_unit_type=array("SL"=>"State Lake","SNA"=>"State Natural Area","SP"=>"State Park","SR"=>"State River","SRA"=>"State Recreation Area","ST"=>"State Trail");

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

// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;

$sql="SELECT distinct unit_code
from acreage 
where 1 order by unit_code
";
$result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$temp_unit_code[]=$row['unit_code'];
	}
	

$skip_these=array("ARCH","EADI","NCBL","NCMA","NODI","SODI","WARE","WEDI","WOED","YORK","SCRI");
$temp_missing_unit=array();
$sql="SELECT distinct t1.parkcode, t1.add1 as park_name
from dprunit_district as t1
where 1 
";
$result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	IF(in_array($row['parkcode'], $skip_these)){continue;}
	IF(in_array($row['parkcode'], $temp_unit_code)){continue;}
	$temp_missing_unit[$row['park_name']]=$row['parkcode'];
	}
// echo "<pre>"; print_r($temp_missing_unit); echo "</pre>";

if(!empty($temp_missing_unit))
	{
	echo "There is no record for these units in the acreage table.<table>"; 
	foreach($temp_missing_unit as $index=>$value)
		{
		echo "<tr><td>$index</td><td>$value</tr>";
		}
	echo "</table>";
	exit;
	}
	
if(empty($year))
	{
	$year=date("Y");
// 	$year=2020;
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

$total_class_0=0;
$total_class_1=0;
$total_class_2=0;
$total_class_3=0;
$total_class_4=0;

$total_class_water=0;

$grand_total_0=0;
$grand_total_1=0;
$grand_total_2=0;
$grand_total_3=0;
$grand_total_4=0;

$grand_total_land=0;
$grand_total_water=0;
$grand_total_land_acres=0;
 
$total_land_units=0;
$total_water_units=0;

$land_unit_array=array("SP","SRA","SNA","SR","ST");
$water_unit_array=array("SL");

$unit_type="SP";
include("system_sp.php");

$unit_type="SRA";
include("system_sp.php");

$unit_type="SNA";
include("system_sp.php");
$var_land=$total_land_units;

$unit_type="SL";
include("system_sp.php");
$var_water=$total_water_units;

echo "<tr bgcolor='#ffffb3'><td></td>
<td align='right'><b>".number_format($total_class_0,0)."</b></td>
<td align='right'><b>".number_format($total_class_1,0)."</b></td>
<td align='right'><b>".number_format($total_class_2,0)."</b></td>
<td align='right'><b>".number_format($total_class_3,0)."</b></td>
<td align='right'><b>".number_format($total_class_4,0)."</b></td>
</tr>";
$total_class_0=0; //units
$total_class_1=0; // fee simple
$total_class_2=0; // con. easement
$total_class_3=0; // total acres
$total_class_4=0; // total miles

$total_land_units=0;

$unit_type="SR";
include("system_sp.php");

$unit_type="ST";
include("system_sp.php");
$var_land+=$total_land_units;

echo "<tr style='background-color:#ffffb3'><td></td>
<td align='right'><b>".number_format($total_class_0,0)."</b></td>
<td align='right'><b>".number_format($total_class_1,0)."</b></td>
<td align='right'><b>".number_format($total_class_2,0)."</b></td>
<td align='right'><b>".number_format($total_class_3,0)."</b></td>
<td align='right'><b>".number_format($total_class_4,0)."</b></td>
</tr>";

echo "<tr bgcolor='#cccc00'><td align='right'>Grand Total</td>
<td align='right'><b>".number_format($grand_total_0,0)."</b></td>
<td align='right'><b>".number_format($grand_total_1,0)."</b></td>
<td align='right'><b>".number_format($grand_total_2,0)."</b></td>
<td align='right'><b>".number_format($grand_total_3,0)."</b></td>
<td align='right'><b>".number_format($grand_total_4,0)."</b></td>
</tr>";


echo "<tr style='background-color:#e6ccff'><td><b>Break out Land v. Water</b></td>
<td></td><td></td><td></td><td></td><td></td>
</tr>";

$grand_total_land_acres=$grand_total_land+$grand_total_2;
echo "<tr style='background-color:#ccccff'>
<td>Land Area (SP, SRA, SNA,SR, ST)</td>
<td align='right'><b>".number_format($var_land,0)."</b></td>
<td align='right'><b>".number_format($grand_total_land,0)."</b></td>
<td align='right'><b>".number_format($grand_total_2,0)."</b></td>
<td align='right'><b>".number_format($grand_total_land_acres,0)."</b></td>
<td></td>
</tr>";
echo "<tr style='background-color:#ccccff'><td>Water Area (State Lakes)</td>
<td align='right'><b>".number_format($var_water,0)."</b></td>
<td align='right'><b>".number_format($grand_total_water,0)."</b></td>
<td></td>
<td align='right'><b>".number_format($grand_total_water,0)."</b></td>
<td></td>
</tr>";


echo "</table></form></html>";