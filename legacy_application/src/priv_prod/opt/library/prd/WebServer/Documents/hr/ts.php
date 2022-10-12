<?php
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
$database="hr";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
//include("../../include/get_parkcodes_i.php"); // database connection parameters
mysqli_select_db($connection,"hr"); // database
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;

$query="SELECT id, date_job_order, division, job_title, start_date, job_description from temp_solutions"; //echo "$query";exit;
$result = mysqli_query($connection,$query) or die ("Couldn't execute query Update. $query");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
include("../_base_top.php");
$c=count($ARRAY);
echo "<table><tr><td>$c</td></tr>";
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
		if($fld=="id")
			{$value="<a href='ts_form.php?id=$value'>View</a>";}
			
		if($fld=="job_description")
			{
			$exp=explode("-",$value);
			$value=$exp[0];}
			
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";

echo "</body></html>";
?>