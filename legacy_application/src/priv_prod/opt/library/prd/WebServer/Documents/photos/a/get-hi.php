<html><head></head><body><title>NC DPR Photo Gallery</title><div align='center'>
Please credit any use of this photo to the:
<b>NC Division of Parks and Recreation</b>
<?php

//print_r($_REQUEST);exit;
extract($_REQUEST);
include("../../../include/connectROOT.inc");
include("../../no_inject.php");
mysql_select_db("photos",$connection);
@$email=mysql_real_escape_string($email);
@$pid=mysql_real_escape_string($pid);

$sql = "select pid as CheckPid from `publish_hi-res` where email='$email'";
//echo "$sql<br />"; exit;
//exit;
$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
while ($row=mysql_fetch_array($result))
	{
	extract($row);
	$pos=strpos($CheckPid,",");
	if($pos>1)
		{
		$tempArray=explode(",",$CheckPid);
		foreach($tempArray as $k=>$v)
			{
			$photoArray[]=$v;
			}
		}
		else
		{
		$photoArray[]=$CheckPid;
		}
	}

if(!isset($photoArray)){exit;}
if(in_array($pid,$photoArray))
	{
	$sql = "update `publish_hi-res` set retrievals=concat_ws(',',retrievals,$pid) where pid like '%$pid%'";
	//echo "$sql";exit;
	$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
	
	$sql = "select photos.images.* from photos.images where pid='$pid'";
	//echo "$sql";exit;
	$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
	
	$row=MYSQL_FETCH_ARRAY($result);
	extract($row);
	  //  $linkOriginal=$link;
	echo "<br><i>$sciName</i> by $photog<br>";
	echo "<img src=\"http://www.dpr.ncparks.gov/photos/$link\">";
	}
else
{echo "<br><br>You do not have access to the hi-rez version of that photo. If you have requested access to photo # $pid, please make sure you have entered your email address correctly.<br><br>Click your browser's Back button to return to the thumbnails.";exit;}
?>
</table></div></body>
</html>