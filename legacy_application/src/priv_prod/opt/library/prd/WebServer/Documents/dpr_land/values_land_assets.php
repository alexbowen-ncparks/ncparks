<?php

$sql="SELECT t1.park_id, t1.park_name, t1.park_classification_id, t1.park_abbreviation
from park_name as t1
 WHERE 1"; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_park_name[]=$row;
	$park_id_array[$row['park_id']]=$row['park_abbreviation'];
	}

$sql="SELECT t1.*
from project_status as t1
 WHERE 1"; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_project_status[]=$row;
	$project_status_id_array[$row['project_status_id']]=$row['project_status'];
	}	
	
$sql="SELECT t1.*
from acquisition_justification as t1
 WHERE 1"; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_acquisition_justification_id_primary[]=$row;
	$acquisition_justification_id_primary_array[$row['acquisition_justification_id']]=$row['acquisition_justification'];$acquisition_justification_id_secondary_array[$row['acquisition_justification_id']]=$row['acquisition_justification'];
	}	

$sql="SELECT t1.*
from county_name as t1
 WHERE 1"; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_county_name[]=$row;
	$county_id_array[$row['county_name_id']]=$row['county_name'];
	}	

$sql="SELECT t1.*
from land_interest_type as t1
 WHERE 1"; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_land_interest_type[]=$row;
	$land_interest_id_array[$row['land_interest_type_id']]=$row['land_interest_type'];
	}	

$sql="SELECT t1.*
from priority as t1
 WHERE 1"; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_priority[]=$row;
	$priority_id_array[$row['priority_id']]=$row['description'];
	}	

$sql="SELECT t1.*
from park_classification as t1
 WHERE 1"; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_park_classification[]=$row;
	$park_classification_id_array[$row['park_classification_id']]=$row['classification'];
	}

$sql="SELECT t1.*
from river_basin as t1
 WHERE 1"; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_river_basin[]=$row;
	$river_basin_id_array[$row['river_basin_id']]=$row['river_basin_name'];
	}
	
$sql="SELECT t1.*
from milestones as t1
 WHERE 1"; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_milestones[]=$row;
	$milestones_array[$row['milestones_id']]=$row['spo_milestones'];
	}
						
$sos_inclusion_array=array("NULL","1");

$flip_key=array("park_id");

// $readonly_array[]="land_assets_id";
?>