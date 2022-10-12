<?php
//print_r($_REQUEST);
//print_r($_SESSION);EXIT;
// called from Secure Server login.php
$database="divper";
include("../../include/iConnect.inc");
mysqli_select_db($connection,$database);

$sql = "SELECT $db as level,emplist.currPark,empinfo.Nname, empinfo.Fname,empinfo.Lname,position.posTitle,position.program_code_reg
FROM emplist 
LEFT JOIN empinfo on empinfo.emid=emplist.emid
LEFT JOIN position on position.beacon_num=emplist.beacon_num
WHERE empinfo.tempID = '$tempID'";
$result = @mysqli_query($connection,$sql) or die();
$num = @mysqli_num_rows($result);
if($num<1)
	{
	  $sql = "SELECT $db as level, tempID,currPark FROM nondpr
					 WHERE tempID='$tempID'";
			 $result2 = mysqli_query($connection,$sql)
					   or die("Couldn't execute query.");
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
extract($row);
// $test_array=array("Crane9534","McGrath9695","Helms7976","Dillard6097");
// if($level<3 and !in_array($tempID, $test_array))
// 	{exit;}
session_start();
$_SESSION[$db]['level']=$level;
$_SESSION[$db]['loginS'] = $level;
$_SESSION[$db]['tempID'] = $tempID;
$_SESSION[$db]['parkS'] = $currPark;
if($Nname){$Fname=$Nname;}
$_SESSION[$db]['first']=$Fname;
$_SESSION[$db]['last']=$Lname;
$_SESSION[$db]['select']=$currPark;
$_SESSION[$db]['position']=$posTitle;
$_SESSION[$db]['sect_prog']=$program_code_reg;
/*
echo "<pre>";
print_r($_SESSION);
//print_r($_SERVER);
echo "</pre>";EXIT;
*/

header("Location: main.php");
?>
