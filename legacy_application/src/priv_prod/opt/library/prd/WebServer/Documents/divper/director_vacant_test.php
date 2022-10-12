<?php

$sql = "SELECT beacon_num From position
WHERE 1 
ORDER by beacon_num";
//echo "l=$level p=$pass_level<br />$sql"; //exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$posArray=array();
while ($row=mysqli_fetch_array($result))
	{
	extract($row);
	$posArray[]=$beacon_num;
	}

 //echo "<pre>"; print_r($posArray); echo "</pre>"; // exit;

$sql = "SELECT beacon_num From emplist ORDER by beacon_num";
//echo "$sql";exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$empArray=array();
while ($row=mysqli_fetch_array($result))
	{
	extract($row);
	$empArray[]=$beacon_num;
	}
// echo "<pre>"; print_r($empArray); echo "</pre>"; // exit;

$sql = "SELECT * From vacant_admin ORDER by beacon_num";
//echo "$sql";exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);
if($num>0)
	{
	while ($row=mysqli_fetch_array($result))
		{
		extract($row);
		$makeVacant[]=$beacon_num;
		}
	$vacArray=array_diff($empArray,$makeVacant);
	}
else
{$vacArray=$empArray;}

// echo "<pre>"; print_r($vacArray); echo "</pre>"; // exit;

$vacantArray=array();
@$sortArray=$sort;
$diffArray=array_diff($posArray,$vacArray);
sort($diffArray);
// echo "diffArray<pre>"; print_r($diffArray); echo "</pre>";  

if(empty($diffArray))
	{
	echo "No vacant positions."; exit;
	}
	

$sql = "SELECT t1.beacon_num, t1.status, t2.tempID, t2.currPark
from vacant as t1
left join emplist as t2 on t1.beacon_num=t2.beacon_num
where 1 and (status!='' and status!='Filled')
";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while ($row=mysqli_fetch_assoc($result))
	{
	$vacant_table[]=$row;
	}// end for
// echo "<pre>"; print_r($vacant_table); echo "</pre>"; // exit;

$skip=array();

echo "<table cellpadding='3'><tr><td> </td><td><b>BEACON Number</b></td><td><b>Status in Vacancy Tracker</b></td><td><b>Comment</b></td></tr>";
foreach($vacant_table AS $index=>$array)
	{
	extract($array);
	if(in_array($beacon_num,$diffArray)){continue;}else{$var=1;}
	if($index==0)
		{
		echo "<tr>";
		foreach($vacant_table[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			echo "<th>$fld</th>";
			}
		echo "</tr>";
		}
		@$i++;
	echo "<tr><td>$i</td>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if($fld=="beacon_num"){$value="<a href='trackPosition.php?beacon_num=$value' target='_blank'>$value</a>";}
		
		if($fld=="tempID"){$value="However, $value is currently at ";}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
if(!empty($var))
	{
echo "<tr><td colspan='5'>The list above needs to be cleaned up before an accurate Directory's report can be generated.</td></tr>";
	}
echo "</table><hr />";

?>