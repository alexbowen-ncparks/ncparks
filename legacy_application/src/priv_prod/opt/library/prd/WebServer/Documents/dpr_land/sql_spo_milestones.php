<?php
$t1_fields="t1.*";
$var="spo_milestones";
	if(empty($show_all))
		{
		$sql="SELECT t1.field_name
		from edit_data_display as t1
		WHERE t1.select_table='$var' and show_field='Yes'"; //ECHO "$sql"; //exit;
		$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		while($row=mysqli_fetch_assoc($result))
			{
			$temp[]="t1.".$row['field_name'];
			}
		$t1_fields=implode(",",$temp);
		}
		
	$sql="SELECT t1.spo_milestones_id as milestones_id
	from land_asset_spo_milestones_jnc as t1
	WHERE t1.land_assets_id='$land_assets_id'"; //ECHO "$sql<br />"; //exit;
	$result = mysqli_query($connection,$sql) or die("$sql Error 2#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	if(mysqli_num_rows($result)>0)
		{
		while($row=mysqli_fetch_assoc($result))
			{
			extract($row);

			$sql="SELECT $t1_fields, t2.spo_milestones
			from $var as t1
			left join milestones as t2 on t1.milestones=t2.milestones_id
			WHERE t1.milestones_id='$milestones_id'"; //ECHO "$sql<br />"; //exit;

			$result1 = mysqli_query($connection,$sql) or die("$sql Error 3#". mysqli_errno($connection) . ": " . mysqli_error($connection));
			while($row1=mysqli_fetch_assoc($result1))
				{$ARRAY[]=$row1;}
			}
		}
		else
		{	//$sql<br />
		$message= "No SPO milestone is on record for land_assets_id $land_assets_id.";
		}
	
?>