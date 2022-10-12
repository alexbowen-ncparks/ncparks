<?php
//  echo "<pre>"; print_r($_POST); echo "</pre>"; //exit;
$db="dpr_land";
$database="dpr_land";
include("../../include/iConnect.inc"); // database connection parameters
$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");

//  echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
$land_assets_id=$_POST['land_assets_id'];

$skip=array("submit_form","land_assets_id");
foreach($_POST as $fld=>$value)
	{
	if($fld=="project_status"){$fld="project_status_id";}
	if($fld=="classification"){$fld="park_classification_id";}
	if($fld=="acquisition_justification_primary"){$fld="acquisition_justification_id_primary";}
	if($fld=="acquisition_justification_secondary"){$fld="acquisition_justification_id_secondary";}
	if($fld=="priority"){$fld="priority_id";}
	if($fld=="river_basin"){$fld="river_basin_id";}
	
	if(in_array($fld,$skip)){continue;}
	$var_q[]="$fld='$value'";
	}

$clause=implode(", ",$var_q);
$sql="UPDATE land_assets
set $clause
WHERE land_assets_id='$land_assets_id'"; //ECHO "$sql"; exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

header("Location: view_form.php?var=$land_assets&land_assets_id=$land_assets_id&edit=1");
?>