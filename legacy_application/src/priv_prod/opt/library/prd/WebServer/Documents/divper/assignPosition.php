<?php
ini_set('display_errors',1);
// ***********Find person form****************
//These are placed outside of the webserver directory for security
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);

//include("menu.php");

extract($_REQUEST);
if(!isset($Lname)){$Lname="";}

// ********** Find by Emid ***********
if(@$emid)
	{
	// First find all vacant positions and fill an array
	$sql = "SELECT beacon_num From position ORDER by beacon_num";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$posArray=array();
	while ($row=mysqli_fetch_array($result))
		{
		extract($row);
		$posArray[]=$beacon_num;
		}
	
	$sql = "SELECT beacon_num From emplist ORDER by beacon_num";
	//echo "$sql";exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$empArray=array();
	while ($row=mysqli_fetch_array($result))
		{
		extract($row);
		$empArray[]=$beacon_num;
		}
	for($i=0;$i<count($posArray);$i++)
		{
		if(!in_array($posArray[$i],$empArray))
			{
			$sql = "SELECT park,posTitle,beacon_num From position where beacon_num=$posArray[$i]";
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
			$row=mysqli_fetch_array($result);extract($row);
			//$vacantArray[]=$posArray[$i]."~".$park."~".$beacon_num;
			$vacantArray[]=$posArray[$i]."~".$park;
			$titleArray[]=$posArray[$i]." - ".$posTitle." ($park)";
			}// end !in_array
		}// end for
	
	// Next setup form to add a person to a position
	$sql = "SELECT empinfo.Nname, empinfo.Fname, empinfo.Lname, empinfo.emid, empinfo.ssn3,empinfo.tempID
	FROM empinfo WHERE empinfo.emid='$emid'";
	//echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_array($result);
	extract($row);
	echo "<html><head><title>Enter Position Info</title>
	<STYLE TYPE=\"text/css\">
	<!--
	body
	{font-family:sans-serif;background:beige}
	td
	{font-size:90%;background:beige}
	th
	{font-size:95%;vertical-align:bottom;color:green}
	--> 
	</STYLE></head>
	<body><font size='4' color='004400'>NC State Parks System Permanent Payroll</font>";
	echo "
	<table><tr><td><font size='3' color='blue'>Employee Position Info
	</font></td></tr>
	</table><table><tr><td><form method='post' action='assignPerson.php'></td></tr>
	<tr><td>$Fname $Lname</td><td>
	<select name=\"posNum\">
			  <option selected>Pick a Vacant Position</option>";
	for($i=0;$i<count($vacantArray);$i++){
			 echo "<option value=\"$vacantArray[$i]\">$titleArray[$i]</option>\n";
			}
			echo "</select></td><td>
	<input type='hidden' name='tempID' value='$tempID'>
	<input type='hidden' name='park' value='$park'>
	<input type='hidden' name='emid' value='$emid'>
	<input type='submit' name='submit' value='Assign Person'></form></td></tr></table></body></html>";
	exit;
	}

// ********** Find by Last Name *************
if(@$Lname !="")
	{
//	$Lname=addslashes($Lname);
	$sql = "SELECT empinfo.Nname, empinfo.Fname, empinfo.Lname, empinfo.emid, emplist.currPark, empinfo.tempID, empinfo.ssn3, emplist.jobtitle,position.posTitle
	FROM empinfo
	LEFT  JOIN emplist ON emplist.tempID = empinfo.tempID
	LEFT  JOIN position ON emplist.posNum = position.posNum
	WHERE empinfo.Lname
	LIKE  '$Lname%'
	ORDER  BY tempID";
// 	echo "$sql";
	
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$count=mysqli_num_rows($result);
	if($count==1)
		{
		$row=mysqli_fetch_array($result);extract($row);
		
		header("Location: assignPosition.php?submit=Find&emid=$emid");
		exit;
		}
	echo "<html><head><title>Enter Emp Info</title>
	<STYLE TYPE=\"text/css\">
	<!--
	body
	{font-family:sans-serif;background:beige}
	td
	{font-size:90%;background:beige}
	th
	{font-size:95%;vertical-align:bottom}
	--> 
	</STYLE></head><body><table><tr><th colspan='6' align='left'>List of Permanent Employees with Last Name beginning with $Lname</th></tr>
	<tr><th></th><th>Name</th><th>Last 4 SSN digits</th><th></th></tr>";
	$z=1;
	while ($row=mysqli_fetch_array($result))
		{
		//echo "<pre>";print_r($row);echo "</pre>";  exit;
		extract($row);
		if($tempID)
			{
			if($Nname){$NN="($Nname)";}else{$NN="";}
			echo "<tr><td align='right'>$z - </td><td>$Lname, $Fname $NN</td><td align='center'>$ssn3</td><td> </td><td>$posTitle</td>
			<td><a href='assignPosition.php?submit=Find&emid=$emid&p=y'>Select this person</a></td>
			</tr>";
			$z++;
			}
			else
			{
			echo "<tr><td colspan='6'><b>$Fname $Lname</b> is in the master database but is not associated with any Park/Duty Station.</td></tr>";
			} //  end else for IF $tempID
		} //  end while
	exit;
	}

//***************Form********************

include("menu.php");

echo "<table><tr><th colspan='3'>Find Employee to Assign a Position</th></tr>
<form action='assignPosition.php' method='post'>
<tr><td align='right'><b>Person's Last Name</b></td>
     <td><input type='text' name='Lname' 
               value='$Lname' size='25' maxlength='35'></td></tr>";
             
echo "<tr><td><input type='submit' name='submit' value='Submit'></td></tr>";
echo "</table></body></html>";
?>