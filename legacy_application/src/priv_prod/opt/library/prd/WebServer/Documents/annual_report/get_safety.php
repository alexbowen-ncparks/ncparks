<?php
ini_set('display_errors',1);
session_start();
$level=$_SESSION['annual_report']['level'];
if($level<2){@$park_code=$_SESSION['annual_report']['select'];}

$database="inspect";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database 

extract($_REQUEST);

$year1="20".substr($f_year,0,2);
$year2="20".substr($f_year,-2);

$y1="20".substr($f_year,0,2)."-07-01";
$y2="20".substr($f_year,-2)."-07-00";


$sql="SELECT id_inspect, count(id) as num  FROM `document` 

WHERE `parkcode` = '$park_code' and date_inspect > '$y1' and date_inspect < '$y2'

and id_inspect != 'Pick an inspection from the list above.'
group by id_inspect";
//echo "$f_year $y1 $y2 $sql";
	
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_1[]=$row;
	}
if(empty($ARRAY_1)){$ARRAY_1[]=array(0=>"none");}
//echo "<pre>";print_r($ARRAY_1);echo "</pre>";


$lead_for="SO";
include("lead_ranger.php");

echo "<table cellpadding='10'><tr><td>Copy the <b>Safety Program</b> info, close this window, and paste into appropriate section.</td></tr></table>";

if(empty($lead_ranger))
	{
	echo "<table><tr><td>No Lead Ranger has been assigned as the park's Lead for Safety Program in the database.</td></tr></table>";
	}
	else
	{
	echo "<table><tr><td>$lead_ranger is the park's Lead for Safety Program.</td></tr></table>";
	}


$text="$park_code Safety Inspection totals for July 1, $year1 through June 30, $year2:";

echo "<table border='1'><tr><td colspan='3'>$text</td></tr>";
foreach($ARRAY_1 as $index=>$array)
	{
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(!isset($value)){$value="blank";}
		echo "<td align='right'>$value</td>";
		}
		
	echo "</tr>";
	}
echo "</table>";


?>