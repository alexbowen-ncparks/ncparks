<?php
//echo "hello";exit;

function headerStuff14($message)
	{
	echo "<html><head><META HTTP-EQUIV=\"CACHE-CONTROL\" CONTENT=\"NO-CACHE\"><title>Status</title>
	<STYLE TYPE=\"text/css\">
	<!--
	body
	{font-family:sans-serif;background:beige}
	td
	{font-size:80%;background:beige}
	th
	{font-size:95%; vertical-align: bottom}
	--> 
	</STYLE></head>
	<body>";
	if($message){echo "<table><tr><td>$message</td></tr></table>";}
	
	echo "<form name='statusForm' method='post' action='itinerary14.php'>";
	}

function headerStuff($message)
	{
	echo "<html><head><META HTTP-EQUIV=\"CACHE-CONTROL\" CONTENT=\"NO-CACHE\"><title>Status</title>
	<STYLE TYPE=\"text/css\">
	<!--
	body
	{font-family:sans-serif;background:beige}
	td
	{font-size:80%;background:beige}
	th
	{font-size:95%; vertical-align: bottom}
	--> 
	</STYLE></head>
	<body><table>";
	if($message){echo "$message";}
	
	echo "</table><form name='statusForm' method='post' action='itinerary.php'>";
	}


function displayWeek($item1,$key)
	{
	global $it,$updateon,$t,$n;
	$itin=explode("*",$item1);
	$n=date("l - F jS",$itin[0]);$it=$itin[1];$var1=$itin[2];
	formatDay($n,$it,$updateon);
	echo "<tr><td align='right' valign='top'>$n</td><td>
	<textarea name='$var1' cols='50' rows='3'>$it</textarea></td></tr>";
	}

function displayWeek1($item1,$key)
	{
	global $it,$updateon,$t,$n;
	$itin=explode("*",$item1);
	$n=date("l - F jS",$itin[0]);$it=$itin[1];$var1=$itin[2];
	$m=strtotime("week");
	$mm=date('l dS of F Y', $m);
	
	formatDay($n,$it,$updateon);
	echo "<td align='right' valign='top'>Day: $mm $n<br>
	<textarea name='$var1' cols='20' rows='2'>$it</textarea></td>";
	}

function displayWeek2($item1,$key)
	{
	global $it,$updateon,$t,$n;
	$itin=explode("*",$item1);
	$n=date("l - F jS",$itin[0]);$it=$itin[1];$var1=$itin[2];
	$w=date("W")+1;
	formatDay($n,$it,$updateon);
	echo "<td align='right' valign='top'>Week: $w $n<br>
	<textarea name='$var1' cols='20' rows='2'>$it</textarea></td>";
	}

function displayItineraryWeek1($week)
	{
//	include_once("../../include/connectWIYS.inc");
	global $connection,$tempID;
	$tempID="Howard6319";
	$sql="SELECT day1 FROM wiys.itinerary14 where empID='$tempID'";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$row=MYSQLI_FETCH_ARRAY($result);
	extract($row);echo "<td>1=$day1</td>";
	$sql="SELECT day2 FROM wiys.itinerary14 where empID='$tempID'";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$row=MYSQLI_FETCH_ARRAY($result);
	extract($row);echo "<td>2=$day2</td>";
	}

function displayItineraryWeek2($item1,$key)
	{
	global $it,$updateon,$t,$n,$new;
	$itin=explode("*",$item1);
	$day=explode("~",$itin[1]);
	$itNew=strtotime($day);
	$n=date("l - F jS",$itin[0]);$it=$itin[1];$var1=$itin[2];
	//$n=date("l - F jS",$itNew);$it=$itin[1];$var1=$itin[2];
	//$new=date("l - F jS",$itNew);
	formatDay($n,$it,$updateon,$new);
	echo "<tr><td align='right' valign='top'>$n</td><td>$it</td></tr>";
	}

function displayItinerary($item1,$key)
	{
	global $it,$updateon,$t,$n,$new;
	$itin=explode("*",$item1);
	$day=explode("~",$itin[1]);
	$itNew=strtotime($day);
	$n=date("l - F jS",$itin[0]);$it=$itin[1];$var1=$itin[2];
	//$n=date("l - F jS",$itNew);$it=$itin[1];$var1=$itin[2];
	//$new=date("l - F jS",$itNew);
	formatDay($n,$it,$updateon,$new);
	echo "<tr><td align='right' valign='top'>$n</td><td>$it</td></tr>";
	}

function formatDay($n,$it,$updateon,$new)
	{
	global $n,$it,$t,$new;
	$IT=explode("~",$it);
	if($IT[0]>=$updateon){$it=$IT[1];}else{$it="";}
	//echo "f=$updateon it=$IT[0]";exit;
	if($n==$t){$n="<b><font color='blue'>$n</font></b>";}
	}
?>
