<?php
ini_set('display_errors',1);
session_start();
$level=$_SESSION['annual_report']['level'];
if($level<2){@$park_code=$_SESSION['annual_report']['select'];}

$database="fire";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database 

extract($_REQUEST);

$year1="20".substr($f_year,0,2);
$year2="20".substr($f_year,-2);

$y1="20".substr($f_year,0,2)."-07-01";
$y2="20".substr($f_year,-2)."-07-00";


$sql="SELECT date_, acres_burned
FROM `burn_history` 
where park_code='$park_code' and date_>='$y1' and date_<'$y2'
order by date_";
//echo "$f_year $y1 $y2 $sql";
	
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_1[]=$row;
	}

//echo "<pre>";print_r($ARRAY_1);echo "</pre>";


$lead_for="NR";
include("lead_ranger.php");

echo "<table cellpadding='10'><tr><td>Copy the <b>Natural Resources</b> info, close this window, and paste into appropriate section.</td></tr></table>";

if(empty($lead_ranger))
	{
	$lead_ranger="No one has been assigned as";
	}
	else
	{
	$lead_ranger.=" is ";
	}


echo "<table><tr><td>$lead_ranger the park's Lead for Natural Resources Program.</td></tr>";

if(empty($ARRAY_1))
	{
	echo "<tr><td>No <b>burn acreage</b> was entered into the Fire Managment database for the period July 1, $year1 through June 30, $year2.</td></tr></table>";
	exit;}

$text="Burn History totals for July 1, $year1 through June 30, $year2:";

echo "<table><tr><td colspan='3'>$text</td></tr>";
foreach($ARRAY_1 as $index=>$array)
	{
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(!isset($value)){$value="blank";}
		if($fld=="acres_burned")
			{@$total+=$value;}
		echo "<td align='right'>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";

echo "<table>";
echo "<tr><td>Total Acres Burned: $total</td></tr>";


echo "</table>";

?>