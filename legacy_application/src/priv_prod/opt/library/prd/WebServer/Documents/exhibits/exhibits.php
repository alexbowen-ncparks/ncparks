<?php
 $userAddress = $_SERVER['REMOTE_ADDR']; //echo"u=$source"; 
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
//echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;

// called from Secure Server login.php
//if(empty($_SERVER['HTTP_COOKIE'])){exit;}

date_default_timezone_set('America/New_York');
$database="exhibits"; 
$dbName="exhibits";
include("../../include/auth.inc");
include("../../include/connectROOT.inc");
extract($_REQUEST);

mysql_select_db("divper",$connection);
$sql = "SELECT $dbName as level,emplist.tempID,emplist.currPark,accessPark,t2.working_title, concat(t3.Fname,' ',t3.Mname,' ',t3.Lname) as full_name, t2.program_code, t2.beacon_num
FROM emplist 
LEFT JOIN position as t2 on t2.beacon_num=emplist.beacon_num
LEFT JOIN empinfo as t3 on t3.tempID=emplist.tempID
WHERE emplist.emid = '$emid' AND emplist.tempID='$tempID'";
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
//echo "<pre>"; print_r($row); echo "</pre>";  exit;
extract($row);

$_SESSION[$dbName]['level'] = $level;
$_SESSION[$dbName]['tempID'] = $tempID;
IF(!empty($currPark)){$_SESSION[$dbName]['select'] = $currPark;}
if($currPark=="ARCH")
	{
	IF(!empty($program_code)){$_SESSION[$dbName]['select'] = $program_code;}
	}

$_SESSION[$dbName]['accessPark'] = @$accessPark;
if($beacon_num=="60032881")
	{
	$_SESSION[$dbName]['accessPark'] = "RALE";
	}
$_SESSION[$dbName]['working_title'] = $working_title;
$_SESSION[$dbName]['full_name'] = $full_name;
$_SESSION[$dbName]['beacon_num'] = $beacon_num;

//echo "<pre>"; print_r($_SESSION); echo "</pre>";  exit;

/*
$today = date("Y-m-d H:i:s");
           $sql = "INSERT INTO $dbName.login (loginName,loginTime,userAddress,level)
                   VALUES ('$tempID','$today','$userAddress','$level')";
           mysql_query($sql) or die("Can't execute query 3.");
 */          
header("Location: home.php");
?>
