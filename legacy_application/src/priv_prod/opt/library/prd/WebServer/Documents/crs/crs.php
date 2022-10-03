<?php

extract($_REQUEST);
if(empty($emid)){
	echo "Access denied.";exit;
	}
include("../../include/salt.inc");
$ck_emid=md5($salt.$emid);

if($ck_emid!=$ck)
	{
	echo "Access denied.";
	exit;
	}

$db="crs";
$database="crs";
include("../../include/auth.inc");
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
$database="divper";
mysqli_select_db($connection,$database); // database 


$sql = "SELECT $db as level,emplist.tempID,emplist.posNum,position.beacon_num, accessPark, emplist.currPark, position.working_title
FROM divper.emplist
LEFT JOIN position on position.beacon_num=emplist.beacon_num
WHERE emid = '$emid'"; 
//echo "$sql";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
$num = @mysqli_num_rows($result);
if($num<1)
	{
	$sql = "SELECT $db as level,nondpr.currPark,nondpr.Fname,nondpr.Lname
	FROM nondpr 
	WHERE nondpr.tempID = '$tempID'";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$num = @mysqli_num_rows($result);
	if($num<1){echo "Access denied";exit;}
	}
$row=mysqli_fetch_array($result);
//print_r($row);EXIT;
extract($row);

//echo "<pre>"; print_r($_SERVER); echo "</pre>";  EXIT;
$user_address=$_SERVER['REMOTE_ADDR'];
mysqli_select_db($connection,$db); // database 
// $sql = "INSERT INTO login set loginName='$tempID',loginTime=now(),userAddress='$user_address',level='$level'"; 
// //echo "$sql";
// $result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

session_start();
$_SESSION[$db]['level'] = $level;
$_SESSION[$db]['tempID'] = $tempID;
//$_SESSION[$db]['posNum'] = $posNum;
$_SESSION[$db]['beacon'] = $beacon_num;
$_SESSION[$db]['select'] = $currPark;
$_SESSION[$db]['title'] = $working_title;

$_SESSION[$db]['accessPark'] = $accessPark;

header("Location: rental.php");
?>
