<?php
$total_fac=0;
$sql = "SELECT COUNT(*) AS `number`, `fac_type` 
FROM facilities.`spo_dpr` 
where park_abbr='$park_code'
GROUP BY `fac_type` ORDER BY `fac_type`";
// echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
while ($row=mysqli_fetch_assoc($result))
	{
	$park_facility[$park_code][$row['fac_type']]=$row['number'];
	$total_fac+=$row['number'];
	}
	@$park_facility[$park_code]['total']=$total_fac;
	
	
// echo "$total<pre>"; print_r($park_facility); echo "</pre>";  //exit;
?>