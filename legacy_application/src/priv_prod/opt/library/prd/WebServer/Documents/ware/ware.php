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
$sql = "SELECT ware as level, emplist.tempID, emplist.currPark,accessPark, t5.rcc, program_code, concat(t3.Fname,' ',t3.Mname,' ',t3.Lname) as full_name, beacon_title, t4.cart 
FROM emplist 
Left Join position on position.beacon_num=emplist.beacon_num 
LEFT JOIN empinfo as t3 on t3.tempID=emplist.tempID 
LEFT JOIN budget.center as t5 on t5.parkCode=emplist.currPark 
LEFT JOIN ware.cart_access as t4 on t4.tempID=emplist.tempID
WHERE emplist.emid = '$emid' AND emplist.tempID='$tempID'";


// $sql = "SELECT $dbName as level, emplist.tempID, emplist.currPark,accessPark,rcc, program_code, concat(t3.Fname,' ',t3.Mname,' ',t3.Lname) as full_name, beacon_title, t4.cart
// FROM emplist
// Left Join position on position.beacon_num=emplist.beacon_num
// LEFT JOIN empinfo as t3 on t3.tempID=emplist.tempID
// LEFT JOIN ware.cart_access as t4 on t4.tempID=emplist.tempID
// WHERE emplist.emid = '$emid' AND emplist.tempID='$tempID'";
// echo "$sql"; exit;
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

$rcc_manage=array("Williams9358","Davis9471");
if(empty($rcc) and $tempID!="Howard6319")
	{
	if(!in_array($tempID, $rcc_manage) and $tempID!="Howard6319")
		{
		echo "You are not associated with a valid RCC - $currPark."; 
		exit;
		}
		else
		{
		if($tempID!="Williams9358"){$rcc="2808";}
		if($tempID!="Davis9471"){$rcc="2834";}
		}
	
	}
$_SESSION[$dbName]['level'] = $level;
$_SESSION[$dbName]['tempID'] = $tempID;
$_SESSION[$dbName]['emid'] = $emid;
$_SESSION[$dbName]['select'] = $currPark;
$_SESSION[$dbName]['program_code'] = $program_code;
$_SESSION[$dbName]['accessPark'] = $accessPark;
$_SESSION[$dbName]['center'] = "1280".$rcc;
$_SESSION[$dbName]['full_name'] = $full_name;
$_SESSION[$dbName]['beacon_title'] = $beacon_title;
$_SESSION[$dbName]['rcc'] = $rcc;
$_SESSION[$dbName]['cart'] = $cart;


header("Location: welcome.php");
	
?>
