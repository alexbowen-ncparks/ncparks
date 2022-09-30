<?php

$sql="SELECT concat(if(t2.Nname!='',t2.Nname,t2.Fname), ' ', t2.Lname,' (', t3.posTitle,')') as lead_ranger
from divper.emplist AS t1
LEFT JOIN divper.empinfo as t2 on t1.tempID=t2.tempID
LEFT JOIN divper.position as t3 on t1.beacon_num=t3.beacon_num
where t1.currPark='$park_code'
and t1.lead_for like '%$lead_for%'";
//echo "$f_year $y1 $y2 $sql";
	
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	extract($row);
	}