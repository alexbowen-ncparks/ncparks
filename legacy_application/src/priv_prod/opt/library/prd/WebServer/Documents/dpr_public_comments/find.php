<?php
$database="dpr_rema";
$action_type="Find";
$var_act="Find";
$skip[]="edits";
// echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
include("../../include/iConnect.inc");
mysqli_select_db($connection, $database);
$sql="SELECT distinct park_code from project where 1";  //echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. $sql ".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$exp=explode(",", $row['park_code']);
	foreach($exp as $k=>$v)
		{
		if($v=="ALL"){continue;}
		$park_code_array[$v]=$v;
		}
	}
if(empty($park_code_array))
	{
	$database="dpr_rema";
	$title="DPR Project Tracking Application";
	include("../_base_top.php");
	echo "No project has been entered.";
	exit;
	}
$sql="SELECT distinct proj_type from project where 1";  //echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. $sql ".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$temp_proj_type_array[]=$row['proj_type'];
	}
foreach($temp_proj_type_array as $k=>$v)
	{
	$exp=explode(",",$v);
	foreach($exp as $k1=>$v1)
		{
		$var_array[]=$v1;
		}
	}
$proj_type_array=array_unique($var_array); 
include("project.php");
?>