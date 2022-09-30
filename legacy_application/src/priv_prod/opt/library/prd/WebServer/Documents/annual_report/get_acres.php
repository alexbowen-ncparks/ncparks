<?php
ini_set('display_errors',1);
session_start();
$level=$_SESSION['annual_report']['level'];
if($level<2){@$park_code=$_SESSION['annual_report']['select'];}

$database="dpr_system";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database,); // database 

extract($_REQUEST);

$year1="20".substr($f_year,0,2);
$year2="20".substr($f_year,-2);

$y1="20".substr($f_year,0,2)."-07-01";
$y2="20".substr($f_year,-2)."-07-00";


$sql="SELECT *
FROM `dpr_acres` 
where parkcode='$park_code'";
//echo "$f_year $y1 $y2 $sql";
	
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_1[]=$row;
	}

//echo "<pre>";print_r($ARRAY_1);echo "</pre>";


echo "<table cellpadding='10'><tr><td>Copy the <b>acreage</b> info, close this window, and paste into appropriate section.</td></tr></table>";


echo "<table>";


$text="Acreage based on the July 2011 \"Land Acreage Report\".";

echo "<table cellpadding='5'><tr><td colspan='3'>$text</td></tr>";
foreach($ARRAY_1 as $index=>$array)
	{
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if($fld=="id"){continue;}
		if(!isset($value)){$value="blank";}
		echo "<td align='right' valign='top'>$fld<br />$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";

?>