<?php
// echo "<pre>"; print_r($_REQUEST); print_r($_FILES); echo "</pre>";  //exit;
ini_set('display_errors',1);
$title="DPR Import Personnel Text";

if(empty($_GET['export']))
	{
include("../inc/_base_top_dpr.php");
include("menu.php");
	
	}
$target="B0149";
date_default_timezone_set('America/New_York');
$year=date("Y");
$month=date("M");


if(empty($connection))
	{
	$database="divper";
	include("../../include/iConnect.inc");// database connection parameters
	mysqli_select_db($connection,$database)
	   or die ("Couldn't select database");
	}
   
$folder="B0149";
$table="B0149";


$where="funding_source='$fs'";
if(!empty($ft))
	{
	if($ft=="sea")
		{
		$where.=" and position_desc like '%*%'";
// 		$where.=" and position like '6009%'";
		}
	if($ft=="perm")
		{
		$where.=" and position_desc not like '%*%'";
// 		$where.=" and position not like '6009%'";
}
	}

$sql ="SELECT * FROM $table where 1 and $where order by position_desc";
$result=mysqli_query($connection,$sql) or (mysqli_query($connection,$sql) and die(mysqli_error($connection) . " - $sql"));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
if(!empty($export))
	{
	header("Content-Type: text/csv");
		header("Content-Disposition: attachment; filename=position_report.csv");
		// Disable caching
		header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
		header("Pragma: no-cache"); // HTTP 1.0
		header("Expires: 0"); // Proxies
		
		
		function outputCSV($header_array, $data) {
		
// 		$comment_line[]=array("To prevent Excel dropping any leading zero of an upper_left_code or upper_right_code an apostrophe is prepended to those values and only to those values.");
			$output = fopen("php://output", "w");
// 			foreach ($comment_line as $row) {
// 				fputcsv($output, $row); // here you can change delimiter/enclosure
// 			}
			foreach ($header_array as $row) {
				fputcsv($output, $row); // here you can change delimiter/enclosure
			}
			foreach ($data as $row) {
				fputcsv($output, $row); // here you can change delimiter/enclosure
			}
		fclose($output);
		}

		$header_array[]=array_keys($ARRAY[0]);
// 		echo "<pre>"; print_r($header_array); print_r($comment_line); echo "</pre>";  exit;
		outputCSV($header_array, $ARRAY);
		exit;
	}
$skip=array();
$c=count($ARRAY);
if(!empty($_GET['fs']))
	{
	$var_fs=$_GET['fs'];
	$link="fs=$var_fs";
	}
if(!empty($_GET['ft']))
	{
	$var_ft=$_GET['ft'];
	$link.="&fs=$var_fs";
	}

$var_ft=$_GET['ft'];
echo "<table><tr><td colspan='3'>$c positions</td><td><a href='B0149_funding_source.php?$link&export=1'>export</a></td></tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			echo "<th>$fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if($fld=="funding_source" and empty($fs))
			{$value="<a href='B0149_funding_source.php' target='_blank'>$value</a>";}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";

mysqli_close($connection);
?>	