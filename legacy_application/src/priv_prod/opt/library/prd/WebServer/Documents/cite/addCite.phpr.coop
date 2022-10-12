<?php
/*
Because of a problem with pulldown menus not sending the hidden value, but sending the shown value when trying to update, I make both the hidden and the sent the same value . 3-Mar and 3-Mar for example. For the date and charge the fields are not capable of handling text and the extra stuff is ignored. For loc_code only the first 4 chars are entered, the rest is ignored. The only field needing parsing is empID.
*/
$database="cite";
// include("../../include/auth.inc"); // used to authenticate users
include_once("menu.php");
session_start();
// ECHO "<pre>test";print_r($_SESSION);echo "</pre>";// exit;
// ECHO "<pre>";print_r($_REQUEST);echo "</pre>";  //exit;

// Construct Query to be passed back to Input form if necessary
foreach($_REQUEST as $k => $v)
	{
	if($v and $k!="PHPSESSID")
		{@$varQuery.=$k."=".addslashes($v)."&";}
	}
//echo "$varQuery";

$checkPark=$_SESSION['cite']['parkS'];
$positionTitle=$_SESSION['cite']['position'];
$CITELevel=$_SESSION['cite']['level'];

extract($_REQUEST);

$canAdd="";

$findme="Park Ranger";
$x=strpos($positionTitle,$findme); //echo "$positionTitle $x";
if($x>-1)
	{
	include("../../include/get_parkcodes_dist.php");
// 	echo "<pre>"; print_r($district); echo "</pre>"; // exit;
	$text="array".$district[$checkPark];
	$distArray=${$text};
// 	echo "$text<pre>"; print_r($distArray); echo "</pre>";  exit;
	if(in_array($park,$distArray))
		{$canAdd="1";}// District Office check
	else
		{// Park check
		if($checkPark==$park)
			{$canAdd="1";}
			else
			{
			$multiPark1=array("MOJE","NERI");
			$multiPark2=array("JONE","SILA");
			$multiPark3=array("CABE","FOFI");
			$multiPark4=array("GRMO","YEMO");
			$canAdd="";
			if(in_array($park,$multiPark1)){$canAdd="1";}// Multi Park check
			if(in_array($park,$multiPark2)){$canAdd="1";}// Multi Park check
			if(in_array($park,$multiPark3)){$canAdd="1";}// Multi Park check
			if(in_array($park,$multiPark4)){$canAdd="1";}// Multi Park check
			}
		}
	//echo "x=$x c=$checkPark p=$park";exit;
	}

$findme="Park Superintendent";
$x=strpos($positionTitle,$findme);
if($x>-1)
	{
	include("../../include/get_parkcodes_dist.php");
	$text="array".$checkPark; $distArray=${$text};
	if(in_array($park,$distArray))
		{$canAdd="1";}// District Office check
		else
		{// Park check
		if($checkPark==$park)
			{$canAdd="1";}
		else
			{
			$multiPark1=array("MOJE","NERI");
			$multiPark2=array("JONE","SILA");
			$multiPark3=array("CABE","FOFI");
			$multiPark4=array("JORD","DERI");
			$canAdd="";
			if(in_array($park,$multiPark1)){$canAdd="1";}// Multi Park check
			if(in_array($park,$multiPark2)){$canAdd="1";}// Multi Park check
			if(in_array($park,$multiPark3)){$canAdd="1";}// Multi Park check
			if(in_array($park,$multiPark4)){$canAdd="1";}// Multi Park check
			}
		}
	}
//echo "c=$checkPark p=$park"; exit;

$findme="Law Enforcement Officer";
$x=strpos($positionTitle,$findme);
if($x>-1){
include("../../include/get_parkcodes_dist.php");
if($checkPark==$park){$canAdd="1";}
}

$findme="Office Assistant";
$x=strpos($positionTitle,$findme);
if($x>-1){
include("../../include/get_parkcodes_dist.php");
if($checkPark==$park){$canAdd="1";}
}


//echo "<br />park=$park  ch=$checkPark<br />c=$canAdd";
//exit;

if($CITELevel>2){$canAdd="1";}

if($canAdd==""){echo "<br>You do not have an access level that allows for that action. If you need the ability to add a record to the CITE, contact Tom Howard at tom.howard@ncmail.net and request a new access level. $CITELevel";
exit;}

if ($citation == "") {$varQuery.="&message=A CITATION NUMBER must be entered before submitting a report."; 
header("Location:cite_new.php?$varQuery");exit;}

if ($month == "") {$varQuery.="&message=The MONTH must be entered before submitting a report."; header("Location:cite_new.php?$varQuery");exit;}

if ($day == "") {$varQuery.="&message=The DAY must be entered before submitting a report."; header("Location:cite_new.php?$varQuery");exit;}

if ($empID == "" AND $overOfficer=="") {$varQuery.="&message=The OFFICER must be entered before submitting a report."; header("Location:cite_new.php?$varQuery");exit;}

if(@$voidCITE=="")
	{
	if ($loc_code == "") {$varQuery.="&message=The LOCATION must be entered before before submitting a report."; header("Location:cite_new.php?$varQuery");exit;}
	
	if ($violator == "") {$varQuery.="&message=The VIOLATOR'S NAME must be entered before submitting a report."; header("Location:cite_new.php?$varQuery");exit;}
	
	if ($sex == "") {$varQuery.="&message=The VIOLATOR'S SEX must be entered before submitting a report."; header("Location:cite_new.php?$varQuery");exit;}
	
	if ($race == "") {$varQuery.="&message=The VIOLATOR'S RACE before submitting a report."; header("Location:cite_new.php?$varQuery");exit;}
	
	if ($charge1 == "") {$varQuery.="&message=The PRIMARY VIOLATION must be entered before submitting a report."; header("Location:cite_new.php?$varQuery");exit;}
	
	if (($charge1 == "32-Other - Write it in."||$charge1 == "54-Other Park Rules Violation - Write it in.") and $charge1_other=="") {//Other - Write it in.
	$varQuery.="&message=The type of \"Other\" for the PRIMARY VIOLATION must be entered before submitting a report."; header("Location:cite_new.php?$varQuery");exit;}
	
	if (($charge2 == "32-Other - Write it in."||$charge2 == "54-Other Park Rules Violation - Write it in.") and $charge2_other=="") {//Other Park Rules Violation - Write it in.
	$varQuery.="&message=The type of \"Other\" for the SECONDARY VIOLATION must be entered before submitting a report."; header("Location:cite_new.php?$varQuery");exit;}
	
	}// end $voidCITE==""

/* Use the INCLUDE statement to both CONNECT and SELECT the correct database*/
$database="cite";
 include ("../../include/iConnect.inc");

$park = strtoupper($park);

/* Use the INCLUDE statement to automatically add correct District given a PARK*/
//   include ("dist.inc");   no longer used - out of date

// get District
mysqli_select_db($connection,"dpr_system");
$query = "SELECT park_code,district FROM parkcode_names_district";
$result = mysqli_query($connection,$query) or die ("<br><br>Couldn't execute query. $query ".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$dist_array[$row['park_code']]=$row['district'];
	}

// get Region
// $query = "SELECT park_code,region FROM parkcode_names_region";
// $result = mysqli_query($connection,$query) or die ("<br><br>Couldn't execute query. $query ".mysqli_error($connection));
// while($row=mysqli_fetch_assoc($result))
// 	{
// 	$region_array[$row['park_code']]=$row['region'];
// 	}
		
//$dateNow=date(Ymd);
$var_month=explode("-",$month);
$newdate = date ("Y-m-d", mktime(0,0,0,$var_month[0],$day,$year));
//echo "n=$newdate";exit;

//if($newdate>$dateNow){echo "You cannot enter a report for a date greater than today.";exit;}

if($park == "")
	{
	$dist = " ";
	$region = " ";
	$park = " ";
	}

// echo "<pre>"; print_r($region_array); echo "</pre>";  exit;
$dist=$dist_array[$park];  
$region=$region_array[$park];


//$empID=$_SESSION[cite][tempID];
$violator=addslashes($violator);
$empID=explode("-",$empID);
$empID=$empID[0];
$charge1_other=addslashes($charge1_other);
$charge2_other=addslashes($charge2_other);
$disposition1_other=addslashes($disposition1_other);
$disposition2_other=addslashes($disposition2_other);

if(@$overOfficer){$empID=$overOfficer;}
if(@$voidCITE)
	{
	$void1f=" ,void";
	$void1v=" ,'x'";
	$void2f=" ,void";
	$void2v=" ,'x'";
	}

if(!isset($void1v)){$void1v="";}
if(!isset($void1f)){$void1f="";}
$database="cite";
mysqli_select_db($connection,$database);
$query = "INSERT INTO
report (citation, dist, park, loc_code,`date`, enter_by, violator, charge,  disposition, empID,sex,race,disposition_other, charge_other $void1f)
VALUES ('$citation', '$dist', '$park', '$loc_code','$newdate', '$enter_by', '$violator', '$charge1','$disposition1','$empID','$sex','$race','$disposition1_other','$charge1_other' $void1v)";
// echo "$query";exit;
$result = mysqli_query($connection,$query) or die ("<br><br>Couldn't execute query. $query ".mysqli_error($connection));

if($charge2)
	{
	if(!isset($void2f)){$void2f="";}
	if(!isset($void2v)){$void2v="";}
	$query = "INSERT INTO
	report (citation, dist, park, loc_code,`date`, enter_by, violator,charge, disposition,empID,sex,race,disposition_other, charge_other $void2f)
	VALUES ('$citation', '$dist', '$park', '$loc_code','$newdate', '$enter_by', '$violator','$charge2', '$disposition2','$empID','$sex','$race','$disposition2_other','$charge2_other' $void2v)";
	//echo "$query";//exit;
	$result = mysqli_query($connection,$query) or die ("<br><br>Couldn't execute query. $query");
	}
//exit;
header("Location:find.php?citation=$citation&editRecord=yes");
?> 
