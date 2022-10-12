<?php
//extract($_REQUEST);
$sql = "SELECT sum(`admin_hours` + `camp_host_hours` + `trail_hours` + `ie_hours` + `main_hours` + `research_hours` + `res_man_hours` + `other_hours`) as vol_hours
FROM park_use.`vol_stats` 
where park='$park_code' and `year_month` >= '$fy_start' and `year_month`<'$fy_end'
";
// echo "$sql"; //exit;

$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
while ($row=mysqli_fetch_assoc($result))
	{
	@$temp_vol_hours[$park_code]=$row['vol_hours'];
	}
	
?>