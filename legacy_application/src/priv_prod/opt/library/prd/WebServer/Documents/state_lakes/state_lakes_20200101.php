<?php
$userAddress = $_SERVER['REMOTE_ADDR']; //echo"u=$source"; 
//print_r($_REQUEST);
//echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;

// called from Secure Server login.php
$database="divper";
include("../../include/connectROOT.inc");
mysql_select_db($database,$connection);

extract($_REQUEST);
$dbName=$db;
session_start();

date_default_timezone_set('America/New_York');

$sql = "SELECT $dbName as level, t1.tempID, t1. currPark, t1.accessPark, t2.rcc
FROM emplist as t1
LEFT JOIN position as t2 on t1.beacon_num=t2.beacon_num
WHERE t1.emid = '$emid' AND t1.tempID='$tempID'";
$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
$num = @mysql_num_rows($result);
if($num<1)
	{
	$sql = "SELECT $dbName as level,nondpr.currPark,nondpr.Fname,nondpr.Lname
	FROM nondpr 
	WHERE nondpr.tempID = '$tempID'";
	$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
	$num = @mysql_num_rows($result);
	if($num<1){echo "Access denied";exit;}
	}
$row=mysql_fetch_array($result);
//print_r($row);EXIT;
extract($row);

$_SESSION[$dbName]['level'] = $level;
$_SESSION[$dbName]['tempID'] = $tempID;
$_SESSION[$dbName]['select'] = $currPark;
$_SESSION[$dbName]['accessPark'] = @$accessPark;
$_SESSION[$dbName]['rcc'] = @$rcc;

 $today = date("Y-m-d H:i:s");
           $sql = "INSERT INTO $dbName.login (loginName,loginTime,userAddress,level)
                   VALUES ('$tempID','$today','$userAddress','$level')";
           mysql_query($sql) or die("Can't execute query 3.");
           
header("Location: menu.php");
?>
