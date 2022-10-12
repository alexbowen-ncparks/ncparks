<?php
$sql = "SELECT park, location, sum( timegiven ) AS given, sum( attend ) AS attend
FROM eeid.eedata
WHERE mark != 'x'
AND (
dateprogram >= '2008-07-01'
AND dateprogram <= '2009-06-31'
)
GROUP BY park, location
ORDER BY park, location";//echo "$sql";

$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_assoc($result))
	{
	$park_year_location_program[$row['park']]['0809'][$row['location']]=$row['given'];
	$park_year_location_attend[$row['park']]['0809'][$row['location']]=$row['attend'];
	}
	
$sql = "SELECT park, location, sum( timegiven ) AS given, sum( attend ) AS attend
FROM eeid.eedata
WHERE mark != 'x'
AND (
dateprogram >= '2009-07-01'
AND dateprogram <= '2010-06-31'
)
GROUP BY park, location
ORDER BY park, location";//echo "$sql";

$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_assoc($result))
	{
	$park_year_location_program[$row['park']]['0910'][$row['location']]=$row['given'];
	$park_year_location_attend[$row['park']]['0910'][$row['location']]=$row['attend'];
	}
	
$sql = "SELECT park, location, sum( timegiven ) AS given, sum( attend ) AS attend
FROM eeid.eedata
WHERE mark != 'x'
AND (
dateprogram >= '2010-07-01'
AND dateprogram <= '2011-06-31'
)
GROUP BY park, location
ORDER BY park, location";//echo "$sql";

$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_assoc($result))
	{
	$park_year_location_program[$row['park']]['1011'][$row['location']]=$row['given'];
	$park_year_location_attend[$row['park']]['1011'][$row['location']]=$row['attend'];
	}
		
$sql = "SELECT park, location, sum( timegiven ) AS given, sum( attend ) AS attend
FROM eeid.eedata
WHERE mark != 'x'
AND (
dateprogram >= '2011-07-01'
AND dateprogram <= '2012-06-31'
)
GROUP BY park, location
ORDER BY park, location";//echo "$sql";

$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_assoc($result))
	{
	$park_year_location_program[$row['park']]['1112'][$row['location']]=$row['given'];
	$park_year_location_attend[$row['park']]['1112'][$row['location']]=$row['attend'];
	}
	
$sql = "SELECT park, location, sum( timegiven ) AS given, sum( attend ) AS attend
FROM eeid.eedata
WHERE mark != 'x'
AND (
dateprogram >= '2012-07-01'
AND dateprogram <= '2013-06-31'
)
GROUP BY park, location
ORDER BY park, location";//echo "$sql";

$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_assoc($result))
	{
	$park_year_location_program[$row['park']]['1213'][$row['location']]=$row['given'];
	$park_year_location_attend[$row['park']]['1213'][$row['location']]=$row['attend'];
	}
		
	
//echo "<pre>"; print_r($park_year_location_program); echo "</pre>";  exit;
?>