<html><head><script language="JavaScript">

function toggleDisplay(objectID) {
	var object = document.getElementById(objectID);
	state = object.style.display;
	if (state == 'none')
		object.style.display = 'block';
	else if (state != 'none')
		object.style.display = 'none'; 
}
</script></head>
<?php
//ini_set('display_errors',1);
session_start();
$level=$_SESSION['annual_report']['level'];
if($level<2){@$park_code=$_SESSION['annual_report']['select'];}

$database="annual_report";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database 

extract($_REQUEST);
// Make f_year
date_default_timezone_set('America/New_York');
if(@$f_year=="")
	{
	$testMonth=date('n');
	if($testMonth >0 and $testMonth<11){$year2=date('Y')-1;}
	if($testMonth >10){$year2=date('Y');}
	$yearNext=$year2+1;
		$yx=substr($year2,2,2);
	$year3=$yearNext;
		$yy=substr($year3,2,2);
	$f_year=$yx.$yy;
	
	$next_fy=($yx+1).($yy+1);
	//force previous year
//	$prev_year="prev";
	if(@$prev_year=="prev")
		{
		$yx=substr(($year2-1),2,2);
		$yy=substr(($year3-1),2,2);
		$f_year=$yx.$yy;
		}
	}
$sql="SELECT park_code, centennial
FROM `task`
 where f_year='$f_year'
 order by park_code
";
//echo "$sql";
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}

//echo "$sql<pre>";print_r($ARRAY);echo "</pre>"; //exit;

echo "<table><tr><td colspan='3'>Centennial Coordinators</td></tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			echo "<th>$fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table></html>";
?>