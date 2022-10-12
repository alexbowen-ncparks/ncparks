<?php

$sql="SELECT t1.*
from project_status as t1
 WHERE 1"; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_project_status[]=$row;
	$project_status_id_array[$row['project_status_id']]=$row['project_status'];
	}
// $flip_key=array("park_id");
?>