<?php
//   echo "<pre>"; print_r($_POST); echo "</pre>"; //exit;
$db="dpr_land";
$database="dpr_land";
include("../../include/iConnect.inc"); // database connection parameters
$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");

//  echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
$land_assets_id=$_POST['land_assets_id'];
$land_owner_id=$_POST['land_owner_id'];

$skip=array("submit_form","land_owner_id","land_assets_id");

//   Tables:
// At this time only the land_owner table is being edited    
$tables_array=array("land_owner", "land_owner_affiliation_lookup", "land_asset_land_owner_junction", "business_name");
foreach($tables_array as $k=>$v)
	{
	$sql="SHOW COLUMNS from $v"; 
	$result = mysqli_query($connection,$sql) or die("$sql");
	while($row=mysqli_fetch_assoc($result))
		{
		$field_array[$v][]=$row['Field'];
		if(array_key_exists($row['Field'],$_POST))
			{
			$update_tables[$v][$row['Field']]=$_POST[$row['Field']];
			}
		}
	}
// 	echo "<pre>"; print_r($update_tables); echo "</pre>";  //exit;

// These could be put in a loop but are separated to help edit

// At this time only the land_owner table is being edited
$skip_land_owner=array("land_owner_id","date_edited");
foreach($update_tables['land_owner'] as $fld=>$value)
	{
	if(in_array($fld,$skip_land_owner)){continue;}
	// if($fld=="classification")
// 		{$fld="park_classification_id";}
	
	$var_q[]="$fld='$value'";
	}	

$clause=implode(", ",$var_q);
$sql="UPDATE land_owner
set $clause, `date_edited`=now()
WHERE land_owner_id='$land_owner_id'"; 
// ECHO "$sql"; exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));	
	
	
// original for land_assets
// foreach($_POST as $fld=>$value)
// 	{
// 	if($fld=="classification"){$fld="park_classification_id";}
// 	if($fld=="acquisition_justification_primary"){$fld="acquisition_justification_id_primary";}
// 	
// 	if(in_array($fld,$skip)){continue;}
// 	$var_q[]="$fld='$value'";
// 	}
// 	
// exit;
UNSET($_POST);
$_POST['var']="land_owner";
$_POST['land_assets_id']=$land_assets_id;
$_POST['edit']="1";

include("view_form_test.php");

?>