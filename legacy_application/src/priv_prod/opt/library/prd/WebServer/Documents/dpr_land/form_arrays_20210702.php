<?php
$unit_type_array=array();
$sql = "SELECT DISTINCT unit_code, unit_type from dpr_system.acreage where unit_code !='';";
$result = @mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$unit_type_array[$row['unit_type']]=$row['unit_type'];
	}
// echo "<pre>"; print_r($unit_type_array); echo "</pre>"; exit;

$drop_down=array("park_id","county_name","county_number", "county_id", "sub_cat", "acquisition_justification_id_primary", "acquisition_justification_id_secondary", "land_interest_id", "acquisition_justification_id_primary", "acquisition_justification_id_secondary", "project_status_id", "priority_id", "park_classification_id", "river_basin_id", "milestones", "park_name","park_code");

if($select_table!="priority")
	{
	$add_fields_array[]="priority_id";
	}
if($select_table!="project_status")
	{
	$add_fields_array[]="project_status_id";
	}
if($select_table!="proposed_funding")
	{
	$add_fields_array[]="funder_id";
	}
if($select_table!="park_name")
	{
	$add_fields_array[]="park_id";
	}
	
if($select_table=="land_leases")
	{
$radio_array_form['asset_yn']=array("Yes"=>"Yes","No"=>"No","NULL"=>"");
$radio_array_form['lease_type']=array("lessor"=>"lessor","lessee"=>"lessee","NULL"=>"");

$radio_array_form['unit_type']=$unit_type_array; // search_form.php line 173
		$radio_array_form['unit_type']['NULL']="NULL";
	}
	
//$park_code_array=$parkCode;  //see get_parkcodes_dist.php 
$disposition_array=array("Surplus","Scrap","Landfill","Park Use");
$category_array=array("Monetary","Non-Monetary","Personal Belongings");

$true_false_array=array("sos_inclusion","restrictions","critical","fi_p","mai","river_basin");
// $true_false_values=array("TRUE","FALSE");
$true_false_values=array("","1");

$date_array=array("date_submit"=>"datepicker1","date_action"=>"datepicker2");

$textarea=array("description","identifiers","where_stored","comments");

$caption=array("identifiers"=>"Enter any number, model name, or 
other identifying marking(s).", "where_stored"=>"Where is the item being kept?", "comments"=>"<br />Contact info on potential owners and any conversations the park staff had with them. Any other info relating to the item.", "description"=>"Please describe the item.");

$admin_array=array("disposition","category","sub_cat");

$flip_key=array();  // see values_land_assets.php  and other values_*.php files

$sql = "SELECT * from county_name"; 
$result = mysqli_query($connection,$sql) or die("23 $sql ".mysqli_error($connection));
$source_county="";
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_county_id_table[$row['county_name']]=$row['county_id'];
	$source_county.="\"".$row['county_name']."\",";		
	}
?>