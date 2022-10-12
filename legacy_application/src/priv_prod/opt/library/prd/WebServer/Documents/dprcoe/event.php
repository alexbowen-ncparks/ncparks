<?php

$database="dprcoe";
include("../../include/auth.inc");
include("../../include/connectROOT.inc");
include("../../include/get_parkcodes.php");

mysql_select_db($database,$connection);
date_default_timezone_set('America/New_York');

//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
extract($_REQUEST);

//echo "<pre>"; print_r($_SESSION); echo "</pre>";  exit;
$level=$_SESSION[$database]['level'];
if($level>3)
	{ini_set('display_errors',1);}


if(!isset($parkA)){$parkA="";}

if($_SESSION['dprcoe']['tempID']=="kboysen")
	{$_SESSION['dprcoe']['accessPark']="FALA,KELA,MEMO,JORD,WIUM";}
	
//  ************Start Input form for Park Selection ************
if($_SESSION['loginS'] =="ADMIN" || $_SESSION['loginS'] =="SUPERADMIN")
	{
	
	if($parkA)
		{
		$_SESSION['parkS']=$parkA;
		$park=$parkA;
		}
	else
		{
		$park=$_SESSION['parkS'];
		}
		
	/*
	echo "<pre>";
	print_r($_REQUEST);
	print_r($_SESSION);//exit;
	echo "</pre>";
	*/
	menuStuff($parkCode,$park);
	}
else
	{
	if(empty($park))
		{
		$park=$_SESSION['parkS'];
		}
	if($parkA)
		{
		$_SESSION['parkS']=$parkA;
		$park=$parkA;
		}
		if(!empty($_SESSION['dprcoe']['accessPark']))
			{
			$parkCode=explode(",",$_SESSION['dprcoe']['accessPark']);
			menuStuff($parkCode,$park);	
			}	
	}

//echo "<pre>";print_r($_REQUEST);print_r($_SESSION);echo "</pre>";  //exit;


// Process input
@$val = strpos($Submit, "Add");
//echo "v $value s $Submit";
if($val > -1)
	{ // strpos returns 0 if Add starts as first character
	
	$_SESSION['parkS']=$park;
	
	$monthArray = range(1,12);
	if(in_array($month, $monthArray))
		{}
		else
		{
		$monthArrayName = array('','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
		$trans = array_flip($monthArrayName);
		$month = $trans[$month];
		}
	
	if($ann_100=="x"){$year=2016;}
	if(!$eid=="")
		{
		$oldTitle=$title;
		$newdateBegin = date ("Y-m-d", mktime(0,0,0,$month,$day,$year));
		$sql = "SELECT * From event WHERE eid='$eid'";
		$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
		$row = mysql_fetch_array($result);
		extract($row);
		$content = urldecode($content);
		if($dateE==$newdateBegin AND $title==$oldTitle)
		{$message = "<font color='red'>You have just entered an event with the SAME DATE and TITLE as the previous record. If this is NOT OK, View Entries and Delete the duplicate.</font>";}
		}
	
	$a=0; $message="";
	if (@$enterBy == "" AND @$enterBy1 == "")
		{
		$message="Enter your Name.";}
		else
		{$a++;}
	if ($month == ""){$message.="<br>Enter a Month.";}else{$a++;}
	if ($day == ""){$message.="<br>Enter a Day.";}else{$a++;}
	if ($start_time == ""){$message.="<br>Enter the Starting Time.";}else{$a++;}
	if ($start_location == ""){$message.="<br>Enter the Starting Location.";}else{$a++;}
	if (@$title == "" AND strlen(trim($title1)) < 1){$message.="<br>Enter a Title.";}else{$a++;}
	if ($content == "") {$message.="<br>Enter a Program Description.";}else{$a++;}
	
	IF($title1 != ""){$title = $title1;$keepTitle1=$title1;}
	IF($enterBy1 != ""){$enterBy = $enterBy1;$keepName1=$enterBy1;}
	IF($content != ""){$keepContent=$content;}
	if($a==7)
		{
		if (checkdate($month, $day, $year)!= "true")
		{
		echo "Invalid date. Click your browser's BACK button and make the change.";
		echo "m $month d $day y $year";
		exit;
		}
		
	//	echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
		$park=$_SESSION['parkS'];
		$newdateBegin = date ("Y-m-d", mktime(0,0,0,$month,$day,$year));
		
		$title=urldecode($title);$title=addslashes($title);
		$enterBy=urldecode($enterBy);$enterBy=addslashes($enterBy);
		//$content1=$content;
		$comment1=$comment;
		$content=nl2br(addslashes($content));
		$start_location=nl2br(addslashes($start_location));
		$dist=$district[$park];
		
		if(!empty($event_type))
			{
			$var_et="";
			foreach($event_type as $k=>$v)
				{
				$var_et.=$v.",";
				}
			$var_et=rtrim($var_et,",");
			}
			else
			{$var_et="";}
		$content=str_replace("<br /><br />","",$content);
			/*
		if($level>3)
			{
			$content=str_replace("<br /><br />","",$content);
			$content=str_replace("\n\n","",$content);
			$test=explode("\n",$content);
			echo "<pre>"; print_r($test); echo "</pre>";  exit;
			$exp=str_split($content);
			foreach($exp as $char)
				{
				$c=ord($char);
				if($c==10 or $c==13){continue;}
				$new_c[]=$char;
				}
				$content=implode($new_c);
				echo "c=$content<br />$query";exit;
				}
			*/
		$query = "INSERT INTO event (dateE, enterBy, title, park, content, dist, comment,start_time,start_location,event_type,ann_100) VALUES ('$newdateBegin','$enterBy', '$title', '$park','$content', '$dist', '$comment1', '$start_time', '$start_location', '$var_et', '$ann_100')";
		
		if($level>3)
			{
//		echo "<br />$query";exit;
			}
	
		if($level > 3 OR $newdateBegin>=date('Y-m-d'))
			{		
			$result = mysql_query($query) or die ("Couldn't execute query. $query");
			$eid = mysql_insert_id();
			$success= "<br><font size='4'>Event successfully added for <font color='red'>$title on $newdateBegin</font>.</font><br>If you would like to <font size='4' color='orange'>add the same event on a different date,</font> change the date and click the Add button again.";	
			}
			else
			{		
			$success="<h2><font color='red'>You tried to enter a program for a date - $newdateBegin - that is earlier than today.</font</font></h2>Your program was NOT entered.";
			}
		}// end if $eid
	} // end Add
//  ************Start input form*************

if(@$title1==""){@$keepTitle=urldecode(stripslashes($title));}
else{$keepTitle=stripslashes($title1);}
if(@$enterBy1==""){@$keepName=urldecode(stripslashes($enterBy));}else
{$keepName=stripslashes($enterBy1);}

@$keepMonth=$month; @$keepDay=$day; @$keepYear=$year;
//echo "m $month  d $day  y $year"; exit;

$this_year=date('Y');
$sql = "SELECT `yot_group` From yotx 
WHERE `year`='$this_year'
";
$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
$row=mysql_fetch_assoc($result);
$yotx=$row['yot_group']; //echo "$sql";

//Temporary table to group individual records together by most recent dateToday
// We first clear any existing temporary table
$sql = "drop table IF EXISTS tempCOE"; 
//$result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
// Create an intermediate table
$sql = "CREATE TEMPORARY TABLE tempCOE SELECT * From event where park='$park' ORDER BY dateToday DESC, title";
//$result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());

//$park=$_SESSION['parkS'];
$current_year=date("Y")."-%";
$sql = "SELECT DISTINCT enterBy From event WHERE park='$park' and dateE like '$current_year' ORDER by enterBy";
$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
//$sql = "SELECT DISTINCT title, content From tempCOE WHERE park='$park' GROUP by title ORDER by title";

$since_date=(date('Y')-2)."01-01";
$sql = "SELECT DISTINCT title, content From event 
WHERE park='$park' and dateE>'$since_date'
GROUP by title ORDER by title";
$result1 = mysql_query($sql) or die ("Couldn't execute query. $sql");

//echo $sql; //exit;


if($level>0)
	{
	if(!isset($success)){$success="";}
	@$parkname=$parkCodeName[$park];
	echo "<html><head><title>New Event</title></head>
	<body><font size='4' color='004400'>NC State Parks System Events Calendar</font>
	<br><font size='5' color='blue'>Add a New Event for $parkname
	</font><br>$success</font>";
	
//	echo "<h2><font color='green'>Enter all 100th Anniversary Events </font><a href='cal.php'>Here</a></h2>";
	}
	
echo "<hr><form name='newEvent' method='post' action='event.php'>
<table><tr><td><b>Entered By:</b></td>";
if(@$color=="red"){$color="green";}else{@$color="red";}
$num=mysql_num_rows($result);
if($num>0){
echo"<td><select name='enterBy'><option value=''>";
while ($row = mysql_fetch_array($result))
	{
	extract($row);$nameE=urlencode($enterBy);
	if($enterBy==$keepName or $enterBy==stripslashes($keepName)){
	echo "<option selected='$nameE'>$enterBy";}ELSE{
	echo "<option value='$nameE'>$enterBy";}
	}
echo "</select></td>";
}
if(!isset($keepName1)){$keepName1="";}
echo "<td><input type='text' name='enterBy1' value=\"$keepName1\">";

if(!isset($enterMessage)){$enterMessage="";}
echo " (If your name wasn't listed, enter it here. $enterMessage)</td></tr></table>";

    $monthArray = range(1,12);
    $monthArrayName = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec',);

echo "<table><tr><td><b>Date of Event:</b></td><td>";
echo "<select name='month'>\n"; echo "<option value=''>\n";
for ($i=0; $i <=11; $i++)
	{
	$month = $monthArray[$i];
	if($keepMonth==$month)
		{
		echo "<option selected='$month'>$monthArrayName[$i]";
		}
	ELSE
		{
		echo "<option value='$month'>$monthArrayName[$i]";
		}
	}
echo "</select> Month &nbsp;&nbsp;</td>";

$dayArray = range(1,31); echo "<td><select name='day'>\n";
 echo "<option value=''>\n";
for ($i=0; $i <=30; $i++) {$day = $dayArray[$i];
if($keepDay==$day){
echo "<option selected='$day'>$day";}ELSE{
echo "<option value='$day'>$day";}
}
echo "</select> Day &nbsp;</td>";
 $thisYear = date('Y');  $nextYear = $thisYear + 1;

$yearArray = range($thisYear, $nextYear);
echo "<td><select name='year'>\n";
 echo "<option value=''>\n";

if(!in_array("2016",$yearArray))
	{$yearArray[]="2016";}
//for ($i=0; $i <=1; $i++) 
foreach($yearArray as $i=>$year)
{
if($keepYear=="")
	{if($thisYear==$yearArray[$i])
	{echo "<option selected='$year'>$year";}
	else{echo "<option value='$year'>$year";}
	}
ELSE
	{if($keepYear==$yearArray[$i])
	{echo "<option selected='$year'>$year";}
	else{echo "<option value='$year'>$year";}
	}
}
echo "</select> Year &nbsp;</td></tr></table>";
echo "<table><tr> <td colspan='3'><b>Program Title:</b><br />";

$titleArray = array(); $titleArray[0] = "";

$num1=mysql_num_rows($result1);
if($num1>0){
echo"<select name='title'><option value=''>";
while ($row = mysql_fetch_array($result1))
	{
	extract($row);
	$titleE=urlencode($title);
	
	$temp_desc=$row[1];
	
	$temp_desc=str_replace("\r\n", "<br />", $temp_desc);
	
	$temp_desc=str_replace("\r", "<br />", $temp_desc);
	$temp_desc=str_replace("\n", "<br />", $temp_desc);
	$desc_array[]=$temp_desc;
	
	$desc=urlencode($row[1]);
	if($title==$keepTitle or $title==stripslashes($keepTitle))
		{
		echo "<option selected='$titleE'>$title";
		}
	ELSE
		{
		echo "<option value='$titleE'>$title";
		}
	
	$jsEncode = str_replace("+", "%20", $desc);
	$jsEncode = str_replace("%2B", " ", $jsEncode);
	$jsEncode = str_replace("%2C", ",", $jsEncode);
	$jsEncode = str_replace("%3A", ":", $jsEncode);
	$jsEncode = str_replace("%3F", "?", $jsEncode);
	$jsEncode = str_replace("%3F", "?", $jsEncode);
	$jsEncode = str_replace("%2C ", " ", $jsEncode);
	$jsEncode = str_replace("%2592", "'", $jsEncode);
	$jsEncode = str_replace("%2593", "'", $jsEncode);
	$jsEncode = str_replace("%2594", "'", $jsEncode);
	$jsEncode = str_replace("%26", "&", $jsEncode);
	$jsEncode = str_replace("%250D%250A", "\u000A", $jsEncode);
	$jsEncode = str_replace("%3Cbr%20%2F%3E", "\u000A", $jsEncode);
	$titleArray[] = $jsEncode;
	}
echo "</select>";
}
if($level>3)
	{
//	echo "<pre>"; print_r($desc_array); echo "</pre>"; // exit;
	}
echo "
<br />(If your title wasn't listed, enter it here.) <input type='text' name='title1' size='55' value=''>";
if(!isset($keepTitle1)){$keepTitle1="";}
if(@$Submit != "Add"){echo $keepTitle1;}

echo "</td></tr>";

if(strpos(@$event_type,"festival")>-1){$ck1="checked";}else{$ck1="";}
if(strpos(@$event_type,"project")>-1){$ck2="checked";}else{$ck2="";}
if(strpos(@$event_type,"halloween")>-1){$ck2_1="checked";}else{$ck2_1="";}
if(strpos(@$event_type,"thanksgiving")>-1){$ck2_2="checked";}else{$ck2_2="";}
if(strpos(@$event_type,"christmas")>-1){$ck2_3="checked";}else{$ck2_3="";}
if(strpos(@$event_type,"yotx")>-1){$ck2_4="checked";}else{$ck2_4="";}

if(@$comment=="public_land"){$ck3="checked";}else{$ck3="";}
if(@$comment=="first_day"){$ck4="checked";}else{$ck4="";}

if(@$comment=="earth_day"){$ck5="checked";}else{$ck5="";}
if(@$comment=="ann_100"){$ck6="checked";}else{$ck6="";}
if(@$comment=="science_festival"){$ck7="checked";}else{$ck7="";}
if(@$comment=="kid2park"){$ck8="checked";}else{$ck8="";}
if(@$comment=="national_trail"){$ck9="checked";}else{$ck9="";}
if(@$comment=="get_out"){$ck11="checked";}else{$ck11="";}
if(@$comment=="child_outside"){$ck12="child_outside";}else{$ck12="";}
if(@$comment==""){$ck="checked";}else{$ck="";}

if(@$ann_100=="")
	{
	$ck100n="checked";
	$ck100y="";
	}
	else
	{
	$ck100y="checked";
	$ck100n="";
	}

if($level>0)
	{
	echo"
	<tr><td><font color='magenta'>Is this a 100th Anniversary event?</font></td><th>
	<input type='radio' name='ann_100' value='x' $ck100y>Yes <input type='radio' name='ann_100' value='' $ck100n>No</th></tr>";
	}


echo "<tr><td>Select if appropriate:</td>
<th>Special Event/Festival:<input type='checkbox' name='event_type[]' value='festival' $ck1></th>
<th>Volunteer Project/Trail Work Day:<input type='checkbox' name='event_type[]' value='project' $ck2></th>
<th>Halloween Event:<input type='checkbox' name='event_type[]' value='halloween' $ck2_1></th>
<th>Thanksgiving Event:<input type='checkbox' name='event_type[]' value='thanksgiving' $ck2_2></th>
<th>Christmas Event:<input type='checkbox' name='event_type[]' value='christmas' $ck2_3></th>";

//if($level>3)
//	{
	echo "<th>Year of the $yotx:<input type='checkbox' name='event_type[]' value='yotx' $ck2_4></th>";
//	}
echo "</tr>";

echo "<tr><td><br /><br /></td></tr>";

echo "<tr><td valign='top'>Select if appropriate:</td><td>
<table>
<tr><th align='right'>
None:<input type='radio' name='comment' value='' checked></th align='right'></tr>

<tr><th align='right'>
First Day Hike:<input type='radio' name='comment' value='first_day' $ck4></th align='right'></tr>
<tr><th align='right'>
Earth Day Event:<input type='radio' name='comment' value='earth_day' $ck5></th align='right'></tr>
<tr><th align='right'>
NC Science Festival:<input type='radio' name='comment' value='science_festival' $ck7></th align='right'></tr>
<tr><th align='right'>
Kids to Parks Day:<input type='radio' name='comment' value='kid2park' $ck8></th align='right'></tr>
</table>
</td>
<td>

<table>
<tr><th align='right'>
National Trails Day :<input type='radio' name='comment' value='national_trail' $ck9></th align='right'></tr>
<tr><th align='right'>
National Public Lands Day :<input type='radio' name='comment' value='public_land' $ck3></th align='right'></tr>
<tr><th align='right'>
National Get Outdoors Day:<input type='radio' name='comment' value='get_out' $ck11></th align='right'></tr>
<tr><th align='right'>
Take A Child Outside Week :<input type='radio' name='comment' value='child_outside' $ck12></th align='right'></tr>
</table>

</td>
</tr></table>";


echo "<table>";
if(!isset($message)){$message="";}
if($message){echo "<tr><td><font size='4' color='red'>$message</font></td></tr>
<tr><td><font size='4' color='green'>Invalid. Click your browser's BACK button and make the change.</font></td></tr></table>";}

if(!isset($start_time)){$start_time="";}
if(!isset($start_location)){$start_location="";}
if(!isset($keepContent)){$keepContent="";}
echo "
<tr>
<td>
<b>Start Time:</b> (required)<input type='text' name='start_time' value='$start_time'>
&nbsp;&nbsp;&nbsp;
<b>Start Location:</b> (required)<input type='text' name='start_location' value='$start_location'>
</td>
</tr>
<tr><td><b>Program Description</b>:</td></tr>
<tr><td><textarea name='content' cols='80' rows='12'>$keepContent</textarea>
</td></tr><tr><td>Be sure to include any comments, such as \"bring bug spray\", \"wear hiking shoes\", etc.</td></tr></table>";

if(!isset($eid)){$eid="";}
echo "
 <table width='800'><tr><td width='100' align='center'>
 <input type='hidden' name='park' value='$park'>
 <input type='hidden' name='color' value='$color'>
 <input type='hidden' name='eid' value='$eid'>";

 if($val === FALSE){  // strpos returns 0 if Add starts as first character
echo "
<input type='submit' name='Submit' value='Add'></form></td></tr>
<tr>";}
else
{echo "
<input type='hidden' name='comment' value=\"$comment\">
<input type='submit' name='Submit' value='Add Another'></form>
</td>
<td width='100'><form><input type='button' name='Submit' value='Edit' onclick=\"location='edit.php?eid=$eid'\"></form></td>
<td width='100'><form><input type='button' name='Submit' value='View Entries' onclick=\"location='find.php?Submit=Find&park=$park'>\"</form></td></tr>
<tr>";}

echo "<tr><td width='100'><form><input type='button' value='Clear Form' onclick=\"location='event.php?park=$park'\">
</form></td></tr></table>";

include("supported_events.php");

echo "</body></html>

<SCRIPT LANGUAGE=Javascript>
// Adds an event to the CONTENT field
function report(element, event) {
    var t = element.form.content;
    var listIndex = element.selectedIndex;
    var phpvar = new Array();";
  
$size=count($titleArray);
    for ($i = 0; $i < $size; $i++) {
    $temp = $titleArray[$i];
   
   echo "phpvar[$i]=\"$temp\"\n";}
    echo "t.value = decodeURI(phpvar[listIndex]);
    }

// This function adds one event handler to every element in a form.
function addhandlers(f) {
    // Loop through all the elements in the form
    //for(var i = 0; i < f.elements.length; i++) {
     //   var e = f.elements[i];
     //  e.onclick = function() { report(this, 'Click'); }
 // In this use we only want the title field to respond.   
   f.elements.title.onclick = function() { report(this, 'Click');}
}

// Finally, activate our form by adding all possible event handlers!
addhandlers(document.newEvent);
</SCRIPT>";

// *************** Display Menu FUNCTION **************
function menuStuff($parkCode,$park)
	{
	$align="align='center'";
	echo "<html><head><title>District Admin Menu</title>
	<STYLE TYPE=\"text/css\">
	<!--
	body
	{font-family:sans-serif;background:beige}
	td
	{font-size:90%;background:beige}
	th
	{font-size:95%; vertical-align: bottom}
	--> 
	</STYLE>
	<script language=\"JavaScript\">
	<!--
	function MM_jumpMenu(selObj,restore){ //v3.0
	eval(\"parent.frames['mainFrame']\"+\".location='\"+selObj.options[selObj.selectedIndex].value+\"'\");
	  if (restore) selObj.selectedIndex=0;
	}
	function toggleDisplay(objectID) {
	var inputs=document.getElementsByTagName('div');
		for(i = 0; i < inputs.length; i++) {
		
	var object1 = inputs[i];
		state = object1.style.display;
			if (state == 'block')
		object1.style.display = 'none';		
		}
		
	var object = document.getElementById(objectID);
	state = object.style.display;
	if (state == 'none')
		object.style.display = 'block';
	else if (state != 'none')
		object.style.display = 'none'; 
}
	//-->
	</script></head>
	<body>
	<font size='4' color='004400'>NC State Parks System Calendar of Events</font>
	<br><font size='5' color='blue'>Administrative Function Menu
	</font><hr><table>
	<tr><td colspan='2' width='300'>
		
	<form method='post' action='event.php'>
	Select a Park
	<select name='park' onChange=\"MM_jumpMenu(this,0)\">
	<option></option>";
	
	$link="event.php?parkA=";  
	foreach($parkCode as $index=>$park_code)  
		   {
		   if($park_code==$park){$s="selected";}else{$s="value";}
			echo "<option $s='$link$park_code'>$park_code</option>\n";
		   }
	echo "</select>
	</form></td></tr>
			</table>";
	}
?>