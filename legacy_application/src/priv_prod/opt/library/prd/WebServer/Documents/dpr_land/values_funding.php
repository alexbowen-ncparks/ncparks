<?php

$sql="SELECT t1.*
from funder as t1
 WHERE 1"; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_funder[]=$row;
	$funder_id_array[$row['funder_id']]=$row['funder_name'];
	}

		
// $flip_key=array("park_id");
?>