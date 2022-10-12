<?php
//print_r($_SERVER);exit;
// extract($_REQUEST);

$database="divper";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection,$database);
session_start();
//print_r($_SESSION);EXIT;

$sql = "SELECT $db as level,emplist.tempID,emplist.posNum,position.beacon_num,position.posTitle,position.park,position.code as station
FROM emplist
LEFT JOIN position on position.beacon_num=emplist.beacon_num
WHERE emid = '$emid'"; //echo "s=$sql";
$result = @mysqli_query($connection,$sql) or die();
//echo "$sql";exit;
$num = @mysqli_num_rows($result);
if($num<1)
	{
	$sql = "SELECT $db as level,nondpr.currPark,nondpr.Fname,nondpr.Lname, nondpr.currPark as station
	FROM nondpr 
	WHERE nondpr.tempID = '$tempID'";
	$result = @mysqli_query($connection,$sql) or die();
	$num = @mysqli_num_rows($result);
	if($num<1){echo "Access denied";exit;}
	}
$row=mysqli_fetch_array($result);
//print_r($row);EXIT;
extract($row);

$db="hr_perm";


$_SESSION[$db]['level'] = $level;
$_SESSION[$db]['tempID'] = $tempID;

$_SESSION[$db]['beacon'] = $beacon_num;
$_SESSION[$db]['position'] = $posTitle;


//   echo "<pre>"; print_r($_SESSION); echo "</pre>";  exit;

header("Location: welcome.php");
?>
