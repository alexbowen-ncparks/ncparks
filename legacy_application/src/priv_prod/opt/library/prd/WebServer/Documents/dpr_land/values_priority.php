<?php

$sql="SELECT t1.*
from priority as t1
 WHERE 1"; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_priority[]=$row;
	$priority_id_array[$row['priority_id']]=$row['description'];
	}
// $flip_key=array("park_id");
?>