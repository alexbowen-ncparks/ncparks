<?php
$userAddress = $_SERVER['REMOTE_ADDR']; //echo"u=$source"; 
//print_r($_REQUEST);
//echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;

// called from Secure Server login.php
extract($_REQUEST);
$dbName=$db;
$database=$dbName;
include("../../include/iConnect.inc");
mysqli_select_db($connection,'divper');

session_start();
 
$sql = "SELECT $dbName as level, t1.tempID, t1. currPark, t1.accessPark, t2.rcc, t3.email
FROM emplist as t1
LEFT JOIN position as t2 on t1.beacon_num=t2.beacon_num
LEFT JOIN empinfo as t3 on t1.emid=t3.emid
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

$_SESSION[$dbName]['level'] = $level;
$_SESSION[$dbName]['tempID'] = $tempID;
$_SESSION[$dbName]['select'] = $currPark;
$_SESSION[$dbName]['accessPark'] = $accessPark;
$_SESSION[$dbName]['rcc'] = $rcc;
$_SESSION[$dbName]['email'] = $email;

date_default_timezone_set('America/New_York');
 $today = date("Y-m-d H:i:s");
           $sql = "INSERT INTO $dbName.login (loginName,loginTime,userAddress,level)
                   VALUES ('$tempID','$today','$userAddress','$level')";
           mysqli_query($connection,$sql) or die("Can't execute query 3.");
           
header("Location: menu.php");
?>
