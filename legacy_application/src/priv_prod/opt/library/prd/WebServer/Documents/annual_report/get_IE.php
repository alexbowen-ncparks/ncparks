<?php
//ini_set('display_errors',1);
session_start();
$level=$_SESSION['annual_report']['level'];
if($level<2){@$park_code=$_SESSION['annual_report']['select'];}

$database="eeid";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database 

extract($_REQUEST);

$year1="20".substr($f_year,0,2);
$year2="20".substr($f_year,-2);

$y1="20".substr($f_year,0,2)."-07-01";
$y2="20".substr($f_year,-2)."-07-00";


$sql="SELECT category,sum(timegiven) as programs, sum(attend) as attendance
FROM `eedata`
 where park='$park_code' and dateprogram>='$y1' and dateprogram<'$y2' 
and category!=6
group by category
with rollup";
// echo "$f_year $y1 $y2 $sql";
	
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_1[]=$row;
	}

//echo "<pre>";print_r($ARRAY_1);echo "</pre>";
$sql="SELECT category,sum(times_given) as programs, sum(total_attendance) as attendance
FROM `programs`
 where park_code='$park_code' and date_program>='$y1' and date_program<'$y2' 
group by category
with rollup";
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_2[]=$row;
	}
// echo "$f_year $y1 $y2 $sql";

$lead_for="IE";
include("lead_ranger.php");

$catArray  = array('', '1 --> Component I Workshop, EE Certification', '2 --> Other I&E Workshop/Training', '3 --> EELE Program', '4 --> Other Structured EE or Inter. Program', '5 --> Events/Organizations hosted by park', '6 --> Short orientations & spontaneous Inter.', '7 --> Exhibits Outreach', '8 --> Jr. Ranger Program');

echo "<table cellpadding='10'><tr><td>Copy the <b>I&E</b> info, close this window, and paste into appropriate section.</td></tr></table>";

if(!isset($lead_ranger)){$lead_ranger="???";}
echo "<table><tr><td>$lead_ranger is the park's Lead for Interpretation and Education.</td></tr>";

$text="Programming totals for July 1, $year1 through June 30, $year2:";

echo "<table border='1'><tr><td colspan='4'>$text</td></tr>";
echo "<tr><td>Category</td><td># of Programs</td><td>Attendance</td></tr>";
foreach($ARRAY_1 as $index=>$array)
	{
	echo "<tr>";
	$line="";
	foreach($array as $fld=>$value)
		{
		if(isset($value))
			{
			if($fld=="category"){$value=@$catArray[$array['category']];}
			$line.="<td align='right'>$value</td>";
			}
			else
			{
			echo "<td align='right'><b>Totals</b></td>";
			$tot1_1=$array['programs'];
			$tot1_2=$array['attendance'];
			}
		}
		echo "$line";
	echo "</tr>";
	}
echo "</table>";

$catArray_2  = array(""=>"", "A"=>"A --> Interpretive Programs", "B"=>"B --> School Field Trips at Parks", "C"=>"C --> I&E Workshops/Training for Adults", "D"=>"D --> Partner-led Events/Organizations Hosted at Park", "E"=>"E --> 'Tabling', Festivals and Short Orientations", "F"=>"F --> Junior Ranger Completions");


echo "<table border='1'><tr><td colspan='4'>$text</td></tr>";
echo "<tr><td>Category</td><td># of Programs</td><td>Attendance</td></tr>";
foreach($ARRAY_2 as $index=>$array)
	{
	echo "<tr>";
	$line="";
	foreach($array as $fld=>$value)
		{
		if(isset($value))
			{
			if($fld=="category")
				{
				$value=$catArray_2[$value];
				}
			$line.="<td align='right'>$value</td>";
			}
			else
			{
			echo "<td align='right'><b>Totals</b></td>";
			$tot2_1=$array['programs'];
			$tot2_2=$array['attendance'];
			}
		}
		echo "$line";
	echo "</tr>";
	}
echo "</table>";
echo "<table border='1'>
<tr><td colspan='4'>The method for compiling I&E stats was changed on Feb. 2, 2019. So the results are shown above in the two different formats.</td></tr>
<tr><td colspan='4'><b>Grand Totals</b></td></tr>";
echo "<tr><td></td><td># of Programs</td><td>Attendance</td></tr>";
$tot1=$tot1_1+$tot2_1;
$tot2=$tot1_2+$tot2_2;
echo "<tr><td></td><td>$tot1</td><td>$tot2</td></tr>";
ECHO "</table>";
?>