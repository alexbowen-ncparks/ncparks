<?php
//print_r($_REQUEST);
//print_r($_SESSION);EXIT;
// called from Secure Server login.php
$database="divper";
include("../../include/connectROOT.inc");
mysql_select_db($database,$connection);

extract($_REQUEST);
$sql = "SELECT $db as level,emplist.currPark,empinfo.Nname, empinfo.Fname,empinfo.Lname,position.posTitle,emplist.itinerary
FROM emplist 
LEFT JOIN empinfo on empinfo.emid=emplist.emid
LEFT JOIN position on position.beacon_num=emplist.beacon_num
WHERE empinfo.tempID = '$tempID'";
$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
$num = @mysql_num_rows($result);
if($num<1)
	{
	  $sql = "SELECT $db as level, tempID,currPark FROM nondpr
					 WHERE tempID='$tempID'";
			 $result2 = mysql_query($sql)
					   or die("Couldn't execute query.");
					$row = mysql_fetch_array($result2);
			 $num2 = mysql_num_rows($result2);
			 extract($row);
		if($num2<1)
		{
		echo "Access denied $sql";exit;
		}
	}
$row=mysql_fetch_array($result);
//print_r($row);EXIT;
extract($row);
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
$_SESSION[$db]['sect_prog']=$itinerary;
/*
echo "<pre>";
print_r($_SESSION);
//print_r($_SERVER);
echo "</pre>";EXIT;
*/

header("Location: index.php");
?>
