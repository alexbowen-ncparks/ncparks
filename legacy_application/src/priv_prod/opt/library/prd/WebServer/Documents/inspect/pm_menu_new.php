<?php
extract($_REQUEST);
session_start();
$level=@$_SESSION['inspect']['level'];
if($level<1)
	{
	ini_set('display_errors',1);
	extract($_REQUEST);
	$ftempID=$ti;
	$db="inspect";
	//echo "hello1";exit;
	$database="divper";
	include("../../include/iConnect.inc"); // new login method
	mysqli_select_db($connection,$database); // database 
	$sql = "SELECT emplist.*,position.posNum,position.posTitle, position.rcc, empinfo.tempID,empinfo.emid as femid,position.beacon_num
	FROM divper.emplist
	LEFT JOIN empinfo on emplist.emid=empinfo.emid
	LEFT JOIN position on position.beacon_num=emplist.beacon_num
	where empinfo.tempID='$ftempID'";

	//echo "$sql";exit;

	$result = mysqli_query($connection,$sql) or die("Error 1.0: $sql");
	$row=mysqli_fetch_assoc($result);
	if(mysqli_num_rows($result)>0)
		{extract($row);}
		else
		{echo "You must login.";exit;}
	$dbName="inspect";
	$dbLevel=$$dbName;
	
			  $_SESSION[$dbName]['level']= $dbLevel;
			  $_SESSION[$dbName]['select']= $currPark;
			  $_SESSION[$dbName]['tempID']= $tempID;
			 if($supervise!=""){$_SESSION[$dbName]['supervise'] = $supervise;}
			  $_SESSION['position']= $posTitle;
			  $_SESSION['beacon_num']= $beacon_num;
			   $_SESSION[$dbName]['accessPark'] = $accessPark;
			   $_SESSION['parkS'] = $currPark;
			  $_SESSION['logemid'] = $emid;
			  $_SESSION['centerS'] = "1280".$rcc;
//echo "<pre>"; print_r($_SESSION); echo "</pre>";  exit;

	$database="inspect";
	}
include("../css/TDnull.php");
?>