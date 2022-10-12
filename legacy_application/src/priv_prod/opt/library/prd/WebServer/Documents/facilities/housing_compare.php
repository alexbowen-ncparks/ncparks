<?php
ini_set('display_errors',1);

//These are placed outside of the webserver directory for security
$database="facilities";
include("../../include/auth.inc"); // used to authenticate users
if(!empty($_SESSION[$database]['accessPark']))
	{$multi_park=explode(",",$_SESSION[$database]['accessPark']);}


include("../../include/iConnect.inc"); 
mysqli_select_db($connection,$database); // database

$sql="SELECT t4.gis_id, t4.park_abbr as park, t4.spo_assid, t1.year, t1.bedrms, t1.bathrms, t1.ac, t1.rent_code, t1.rent_comment, t1.occupant, t1.tempID, t1.position, group_concat(distinct t7.pid) as fac_photo, t1.fas_num, t1.rent_fee as rent_DPR, t6.amount as rent_DENR, t6.for_period as pay_period, LPAD(t5.beaconID,8,'0') as beaconID, LPAD(t6.pers_no_,8,'0') as personnel_number, t8.housing_agreement 

from spo_dpr as t4 

LEFT JOIN housing as t1 on t1.gis_id=t4.gis_id 

LEFT JOIN divper.emplist as t2 on t2.tempID=t1.tempID 

LEFT JOIN divper.position as t3 on t3.beacon_num=t2.beacon_num 

LEFT JOIN divper.empinfo as t5 on t2.tempID=t5.tempID 

LEFT JOIN fac_photos as t7 on t1.gis_id=t7.gis_id 

left join facilities.rent as t6 on LPAD(t5.beaconID,8,'0')=LPAD(t6.pers_no_,8,'0') 

left join housing_attachment as t8 on t1.gis_id=t8.gis_id 

where 1 and t4.fac_type='park residence' group by t1.gis_id 

ORDER BY t4.park_abbr";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");

while ($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
		
date_default_timezone_set('America/New_York');
	$date=date('Y-m-d');
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=DPR_housing_comparison_$date.xls");
echo "<table>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			echo "<th>$fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";