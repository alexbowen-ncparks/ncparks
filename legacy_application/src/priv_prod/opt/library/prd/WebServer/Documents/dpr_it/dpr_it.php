<?php

/********************************************************************************
Name: John Carter             Related Ticket(s): 20220719-392
Date: 07/19/2022
Description:Bin submitted request to have REMO added to the IT app. Upon further investiation the location drop down is inconsistant within the app and inconsistant the other DPR Div apps and other databases that use the 4 letter code Director policy standard.

-- if applicable:
[Include files]
- login.php
- ../../include/auth.inc
- ../../include/iConnect.inc
- home.php

[Arrays created/used]  

[Databases accessed]
- emplist
- position
- empinfo
- nondpr
- dpr_it

---------------------------------------------------------------------------
                                Change Log
---------------------------------------------------------------------------
{youngest}
07/19/202 – [TIC<392>] : reformated lay out/beautified for easier reading and finding. updated error notice outputs to include file name and line numbers for easier referenceing and finding. 
MM/DD/YYYY – [TIC<#>] : <description of change>
{oldest}
******************************************************************************/
// 

$userAddress = $_SERVER['REMOTE_ADDR'];

// echo "u = $source";

// print_r($_REQUEST);

/*
	echo "<pre>";
	print_r($_SERVER);
	echo "</pre>";
	// exit;
*/

// called from Secure Server login.php
/*
	IF (empty($_SERVER['HTTP_COOKIE']))
	{
		exit;
	}
*/

date_default_timezone_set('America/New_York');

$database = "dpr_it"; 
$dbName = "dpr_it";

include("../../include/auth.inc");
include("../../include/iConnect.inc");

extract($_REQUEST);
mysqli_select_db($connection,"divper");

$sql1 = "SELECT $dbName AS level,
					emplist.tempID,
					t2.park_reg AS park,
					accessPark,
					t2.working_title_reg AS working_title,
					concat(t3.Fname,' ',t3.Mname,' ',t3.Lname) AS full_name,
					t2.beacon_num
			FROM emplist
				LEFT JOIN position AS t2
					ON t2.beacon_num = emplist.beacon_num
				LEFT JOIN empinfo AS t3
					ON t3.tempID = emplist.tempID
			WHERE emplist.emid = '$emid'
				AND emplist.tempID = '$tempID'
		";
$result = @mysqli_query($connection,$sql1)
			OR DIE ("<br >In File: " . __FILE__ . "<br >On Line: " . __LINE__ .  "<br >Error executing query sql1:". mysqli_errno($connection) . "<br > " . mysqli_error($connection) . "<br >$sql1<br >");
$num = @mysqli_num_rows($result);

IF ($num < 1)
{
   $sql2 = "SELECT $dbName AS level,
   					nondpr.currPark AS park,
   					nondpr.Fname,
   					nondpr.Lname
   			FROM nondpr
   			WHERE nondpr.tempID = '$tempID'
   		";
   $result = @mysqli_query($connection,$sql2)
   			OR DIE ("<br >In File: " . __FILE__ . "<br >On Line: " . __LINE__ . "<br >Error executing query sql2:". mysqli_errno($connection) . "<br >" . mysqli_error($connection) . "<br >$sql2<br >");
   $num = @mysqli_num_rows($result);
   
   IF ($num < 1)
   {
   	echo "Access denied";
   	exit;
   }
 }

$row = mysqli_fetch_array($result);

// print_r($row);
// EXIT;

extract($row);

$_SESSION[$dbName]['level'] = $level;
$_SESSION[$dbName]['tempID'] = $tempID;
$_SESSION[$dbName]['select'] = $park;
$_SESSION[$dbName]['accessPark'] = $accessPark;
$_SESSION[$dbName]['working_title'] = $working_title;
$_SESSION[$dbName]['full_name'] = $full_name;
$_SESSION[$dbName]['beacon_num'] = $beacon_num;

/* 
	$today = date("Y-m-d H:i:s");
   
   $sql3 = "INSERT INTO $dbName.login (loginName,
   												loginTime,
   												userAddress,
   												level)
         	VALUES ('$tempID',
         				'$today',
         				'$userAddress',
         				'$level')
         ";
   mysqli_query($connection,$sql3)
   OR DIE ("<br >In File: " . __FILE__ . "<br >On Line: " . __LINE__ . "<br >Can't execute query sql3:<br > $sql<br >");
*/

header("Location: home.php");

?>
