<?php
$userAddress = $_SERVER['REMOTE_ADDR']; //echo"u=$source"; 
//print_r($_REQUEST);
//echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
date_default_timezone_set('America/New_York');
// called from Secure Server login.php
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, "divper")
       or die ("Couldn't select database $database");
$dbName=$db;
session_start();

// t2.park_reg replaced with t2.park  teh_20220531
$sql = "SELECT $dbName as level, emplist.tempID, t2.park as currPark,accessPark,rcc, t2.program_code_reg, concat(t3.Fname,' ',t3.Mname,' ',t3.Lname) as full_name, beacon_title
FROM emplist
Left Join position as t2 on t2.beacon_num=emplist.beacon_num
LEFT JOIN empinfo as t3 on t3.tempID=emplist.tempID
WHERE emplist.emid = '$emid' AND emplist.tempID='$tempID'";
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

$_SESSION['fixed_assets']['original_level']=$level;
$_SESSION['fixed_assets']['original_tempID']=$tempID;


$_SESSION[$dbName]['emid'] = $emid;
$_SESSION[$dbName]['select'] = $currPark;
$_SESSION[$dbName]['program_code'] = $program_code_reg;
$_SESSION[$dbName]['accessPark'] = $accessPark;
$_SESSION[$dbName]['center'] = "1280".$rcc;
$_SESSION[$dbName]['full_name'] = $full_name;
$_SESSION[$dbName]['beacon_title'] = $beacon_title;

mysqli_select_db($connection,$dbName);
 $today = date("Y-m-d H:i:s");
           $sql = "INSERT INTO $dbName.login (loginName,loginTime,userAddress,level)
                   VALUES ('$tempID','$today','$userAddress','$level')";
           mysqli_query($connection,$sql) or die("Can't execute query 3.");


header("Location: home.php");
	
?>
