<?php

$t1_fields="t1.*";
$var="deed_history";
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
		
	$sql="SELECT t1.deed_history_id
	from deed_history_junction as t1
	WHERE t1.land_assets_id='$land_assets_id'"; //ECHO "$sql<br />"; //exit;
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	if(mysqli_num_rows($result)>0)
		{
		while($row=mysqli_fetch_assoc($result))
		{
		extract($row);

		$sql="SELECT $t1_fields
		from $var as t1
		WHERE t1.deed_history_id='$deed_history_id'"; //ECHO "$sql"; //exit;

		$result1 = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		while($row1=mysqli_fetch_assoc($result1))
			{$ARRAY[]=$row1;}
			}
		}
		else
		{	
		$message= "$sql<br />No deed history is on record for land_assets_id $land_assets_id.";
		}
		
?>