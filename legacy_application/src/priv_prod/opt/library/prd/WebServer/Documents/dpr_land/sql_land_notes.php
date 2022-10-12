<?php
$t1_fields="t1.*";


$sql="SELECT $t1_fields
from land_notes as t1

WHERE t1.land_assets_id='$land_assets_id'"; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	if(empty($row['notes'])){continue;}
	$ARRAY[]=$row;
	}

?>