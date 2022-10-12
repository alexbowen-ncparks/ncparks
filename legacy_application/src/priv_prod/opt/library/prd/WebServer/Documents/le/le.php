<?php
//print_r($_REQUEST);
//print_r($_SESSION);EXIT;
extract($_REQUEST);
session_start();

// called from Secure Server login.php
$db="le";
$database="divper";
include("../../include/iConnect.inc");
$database="divper";
mysqli_select_db($connection,$database);
$sql = "SELECT $db as level,emplist.tempID,emplist.posNum,t2.beacon_num, accessPark, t2.park, t2.beacon_title as title
FROM emplist
LEFT JOIN position as t2 on t2.beacon_num=emplist.beacon_num
WHERE emid = '$emid'"; 
// echo "$sql"; exit;
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
$num = @mysqli_num_rows($result);
if($num<1)
	{
	$sql = "SELECT $db as level,nondpr.currPark,nondpr.Fname,nondpr.Lname
	FROM nondpr 
	WHERE nondpr.tempID = '$tempID'";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$num = @mysqli_num_rows($result);
	if($num<1)
		{
		// Temporary bypass to allow Jay Greenwood (SODI DISU) to act for NODI will that DISU is vacant
		// 
		 if($emid=="79")
			{
			//echo "Hello"; exit;
			$tempID="Cook4712";
			$level=2;
			$title="Law Enforcement Manager";
			$currPark="NODI";
	
			$emid="79";
			$accessPark="";
			$posTitle="Parks District Superintendent";
			$posNum="09438";
			$rcc="2901";
			$file="";
			$supervise="";
			$beacon_num="60033104";
			}
			else
			{
			echo "Access denied";exit;
			}
		}
	}
$row=mysqli_fetch_array($result);
//echo "$sql<pre>"; print_r($row); echo "</pre>";  exit;
extract($row);

if($level<1)
	{
	echo "You do not have access.";  exit;
	}
	
$_SESSION[$db]['level'] = $level;
$_SESSION[$db]['tempID'] = $tempID;
$_SESSION[$db]['beacon'] = $beacon_num;
// $_SESSION[$db]['select'] = $currPark;
$_SESSION[$db]['select'] = $park;
$_SESSION[$db]['accessPark'] = $accessPark;
$_SESSION[$db]['beacon_title'] = $title;

// echo "t=$title<pre>"; print_r($_SESSION); echo "</pre>";  exit;

if($level==1 and (strpos($title,"Law")>-1 or strpos($title,"Park Ranger")>-1))
	{
	header("Location: start_le.php");  exit;
	}
if($level==1)
	{
	header("Location: pr63_home.php");  exit;
	}
if($level==2)
	{
	header("Location: level.php"); exit;
	}
if($level>2)
	{
	header("Location: level.php");  exit;
	}
           

//print_r($_SESSION);EXIT;
?>
