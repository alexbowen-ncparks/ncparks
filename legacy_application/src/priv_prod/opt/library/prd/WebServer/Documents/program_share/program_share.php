<?php
$userAddress = $_SERVER['REMOTE_ADDR']; //echo"u=$source"; 
//print_r($_REQUEST);
//echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
date_default_timezone_set('America/New_York');
// called from Secure Server login.php
include("../../include/iConnect.inc");
extract($_REQUEST);
$dbName=$db;
session_start();
mysqli_select_db($connection,"divper");
$sql = "SELECT $dbName as level, t1.tempID, t1.currPark, t1.accessPark, t2.rcc, t2.program_code, t2.beacon_title, t3.Fname, t3.Lname
FROM emplist as t1
Left Join position as t2 on t2.beacon_num=t1.beacon_num
Left Join empinfo as t3 on t1.emid=t3.emid
WHERE t1.emid = '$emid' AND t1.tempID='$tempID'";
$result = @mysqli_query($connection, $sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
$num = @mysqli_num_rows($result);
if($num<1)
	{
	$sql = "SELECT $dbName as level,nondpr.currPark,nondpr.Fname,nondpr.Lname
	FROM nondpr 
	WHERE nondpr.tempID = '$tempID'";
	$result = @mysqli_query($connection, $sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$num = @mysqli_num_rows($result);
	if($num<1){echo "Access denied";exit;}
	}
$row=mysqli_fetch_array($result);
//print_r($row);EXIT;
extract($row);

$_SESSION[$dbName]['level'] = $level;
$_SESSION[$dbName]['tempID'] = $tempID;
$_SESSION[$dbName]['emid'] = $emid;
$_SESSION[$dbName]['select'] = $currPark;
$_SESSION[$dbName]['program_code'] = $program_code;
$_SESSION[$dbName]['accessPark'] = $accessPark;
$_SESSION[$dbName]['center'] = "1280".$rcc;
$_SESSION[$dbName]['position_title'] = $beacon_title;
$_SESSION[$dbName]['name'] = $Fname[0].". ".$Lname;

/*
mysqli_select_db($dbName,$connection);
 $today = date("Y-m-d H:i:s");
           $sql = "INSERT INTO $dbName.login (loginName,loginTime,userAddress,level)
                   VALUES ('$tempID','$today','$userAddress','$level')";
  //         mysqli_query($connection, $sql) or die("Can't execute query 3.");
*/

header("Location: welcome.php");
	
?>
