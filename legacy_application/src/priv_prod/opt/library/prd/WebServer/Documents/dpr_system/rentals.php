<?php
extract($_REQUEST);
$sql = "SELECT *
FROM crs.`rental_facility` 
where park='$park_code'";	//echo "$sql";


$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
while ($row=mysqli_fetch_assoc($result))
	{
	$rental_array[]=$row;
	}
	
	
//echo "<pre>"; print_r($rental_array); echo "</pre>";  exit;
?>