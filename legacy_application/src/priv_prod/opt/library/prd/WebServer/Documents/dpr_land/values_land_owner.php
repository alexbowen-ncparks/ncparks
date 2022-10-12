<?php

$sql="SELECT t1.*
from land_owner_affiliation_lookup as t1
 WHERE 1"; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_land_owner_affiliation[]=$row;
	$land_owner_affiliation_id_array[$row['land_owner_affiliation_id']]=$row['land_owner_affiliation_description'];
	}

		
// $flip_key=array("park_id");
?>