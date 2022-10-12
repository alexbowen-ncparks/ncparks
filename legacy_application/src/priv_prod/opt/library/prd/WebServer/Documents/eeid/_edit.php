<?php
$database="eeid";
include("../../include/auth.inc");
include("menu.php");
if($level>1)
	{ini_set('display_errors',1);}

//print_r($_REQUEST);
//echo "<pre>";print_r($_SESSION);echo "</pre>";
date_default_timezone_set('America/New_York');
$showDate=date("D Y-m-d");
$findDate=(date("Y")).".00.00";
    // Data from form is processed
$catArray  = array('', '1 --> Component I Workshop, EE Certification', '2 --> Other I&E Workshop/Training', '3 --> EELE Program', '4 --> Other Structured EE or Inter. Program', '5 --> Events/Organizations hosted by park', '6 --> Short orientations & spontaneous Inter.', '7 --> Exhibits Outreach');

include("../../include/connectROOT.inc");
mysql_select_db($database,$connection);

extract($_REQUEST);
    // ********* DELETE record
if ($submit == "Delete Record") 
	{
	//print_r($_REQUEST); EXIT;
	   
	$sql = "DELETE FROM eedata where eeid='$eeid'";
	//echo "$sql";exit;
	$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
	if($result){echo "Record deleted.";}
	exit;}


    // ********* EDIT record
if ($submit == "Edit Record") 
	{
	//print_r($_REQUEST); EXIT;
	include("../../include/get_parkcodes.php");
	   
mysql_select_db($database,$connection);
	$sql = "SELECT * from eedata where eeid='$eeid'";
	$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
		MYSQL_CLOSE();
	$row=mysql_fetch_array($result);
	extract($row);
	
	$testPark=$_SESSION['eeid']['select'];
	if($park==$testPark){$del=1;}
	
	@$park_name=$parkCodeName[$park];
	if($park=="YORK")
		{$park_name="Yorkshire Center";}
	
	if($park=="ARCH")
		{$park_name="At Raleigh Central Headquarters";}
	
	echo "<form method='post' action='store.php' enctype='multipart/form-data'>";
	
	echo "<font color='purple'>Make any changes and then submit.</font><font face='Verdana, Arial, Helvetica, sans-serif'><table cellpadding='5'><tr><td>Park: <b>$park_name</b></td><td>Dist: <b>$dist</b>  Today is: $showDate</td></tr></table></font>";
		echo "
		<hr>";
	
	echo "<table><tr><td>
	Date of Program: <input type='text' name='dateprogram' value='$dateprogram'>Enter as: 2005-12-30 or 12/30/2005</td></tr>
	<tr><td>
	Presented by: <input type='text' name='presenter' value='$presenter'></td></tr>
	<tr><td colspan='3'>
	Title of Program: <textarea name='progtitle' cols='50' rows='1'>$progtitle</textarea></td></tr>
	<tr><td>
	County: <input type='text' name='county' value='$county'></td></tr>
	<tr><td>Category: ";
	
	echo "<select name=\"category\">\n";
	 $i="";
	while ($i < count($catArray))
		{
		if($category == $i){$ck="selected";}else{$ck="value";}
		if(isset($catArray[$i]))
			{
			 echo "<option $ck=\"$i\">$catArray[$i]\n";
			}
			 $i++;
		}
	
	echo "</select></td></tr>
		
	<tr><td>
	Times Given: <input type='text' name='timegiven' value='$timegiven' size='3'></td></tr>
	<tr><td>Attendance: <input type='text' name='attend' value='$attend' size='5'></td></tr>";
	
	if(!isset($checkS)){$checkS="";}
	if(!isset($checkP)){$checkP="";}
	if(!isset($checkA)){$checkA="";}
		switch ($age) {
			case "school":
				$checkS="checked";
				break;	
			case "adult":
				$checkA="checked";
				break;	
			default:
				$checkP="checked";
		}
	echo "<tr><td>
	Age Group: <input type='radio' name='age' value='school' $checkS>School-age
	<input type='radio' name='age' value='adult' $checkA>Adults
	<input type='radio' name='age' value='public' $checkP>General Public</td></tr>";
	
	if(!isset($checkO)){$checkO="";}
	if($location =="Outreach"){$checkO="checked";}else{$checkP="checked";}
	echo "</table><table><tr><td align='right'>
	Location: <input type='radio' name='location' value='Park' $checkP>Park&nbsp;&nbsp;
	<input type='radio' name='location' value='Outreach' $checkO>Outreach<?td></tr>
	
	<tr><td>Comment:<br><textarea cols='40' rows='5' name='comments'>$comments</textarea><?td></tr>
	<tr><td>Resource People | Materials<br><textarea cols='40' rows='5' name='resources'>$resources</textarea></td>";
	
if(!empty($_SESSION['eeid']['accessPark']))
	{
	$var_1=explode(",",$_SESSION['eeid']['accessPark']);
	if(in_array($park,$var_1)){$del=1;}
	}
	if($_SESSION['eeid']['level']>2 || @$del==1)
		{
		echo "</tr><tr><td>
		<input type='hidden' name='dist' value='$dist'>
		<input type='hidden' name='park' value='$park'>
		<input type='hidden' name='eeid' value='$eeid'>
		<input type='submit' name='submit' value='Update Record'>
		</form></td>";
		
		echo "<td><form action='edit.php'><input type='hidden' name='eeid' value='$eeid'>
		<input type='submit' name='submit' value='Delete Record' onClick=\"return confirmLink()\"></form></td>";
		}
	
	echo "</tr></table></BODY></HTML>";
	exit;
	}
?>
