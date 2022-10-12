<?php
ini_set('display_errors',1);
$database="mar";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/connectROOT.inc"); // used to authenticate users

include_once("../../include/get_parkcodes.php");
mysql_select_db($database,$connection);
date_default_timezone_set('America/New_York');
include_once("menu.php");

$checkPark=$_SESSION['mar']['select'];
$positionTitle=$_SESSION['mar']['position'];
$marLevel=$_SESSION['mar']['level'];

//echo "<pre>";print_r($_SESSION);echo "</pre>"; exit;

$canAdd="";

extract($_REQUEST);

$findme="Office Assistant";
$x=strpos($positionTitle,$findme);
if($x>-1)
	{
	$text="array".$checkPark;
	@$distArray=${$text};
	if(@in_array($park,$distArray))
		{
		$canAdd="1";
		}// District Office check
	else
		{// Park check
		if($checkPark==$park)
			{$canAdd="1";}
		else
			{
			$canAdd="";
			if($checkPark=="FOMA" AND $park=="THRO"){$canAdd="1";}
			}// end else1
		}// end else0
	}
$findme="Park ";
$x=strpos($positionTitle,$findme);
$findme="Administrative ";// //HARI administrative assistant
$y=strpos($positionTitle,$findme);
if($x>-1 OR $y>-1)
	{
	$text="array".$checkPark;
	@$distArray=${$text};
	if(@in_array($park,$distArray))
		{$canAdd="1";}// District Office check
		else
		{// Park check
		if($checkPark==$park)
			{$canAdd="1";}
			else
			{
			$canAdd="";
			}
		}
	}

if($marLevel==2)
	{
	if($x>-1 AND $checkPark=="YORK" AND $section=="con"){$canAdd="1";}
	}

if($marLevel>2){$canAdd="1";}

if($canAdd==""){echo "You do not have an access level that allows for that action. If you need the ability to add a record to the MAR outside your Park or District, contact Tom Howard at tom.howard@ncmail.net and request a new access level.";
exit;}

if (@$section == "") {echo "Click your BACK button and select a SECTION before submitting a report."; exit;}

if (@$title == "") {echo "Click your BACK button and enter a TITLE before submitting a report."; exit;}

if (@$body == "") {echo "Click your BACK button and enter the BODY text before submitting a report."; exit;}

if (@$month == "") {echo "Click your BACK button and enter the MONTH before submitting a report."; exit;}

if (@$day == "") {echo "Click your BACK button and enter the DAY before submitting a report."; exit;}

echo "<html>
<head>
<title>MAR - New Record</title>
</head>
<body>";

$park = strtoupper($park);

$dateNow=date("Y-m-d");
$newdate = date ("Y-m-d", mktime(0,0,0,$month,$day,$year));

if($newdate>$dateNow){echo "You cannot enter a report for a date greater than today.";exit;}

$week = date ("W", mktime(0,0,0,$month,$day,$year));

list($todayYear,$todayMonth,$todayDay)=explode("-",$dateNow);
$thisWeek = date ("W", mktime(0,0,0,$todayMonth,$todayDay,$todayYear));

if ($park == "")
	{
	$dist = " ";
	$park = " ";
	}
else
	{
	$dist=$district[$park];
	}
	
$empID=$_SESSION['mar']['tempID'];
$section=strtoupper($section);
$title=addslashes($title);
$body=addslashes($body);
$query = "INSERT INTO report (section, dist, park, date, enter_by, title, body, week,empID,dateEntered,weekentered) VALUES ('$section', '$dist', '$park', '$newdate', '$enter_by', '$title', '$body', '$week','$empID','$dateNow','$thisWeek')";
//echo "$query";exit;
$result = mysql_query($query) or die ("Couldn't execute query. $query");

$text = substr($body, 0, 75);
echo "New Record Added to database.";
echo "<br><br><h3>$title</h3>";
echo "$text ....<br /><br />";
?> 
<p><a href="mar_new.php">ENTER</a> another RECORD.</p>
<p><a href="index.php">VIEW</a> previously entered RECORDS.</p>

</body>
</html>
