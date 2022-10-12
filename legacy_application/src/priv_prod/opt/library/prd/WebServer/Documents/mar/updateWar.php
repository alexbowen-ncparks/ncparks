<?php
ini_set('display_errors',1);
$database="war";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/connectROOT.inc"); 
include_once("../../include/get_parkcodes.php");
mysql_select_db($database,$connection);
date_default_timezone_set('America/New_York');
extract($_REQUEST);
include("menu.php");
echo "<html>
<head>
<title>WAR - Edit/Delete Record</title>
</head>
<body>";


/* Use the INCLUDE statement to both CONNECT and SELECT the correct database*/
include ("include/connectWar.inc");

if(strchr($submit,"Save"))
	{	
	$park = strtoupper($park);
	
	/* Use the INCLUDE statement to automatically add correct District given a PARK*/
	include ("dist.inc");
	
	$newdate = date ("Y-m-d", mktime(0,0,0,$month,$day,$year));
	$week = date ("W", mktime(0,0,0,$month,$day,$year));
	
	if ($park == "")
		{
		$dist = " ";
		$park = " ";
		}
	
	$empID=$_SESSION['war']['tempID'];
	$section=strtoupper($section);
	$title=addslashes($title);
	$body=addslashes($body);
	if(!isset($sectApprov)){$sectApprov="";}
	if(!isset($direApprov)){$direApprov="";}
	if(!isset($distApprov)){$distApprov="";}
	$query = "UPDATE report SET section='$section', dist='$dist', park='$park', date='$newdate', enter_by='$enter_by', title='$title', body='$body', week='$week',distApprov='$distApprov',sectApprov='$sectApprov',direApprov='$direApprov',empID=concat('$empID',empID) WHERE id='$id'";
	//echo "$query";exit;
	$result = mysql_query($query) or die ("Couldn't execute query.<br>$query");
	
	//$m = "Record Updated.";
	header("Location: update.php?id=$id&m=1&thisWeek=$thisWeek&section=$section");
	}
ELSE if(strchr($submit,"Delete"))
{
$query = "DELETE from report WHERE id='$id'";

//echo "$query";exit;
$result = mysql_query($query) or die ("Couldn't execute query.");
header("Location: update.php?id=$id&m=2&thisWeek=$thisWeek&section=$section");
}
?> 

