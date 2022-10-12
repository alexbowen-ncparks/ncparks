<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo "game_document=$game_document";
$game_document2=addslashes($game_document);
//echo "game_document2=$game_document2";exit;

$query1="update gameday set game_document='$game_document2' where gid='$gid'";
		
//echo "query1=$query1";exit;
$result1=mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");


header("location: /budget/games/gameday.php?comment=y&add_comment=y&folder=community&gid=$gid");

 
 ?>




















