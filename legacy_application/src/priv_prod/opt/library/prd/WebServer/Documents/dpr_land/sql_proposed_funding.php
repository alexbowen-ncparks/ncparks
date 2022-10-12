<?php
$t1_fields="t1.*";
$var="proposed_funding";
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
		
	$sql="SELECT t1.proposed_funding_id
	from land_asset_proposed_fund_jnctn as t1
	WHERE t1.land_assets_id='$land_assets_id'"; //ECHO "$sql<br />"; //exit;
	$result = mysqli_query($connection,$sql) or die("$sql Error 2#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	if(mysqli_num_rows($result)>0)
		{
		while($row=mysqli_fetch_assoc($result))
			{
			extract($row);

			$sql="SELECT $t1_fields, t2.funder_name, funder_abbreviation
			from $var as t1
			left join funder_proposed as t2 on t1.funder_id=t2.funder_id
			WHERE t1.proposed_funding_id='$proposed_funding_id'"; //ECHO "$sql<br />"; //exit;

			$result1 = mysqli_query($connection,$sql) or die("$sql Error 3#". mysqli_errno($connection) . ": " . mysqli_error($connection));
			while($row1=mysqli_fetch_assoc($result1))
				{$ARRAY[]=$row1;}
			}
		}
		else
		{	//$sql<br />
		$message= "No Proposed Fundng record was found for land_assets_id $land_assets_id.";
		}
	
?>