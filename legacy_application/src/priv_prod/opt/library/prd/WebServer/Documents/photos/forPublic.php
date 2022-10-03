<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";
extract($_REQUEST);
if(count($_REQUEST)<1){exit;}

//echo "<pre>";print_r($_SERVER);echo "</pre>";
//echo "<pre>";print_r($_REQUEST);echo "</pre>";
@$refer=explode("?",$_SERVER['HTTP_REFERER']);
//echo "ref=$refer[0]";

$withThis="http:";
@$pos=strpos($sciName,$withThis);
@$pos1=strpos($pid,$withThis);
@$pos2=strpos($location,$withThis);
if($pos>-1 OR $pos1>-1 OR $pos2>-1)
	{
	header("Location: www.fbi.gov");
	exit;
	}

@$pos=strpos($_SERVER['QUERY_STRING'],"../");
if($pos>-1)
	{
	header("Location: http://www.fbi.gov");
	exit;
	}

include("../../include/connectROOT.inc");//$connection
include("../../include/get_parkcodes.php");

$database="photos";
mysql_select_db($database,$connection);	

@$pid=mysql_real_escape_string($pid);
@$sciName=mysql_real_escape_string($sciName);
@$location=mysql_real_escape_string($location);
$sql = "select photos.images.* from photos.images 
where pid='$pid'";
//echo "p=$pid";exit;
$result1 = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
$test_select=mysql_num_rows($result1);
if($test_select<1){exit;}
$row1=MYSQL_FETCH_ARRAY($result1);
extract($row1);
    $linkOriginal=$link; //used to pass file location from database
    $otherLinks[]=$link;
$CATgroup = strtoupper(str_replace(",", " ", $cat));

Header( "Content-type: text/html");
    echo "
<HTML>
<HEAD><TITLE>ID (Image Database)</TITLE>

<script language='JavaScript'>
function confirmLink()
{bConfirm=confirm('Are you sure you want to delete this Photo?')
 return (bConfirm);}
</script></HEAD>
<BODY bgcolor='beige'><div align='center'";
    echo "<hr>
<table border='1' cellpadding='3'><tr><td>Category: $CATgroup</td><td>Photo Title: $photoname</td><td>CD Name: $park $cd</td></tr>
<tr><td>File Name: $filename</td><td>Original File Size: $width x $height pixels</td></tr>";

if($photog){echo "<tr><td>Photographer: $photog</td>";}
if($date != "0000-00-00"){echo "<td>Date photo taken: $date </td>";}

if($width>640 AND $height>640)
	{
	echo "Also available in sizes up to <b>$width x $height</b><br>Contact the site <a href='mailto:tom.howard@ncdenr.gov?subject=Request%20for%20photo&body=Photo%20of%20$photoname%20from%20$park%20with%20ID=$pid'>admin</a> for info on obtaining a higher resolution.";
	}
	else
	{
	echo "Not available in any resolution higher than what is displayed.";
	}
if(!isset($linkFull)){$linkFull="";}
if(!isset($link1024)){$link1024="";}
if(!isset($link800)){$link800="";}
if(!isset($link640)){$link640="";}
if(!isset($editLink)){$editLink="";}
if(!isset($comment)){$comment="";}
echo "</tr></table>";
if($comment)
	{
	echo "<table><tr><td>Comment: $comment</td></tr></table>";
	}
echo "<table><tr><td align='center'>$linkFull</td><td>$link1024</td><td>$link800</td><td>$link640</td>$editLink</tr>";
echo "</table>";

// Works with either photo stored in db or as a file
@$cn=urlencode($comName);
if(@!$location)
	{
//	echo "hello";exit;
	include("getPhoto.php");
	//echo "<img src='getPhoto.php?pid=$pid' alt=\"$cn (<I>$sciName</I>), //$parkCodeName[$park], North Carolina, United States\">";
	}
	else
	{
	$loc=explode("/",$location); 
	
	if($source=="pub" || $source==""){$size="640";}
	
	switch ($size)
		{
				case "max":
		echo "<img src='$location'>";
		
					break;
				case "800":
				// code to resize to 800  resize.php
		$wid=800; $hei=800;
		$tn=$loc[0]."/".$loc[1]."/".$loc[2]."/800.".$pid.".jpg";
		if (file_exists($tn))
			{
				echo "<img src='$tn'>";
			}
			else
			{
			include("resize.php");
			createthumb($location,$tn,$wid,$hei);
			echo "<img src='$tn'>";
			}
					break;
				case "640":
				// code to resize to 640  resize.php
		$wid=640; $hei=640;
		$tn=$loc[0]."/".$loc[1]."/".$loc[2]."/640.".$pid.".jpg";
		if (file_exists($tn))
			{
				echo "<img src='$tn' alt=\"$cn (<I>$sciName</I>), $parkCodeName[$park], North Carolina, United States\">";
			}
			else
			{
			include("resize.php");
			createthumb($location,$tn,$wid,$hei);
			echo "<img src='$tn'>";
			}
					break;
				default:
				$tn=$loc[0]."/".$loc[1]."/".$loc[2]."/640.".$pid.".jpg";
					echo "<img src='$tn'>";
		}
	}	

echo "<br>Close window when done.<br>";//exit;


if($sciName)
	{
	$sql = "select photos.images.* from photos.images 
	where sciName='$sciName' and mark=''";
	$result1 = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
	$num=mysql_num_rows($result1);
	
	$j=0;$k=4;
	
	if($num>1){
	echo "<hr><table>";
	while ($row1=MYSQL_FETCH_ARRAY($result1)){
	extract($row1);
	
	$base="http://www.dpr.ncparks.gov/photos/";
	$newLink="http://www.dpr.ncparks.gov/photos/fromNRID.php?sciName=$sciName&pid=$pid&location=$link&size=640&source=pub";
	$iLink=explode("/",$link);
	$tempA=array($iLink[0],$iLink[1],$iLink[2]);
	$jLink=implode("/",$tempA);
	@$x++;
	$tnLink=$base.$jLink."/ztn.".$iLink[3];
	
	$z=fmod($j,$k);
	if($z==0){$t1="<tr>";}else{$t1="";}
	if($z==3){$t2="</tr>";}else{$t2="";}
	
	echo "$t1<td width='25%' align='center'><a href='$newLink'><img src='$tnLink'><br>Photo $x</a> &nbsp;&nbsp;$park&nbsp;&nbsp;$comment</td>$t2";
	$j++;
	}
	echo "</table>";
	}
	}
echo "</div></body></html>";
?>