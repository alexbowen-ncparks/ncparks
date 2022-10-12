<?php

$ckC="";$ckF="checked";$ckB="";
	$sql = "truncate table park_use.stats_f_year";//echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	
// data for year_month_week
	$sql = "INSERT INTO park_use.stats_f_year 
	SELECT left(year_month_week,4) as cutYear, substring(year_month_week,5,2) as cutMonth,park,sum(attend_tot) as attendance,''
	FROM park_use.stats 
	where year_month_week > '20000100' and year_month_week < '20120000' group by park,cutYear,cutMonth order by cutYear,cutMonth";  //echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");

// data for year_month_day
	$lastDate=date('Ymd');
	$sql = "INSERT INTO park_use.stats_f_year 
	SELECT left(year_month_day,4) as cutYear, substring(year_month_day,5,2) as cutMonth,park,sum(attend_tot) as attendance,''
	FROM park_use.stats_day
	where year_month_day > '20120000' and year_month_day < '$lastDate' 
	group by park,cutYear,cutMonth 
	order by cutYear,cutMonth";  //echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
	
	$sql = "update park_use.stats_f_year set `f_year`= CASE `cutMonth`
	when '01' then concat(right(cutYear-1,2),right(cutYear,2))
	when '02' then concat(right(cutYear-1,2),right(cutYear,2))
	when '03' then concat(right(cutYear-1,2),right(cutYear,2))
	when '04' then concat(right(cutYear-1,2),right(cutYear,2))
	when '05' then concat(right(cutYear-1,2),right(cutYear,2))
	when '06' then concat(right(cutYear-1,2),right(cutYear,2))
	when '07' then concat(right(cutYear,2),right(cutYear+1,2))
	when '08' then concat(right(cutYear,2),right(cutYear+1,2))
	when '09' then concat(right(cutYear,2),right(cutYear+1,2))
	when '10' then concat(right(cutYear,2),right(cutYear+1,2))
	when '11' then concat(right(cutYear,2),right(cutYear+1,2))
	when '12' then concat(right(cutYear,2),right(cutYear+1,2))
	end";//echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	
	$sql = "SELECT park,f_year,sum(attendance) as tot FROM park_use.`stats_f_year` WHERE 1 group by f_year,park order by park,cutYear";//echo "$sql";
	
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	while ($row=mysqli_fetch_assoc($result))
		{
	//	$aYear[]=$row[1];
	//	$aPark[]=$row[0];
	//	$parkTotYear[]=$row[2];
		$park_year_attend[$row['park']][$row['f_year']]=$row['tot'];
		}
//echo "<pre>"; print_r($park_year_attend); echo "</pre>"; // exit;
//echo "<pre>"; print_r($park_year_attend['CABE']); echo "</pre>"; // exit;
?>