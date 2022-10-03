<?php
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');

//echo "<pre>"; print_r($_REQUEST); echo "</pre>";
$db="photos";
$database=$db;

include("../../include/auth.inc"); // includes session_start();

$title="The ID";
include("../_base_top.php"); // includes session_start();

//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;

include("../../include/connectROOT.inc");  //sets $database
include("../../include/get_parkcodes.php");

$db = mysql_select_db($database,$connection) or die ("Couldn't select database");

extract($_REQUEST);

// used to pass full Group for Leps, Odes, etc.
$group = $majorGroup;

if(@$e==1)
	{
	//print_r($_SESSION);
	$formX = "edit.php?pid=$pid"; $word="Change";
	$nridFile = "listTest.php?e=1";
	$nridFileColumn = "listTest.php";
	}
else
	{
	$formX = "store.php";$word="Add";
	$nridFile = "listTest.php";
	$nridFileColumn = "listTest.php";
	}

if(@$e==2)
	{
	$formX = "video.php";$word="Add";
	$nridFile = "listTest.php";
	$nridFileColumn = "listTest.php";
	if(!empty($pid))
		{	
		$formX = "video_edit.php?pid=$pid";$word="Update Video Link";
		$nridFile = "listTest.php?e=1";
		$nridFileColumn = "listTest.php";
		}
	}
	
switch ($majorGroup)
	{
	case $majorGroup == "INSECT-BEETLE":
	$majorGroup = "INSECT";
	break;
	case $majorGroup == "INSECT-BUTTERFLY":
	$_SESSION['mg']=$majorGroup;
	 $majorGroup = "INSECT";
	break;
	case $majorGroup == "INSECT-ODONATES":
	$majorGroup = "INSECT";
	break;
	case $majorGroup == "INSECT-MOTH":
	 $majorGroup = "INSECT";
	break;
	default:
	$majorGroupPrint = "$majorGroup";
	}

//echo "$group $all"; //for testing
if (@$family != "" OR @$sciName !="" OR @$comName !="" OR @$all !="")
	{

$db = mysql_select_db('nrid',$connection) or die ("Couldn't select database");

	if (@$sort == ""){$sort = "family,sciName";}
	
	if (@$all !="")
		{
		
		$where = "WHERE majorGroup = '$group'";
		$sql = "SELECT family,sciName,comName,synonym FROM nrid.dprspp $where ORDER by $sort";
		$findO = "majorGroup=$majorGroup&park=$park&all=1&e=1&pid=$pid&sort=";

	if(!isset($offset)){$offset="";}
		$findS = "majorGroup=$majorGroup&park=$park&all=1&e=1&pid=$pid&sort=sciName&offset=$offset";
		$findC = "majorGroup=$majorGroup&park=$park&all=1&e=1&pid=$pid&sort=comName";
		}
	ELSE
		{
		$where = "WHERE majorGroup = '$group'";
		$sql = "SELECT family,sciName,comName,synonym  FROM nrid.dprspp $where ORDER by $sort";
		$findO = "majorGroup=$majorGroup&park=$park&all=1&e=1&pid=$pid&sort=";
		$findS = "majorGroup=$majorGroup&park=$park&all=1&e=1&pid=$pid&sort=sciName";
		$findC = "majorGroup=$majorGroup&park=$park&all=1&e=1&pid=$pid&sort=comName";
		}
	
	
	if (@$family != "")
		{
		$where = "WHERE majorGroup = '$group' AND family LIKE '$family%'";
		$sql = "SELECT family,sciName,comName,synonym  FROM nrid.dprspp $where ORDER by $sort";
		$findO = "park=$park&majorGroup=$majorGroup&family=$family&e=1&pid=$pid&sort=";
		$findS = "park=$park&majorGroup=$majorGroup&family=$family&e=1&pid=$pid&sort=sciName";
		$findC = "park=$park&majorGroup=$majorGroup&family=$family&e=1&pid=$pid&sort=comName";
		}
	
	if (@$sciName != "")
		{
		$where = "WHERE (majorGroup = '$group' AND sciName LIKE '%$sciName%') OR (majorGroup = '$group' AND synonym LIKE '%$sciName%')";
		$findO = "park=$park&majorGroup=$majorGroup&sciName=$sciName&e=1&pid=$pid&sort=";
		$findS = "park=$park&majorGroup=$majorGroup&sciName=$sciName&e=1&pid=$pid&sort=sciName";
		$findC = "park=$park&majorGroup=$majorGroup&sciName=$sciName&e=1&pid=$pid&sort=comName";
		$sql = "SELECT family,sciName,comName,synonym  FROM nrid.dprspp $where ORDER BY $sort";
		}
	
	if (@$comName != "")
		{
		$where = "WHERE majorGroup = '$group' AND comName LIKE '%$comName%'";
		$findO = "park=$park&majorGroup=$majorGroup&comName=$comName&e=1&pid=$pid&sort=";
		$findS = "park=$park&majorGroup=$majorGroup&comName=$comName&e=1&pid=$pid&sort=sciName";
		$findC = "park=$park&majorGroup=$majorGroup&comName=$comName&e=1&pid=$pid&sort=comName";
		$sql = "SELECT family,sciName,comName,synonym  FROM nrid.dprspp $where ORDER BY $sort";
		}
	
	// ****************************************************
//	echo "test $sql";  //for testing
	
	$total_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
	$test = mysql_num_rows($total_result);
//	echo "t=$test";
	}



$parkName = @$parkCodeName[$park];

echo "If you know the name of the organism, use the fields below to find the species. If you don't, then click your browser's BACK button to return to the previous screen.<h3>Add $majorGroup species to $parkName<br>ID Species List</h3>
<table width=\"100%\" border=\"1\">
<tr>

    <td align=\"center\"><b>";

if(!isset($pid)){$pid="";}
echo "List of all <a href='listTest.php?e=1&pid=$pid&majorGroup=$majorGroup&park=$park&all=1'>$majorGroup</a>

    <td align=\"center\"><font size=\"4\">To view a species list, type some text in a box and click \"Find\".</font></td>
  </tr>";

if ($majorGroup != "TERRESTRIAL COMMUNITY")
	{
	if(!isset($e)){$e="";}
	echo "<tr>
		<td align='right'>Common Name CONTAINS:</td>
		<td align='left'>
		<form action='$nridFile' method='POST'>
		<input type='hidden' name='majorGroup' value='$majorGroup'>
		<input type='hidden' name='park' value='$park'>
		<input type='hidden' name='pid' value='$pid'>
		<input type='hidden' name='e' value='$e'>
		<input type='text' name='comName'> 
	<input type='submit' name='submit' value='Find'> 'green' will find all species with 'green' in common name.</form></td>
	</tr>";
	}

  echo "<tr>
    <td align=\"right\">Scientific Name CONTAINS:</td>
    <td align=\"left\">
    <form action=\"$nridFile\" method='POST'>
<input type='hidden' name='majorGroup' value=\"$majorGroup\">
<input type='hidden' name='park' value=\"$park\">
<input type='hidden' name='pid' value=\"$pid\">
<input type='text' name='sciName'> 
		<input type='hidden' name='e' value='$e'>
<input type='submit' name='submit' value='Find'> \"flora\" will find all species with \"flora\" in scientific name.&nbsp;&nbsp;&nbsp;
</form></td></tr>";

 
 if ($majorGroup != "TERRESTRIAL COMMUNITY")
	 {
	 echo "<tr>
		<td align='right'>Family name BEGINS with:</td>
		<td align='left'>
		<form action='$nridFile' method='POST'>
		<input type='hidden' name='majorGroup' value='$majorGroup'>
		<input type='hidden' name='park' value='$park'>
		<input type='hidden' name='pid' value='$pid'>
		<input type='hidden' name='e' value='$e'>
		<input type='text' name='family'> 
	<input type='submit' name='submit' value='Find'> 'ast' will find all species in the 'Asteraceae'.
	</form></td></tr></table>";
	}

if (@$family != "" OR @$sciName !="" OR @$comName !="" OR @$all !="")
	{
	if (@$test == "")
		{
		@$reply1 = $family.$sciName.$comName;
		if (@$family != ""){$reply2 = "begins with"; $reply3 = "Family";}
		if (@$sciName != ""){$reply2 = "contains"; $reply3 = "Scientific Name";}
		if (@$comName != ""){$reply2 = "contains"; $reply3 = "Common Name";}
		echo "<br><b>No $majorGroup $reply3 in our database $reply2 $reply1.</b><br><br>";
		}
	
	if (@$test !="")
		{
		$found = "Found $test taxa.";
		echo "<table width='100%' border='1'><tr><td><font color='red'><b>$found</b></font><br />Click in radio button to select species, then click the 'Select Species...' button at bottom of page.</td></tr></table>";
		}
	//////  Web links
	echo "<table><tr><td align='center'><font size='2'><b><a href='$nridFileColumn?$findS'>Scientific Name</a></font></td>
	
	<td align='center'><font size='2'><b><a href='$nridFileColumn?$findC'> Common Name</a></font></td>
	
	<td align='center'><font size='2'><b><a href='$nridFileColumn?$findO'> Family</a></font></td>
	<td align='center' width='15%'><font size='2'>&nbsp;&nbsp; <b>Synonym </td></tr>";
	
	echo "<form action='$formX' method='post'>";
	
	while ($row = mysql_fetch_array($total_result))
		{
		 extract($row);
		 //  varible to pass BOTH comName and sciName to store.php or edit.php
		 $com=urlencode($comName."*".$sciName);
		
		echo "<tr><td>
		<input type='radio' name='com' value='$com'>$sciName</td>
		<td> - $comName</td><td> - $family</td><td width='15%'> $synonym</td></tr>";
		}
	if ($test != "")
		{
		echo "</table><input type='hidden' name='park' value='$park'>";
		echo "<input type='hidden' name='pid' value='$pid'>";
		echo "<input type='hidden' name='source' value='photos'>";
		echo "<input type='hidden' name='majorGroup' value='$group'>";
		echo "<input type='submit' name='submit' value='$word species'>";
		echo "</form>";
		echo "<hr />";
		}
	}
?>
</body>
</html>
