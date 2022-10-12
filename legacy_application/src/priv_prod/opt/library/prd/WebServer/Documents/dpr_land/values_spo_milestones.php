<?php

$sql="SELECT t1.*
from milestones as t1
 WHERE 1"; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_spo_milestones[]=$row;
	$milestones_array[$row['milestones_id']]=$row['spo_milestones'];
	}
// $flip_key=array("park_id");
?>