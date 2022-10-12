<?php

//if(empty($_SERVER['HTTP_COOKIE'])){exit;}

$db="hr";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
$database="divper";
mysqli_select_db($connection,$database); // database 

extract($_REQUEST);

session_start();

$sql = "SELECT $db as level,emplist.tempID,emplist.posNum,position.beacon_num, accessPark, emplist.currPark
FROM divper.emplist
LEFT JOIN position on position.beacon_num=emplist.beacon_num
WHERE emplist.emid = '$emid' AND emplist.tempID='$tempID'";
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

if($beacon_num=="60032832"){$currPark="USBG";}


//echo "<pre>"; print_r($_SERVER); echo "</pre>";  EXIT;
$user_address=$_SERVER['REMOTE_ADDR'];
mysqli_select_db($db, $connection); // database 
$sql = "INSERT INTO login set loginName='$tempID',loginTime=now(),userAddress='$user_address',level='$level'"; 
//echo "$sql";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

/*
if($level<5)
	{echo "The HR Seasonal db application is temporarily offline. We are making changes to allow the new seasonal positions requests to be available. It will probably be down most of today. If you have any questions, please contact Tom Howard."; exit;}
*/
$_SESSION[$db]['level'] = $level;
$_SESSION[$db]['tempID'] = $tempID;
$_SESSION[$db]['posNum'] = $posNum;
$_SESSION[$db]['beacon'] = $beacon_num;
$_SESSION[$db]['select'] = $currPark;

// 		if($_SESSION['hr']['tempID']=="ONeal2990") // Exhibit Coordinator
// 			{$_SESSION['hr']['select']="DEDE";}
			
$_SESSION[$db]['accessPark'] = $accessPark;
//if($tempID=="Peele5397"){print_r($_SESSION);EXIT;}
header("Location: start.php");
?>
