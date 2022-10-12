<?php
//print_r($_REQUEST);
session_start();
//print_r($_SESSION);EXIT;
// called from Secure Server login.php
include("../../include/connectROOT.inc");
extract($_REQUEST);

mysql_select_db('divper',$connection);
$sql = "SELECT $db as level,currPark,accessPark,emid FROM emplist WHERE emid = '$emid'";
$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
$num = @mysql_num_rows($result);
if($num<1){
$sql = "SELECT $db as level,currPark FROM nondpr WHERE tempID = '$tempID'";
$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
$num = @mysql_num_rows($result);
if($num<1){echo "Access denied";exit;}
}
$row=mysql_fetch_array($result);
//print_r($row);EXIT;
extract($row);
$_SESSION['dprcoe']['level'] = $level;
$_SESSION['dprcoe']['accessPark'] = $accessPark;
$_SESSION['dprcoe']['tempID'] = $tempID;

if($level==1){$level="PARK";}
if($level==2){$level="DIST";}
if($level==3){$level="ADMIN";}
if($level==4){$level="SUPERADMIN";}

$_SESSION['loginS'] = $level;
$_SESSION['dprcoe']['park'] = $currPark;
$_SESSION['dprcoe']['emid'] = $currPark;
$_SESSION['parkS'] = $currPark;
//print_r($_SESSION);EXIT;
header("Location: index.php");
?>
