<?php
ini_set('display_errors',1);
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
if(!empty($_REQUEST['submit']))
	{
	if($_REQUEST['submit']=="ADD")
		{
		header("LOCATION: add_it.php");
		exit;
		}
	}
session_start();

//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
date_default_timezone_set('America/New_York');

$database="fixed_assets";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, $database)
       or die ("Couldn't select database $database");
       
$level=$_SESSION['fixed_assets']['level'];

if($level<1){exit;}
	
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

if(@$_REQUEST['submit']=="Delete")
	{
	$sql="delete from its_subnets where id='$_REQUEST[id]'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	unset($_REQUEST);
	}

$title="DPR IT Inventory";
include("../_base_top.php");


echo "<title>NC DPR IT Tracking System</title><body>";


$sql="select distinct park_code from its_subnets where 1 order by park_code";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result))
	{
	$park_array[]=$row['park_code'];
	}
$sql="select distinct county_office from its_subnets where 1 order by county_office";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result))
	{
	$county_office_array[]=$row['county_office'];
	}
$sql="select distinct current_service_type from its_subnets where 1 order by current_service_type";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result))
	{
	if(empty($row['current_service_type'])){$row['current_service_type']="blank_current_service_type";}
	$current_service_type_array[]=$row['current_service_type'];
	}

echo "<form action='its_subnets.php' method='POST'>";
echo "<div align='center'><table border='1' cellpadding='5'>";
echo "<tr><td colspan='6' align='center'><font color='magenta' size='+1'>NC DPR ITS Subnets</font></td></tr>";

$test_unit=@$_REQUEST['single_location']; 
if(empty($test_unit)){$test_unit=$_SESSION['fixed_assets']['select'];}

$rename_dist=array("EADI"=>"EAST","SODI"=>"SOUTH","NODI"=>"NORTH","WEDI"=>"WEST");

IF(array_key_exists($test_unit, $rename_dist))
	{
	$test_unit="DPR".$rename_dist[$test_unit];
	}
	else
	{
	$test_unit="DPR".$test_unit;
	}

	
echo "<tr>";

echo "<td align='center'>Park Code<br /><select name='park_code_1'><option></option>";
	foreach($park_array as $k=>$v)
		{
		if($v==$test_unit){$s="selected";}else{$s="";}
		echo "<option value='$v' $s>$v</option>";
		}
echo "</select></td>";
echo "<td align='center'>Service Type<br /><select name='current_service_type_1'><option></option>";
	foreach($current_service_type_array as $k=>$v)
		{
		if($v==$current_service_type){$s="selected";}else{$s="";}
		echo "<option value='$v' $s>$v</option>";
		}
echo "</select></td>";

//echo "<td><a href='inventory.php?action=inventory' target='_blank'>FAS Inventory</a></td>";

echo "</tr>";
echo "</table></div>";


	include("its_subnets_form.php");

?>