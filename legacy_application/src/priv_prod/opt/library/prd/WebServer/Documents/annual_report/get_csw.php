<?php
ini_set('display_errors',1);
session_start();
$level=$_SESSION['annual_report']['level'];
if($level<2){@$park_code=$_SESSION['annual_report']['select'];}

$database="park_use";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database 

extract($_REQUEST);

$year1="20".substr($f_year,0,2);
$year2="20".substr($f_year,-2);

$y1="20".substr($f_year,0,2)."0701";
$y2="20".substr($f_year,-2)."0630";


$sql="SELECT sum(csw_number) as csw_number, sum(csw_hours) as csw_hours
from stats
where `year_month_week`>='$y1' and `year_month_week`<='$y2'
and park='$park_code'";
//echo "$f_year $y1 $y2 $sql";

if($f_year>1200)
	{
	$sql="SELECT sum(csw_number) as csw_number, sum(csw_hours) as csw_hours
	from stats_day
	where `year_month_day`>='$y1' and `year_month_day`<='$y2'
	and park like '$park_code%'";
	}
echo "$sql";
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_1[]=$row;
	}

$rename=array("csw_number"=>"Number of offenders: ","csw_hours"=>"Hours worked: ");

echo "<table cellpadding='10'><tr><td>Copy the <b>Community Service Workers</b> info, close this window, and paste into appropriate section.</td></tr></table>";

echo "<table><tr><td>Community Service Worker totals for July 1, $year1 through June 30, $year2:</td></tr>";
foreach($ARRAY_1 as $index=>$array)
	{
	foreach($array as $fld=>$value)
		{
		if(!isset($value)){$value="blank";}
		@$total+=$value;
		@$value=number_format($value,0);
		$fld=$rename[$fld];
		echo "<tr><td>$fld $value</td></tr>";
		}
	}
echo "</table>";
