<?php
$sql = "SELECT park, sum( admin_hours+camp_host_hours+trail_hours+ie_hours+main_hours+research_hours+res_man_hours+other_hours ) AS vol_hrs, count(Lname) as vol_num
FROM park_use.vol_stats
WHERE 1
AND (
`year_month` >= '2008-07-01'
AND `year_month` <= '2009-06-31'
)
GROUP BY park
ORDER BY park";//echo "$sql";


$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_assoc($result))
	{
	$park_year_vols_hrs[$row['park']]['0809']=$row['vol_hrs'];
	$park_year_vols_num[$row['park']]['0809']=$row['vol_num'];
	}
	
$sql = "SELECT park, sum( admin_hours+camp_host_hours+trail_hours+ie_hours+main_hours+research_hours+res_man_hours+other_hours ) AS vol_hrs, count(Lname) as vol_num
FROM park_use.vol_stats
WHERE 1
AND (
`year_month` >= '2009-07-01'
AND `year_month` <= '2010-06-31'
)
GROUP BY park
ORDER BY park";//echo "$sql";


$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_assoc($result))
	{
	$park_year_vols_hrs[$row['park']]['0910']=$row['vol_hrs'];
	$park_year_vols_num[$row['park']]['0910']=$row['vol_num'];
	}
	
$sql = "SELECT park, sum( admin_hours+camp_host_hours+trail_hours+ie_hours+main_hours+research_hours+res_man_hours+other_hours ) AS vol_hrs, count(Lname) as vol_num
FROM park_use.vol_stats
WHERE 1
AND (
`year_month` >= '2010-07-01'
AND `year_month` <= '2011-06-31'
)
GROUP BY park
ORDER BY park";//echo "$sql";

$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_assoc($result))
	{
	$park_year_vols_hrs[$row['park']]['1011']=$row['vol_hrs'];
	$park_year_vols_num[$row['park']]['1011']=$row['vol_num'];
	}
		
$sql = "SELECT park, sum( admin_hours+camp_host_hours+trail_hours+ie_hours+main_hours+research_hours+res_man_hours+other_hours ) AS vol_hrs, count(Lname) as vol_num
FROM park_use.vol_stats
WHERE 1
AND (
`year_month` >= '2011-07-01'
AND `year_month` <= '2012-06-31'
)
GROUP BY park
ORDER BY park";//echo "$sql";

$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_assoc($result))
	{
	$park_year_vols_hrs[$row['park']]['1112']=$row['vol_hrs'];
	$park_year_vols_num[$row['park']]['1112']=$row['vol_num'];
	}
	
$sql = "SELECT park, sum( admin_hours+camp_host_hours+trail_hours+ie_hours+main_hours+research_hours+res_man_hours+other_hours ) AS vol_hrs, count(Lname) as vol_num
FROM park_use.vol_stats
WHERE 1
AND (
`year_month` >= '2012-07-01'
AND `year_month` <= '2013-06-31'
)
GROUP BY park
ORDER BY park";//echo "$sql";

$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_assoc($result))
	{
	$park_year_vols_hrs[$row['park']]['1213']=$row['vol_hrs'];
	$park_year_vols_num[$row['park']]['1213']=$row['vol_num'];
	}
		
	
//echo "<pre>"; print_r($park_year_vols_hrs); echo "</pre>";  exit;
//echo "<pre>"; print_r($park_year_vols_num); echo "</pre>";  exit;
?>