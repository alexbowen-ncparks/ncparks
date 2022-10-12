<?php
 $userAddress = $_SERVER['REMOTE_ADDR']; //echo"u=$source"; 

//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  exit;

// called from Secure Server login.php
//if(empty($_SERVER['HTTP_COOKIE'])){exit;}

date_default_timezone_set('America/New_York');
$database="donation"; 
$dbName="donation";
include("../../include/auth.inc");
include("../../include/iConnect.inc");

include("../include/salt.inc"); // salt phrase

extract($_REQUEST);

$ck=md5($salt.$emid);


mysqli_select_db($connection,"divper");
$sql = "SELECT $dbName as level,emplist.tempID,emplist.currPark,accessPark,t2.working_title, concat(t3.Fname,' ',t3.Mname,' ',t3.Lname) as full_name, IF(t3.Nname!='',t3.Nname,t3.Fname) as Fname, t3.Lname, t2.beacon_num, t2.code as position_code, t3.emid as emid_empinfo
FROM emplist 
LEFT JOIN position as t2 on t2.beacon_num=emplist.beacon_num
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

if(isset($emid_empinfo))
{
$ck_emid=md5($salt.$emid_empinfo);
if($ck!=$ck_emid){echo "No access."; exit;}
}

$_SESSION[$dbName]['level'] = $level;
$_SESSION[$dbName]['tempID'] = $tempID;
$_SESSION[$dbName]['select'] = $currPark;
$_SESSION[$dbName]['accessPark'] = $accessPark;
$_SESSION[$dbName]['working_title'] = $working_title;
$_SESSION[$dbName]['full_name'] = $full_name;
$_SESSION[$dbName]['beacon_num'] = $beacon_num;
$_SESSION[$dbName]['emid'] = $emid;

$log_name=$row['Fname']." ".$row['Lname'];
$_SESSION[$dbName]['log_name']=$log_name;

$today = date("Y-m-d H:i:s");
           $sql = "INSERT INTO $dbName.login (loginName,loginTime,userAddress,level)
                   VALUES ('$tempID','$today','$userAddress','$level')";
           mysqli_query($connection,$sql) or die("Can't execute query 3.");
           
header("Location: form.php");
?>
