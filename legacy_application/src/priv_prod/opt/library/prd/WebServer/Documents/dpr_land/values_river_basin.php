<?php

$sql="SELECT t1.*
from river_basin as t1
 WHERE 1"; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_river_basin[]=$row;
	$river_basin_id_array[$row['river_basin_id']]=$row['river_basin_name'];
	}
// $flip_key=array("park_id");
?>