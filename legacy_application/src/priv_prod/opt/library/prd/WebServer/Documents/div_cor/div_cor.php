<?php
//print_r($_SERVER);exit;
extract($_REQUEST);

$database="divper";
include("../../include/iConnect.inc");// database connection parameters
$database="divper";
mysqli_select_db($connection,$database);
session_start();
//print_r($_SESSION);EXIT;
// echo "db=$db data=$database"; exit;

$sql = "SELECT $db as level,emplist.tempID,emplist.posNum,position.beacon_num,position.posTitle,position.park,position.code as station
FROM emplist
LEFT JOIN position on position.beacon_num=emplist.beacon_num
WHERE emid = '$emid'";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
//echo "$sql";exit;
$num = @mysqli_num_rows($result);
if($num<1)
	{
	$sql = "SELECT $db as level,nondpr.currPark,nondpr.Fname,nondpr.Lname, nondpr.currPark as station
	FROM nondpr 
	WHERE nondpr.tempID = '$tempID'";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$num = @mysqli_num_rows($result);
	if($num<1){echo "Access denied";exit;}
	}
$row=mysqli_fetch_array($result);
//print_r($row);EXIT;
extract($row);

$userAddress=$_SERVER['REMOTE_ADDR'];
$database="div_cor";
mysqli_select_db($connection,$database);

// $sql = "INSERT INTO login set loginName='$tempID', loginTime=NOW(), userAddress='$userAddress', level='$level'";
// $result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));


$sql = "SELECT * FROM access WHERE 1";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

while($row=mysqli_fetch_array($result))
	{
	if($row['admin_id']){$admin_id[]=$row['admin_id'];}
	if($row['operation_id']){$operation_id[]=$row['operation_id'];}
	if($row['apc_id']){$apc_id[]=$row['apc_id'];}
	if($row['engn_id']){$engn_id[]=$row['engn_id'];}
	if($row['le_id']){$le_id[]=$row['le_id'];}
	if($row['opaa_id']){$opaa_id[]=$row['opaa_id'];}
	}
//echo "<pre>"; print_r($operation_id); echo "</pre>";  exit;

$db="div_cor";

if($station=="OPER")
	{
	$_SESSION[$db]['station'] = $park;
	}
	else
	{$_SESSION[$db]['station'] = $station;} //Operations,Administration,NODI,CABE


if(in_array($beacon_num,$admin_id))
	{
	$_SESSION[$db]['admin'] = "x";
	$_SESSION[$db]['station'] = "Administration";
	}
if(in_array($beacon_num,$operation_id))
	{// CHOP and CHOP OA
	$_SESSION[$db]['ops'] = "x";
	$_SESSION[$db]['station'] = "Operations";
	}
if(in_array($beacon_num,$apc_id))
	{
	$_SESSION[$db]['apc'] = "x";
	}
if(in_array($beacon_num,$engn_id))
	{
	$_SESSION[$db]['engn'] = "x";
	$_SESSION[$db]['station'] = "ENGN";
	$_SESSION[$db]['station_temp'] = "ENGN";
	}

if(in_array($beacon_num,$le_id))
	{
	$_SESSION[$db]['le'] = "x";
	$_SESSION[$db]['station'] = "LAEN";
	$_SESSION[$db]['station_temp'] = "LAEN";
	}

if(in_array($beacon_num,$opaa_id))
	{
	$_SESSION[$db]['opaa_id'] = "x";
	$_SESSION[$db]['station'] = "OPAA";
	$_SESSION[$db]['station_temp'] = "OPAA";
	}


if($tempID=="Williams5894")
	{
// 	$_SESSION[$db]['station'] = "Operations";
// 	$_SESSION[$db]['chop'] = "x";
	$_SESSION[$db]['opaa'] = "x";
	}
if($tempID=="Pearson2659")
	{
	$_SESSION[$db]['station'] = "HABE";
	$_SESSION[$db]['station_temp'] = "Pearson_private";
	$_SESSION[$db]['station_private'] = "Pearson_private";
	}
if($tempID=="Locke9589")
	{
	$_SESSION[$db]['station_temp'] = "Locke_private";
	$_SESSION[$db]['station_private'] = "Locke_private";
	}
if($tempID=="Mahaffey8312")
	{
	$_SESSION[$db]['station_temp'] = "Mahaffey_private";
	$_SESSION[$db]['station_private'] = "Mahaffey_private";
	}
if($tempID=="Howell4351")
	{
	$_SESSION[$db]['station_temp'] = "Howell_private";
	$_SESSION[$db]['station_private'] = "Howell_private";
	}

$_SESSION[$db]['level'] = $level;
$_SESSION[$db]['tempID'] = $tempID;

$_SESSION[$db]['beacon'] = $beacon_num;
$_SESSION[$db]['position'] = $posTitle;


//echo "<pre>"; print_r($_SESSION); echo "</pre>";  exit;

header("Location: display_item.php");
?>
