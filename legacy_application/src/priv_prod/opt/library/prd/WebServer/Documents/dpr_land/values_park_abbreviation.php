<?php


$sql="SELECT t1.park_id, t1.park_name, t1.park_abbreviation, t1.park_classification_id, t2.classification_abbreviation
from park_name as t1
left join park_classification as t2 on t1.park_id = t2.park_classification_id
 WHERE 1"; 
 ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$values_park_abbreviation_array[$row['park_id']]=$row;
	}
	
echo "<pre>"; print_r($values_park_abbreviation_array); echo "</pre>";

/*
$temp_array=array();
$sql="SELECT t1.*
from $select_table as t1
 WHERE 1"; 
 
 ECHO "$sql"; exit;
 
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$temp_array[]=$row;
	}

	foreach($temp_array as $index=>$array)
		{
		foreach($array as $f=>$v)
			{
			if($f=="park_code")
				{$land_leases_park_code_array[$row['park_code']]=$row['park_code'];}
			if($f=="park_id")
				{}
			}
		
		}
	
	}
	sort($land_leases_park_code_array);
// echo "<pre>"; print_r($land_leases_park_code_array); echo "</pre>"; // exit;
		
// $flip_key=array("park_id");
*/
?>