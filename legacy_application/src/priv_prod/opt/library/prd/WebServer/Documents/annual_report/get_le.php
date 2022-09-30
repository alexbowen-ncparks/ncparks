<?php
ini_set('display_errors',1);
session_start();
$level=$_SESSION['annual_report']['level'];
if($level<2){@$park_code=$_SESSION['annual_report']['select'];}

$database="le";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database 

extract($_REQUEST);

$year1="20".substr($f_year,0,2);
$year2="20".substr($f_year,-2);

$y1="20".substr($f_year,0,2)."-07-01";
$y2="20".substr($f_year,-2)."-07-00";


$sql="SELECT incident_code, incident_name
FROM `pr63` 
where parkcode='$park_code' and date_occur>='$y1' and date_occur<'$y2'
";
//echo "$f_year $y1 $y2 $sql";

$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$incident_array[$row['incident_code']]=$row['incident_name'];
	}
	
$sql="SELECT count(incident_code) as incidents, incident_code
FROM `pr63` 
where parkcode='$park_code' and date_occur>='$y1' and date_occur<'$y2'
group by parkcode,incident_code";
//echo "$f_year $y1 $y2 $sql";

$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_1[]=$row;
	}

//echo "<pre>";print_r($ARRAY_1);echo "</pre>";


$lead_for="LE";
include("lead_ranger.php");

echo "<table cellpadding='10'><tr><td>Copy the <b>Law Enforcement</b> info, close this window, and paste into appropriate section.</td></tr></table>";

if(empty($lead_ranger))
	{
	$lead_ranger="No one has been assigned as";
	}
	else
	{
	$lead_ranger.=" is ";
	}

echo "<table><tr><td>$lead_ranger the park's Lead for Law Enforcement Program.</td></tr>";


$text="PR-63 totals for July 1, $year1 through June 30, $year2:";

echo "<table><tr><td colspan='3'>$text</td></tr>";
foreach($ARRAY_1 as $index=>$array)
	{
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(!isset($value)){$value="blank";}
			if($fld=="incidents"){@$total+=$value;}
		echo "<td align='right'>$value</td>";
		if($fld=="incident_code")
			{
			$val=$incident_array[$value];
			echo "<td>$val</td>";
			}
		}
		
	echo "</tr>";
	}
echo "<tr><td colspan='3'>Total PR-63s: $total</td></tr>";
echo "</table>";

echo "<table>";
//echo "<tr><td>Total Programs: Outreach = $tot_out_num[Outreach] Park = $tot_out_num[Park]</td></tr>";
//echo "<tr><td>Total Attendance: Outreach = $tot_out_attend[Outreach] Park = $tot_out_attend[Park]</td></tr>";


echo "</table>";

?>