<?php
// print_r($_REQUEST); exit;
// called from Secure Server login.php
$database="photos";
include("../../include/iConnect.inc");
extract($_REQUEST);
session_start();
//print_r($_SESSION);EXIT;

mysqli_select_db($connection,'divper');
$sql = "SELECT $db as level, t1.currPark, t1.tempID, t2.Fname, t2.Lname 
FROM emplist as t1
left join empinfo as t2 on t1.emid=t2.emid
WHERE t1.emid = '$emid' and t1.tempID='$tempID'";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
$num = @mysqli_num_rows($result);
if($num<1)
	{
	$sql = "SELECT $db as level,nondpr.currPark,nondpr.Fname,nondpr.Lname, nondpr.tempID
	FROM nondpr
	WHERE nondpr.tempID = '$tempID'";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$num = @mysqli_num_rows($result);
	if($num<1){echo "Access denied";exit;}
	}
$db="photos";
$row=mysqli_fetch_array($result);
//print_r($row);EXIT;
extract($row);
$_SESSION[$db]['level'] = $level;
if($level==1){$level="PARK";}
if($level==2){$level="DIST";}
if($level==3){$level="ADMIN";}
if($level==4){$level="SUPERADMIN";}
$_SESSION[$db]['loginS'] = $level;
$_SESSION[$db]['tempID'] = $tempID;
$_SESSION[$db]['name'] = $Lname.", ".$Fname;
$_SESSION['loginS'] = $level;
$_SESSION['parkS'] = $currPark;
//print_r($_SESSION);EXIT;

// mysqli_select_db($connection,$db);
// $us=$_SERVER['REMOTE_ADDR'];
// $sql="INSERT INTO login set loginTime=NOW(), userAddress='$us', loginName='$tempID', level='$level'"; //echo "$sql";exit;
// $result = mysqli_query($sql,$connection) or die ("Couldn't execute select query. $sql c=$connection");

header("Location: index.php");
?>
