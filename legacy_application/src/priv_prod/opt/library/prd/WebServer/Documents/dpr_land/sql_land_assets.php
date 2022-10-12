<?php
$t1_fields="t1.*";
	if(empty($show_all))
		{
		$sql="SELECT t1.field_name
		from edit_data_display as t1
		WHERE t1.select_table='land_assets' and show_field='Yes'"; //ECHO "$sql"; //exit;
		$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		while($row=mysqli_fetch_assoc($result))
			{
			$temp[]="t1.".$row['field_name'];
			}
		$t1_fields=implode(",",$temp);
		}
if(!empty($edit))  //only run if editing a land_asset
	{
	$sql="SELECT project_status_id, project_status
		from project_status as t1
		WHERE 1"; //ECHO "$sql"; //exit;
		$result = mysqli_query($connection,$sql) or die("$sql");
		while($row=mysqli_fetch_assoc($result))
			{
			$project_status_array[$row['project_status_id']] = $row['project_status'];
			}
	$sql="SELECT park_classification_id, concat(classification_abbreviation,'-',classification) as classification
		from park_classification
		WHERE 1"; //ECHO "$sql"; //exit;
		$result = mysqli_query($connection,$sql) or die("$sql");
		while($row=mysqli_fetch_assoc($result))
			{
			$classification_array[$row['park_classification_id']] = $row['classification'];
			}
	$sql="SELECT acquisition_justification_id, acquisition_justification
		from acquisition_justification
		WHERE 1"; //ECHO "$sql"; //exit;
		$result = mysqli_query($connection,$sql) or die("$sql");
		while($row=mysqli_fetch_assoc($result))
			{
			$acquisition_justification_primary_array[$row['acquisition_justification_id']] = $row['acquisition_justification'];
			$acquisition_justification_secondary_array[$row['acquisition_justification_id']] = $row['acquisition_justification'];
			}
	$sql="SELECT river_basin_id, river_basin_name
		from river_basin
		WHERE 1"; //ECHO "$sql"; //exit;
		$result = mysqli_query($connection,$sql) or die("$sql");
		while($row=mysqli_fetch_assoc($result))
			{
			$river_basin_array[$row['river_basin_id']] = $row['river_basin_name'];
			}
	$sql="SELECT priority_id, description
		from priority
		WHERE 1"; //ECHO "$sql"; //exit;
		$result = mysqli_query($connection,$sql) or die("$sql");
		while($row=mysqli_fetch_assoc($result))
			{
			$priority_array[$row['priority_id']] = $row['description'];
			}
	}

	
	$sql="SELECT t3.project_status, $t1_fields, concat(t2.classification_abbreviation,'-',t2.classification) as classification, t4.acquisition_justification as acquisition_justification_primary, t5.acquisition_justification as acquisition_justification_secondary, t6.description as priority, t7.river_basin_name as river_basin
	from $var as t1
	left join park_classification as t2 on t1.park_classification_id=t2.park_classification_id
	left join project_status as t3 on t1.project_status_id=t3.project_status_id
	left join`acquisition_justification` as t4 on t1.acquisition_justification_id_primary=t4.acquisition_justification_id
	left join`acquisition_justification` as t5 on t1.acquisition_justification_id_secondary=t5.acquisition_justification_id
	left join priority as t6 on t1.priority_id=t6.priority_id
	left join river_basin as t7 on t1.river_basin_id=t7.river_basin_id
	
	WHERE t1.land_assets_id='$land_assets_id'"; //ECHO "$sql"; //exit;
	$result = mysqli_query($connection,$sql) or die(" sql_land_assets.php <br />$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$row=mysqli_fetch_assoc($result);	
	$ARRAY[]=$row;
	
?>