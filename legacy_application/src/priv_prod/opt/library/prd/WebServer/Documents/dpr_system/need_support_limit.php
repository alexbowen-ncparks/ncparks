<?php
extract($_REQUEST);
/*
$sql = "SELECT t1.*, t2.*, t3.support
FROM dpr_system.`future_needs`  as t1
left join dpr_system.`restrictions` as t2 on t1.park_code=t2.park_code
left join dpr_system.`need_support_limit` as t3 on t1.park_code=t3.park_code
where t1.park_code='$park_code'";//echo "$sql";
*/

$sql = "SELECT t1.*, t2.*
FROM dpr_system.`restrictions`  as t1
left join dpr_system.`future_needs` as t2 on t1.park_code=t2.park_code
where t1.park_code='$park_code'";  //echo "$sql";


$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
while ($row=mysqli_fetch_assoc($result))
	{
	$park_nsl[$park_code]=$row;
	}
	
	
//echo "$sql<pre>"; print_r($park_nsl); echo "</pre>";  exit;
?>