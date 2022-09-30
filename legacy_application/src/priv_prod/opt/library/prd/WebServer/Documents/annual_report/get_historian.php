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

$sql="SELECT park_code, historian, park_history
FROM `task`
 where f_year='$f_year'
 order by park_code
";

$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}

//echo "$sql<pre>";print_r($ARRAY);echo "</pre>"; //exit;

echo "<table><tr><td colspan='3'>Park Historians and Park History</td></tr>";
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
		if($fld=="park_history" and !empty($value))
			{
			$value=nl2br($value);
			$temp="<a onclick=\"toggleDisplay('ph');\" href=\"javascript:void('')\">show/hide</a>
			<div id=\"ph\" style=\"display: none\">$value</div>";
			$value=$temp;
			}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table></html>";
?>