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
	{echo "You must first login to the Division Personnel/Park Info <a href='/divper/'>database</a>.<br /><br />Select the Land Acreage option under the \"Contact Info\" pull-down.";}
	{echo "You must first login to the Division Personnel/Park Info <a href='/divper/'>database</a>.<br /><br />Select the Land Acreage option under the \"Contact Info\" pull-down.";}

$database="dpr_system";
include("../../include/iConnect.inc"); // database connection parameters

mysqli_select_db($connection,$database);
include("menu.php");

// echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
if(empty($year))
	{
	$year=date("Y");
	}
// get years
$sql="SELECT distinct year as var_year
from acreage 
where 1 
";
$result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$temp_years[]=$row['var_year'];
	}
$temp_years=array_reverse($temp_years);


	$var_fld="fee_simple_acres";
	$sum_fld="sum(fee_simple_acres) as var_acres";
	$sum_fld.=", sum(system_area_acres) as var_system_acres";
	
// Get total system acres
$sql="SELECT unit, unit_code, year, concat(year, lpad(month,2,'0'), lpad(day,2,'0')) as max, $sum_fld
from acreage 
where 1 and year='$year'
group by unit_code,  max
order by unit, concat(year, lpad(month,2,'0'), lpad(day,2,'0')) desc
";
$result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[$row['unit']][][$row['max']]=array($row['var_acres'],$row['var_system_acres']);
	}
// echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

foreach($ARRAY AS $unit=>$array)
	{
	foreach($array[0] as $date=>$array1)
		{
		$new_ARRAY_fee_acres[$unit]=$array1[0];
		$new_ARRAY_system_acres[$unit]=$array1[1];
		
		}
	}
// echo "<pre>"; print_r($new_ARRAY_system_acres); echo "</pre>";  exit;
$skip=array();
echo "<form action=\"acreage.php\" method=\"post\" id=\"form1\">
</form>";

$c=count($ARRAY);
$sum_fee_acres=number_format(array_sum($new_ARRAY_fee_acres),3);
$sum_system_acres=number_format(array_sum($new_ARRAY_system_acres),3);
echo "<form><table id='acreage'><tr><td colspan='2'>$c Units
<select name='year' onchange=\"this.form.submit()\";>";
foreach($temp_years as $k=>$v)
	{
	if($year==$v){$s="selected";}else{$s="";}
	echo "<option value='$v' $s>$v</option>\n";
	}
echo "</select>&nbsp;&nbsp;&nbsp;<button style='color: magenta; font-size: 16px;' type='submit' form='form1' value='Submit'>RESET</button>
</td>
<td>Total Fee Simple: $sum_fee_acres</td><td>Total System: $sum_system_acres</td></tr>";
echo "<tr><td></td><td>Date</td><td>Fee simpe acres</td><td>System Acres</td></tr>";
foreach($ARRAY AS $unit=>$array)
	{
	echo "<tr><td>$unit</td>";
	foreach($array[0] as $date=>$acreage)
		{
		$acre0=$acreage[0];
		$acre1=$acreage[1];
		if($acre0!=$acre1){$f1="<font color='green'>";$f2="</font>";}else{$f1=""; $f2="";}
		if(strpos($acre0, ".")>-1)
			{$acre0=number_format($acre0,3);}
			else
			{$acre0=number_format($acre0,0);}
		if(strpos($acre1, ".")>-1)
			{$acre1=number_format($acre1,3);}
			else
			{$acre1=number_format($acre1,0);}
		echo "<td>$date</td><td>$acre0</td><td>$f1$acre1$f2</td>";
		}
	echo "</tr>";
	}
echo "</table></form></html>";