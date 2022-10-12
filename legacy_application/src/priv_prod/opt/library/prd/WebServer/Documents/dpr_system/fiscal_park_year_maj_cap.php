<?php
extract($_REQUEST);
$sql = "SELECT *
FROM dpr_system.`major_cap` 
where park_code='$park_code'";//echo "$sql";


$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
while ($row=mysqli_fetch_assoc($result))
	{
	$park_maj_cap[$row['type']]=$row;
	}
	
	
//echo "<pre>"; print_r($park_maj_cap); echo "</pre>";  exit;
?>