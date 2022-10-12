<?php
mysqli_select_db($connection,'budget');

$sql = "SELECT t1.center,t2.parkcode,sum(py1_amount) as receipts
FROM `report_budget_history_multiyear2` as t1
left join center as t2 on t1.center=t2.new_center
WHERE 1
and t1.parkcode = '$park_code'
and t1.center like '1680%'
and t2.stateparkyn='y'
and cash_type='receipt'
group by t1.center
ORDER by t2.parkcode";
//echo "$sql";

$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_assoc($result))
	{
	$temp_receipts[$row['parkcode']]=$row['receipts'];
	}

$sql="SELECT t1.center,t2.parkcode,-sum(py1_amount) as appropriations  FROM `report_budget_history_multiyear2` as t1
left join center as t2 on t1.center=t2.new_center
WHERE 1
and t1.parkcode = '$park_code'
and t1.center like '1680%'
and t2.stateparkyn='y'
group by t1.center
ORDER by t2.parkcode";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_assoc($result))
	{
	$temp_appropriations[$row['parkcode']]=$row['appropriations'];
	}
?>