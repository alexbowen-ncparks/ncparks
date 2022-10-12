<?php
$userAddress = $_SERVER['REMOTE_ADDR']; //echo"u=$source"; 
//print_r($_REQUEST);
//echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;

// called from Secure Server login.php
$database="divper";
include("../../include/iConnect.inc");
mysqli_select_db($connection,$database);

extract($_REQUEST);
$dbName=$db;
session_start();

date_default_timezone_set('America/New_York');

$sql = "SELECT $dbName as level, t1.tempID, t1. currPark, t1.accessPark, t2.rcc
FROM emplist as t1
LEFT JOIN position as t2 on t1.beacon_num=t2.beacon_num
WHERE t1.emid = '$emid' AND t1.tempID='$tempID'";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
$num = @mysqli_num_rows($result);
if($num<1)
	{
	$sql = "SELECT $dbName as level,nondpr.currPark,nondpr.Fname,nondpr.Lname
	FROM nondpr 
	WHERE nondpr.tempID = '$tempID'";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$num = @mysqli_num_rows($result);
	if($num<1){echo "Access denied";exit;}
	}
$row=mysqli_fetch_array($result);
//print_r($row);EXIT;
extract($row);

if($level<1)
	{
	echo "The State Lakes db is undergoing maintenace to prepare it for 2020. Check back in a day or two. Contact Tom Howard if access is needed before then.";
	exit;
	}
	
$_SESSION[$dbName]['level'] = $level;
$_SESSION[$dbName]['tempID'] = $tempID;
$_SESSION[$dbName]['select'] = $currPark;
$_SESSION[$dbName]['accessPark'] = @$accessPark;
$_SESSION[$dbName]['rcc'] = @$rcc;

 $today = date("Y-m-d H:i:s");
           $sql = "INSERT INTO $dbName.login (loginName,loginTime,userAddress,level)
                   VALUES ('$tempID','$today','$userAddress','$level')";
           mysqli_query($connection,$sql) or die("Can't execute query 3.");
           
header("Location: menu.php");
?>
