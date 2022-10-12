<?php
include("menu.php");
extract($_REQUEST);
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; //exit;
$database="divper";
include("../../include/iConnect.inc"); // database connection parameters

mysqli_select_db($connection,'divper'); // database

$table="emplist_20170227";
$sql="Select t1.currPark, count(currPark) as Num, t2.posTitle
From $table as t1
left join position as t2 on t1.beacon_num=t2.beacon_num
where 1 and currPark !='ARCH'
group by t1.currPark, t2.posTitle
order by t1.currPark"; //echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $sql ".mysqli_error($connection));

while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
$skip=array();
$c=count($ARRAY);
echo "<table><tr><td colspan='2'>$c for $table</td></tr>";
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
echo "</table><html>";
?>