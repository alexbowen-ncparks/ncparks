<?php

$sql="SELECT t1.*
from county_name as t1
 WHERE 1"; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$county_id_array[$row['county_name_id']]=$row['county_name_id'];
	$county_name_array[$row['county_name']]=$row['county_name'];
	}

?>