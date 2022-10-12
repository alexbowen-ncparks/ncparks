<?php
//ini_set('display_errors',1);

extract($_REQUEST);
if(!isset($rep))
	{
	$title="Commercial Drivers License";
	include("../inc/_base_top_dpr.php");
	}
	else
	{
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: inline; filename=commercial_driver_license.xls");
	}
//echo "<pre>";print_r($_REQUEST);echo "</pre>";

include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters

mysqli_select_db($connection,"divper"); // database

$sql="SELECT t1.beacon_num, t5.district as dist,concat(t5.park_name,' [',t2.park,']') as park, t2.posTitle as Title,IF(Nname !='',concat('[',Nname,']',' ',t4.Fname),t4.Fname) as F_name, t4.Lname as L_name, 
t1.license,t1.expiration_date, date_format(concat('1900-',t4.dbmonth,'-',t4.dbday),'%e-%b') as DOB, t6.city, t6.county,t2.fund,t2.rcc
FROM divper.cdl as t1
left join divper.position as t2 on t1.beacon_num=t2.beacon_num
left join divper.emplist as t3 on t1.beacon_num=t3.beacon_num
left join divper.empinfo as t4 on t3.tempID=t4.tempID
left join dpr_system.parkcode_names as t5 on t2.park=t5.park_code
left join dpr_system.dprunit as t6 on t2.park=t6.parkcode
ORDER BY t2.park";
$result = @mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
echo "<table border='1' align='center'>";

if(!isset($rep))
	{
	$span=count($ARRAY[0])-1;
	echo "<tr><th colspan='$span'>NC DPR Commercial Driver License Holders</th><th><a href='commercial_driver_license.php?rep=1'>Excel</a></th></tr>";	
	}

echo "<tr>";
foreach($ARRAY[0] as $key=>$value)
	{
	$key=strtoupper($key);
	echo "<th>$key</th>";
	}
echo "</tr>";

foreach($ARRAY AS $i=>$array)
	{
	echo "<tr>";
	foreach($array as $fld=>$val)
		{
		if($fld=="beacon_num")
			{
			$val="<a href='commercial_driver_license_update.php?beacon_num=$val'>$val</a>";
			}
		echo "<td>$val</td>";
		}
	echo "</tr>";
	}
echo "</table>";
?>