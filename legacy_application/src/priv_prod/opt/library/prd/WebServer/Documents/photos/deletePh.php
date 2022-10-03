<?php

ini_set('display_errors',1);
$database="photos";
include("../../include/auth.inc");
include("../../include/connectROOT.inc");
mysql_select_db($database,$connection);
extract($_REQUEST);	
// echo "<pre>";print_r($_REQUEST);echo "</pre>";  exit;

if (@$del == "y")
	{
	$sql="SELECT link FROM images where pid='$pid'";
	$result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
	$row=mysql_fetch_assoc($result);
	extract($row);
//	echo "<pre>"; print_r($row); echo "</pre>"; exit;
	unlink($link);
	
	$dir=explode("/",$link);
		$file1024 = $dir[0]."/".$dir[1]."/".$dir[2]."/1024.".$dir[3];
		$file800 = $dir[0]."/".$dir[1]."/".$dir[2]."/800.".$dir[3];
		$file640 = $dir[0]."/".$dir[1]."/".$dir[2]."/640.".$dir[3];
		$fileztn = $dir[0]."/".$dir[1]."/".$dir[2]."/ztn.".$dir[3];
		
	if (file_exists($file1024)) {unlink($file1024);}
	if (file_exists($file640)) {unlink($file640);}
	if (file_exists($fileztn)) {unlink($fileztn);}
	
	$query = "DELETE FROM images WHERE pid=$pid";
	} 
ELSE
	{
	$query = "UPDATE images SET mark='x' WHERE pid='$pid'";
	}
    
$result = @mysql_query($query, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());

if (@$del == "y")
	{
	if(@$source=="divper"){echo "Photo deleted. You can close this window";exit;}
	include("markedPhoto.php"); exit;
	}
else {
    print "The photo has been deleted.
<br><br>Close this window.";}

?>