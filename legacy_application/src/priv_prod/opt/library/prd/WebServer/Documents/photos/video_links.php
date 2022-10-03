<?php
$session_database="photos";
$database=$session_database;
$title="The ID";

include("../../include/auth.inc"); // includes session_start();
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

ini_set('display_errors',1);

include("/opt/library/prd/WebServer/Documents/_base_top.php");

extract($_REQUEST);

$level=$_SESSION['photos']['level'];

include("../../include/connectROOT.inc");

include("../../include/connectROOT.inc");
include("../../include/get_parkcodes.php");

$db = mysql_select_db($database,$connection) or die ("Couldn't select database $database");

$sql = "SELECT distinct park FROM videos where mark='' order by park";  //echo "$sql c=$connection";
$result = @mysql_query($sql, $connection);
while($row=mysql_fetch_assoc($result))
	{
	$park_array[]=$row['park'];
	}

if(!isset($park)){$park="";}
echo "<table align='center'><tr><td>View videos from a NC State Park: </td>
<td><select name='park' onChange=\"MM_jumpMenu('parent',this,0)\"><option selected=''></option>\n";
foreach($park_array as $k=>$v)
	{
	$var=$parkCodeName[$v];
	if($v==$park){$s="selected";}else{$s="value";}
	echo "<option $s='video_links.php?park=$v'>$var</option>\n";
	}
echo "</select></td></tr></table>";

if(empty($park))
	{
	$sql = "SELECT t1.park, t1.sciName, t2.comName, t2.majorGroup, t1.video_link, t1.photog, t1.date,t1.cat,t1.subcat, t1.lat, t1.lon, t1.comment, t1.pid
	FROM videos as t1
	LEFT JOIN nrid.dprspp as t2 on t1.sciName=t2.sciName
	where 1 
	order by dateM desc";  //echo "$sql c=$connection";
	$result = @mysql_query($sql, $connection);
	while($row=mysql_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	}
else
	{
	if(isset($park)){$where="and park='$park'";}else{$where="";}
	$sql = "SELECT t1.park, t1.sciName, t2.comName, t2.majorGroup, t1.video_link, t1.photog, t1.date,t1.cat,t1.subcat, t1.lat, t1.lon, t1.comment, t1.pid
	FROM videos as t1
	LEFT JOIN nrid.dprspp as t2 on t1.sciName=t2.sciName
	where mark='' $where";  //echo "$sql c=$connection";
	$result = @mysql_query($sql, $connection);
	while($row=mysql_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	}

if(empty($ARRAY)){EXIT;}

//echo "<pre>"; print_r($ARRAY); echo "</pre>";

$skip=array("photo","video_name","personID","dateM","mark","comment");
echo "<table border='1' cellpadding='3'><tr>";
foreach($ARRAY[0] as $k=>$v)
	{
	if(in_array($k,$skip)){continue;}
	echo "<th>$k</th>";
	}
	echo "</tr>";

$color="aliceblue";	
foreach($ARRAY as $index=>$array)
	{
	$comment=nl2br($array['comment']);
	if($color=="aliceblue"){$color="lightyellow";}else{$color="aliceblue";}
	echo "<tr><td colspan='12' bgcolor='$color'><b>$comment</b></td></tr>";
	echo "</tr>";
	echo "<tr bgcolor='$color'>";
	foreach($array as $k=>$v)
		{
		if(in_array($k,$skip)){continue;}
		$td="";
		if($k=="video_link")
			{
			$td="bgcolor='$color'";
			$v=" &nbsp;<a href='$v' target='_blank'>video link</a>";
			}
		if($k=="cat" OR $k=="subcat"){$v=str_replace(","," ",$v);}
		if($k=="sciName"){$v="<i>$v</i>";}
		if($k=="park"){$v="<b>$v</b>";}
		if($k=="pid")
			{
			$v="<a href='video_edit.php?source=photos&pid=$v'>edit</a>";
			}
		
		echo "<td valign='top' $td>$v</td>";
		}
	}
echo "</table>";

echo "</body></html>";

?>