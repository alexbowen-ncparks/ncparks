<?php

$sql="SELECT t1.*
from land_leases as t1
 WHERE 1"; 
//  ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
// 	$ARRAY_land_leases[]=$row;
// 	$land_leases_park_abbreviation_array[$row['park_abbreviation']]=$row['park_abbreviation'];
	}
// echo "<pre>"; print_r($land_leases_park_abbreviation_array); echo "</pre>"; // exit;


$sql="SELECT t1.park_id, t1.park_name, t1.park_abbreviation, t1.park_classification_id, t2.classification_abbreviation
from park_name as t1
left join park_classification as t2 on t1.park_id = t2.park_classification_id
 WHERE 1"; 
//  ECHO "<br />$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
// 	$park_abbreviation_array[$row['park_id']]=$row;
	}
	
// 	asort($park_abbreviation_array);
// echo "<pre>"; print_r($park_abbreviation_array); echo "</pre>";
?>