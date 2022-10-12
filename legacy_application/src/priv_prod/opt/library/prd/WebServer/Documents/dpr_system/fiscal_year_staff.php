<?php

mysqli_select_db($connection,'dpr_system');
$sql = "SELECT park_code,  year, COUNT( * ) AS `Rows` , `employee_subgroup`
FROM `fte` where park_code!='' 
GROUP BY year, park_code,`employee_subgroup` 
ORDER BY year, park_code, `employee_subgroup`";//echo "$sql";

$result = mysqli_query($connection,$sql) or die (mysqli_error($connection)."Couldn't execute query 1. $sql<br />fiscal_year_staff.php");
while ($row=mysqli_fetch_assoc($result))
	{
	$year_park_staff[$row['year']][$row['park_code']][$row['employee_subgroup']]=$row['Rows'];
	}
	
	
//echo "<pre>"; print_r($year_park_staff); echo "</pre>";  exit;
?>