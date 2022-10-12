<?php

$sql="SELECT t1.*
from park_name as t1
 WHERE 1"; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_park_name[]=$row;
	$park_id_array[$row['park_id']]=$row['park_name'];
	$park_name_array[$row['park_name']]=$row['park_name'];
	}
$sql="SELECT t1.*
from park_classification as t1
 WHERE 1"; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_park_classification[]=$row;
	$park_classification_id_array[$row['park_classification_id']]=$row['classification'];
	}

		
// $flip_key=array("park_id");
?>