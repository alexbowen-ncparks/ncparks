<?php
//print_r($_REQUEST);
//print_r($_SESSION);EXIT;
// called from Secure Server login.php
//if(empty($_SERVER['HTTP_COOKIE'])){exit;}

include("../../include/iConnect.inc");

mysqli_select_db($connection,'divper');
extract($_REQUEST);

//$sql = "SELECT $db as level,tempID FROM emplist WHERE emid = '$emid'";  exit;
if($db==''){$db=$db2;}


$sql = "SELECT $db as 'level',t1.currPark,t2.Nname,t2.Fname,t2.Lname,t3.posTitle,t2.tempID,accessPark, t3.beacon_num,t3.rcc,t2.emid as ck_emid
FROM divper.emplist as t1
LEFT JOIN divper.empinfo as t2 on t2.emid=t1.emid
LEFT JOIN divper.position as t3 on t3.beacon_num=t1.beacon_num
WHERE t1.emid = '$emid'";

//echo "<br />sql=$sql<br />"; exit;


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
$_SESSION[$db]['tempID'] = $tempID;
$_SESSION[$db]['beacon_num'] = $beacon_num;
$_SESSION[$db]['select'] = $currPark;

//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";  exit;

header("Location: conference_list.php");

/*
if(@$forumID)
	{
	header("Location: forum.php?forumID=$forumID&submit=Go");
	}
	else
	{
	header("Location: forum.php");
	}
*/
?>
