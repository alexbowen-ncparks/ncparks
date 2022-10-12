<?php 
ini_set('display_errors',1);
$database="dprcoe";
include("../../include/auth.inc");
include("../../include/connectROOT.inc");
include("../../include/get_parkcodes.php");

mysql_select_db($database,$connection);
date_default_timezone_set('America/New_York');

//echo "<pre>";
//print_r($_REQUEST);
//print_r($_SESSION);//exit;
//echo "</pre>";

extract($_REQUEST);

// Edit input
if(@$Submit =="Update")
	{
//	echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
	$title=urldecode($title);$title=addslashes($title);
	$enterBy=urldecode($enterBy);$enterBy=addslashes($enterBy);
	$content1=$content;
	$content=urlencode($content);
	if(!empty($_REQUEST['event_type']))
		{
		$events="";
		foreach($_REQUEST['event_type'] as $k=>$v)
			{
			$events.="$v,";
			}
		$events=rtrim($events,",");
		}
		else
		{$events="";}
	
	$content1=addslashes($content1); 
	//$content=nl2br($content);
	$start_location=nl2br(addslashes($start_location));
	 $monthArray = range(1,12);
	if (in_array($month, $monthArray))
		{}
		else
		{
		$monthArrayName = array('','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
		$trans=array_flip($monthArrayName);
		$month=$trans[$month];
		}
	if (checkdate($month, $day, $year) == "true")
		{
		$newdateBegin = date ("Y-m-d", mktime(0,0,0,$month,$day,$year));
		}
	else
		{
		echo "You have entered an incorrect date. Please go back and make the correction.<br><br><FORM>
		<INPUT TYPE='Button' VALUE='Go Back' onClick='javascript:history.back()'>
		</form></body>"; exit;
		}
	
	if(!isset($ann_100)){$ann_100="";}
	$query = "UPDATE event SET title='$title', content='$content1', dateE='$newdateBegin', comment='$comment', start_time='$start_time', start_location='$start_location', enterBy='$enterBy', ann_100='$ann_100', event_type='$events'
	 WHERE eid=$eid";
//	echo "$query";exit;
	$result = mysql_query($query) or die ("Couldn't execute query. $query");
//	$ok = mysql_affected_rows();
	$ok=1;
	if($ok == 1)
		{
		$temp1=rand (0, 9);
		$temp2=rand (0,9);
		$colorNum=$temp2.$temp2.$temp1.$temp1.$temp1.$temp2;
		$success= "<font size='4'>Event successfully edited.</font><br>If necessary, make any additional edits and click the Update button again.";
	if(!empty($year16_100))
			{
			list($year,$month, $day)=explode("-",$newdateBegin);
			$newdate2016="2016-".$month."-".$day;
			$query = "REPLACE year_2016 SET title='$title', content='$content1', dateE='$newdate2016', comment='$comment', start_time='$start_time', start_location='$start_location', enterBy='$enterBy', year16_100='$year16_100', eid='$eid', park='$park'
			 ";    //echo "$query"; exit;
			$result = mysql_query($query) or die ("Couldn't execute query. $query");
			}
			else
			{
			$newdate2016="";
			$query = "REPLACE year_2016 SET title='$title', content='$content1', dateE='$newdate2016', comment='$comment', start_time='$start_time', start_location='$start_location', enterBy='$enterBy', year16_100='', eid='$eid', park='$park'
			 ";   
			$result = mysql_query($query) or die ("Couldn't execute query. $query");
			}
		}
		else
		{
		echo "$park, we have a problem! No changes were made to the entry before clicking the Update button.<br /><br />
		<form>
		<input type='button' value='Go Back' onclick=\"location='edit.php?eid=$eid'\">
		</form></body>"; exit;
		}
	} // end Update

// Delete Record
if(@$Submit =="Delete")
	{
	$query = "DELETE from event WHERE eid=$eid"; //echo $query; exit;
	$result = mysql_query($query) or die ("Couldn't execute query. $query");
	$ok = mysql_affected_rows();
	//echo "s $ok p $park";
	header("Location:find.php?park=$park&Submit=Find"); exit;
	  }

//  ************Start edit form*************

$sql = "SELECT * From event WHERE eid='$eid'";
$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
if(mysql_num_rows($result)<1){echo "Record not found";exit;}

$row = mysql_fetch_array($result);
extract($row);
//echo $sql; exit;
//$row = mysql_fetch_array($result); print_r($row); exit;
echo "<html><head><title>New Event</title></head>
<body bgcolor='beige'><font size='4' color='004400'>NC State Parks System Events Calendar</font>
<br><br><font size='5' color='blue'>Edit an Event for $parkCodeName[$park]
</font>
<hr><form name='newEvent' method='post' action='edit.php'>";
$content=urldecode($content);
$monthArrayName = array('','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec',);

$dateParse = explode("-", $dateE);
$month = $dateParse[1];
$month=$month+0;$monthName=$monthArrayName[$month];
$day = $dateParse[2];$day=$day+0;$year = $dateParse[0];

if(!isset($start_time)){$start_time="";}
if(!isset($start_location)){$start_location="";}
if(!isset($title)){$title="";}
if(!isset($enterBy)){$enterBy="";}
echo "<table width='600'><tr><td width='40'><b>Entered By:</b> </td><td><input type='text' name='enterBy' value='$enterBy'></td></tr>
<tr><td width='40'><b>Month:</b> </td><td><input type='text' name='month' value='$month' size='3'> = $monthName</td></tr>
<tr><td width='40'><b>Day:</b> </td><td><input type='text' name='day' value='$day' size='3'></td></tr>
<tr><td width='40'><b>Year:</b> </td><td><input type='text' name='year' value='$year' size='5'></td></tr>
<tr><td width='40'><b>Title:</b> </td><td><textarea name='title' cols='45' rows='1'>$title</textarea></td></tr>
<tr><td width='40'><b>Description:</b> </td>
<td><textarea name='content' cols='80' rows='12'>$content</textarea></td>
</tr>
<tr><td width='40'><b>Start Time:</b> </td><td><input type='text' name='start_time' value='$start_time'></td></tr>
<tr><td width='40'><b>Start Location:</b> </td><td><input type='text' name='start_location' value=\"$start_location\" size='45'></td></tr></table>";

if(strpos(@$event_type,"festival")>-1){$ck1="checked";}else{$ck1="";}
if(strpos(@$event_type,"project")>-1){$ck2="checked";}else{$ck2="";}
if(strpos(@$event_type,"halloween")>-1){$ck2_1="checked";}else{$ck2_1="";}
if(strpos(@$event_type,"thanksgiving")>-1){$ck2_2="checked";}else{$ck2_2="";}
if(strpos(@$event_type,"christmas")>-1){$ck2_3="checked";}else{$ck2_3="";}
if(@$comment=="public_land"){$ck3="checked";}else{$ck3="";}
if(@$comment=="first_day"){$ck4="checked";}else{$ck4="";}

if(@$comment=="earth_day"){$ck5="checked";}else{$ck5="";}
//if(@$comment=="ann_100"){$ck6="checked";}else{$ck6="";}
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

echo "<table>";

if($level>3)
	{
	echo "<tr><td><font color='magenta'>Is this a 100th Anniversary event?</font></td><th>
	<input type='radio' name='ann_100' value='x' $ck100y>Yes <input type='radio' name='ann_100' value='' $ck100n>No</th></tr>";
	}
	else
	{
	@$val=$ann_100;
	echo "<input type='hidden' name='ann_100' value='$val'>";
	}
echo "<tr><td>Select if appropriate:</td><th>
Special Event/Festival:<input type='checkbox' name='event_type[]' value='festival' $ck1></th><th>
Volunteer Project/Trail Work Day:<input type='checkbox' name='event_type[]' value='project' $ck2></th>
<th>Halloween:<input type='checkbox' name='event_type[]' value='halloween' $ck2_1></th>
<th>Thanksgiving Event:<input type='checkbox' name='event_type[]' value='thanksgiving' $ck2_2></th>
<th>Christmas Event:<input type='checkbox' name='event_type[]' value='christmas' $ck2_3></th>

</tr>

<tr><td><br /><br /></td></tr>

<tr><td valign='top'>Select if appropriate:</td><td>
<table>
<tr><th align='right'>
None:<input type='radio' name='comment' value='' checked></th></tr>

<tr><th align='right'>
First Day Hike:<input type='radio' name='comment' value='first_day' $ck4></th></tr>
<tr><th align='right'>
Earth Day Event:<input type='radio' name='comment' value='earth_day' $ck5></th></tr>
<tr><th align='right'>
NC Science Festival:<input type='radio' name='comment' value='science_festival' $ck7></th></tr>
</table>
</td>
<td>

<table>
<tr><th align='right'>
Kids to Parks Day:<input type='radio' name='comment' value='kid2park' $ck8></th></tr>
<tr><th align='right'>
National Trails Day :<input type='radio' name='comment' value='national_trail' $ck9></th></tr>
<tr><th align='right'>
National Public Lands Day :<input type='radio' name='comment' value='public_land' $ck3></th></tr>
<tr><th align='right'>
National Get Outdoors Day:<input type='radio' name='comment' value='get_out' $ck11></th></tr>
<tr><th align='right'>
Take A Child Outside Week :<input type='radio' name='comment' value='child_outside' $ck12></th></tr>
</table>

</td>
</tr>";
/*
if($level>2)
	{
	if(empty($ann_100)){$ck100="";}else{$ck100="checked";}
	if(empty($year16_100)){$ck16_100="";}else{$ck16_100="checked";}
	echo "<tr><td colspan='3'>Check if the event on this <b>exact date</b> should appear on the 100th Anniversary Calendar: <input type='checkbox' name='ann_100' value='x' $ck100></td></tr>";
	
	echo "<tr><td colspan='3'>Check if this event should appear for <b>this date in 2016</b> on the 100th Anniversary Calendar: <input type='checkbox' name='year16_100' value='x' $ck16_100></td></tr>";
	
	}
*/
if(!isset($colorNum)){$colorNum="black";}
if(!isset($success)){$success="";}
if(!isset($park)){$park="";}
echo "</table><br><font color='$colorNum'>$success</font>
    <table><tr> <td><br><input type='hidden' name='park' value='$park'>
      <input type='hidden' name='eid' value='$eid'>
      <input type='submit' name='Submit' value='Update'></td></tr>
      <tr> <td><br><input type='hidden' name='park' value='$park'>
      <input type='hidden' name='eid' value='$eid'>
      <input type='submit' name='Submit' value='Delete'></td></tr></table>
</form></body></html>";
?>