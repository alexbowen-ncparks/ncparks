<?php 

//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;

$database="dprcoe";
include("../../include/auth.inc");
include("../../include/connectROOT.inc");
include("../../include/get_parkcodes.php");
$level=$_SESSION[$database]['level'];
if($level>3)
	{ini_set('display_errors',1);}

mysql_select_db($database,$connection);
date_default_timezone_set('America/New_York');

//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
//print_r($_SESSION);//exit;

if(!isset($park)){$park="";}
$level=$_SESSION['dprcoe']['level'];

if($_SESSION['dprcoe']['level'] < 2 AND empty($_SESSION['dprcoe']['accessPark']))
	{
	$park = $_SESSION['parkS'];
	}
else
	{$_SESSION['parkS']=$park;}

// Process input
if(@$Submit =="Find")
	{
// 	echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
			$selectCount="";
			$groupby="";
	  $monthArray = range(1,12);
	  if(!isset($month)){$month="";}
		if (in_array($month, $monthArray)){}
	else
		{
		$monthArrayName = array('','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
		$trans = array_flip($monthArrayName);
		@$month = $trans[$month];
		}
	
	if(!isset($dist)){$dist="";}
	if(!isset($park)){$park="";}

	
	// Create the WHERE clause
	$where = "WHERE 1";
	if($park)
		{
		$where .= " AND park='$park'";}
	if(@$enterBy)
		{
	//	@$enterBy=urldecode($enterBy);
		$where .=" AND enterBy='$enterBy'";}
	if($month)
		{
		if($month<10)
			{
			$month="-0".$month;
			}
			ELSE
			{
			$month="-".$month;
			}
		}
	ELSE
		{
		$month = "";
		}
		
	if(isset($day) AND @$day!="")
		{
		if($day<10){$day="-0".$day;}ELSE{$day="-".$day;}
		}
	@$dateE="%".$year.@$month.@$day."%";
	if($dateE!="%%")
		{$where .=" AND dateE LIKE '$dateE'";}
	
	
	if(@$title)
		{
		@$title=addslashes(urldecode($title));
		$where .=" AND title='$title'";}
	if(@$dist)
		{
		if(@$groupDist)
			{
			$where .=" and dist = '$dist'";
			$selectCount=",count(park) as countPark";
			$groupby="Group by park";}
			else
			{
			$where .=" and dist = '$dist'";}
		}
	
	$order_by="dateE desc ,park asc, title";
	
	if(!empty($comment))
		{
		if($comment=="ann_100")
			{
			$where .=" and ann_100 = 'x'";
			$order_by="dateE,park, title";
			}
			else
			{$where .=" and comment = '$comment'";}
		}
	if(!empty($event_type))
		{
//		echo "<pre>"; print_r($event_type); echo "</pre>"; // exit;
		$where .=" and (";
		foreach($event_type as $k=>$v)
			{$where .="event_type like '%$v%' OR ";}
		$where=rtrim($where, " OR ").")";
		}

	if(!empty($ann_100))
		{
		$where .=" and ann_100 = 'x'";
		$order_by="dateE,park, title";
		}
	
	$var_park_name="";
	$JOIN="";
	if(!empty($clause))
		{
		$var=explode("|",$clause);
		$where="WHERE ";
		foreach($var as $k=>$v)
			{
			$var1=explode("*",$v);
			IF($var1[0]=="Submit"){continue;}
			IF($var1[0]=="year"){$var1[0]="dateE";}
			IF($var1[0]=="month"){$var1[0]="dateE"; $var1[1]="-".str_pad($var1[1], 2, 0, STR_PAD_LEFT)."-";}
			IF($var1[0]=="day")
				{
				$var1[0]="dateE"; $var1[1]="-".str_pad($var1[1], 2, 0, STR_PAD_LEFT);
				$where.=$var1[0]." like '%".$var1[1]."' and ";
				}
				else
				{
				$where.=$var1[0]." like '%".$var1[1]."%' and ";
				}
			}
		$where=rtrim($where, " and ");
		$order_by="dateE,park, title";
		$var_park_name=", t2.park_name";
		$today=date("Y-m-d");
		$JOIN="LEFT JOIN dpr_system.parkcode_names as t2 on dprcoe.event.park=t2.park_code";
		$where.=" and dateE > '$today'";
		}
		
	$sql = "SELECT * $var_park_name $selectCount 
	From event 
	$JOIN
	$where $groupby ORDER BY $order_by";
//	echo " <br />$sql"; EXIT;
	$result = @mysql_query($sql, $connection) or die("$sql<br>Error #". mysql_errno() . ": " . mysql_error());
	$numrow = mysql_num_rows($result);
	if($numrow<1)
		{
		echo "<br><hr>No event found. $sql";exit;
		}
	if(@!$groupDist){$showNum=$numrow." programs";}
	
	if($numrow < 1){
	if(!isset($enterBy)){$enterBy="";}
	if(!isset($title)){$title="";}
	if(empty($year) and empty($month))
		{
		echo "<br><hr>Event deleted.";exit;
		}
		else
		{
		echo "<br><hr>No event found using: $year$month$day&nbsp;&nbsp;&nbsp;$enterBy&nbsp;&nbsp;&nbsp;$title";exit;
		}
	
	
	}
	//echo "<br>y $year m $month d $day $sql";
	
	if(!isset($showNum)){$showNum="";}
	
	if($level>2 and empty($rep))
		{
	//	echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
		FOREACH($_REQUEST as $k=>$v)
			{
			if(!empty($v))
				{
				$var[]=$k."*".$v;
				}
			}
		$temp=implode("|",$var);
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Excel <a href='find.php?rep=1&clause=$temp&Submit=Find'>export</a>";
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Excel <a href='find.php?rep=1&comment=ann_100&Submit=Find'>export Centennial</a> Events";
		}
	if(empty($rep))
		{echo "<html><head><title> Calendar of Events</title></head>
	<body bgcolor='beige'>
		<hr><font size='4' color='004400'> Calendar of Events $park $dist</font>$showNum <table width='100%'>";
		}
	
	if(!empty($rep))
		{
		$var_date=date("Y-m-d");
		$filename="Centennial_Events_".$var_date.".xls";
		if(!empty($clause))
			{$filename="NC_State_Park_Events_".$var_date.".xls";}
		header('Content-Type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=$filename");
		echo "<html><body><table border=1>";
		}
	echo "
	<tr><td width='7%' align='center'><u>Park</u></td><td width='7%' align='center'><u>Date of Event</u></td><td width='5%'></td><td width='20%' align='center'><u>Event Title</u></td>";
	if(!empty($clause))
		{echo "<td width='20%' align='center'><u>Description</u></td>";}
	if(empty($rep))
		{
		echo "<td width='15%' align='center'><u>Entered By</u></td></tr>";
		}
		
	if(!isset($countPark)){$countPark="";}
	while ($row = mysql_fetch_array($result))
		{
		extract($row);
		@$total+=$countPark;
		if(!empty($clause))
			{$park=$park_name;}
		echo "<tr><td width='5%' align='center'>$park $countPark</td>";
		$adate=strftime('%a, %b %e, %Y',strtotime($dateE));
		if (substr("$adate", 0, 1)=="S")
			{echo "<td width='7%' align='center'><font color = 'red'>$adate</font></td>";} 
			ELSE 
			{echo "<td width='10%' align='right'><font color = 'green'>$adate</font></td>";}
		
		if(empty($rep))
			{
			echo "<td width='5%'></td><td width='20%' >";
			if($ann_100=="x" and $level>3)
				{echo "100th <a href='new_entry.php?eid=$eid'>$title</a>";}
				else
				{echo "<a href='edit.php?eid=$eid'>$title</a>";}
			}
		if(!empty($rep))
			{
			if(empty($clause))
				{echo "<td>100th</td><td>$title</td>";}
				else
				{echo "<td>Start Time: $start_time</td><td>$title</td><td width='50%'>$content</td>";}
			
			}
		
		if(empty($rep))
			{
			echo "<td width='15%'>$enterBy</td></tr>";
			}
			else
			{
				if(empty($clause))
					{echo "</tr>";}
			}
		}
	if(@$groupDist)
		{
		$showTot="<tr><td colspan='2'>Total Number of Programs: $total</td><td colspan='2'>Date of Event and Title are just representative. To see all programs for the District do not summarize.</tr>";}
		else
		{$showTot="";}
		
	echo "$showTot</table></body></html>";
	exit;
	} // end Add
//  ************Start input form*************

@$defaultPark=$park;      
if(@$title1==""){@$keepTitle=urldecode(stripslashes($title));}else
{$keepTitle=stripslashes($title1);}
if(@$enterBy1==""){@$keepName=urldecode(stripslashes($enterBy));}else
{$keepName=stripslashes($enterBy1);}

@$keepMonth=$month; @$keepDay=$day; @$keepYear=$year;
//echo "m $month  d $day  y $year"; exit;

$sql = "SELECT DISTINCT enterBy From event WHERE park='$defaultPark' ORDER by enterBy";
$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
$sql = "SELECT DISTINCT title, content From event WHERE park='$park' GROUP by title ORDER by title";
$result1 = mysql_query($sql) or die ("Couldn't execute query. $sql");

if(!empty($park))
	{
	$sql = "SELECT DISTINCT left(dateE,4) as years From event WHERE park='$park' ORDER by dateE";
	$result2 = mysql_query($sql) or die ("Couldn't execute query. $sql");
	while($row=mysql_fetch_assoc($result2))
		{
		$array_of_years[]=$row['years'];
		}
//echo "<pre>"; print_r($array_of_years); echo "</pre>"; // exit;
	}
echo "<html><head><title>Search Calendar of Events</title>

<script language=\"JavaScript\">
<!--
function MM_jumpMenu(selObj,restore){ //v3.0
eval(\"parent.frames['mainFrame']\"+\".location='\"+selObj.options[selObj.selectedIndex].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>


</head>
<body bgcolor='beige'><font size='4' color='004400'>Search the NC DPR Events Calendar</font>";

if(!isset($success)){$success="";}
echo "<br><br>$success</font>
<hr><form name='findEvents' method='post' action='find.php'>
<table> <tr><td align='right'><b>Selected Park: </b></td>
     <td><font size='4' color='blue'>";
     if($park!=""){echo "$parkCodeName[$park]";}
     echo "</font></td></tr></table>

<form name='newPark' method='post' action='find.php'>
<table><tr><td align='right'>Select a Different Park: </td>";
  echo "<td><select name='park' onChange=\"MM_jumpMenu(this,0)\">
  <option selected=''></option>";

       foreach($parkCode as $index=>$park_code)
        {
          $scode=$park_code;
          $xx="find.php?park=$scode";
          if($defaultPark == $scode){
         echo "<option selected='$xx'>$scode";}ELSE{
echo "<option value='$xx'>$scode";}
			echo "\n";
          }
echo "</select><td align='right'><b>District: </b>
<input type='radio' name='dist' value='EADI'>East
<input type='radio' name='dist' value='NODI'>North
<input type='radio' name='dist' value='SODI'>South
<input type='radio' name='dist' value='WEDI'>West</td>
<td> [Summarize by Dist.: <input type='checkbox' name='groupDist'>]</td>
</tr></table>";

echo "<table>";
echo "<tr><td>Select if appropriate:</td>
<th>Special Event/Festival:<input type='checkbox' name='event_type[]' value='festival'></th>
<th>Volunteer Project/Trail Work Day:<input type='checkbox' name='event_type[]' value='project'></th>
<th>Halloween:<input type='checkbox' name='event_type[]' value='halloween'></th>
<th>Thanksgiving:<input type='checkbox' name='event_type[]' value='thanksgiving'></th>
<th>Christmas:<input type='checkbox' name='event_type[]' value='christmas'></th>
</tr>";

echo "<tr><td><br /><br /></td></tr>";

echo "<tr><td valign='top'>Select if appropriate:</td><td>
<table>
<tr><th align='right'>
None:<input type='radio' name='comment' value='' checked></th align='right'></tr>

<tr><th align='right'>
First Day Hike:<input type='radio' name='comment' value='first_day'></th align='right'></tr>
<tr><th align='right'>
Earth Day Event:<input type='radio' name='comment' value='earth_day'></th align='right'></tr>
<tr><th align='right'>
100-Year Celebration/Homecoming:<input type='radio' name='comment' value='ann_100'></th align='right'></tr>
<tr><th align='right'>
NC Science Festival:<input type='radio' name='comment' value='science_festival'></th align='right'></tr>
</table>
</td>
<td>

<table>
<tr><th align='right'>
Kids to Parks Day:<input type='radio' name='comment' value='kid2park'></th align='right'></tr>
<tr><th align='right'>
National Trails Day :<input type='radio' name='comment' value='national_trail'></th align='right'></tr>
<tr><th align='right'>
National Public Lands Day :<input type='radio' name='comment' value='public_land'></th align='right'></tr>
<tr><th align='right'>
National Get Outdoors Day:<input type='radio' name='comment' value='get_out'></th align='right'></tr>
<tr><th align='right'>
Take A Child Outside Week :<input type='radio' name='comment' value='child_outside'></th align='right'></tr>
</table>

</td>
</tr></table>";

if($park)
	{
	echo "<table><tr><td><b>Entered By:</b></td>";
	echo"<td><select name='enterBy'><option value=''>";
	while ($row = mysql_fetch_array($result))
	{extract($row);$nameE=urlencode($enterBy);
	if($enterBy==$keepName or $enterBy==stripslashes($keepName)){
	echo "<option selected='$nameE'>$enterBy";}ELSE{
	echo "<option value='$nameE'>$enterBy";}
	}
	echo "</select></td></tr></table>";
	}

    $monthArray = range(1,12); $monthArrayName = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec',);

echo "<table><tr><td><b>Date of Event:</b></td><td>";
echo "<select name='month'>\n"; echo "<option value=''>\n";
for ($i=0; $i <=11; $i++)
	{
	$month = $monthArray[$i];
	if($keepMonth==$month){
	echo "<option selected='$month'>$monthArrayName[$i]";}ELSE{
	echo "<option value='$month'>$monthArrayName[$i]";}
	}
echo "</select> Month &nbsp;&nbsp;</td>";

$dayArray = range(1,31); echo "<td><select name='day'>\n";
 echo "<option value=''>\n";
for ($i=0; $i <=30; $i++)
	{
	$day = $dayArray[$i];
	if($keepDay==$day)
		{
		echo "<option selected='$day'>$day";
		}
		ELSE
		{
		echo "<option value='$day'>$day";
		}
	}
echo "</select> Day &nbsp;</td>";
 $thisYear = date('Y');  $nextYear = $thisYear + 1;

if(!empty($array_of_years))
	{$yearArray=$array_of_years;}
	else
	{$yearArray = range($thisYear, $nextYear);}

if(!in_array("2016",$yearArray))
	{$yearArray[]="2016";}
echo "<td><select name='year'>\n";
 echo "<option value=''>\n";
// $year = $yearArray[$i];
foreach($yearArray as $index=>$year)
	{
	if($year==$keepYear){$s="selected";}else{$s="value";}
	echo "<option $s='$year'>$year</option>\n";
	}
echo "</select> Year &nbsp;</td></tr></table>";

if($park)
	{
	echo "<table><tr> <td><b>Program Title:</b></td>";
	$titleArray = array(); $titleArray[0] = "";
	echo"<td><select name='title'><option value=''>";
	while ($row = mysql_fetch_array($result1))
	{extract($row);
// 	$titleE=urlencode($title);
	$titleE=$title;
	if($title==stripslashes($keepTitle)){
	echo "<option selected='$titleE'>$title";}ELSE{
	echo "<option value='$titleE'>$title";}
	}
	echo "</select></td></tr></table>";
	}

echo "
 <table width='500'><tr><td width='100' align='center'>
 <input type='hidden' name='park' value='$park'>
 <input type='submit' name='Submit' value='Find'></form></td></tr></table>
<hr>
</body></html>";
?>