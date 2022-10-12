<?php
extract($_REQUEST);
$sql = "SELECT *
FROM dpr_system.`land_awards` 
where park_code='$park_code'";	//echo "$sql";


$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
while ($row=mysqli_fetch_assoc($result))
	{
	$park_land[$row['park_code']]=$row;
	}
	
	
//echo "<pre>"; print_r($park_land); echo "</pre>";  exit;
?>