<?php

$sql="SELECT t1.park_id, t1.park_name, t1.park_classification_id, t1.park_abbreviation
from park_name as t1
 WHERE 1"; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_park_name[]=$row;
	$park_id_array[$row['park_id']]=$row['park_abbreviation'];
	}

	$park_id_array['49']='YORK';
?>