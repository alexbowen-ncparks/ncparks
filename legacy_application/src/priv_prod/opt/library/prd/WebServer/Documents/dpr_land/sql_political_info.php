<?php
$t1_fields="t1.congressional_district, t1.senate_district, t1.house_district";


$sql="SELECT $t1_fields
from land_assets as t1

WHERE t1.land_assets_id='$land_assets_id'"; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
$row=mysqli_fetch_assoc($result);	
$ARRAY[]=$row;

?>