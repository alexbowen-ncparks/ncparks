<?php
// echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
echo "<html><head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
	<link rel=\"stylesheet\" href=\"/css/style.css\" type=\"text/css\" />

<script type=\"text/JavaScript\">
<!--
function MM_jumpMenu(targ,selObj,restore)
	{ //v3.0
	  eval(targ+\".location='\"+selObj.options[selObj.selectedIndex].value+\"'\");
	  if (restore) selObj.selectedIndex=0;
	}

function MM_jumpMenuNewWindow (selObj, restore)
	{
	
		window.open(selObj.options[selObj.selectedIndex].value);
	
		if (restore) selObj.selectedIndex=0;
	
	}
//-->
</script>";

extract($_REQUEST);
$findThis="http:";
$qs=$_SERVER['QUERY_STRING'];
$pos=strpos($qs,$findThis);
if($pos>-1){header("Location: http://www.fbi.gov");
exit;}
?>
	
<STYLE>
  .saveHistory {behavior:url(#default#savehistory);}
  .titletext {
	font: 0.7em Tahoma, sans-serif;
	font-size:24px;
	font-weight:bold;
	color: #CCCCCC;
}
.bodytext {
	font: 0.7em Tahoma, sans-serif;
	font-size:11px;
	color: #666666;
	}
	
.smalltext {
	font: 0.7em Tahoma, sans-serif;
	font-size: 11px;
	color: #666666;
}
</STYLE>
</SCRIPT>
</HEAD>
<body bgcolor="white">
<div align="center"><table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr bgcolor='gray'>
	  <td align="center" valign="top"><a href="http://ncparks.gov/"><img name="nrid_logo.jpg" src="../inc/nrid_logo.jpg" height="135" border="0" alt="NC State Parks System"></a></td>
	  </tr>
	  <tr bgcolor='white' height='1'>
	  <td> </td>
	  </tr>
	  <tr bgcolor='blue' height='2'>
	  <td> </td>
	  </tr>
	</table>
</div>

<?php

extract($_REQUEST);

$database="photos";
include("../../include/connectROOT.inc");
include("../../include/get_parkcodes.php");
$db = mysql_select_db($database,$connection) or die ("Couldn't select database $database");

$sql = "SELECT distinct park FROM videos where mark='' order by park";  //echo "$sql c=$connection";
$result = @mysql_query($sql, $connection);
while($row=mysql_fetch_assoc($result))
	{
	$park_array[]=$row['park'];
	}

echo "<table align='center'><tr><td>View videos from a NC State Park: </td>
<td><select name='park' onChange=\"MM_jumpMenu('parent',this,0)\"><option selected=''></option>\n";
foreach($park_array as $k=>$v)
	{
	$var=$parkCodeName[$v];
	if($v==$park){$s="selected";}else{$s="value";}
	echo "<option $s='video_public.php?park=$v'>$var</option>\n";
	}
echo "</select></td></tr></table>";

if(empty($park)){exit;}

if(isset($park)){$where="and park='$park'";}else{$where="";}
$sql = "SELECT t1.park, t1.sciName , t2.comName, t2.majorGroup, t1.video_link, t1.photog, t1.date,t1.comment
FROM videos as t1
LEFT JOIN nrid.dprspp as t2 on t1.sciName=t2.sciName
where mark='' $where";  //echo "$sql c=$connection";
$result = @mysql_query($sql, $connection);
while($row=mysql_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}

if(empty($ARRAY)){EXIT;}

$skip=array("photo","video_name","personID","dateM","mark","comment","cat","pid","subcat","lat","lon");
echo "<table border='1' cellpadding='3'><tr bgcolor='white'>";
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
	echo "<tr><td colspan='11' bgcolor='$color'><b>$comment</b></td></tr>";
	echo "</tr>";
	echo "<tr>";
	foreach($array as $k=>$v)
		{
		if(in_array($k,$skip)){continue;}
		$td="";
		if($k=="video_link")
			{
			$td="bgcolor='yellow' align='center'";
			$v=" &nbsp;<a href='$v' target='_blank'>video link</a>";
			}
		if($k=="cat" OR $k=="subcat"){$v=str_replace(","," ",$v);}
		if($k=="sciName"){$v="<i>$v</i>";}
		if($k=="park"){$v="<b>$v</b>";}
		
		echo "<td valign='top' $td>$v</td>";
		}
	}
echo "</table>";

echo "</body></html>";

?>