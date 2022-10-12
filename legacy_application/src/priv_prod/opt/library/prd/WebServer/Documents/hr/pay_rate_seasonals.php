<?php

$database="hr";
ini_set('display_errors',1);
include("../../include/iConnect.inc"); // database connection parameters

mysqli_select_db($connection,$database);
  
session_start();
$level=$_SESSION['hr']['level'];

if($level<1){exit;}

$sql="SELECT osbm_title, avg_rate_new
FROM `seasonal_payroll_next`
group by `osbm_title`";
// $sql="SELECT osbm_title, avg_rate_new, avg_rate as avg_rate_old 
// FROM `seasonal_payroll_next`
// group by `osbm_title`";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
$skip=array();
$c=count($ARRAY);
echo "<table><tr><td>$c Positions</td></tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			echo "<th>$fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";
?>
