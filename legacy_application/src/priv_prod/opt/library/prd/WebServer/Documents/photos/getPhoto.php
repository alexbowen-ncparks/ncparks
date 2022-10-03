<?php
//extract($_REQUEST);
if(!isset($pid)){extract($_REQUEST);}
//echo "hello";exit;

if($pid)
	{
//	ini_set('display_errors',1);
	$database="photos";
	if(!isset($connection))
		{
		include("/opt/library/prd/WebServer/include/connectROOT.inc");
		}
	mysql_select_db($database,$connection);
	$pid=mysql_real_escape_string($pid);
	$sql="SELECT link FROM images WHERE pid=$pid";
//	echo "getPhoto.php<br />$sql"; exit;
	$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
	
	$row=mysql_fetch_array($result);
	extract($row);
	$var=explode("/",$link);
	$file=array_pop($var);
	$a="/640.".$file;
	$var1=implode("/",$var);
	$link=$var1.$a;
		$link="/photos/".$link;
	if(@$source=="admin")
		{
		echo "<img src='$link'>";
		}
	else
		{
		if(!isset($sciName)){$sciName="";}
		if(!isset($cn)){$cn="";}
		if(!isset($park)){$park="";}
		
		if(!isset($parkCodeName[$park])){$parkCodeName[$park]="";}
		if($park!="NONDPR"){$park=$parkCodeName[$park];}
		echo "<img src='$link' alt=\"$cn (<I>$sciName</I>), $park, North Carolina, United States\">";
		}
	}
?> 