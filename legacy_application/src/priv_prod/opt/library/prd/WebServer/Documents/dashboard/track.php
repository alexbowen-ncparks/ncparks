<?php
ini_set('display_errors',1);

	$database="dashboard";
	$title="DPR Dashboard";
	include("../_base_top.php");	
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

// include("../../include/get_parkcodes_reg.php");
include("../../include/iConnect.inc");

date_default_timezone_set('America/New_York');

$beacon_num=$_SESSION['beacon_num'];  //echo "e=$emid";
if($var_temp=="Howard")
	{
	$beacon_num='60033018';
	}
$database="dashboard";
mysqli_select_db($connection, $database);
$sql="SELECT  db
FROM `track` 
where beacon_num = '$beacon_num'
";    //echo "$sql";
$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_db[]=$row['db'];
	}
//  echo "<pre>"; print_r($ARRAY_db); echo "</pre>";  exit;

if(empty($ARRAY_db))
	{
	echo "Nothing to track for $beacon_num"; exit;
	}
$db_name_array=array("dpr_proj"=>"DPR Project Tracking","second_employ"=>"Secondary Employment","travel"=>"Travel Authorization");
foreach($ARRAY_db as $k=>$v)
	{
	$file="track_".$v.".php";
	include($file);
	}
?>