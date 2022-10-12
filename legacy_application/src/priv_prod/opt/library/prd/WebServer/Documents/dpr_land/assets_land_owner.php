<?php
//echo "<br />land_owner_assets.php <pre>"; print_r($ARRAY); echo "</pre>"; // exit;
$key_field="land_assets_id";
$select_table="land_assets";
foreach($ARRAY AS $index_1=>$array_1)
	{
	$land_owner_id=$array_1['land_owner_id'];
	$pass_value_1[$land_owner_id]=$array_1['first_name'];
	$pass_value_2[$land_owner_id]=$array_1['last_name'];
	
	$clause="`land_owner_id`='$land_owner_id'";
	
	$sql="SELECT t1.land_assets_id, t2.common_name, t2.acreage, t2.notes, t3.park_abbreviation, t3.park_name
	FROM `land_asset_land_owner_junction`  as t1
	left join `land_assets` as t2 on t1.land_assets_id=t2.land_assets_id
	left join `park_name` as t3 on t2.park_id=t3.park_id
	WHERE $clause"; //ECHO "<br />$sql"; exit;
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_sub[$land_owner_id][]=$row;
		$header_array=$row;
		}
	}
 //echo "<pre>"; print_r($ARRAY_sub); echo "</pre>"; // exit;
//  echo "<pre>"; print_r($land_owner_last_name); echo "</pre>"; // exit;
$table_title="Land Owner Assets";
?>