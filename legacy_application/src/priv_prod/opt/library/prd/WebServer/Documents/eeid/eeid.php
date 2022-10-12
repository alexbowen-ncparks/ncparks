<?php
//print_r($_REQUEST);
//print_r($_SESSION);EXIT;
// called from Secure Server login.php
//if(empty($_SERVER['HTTP_COOKIE'])){exit;}

$database="eeid";$db="eeid";
//include("../../include/auth.inc");
include("../../include/iConnect.inc");


mysqli_select_db($connection,'divper');
$sql = "SELECT $db as level,emplist.currPark,empinfo.Nname,empinfo.Fname,empinfo.Lname, accessPark
FROM emplist 
LEFT JOIN empinfo on empinfo.emid=emplist.emid
WHERE empinfo.tempID = '$tempID'";
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

session_start();
$_SESSION[$db]['level'] = $level;
if($level==1){$access="PARK";}
if($level==2){$access="DIST";}
if($level==3){$access="ADMIN";}
if($level==4){$access="SUPERADMIN";}
if($level==5){$access="SUPERADMIN";}

$_SESSION[$db]['loginS'] = $access;
$_SESSION[$db]['tempID'] = $tempID;
$_SESSION[$db]['parkS'] = $currPark;

if($Nname){$Fname=$Nname;}
$_SESSION[$db]['first']=$Fname;
$_SESSION[$db]['last']=$Lname;
$_SESSION[$db]['select']=$currPark;
$_SESSION[$db]['accessPark']=$accessPark;
// echo "<pre>"; print_r($_SESSION); echo "</pre>";  exit;
if($level>0)
	{
	header("Location: landing.php");
	}
// 	else
// 	{
// 	header("Location: store.php");
// 	}
?>
