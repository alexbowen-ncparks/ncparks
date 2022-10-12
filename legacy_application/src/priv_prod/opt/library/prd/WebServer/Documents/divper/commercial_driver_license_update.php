<?php
//ini_set('display_errors',1);

//echo "<pre>";print_r($_POST);echo "</pre>"; //exit;

include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters

mysqli_select_db($connection,"divper"); // database

if(isset($_POST) AND count($_POST)>0)
	{
	EXTRACT($_POST);
	$sql="UPDATE cdl set license='$license',expiration_date='$expiration_date'
	where beacon_num='$beacon_num'";  echo "$sql";
	$result = @mysqli_query($connection,$sql);
	
	header("Location: commercial_driver_license.php");
	EXIT;
	}

extract($_REQUEST);

$sql="SELECT t1.beacon_num, t5.district as dist,concat(t5.park_name,' [',t2.park,']') as park, t2.posTitle as Title,IF(Nname !='',concat('[',Nname,']',' ',t4.Fname),t4.Fname) as F_name, t4.Lname as L_name, 
t1.license,t1.expiration_date
FROM divper.cdl as t1
left join divper.position as t2 on t1.beacon_num=t2.beacon_num
left join divper.emplist as t3 on t1.beacon_num=t3.beacon_num
left join divper.empinfo as t4 on t3.tempID=t4.tempID
left join dpr_system.parkcode_names as t5 on t2.park=t5.park_code
left join dpr_system.dprunit as t6 on t2.park=t6.parkcode
WHERE t1.beacon_num='$beacon_num'";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}


$title="Commercial Drivers License";
include("../inc/_base_top_dpr.php");

echo "<form action='commercial_driver_license_update.php' method='POST'>";
echo "<table border='1' align='center'>";

if(!isset($rep))
	{
	$span=count($ARRAY[0])-1;
	echo "<tr><th colspan='$span'>NC DPR Commercial Driver License Holder</th></tr>";	
	}

$edit_array=array("license","expiration_date");
foreach($ARRAY AS $i=>$array)
	{
	echo "<tr>";
	foreach($array as $fld=>$val)
		{
		if(in_array($fld,$edit_array))
			{
			$val="<input type='text' name='$fld' value='$val'>";
			}
		
		echo "<tr><th>$fld</th><td>$val</td></tr>";
		}
	}
echo "<tr><th colspan='2'>
<input type='hidden' name='beacon_num' value='$beacon_num'>
<input type='submit' name='submit' value='Update'>
</td></tr>";
echo "</table></form></html>";
?>
