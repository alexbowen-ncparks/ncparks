<?php
//echo "<br />assets_business_name.php <pre>"; print_r($ARRAY); echo "</pre>"; // exit;
$key_field="land_assets_id";
$select_table="business_name";
foreach($ARRAY AS $index_1=>$array_1)
	{
	$business_name_id=$array_1['business_name_id'];
	$pass_value_1[$business_name_id]=$array_1['business_name'];
	
	$clause="t1.`business_id`='$business_name_id'";
	
	$sql="SELECT t2.land_assets_id, t1.land_owner_id, t3.common_name, t3.acreage, t4.park_abbreviation, t4.park_name
	FROM `land_owner` as t1
	left join `land_asset_land_owner_junction`  as t2 on t1.land_owner_id=t2.land_owner_id
	left join `land_assets` as t3 on t2.land_assets_id=t3.land_assets_id
	left join `park_name` as t4 on t3.park_id=t4.park_id
	WHERE $clause"; //ECHO "<br />$sql"; //exit;
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_sub[$business_name_id][]=$row;
		$header_array=$row;
		}
	}
 //echo "<pre>"; print_r($header_array); echo "</pre>";  exit;
$table_title="Business Assets";
?>