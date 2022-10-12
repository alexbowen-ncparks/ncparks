<?php
$t1_fields="t1.*";
$show_all=1;
	if(empty($show_all) AND empty($edit))
		{
		$sql="SELECT t1.field_name
		from edit_data_display as t1
		WHERE t1.select_table='land_owner' and show_field='Yes'"; //ECHO "$sql"; //exit;
		$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		while($row=mysqli_fetch_assoc($result))
			{
			$temp[]="t1.".$row['field_name'];
			}
		$t1_fields=implode(",",$temp);
		}
	
if(!empty($edit))  //only run if editing a land_owner
	{
	$sql="SELECT land_owner_affiliation_id, land_owner_affiliation_description
		from land_owner_affiliation_lookup as t1
		WHERE 1"; //ECHO "$sql"; //exit;
		$result = mysqli_query($connection,$sql) or die("$sql");
		while($row=mysqli_fetch_assoc($result))
			{
			$land_owner_affiliation_id_array[$row['land_owner_affiliation_id']] = $row['land_owner_affiliation_description'];
			}
	
			
	$switch_select=array("land_owner_affiliation_id");
	}
	
	
	
			
	$sql="SELECT t1.land_owner_id
	from land_asset_land_owner_junction as t1
	WHERE t1.land_assets_id='$land_assets_id'"; //ECHO "$sql"; //exit;
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	if(mysqli_num_rows($result)>0)
		{
		$row=mysqli_fetch_assoc($result);
		extract($row);

		$sql="SELECT t2.land_owner_affiliation_description, t3.business_name, $t1_fields
		from $var as t1
		left join land_owner_affiliation_lookup as t2 on t1.land_owner_affiliation_id=t2.land_owner_affiliation_id
		left join business_name as t3 on t1.business_id=t3.business_name_id
		
		WHERE t1.land_owner_id='$land_owner_id'"; //ECHO "$sql"; //exit;

		$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		$row=mysqli_fetch_assoc($result);	
		$ARRAY[]=$row;
		}
		else
		{	
		$message= "No land owner is on record for land_assets_id $land_assets_id.";
		}
	
?>