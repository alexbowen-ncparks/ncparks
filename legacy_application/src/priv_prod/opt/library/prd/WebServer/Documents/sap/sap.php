<?php
//print_r($_REQUEST);
//print_r($_SESSION);EXIT;
// called from Secure Server login.php

$database="divper";
include("../../include/iConnect.inc"); // new login method
mysqli_select_db($connection,$database); // database 

extract($_REQUEST);
$sql = "SELECT $db as level,emplist.currPark,empinfo.Nname,empinfo.Fname,empinfo.Lname, emplist.accessPark
FROM emplist 
LEFT JOIN empinfo on empinfo.emid=emplist.emid
WHERE empinfo.tempID = '$tempID'";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
$num = @mysqli_num_rows($result);
if($num<1)
	{
	  $sql = "SELECT $db as level, tempID,currPark FROM nondpr
					 WHERE tempID='$tempID'";
			 $result2 = mysqli_query($connection,$sql)
					   or die("Couldn't execute query. 22 $database");
					$row = mysqli_fetch_array($result2);
			 $num2 = mysqli_num_rows($result2);
			 extract($row);
		 if($num2<1)
			{
			echo "Access denied $sql";exit;
			}
	}
$row=mysqli_fetch_array($result);
//print_r($row);EXIT;
session_start();
extract($row);
$_SESSION[$db]['level']=$level;
$_SESSION[$db]['loginS'] = $level;
$_SESSION[$db]['tempID'] = $tempID;
//$_SESSION['loginS'] = $level;
$_SESSION[$db]['parkS'] = $currPark;
if($Nname){$Fname=$Nname;}
$_SESSION[$db]['first']=$Fname;
$_SESSION[$db]['last']=$Lname;
$_SESSION[$db]['select']=$currPark;
$_SESSION[$db]['accessPark']=$accessPark;
/*
echo "<pre>";
print_r($_SESSION);
//print_r($_SERVER);
echo "</pre>";EXIT;
*/

mysqli_select_db($connection,'sap'); // database 
$sql = "Insert into login set loginName='$tempID', loginTime=NOW(), level='$level'";
//echo "$sql";exit;
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

mysqli_close($connection);
header("Location: index.php");
?>
