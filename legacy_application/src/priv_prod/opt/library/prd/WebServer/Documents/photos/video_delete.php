<?php
date_default_timezone_set('America/New_York');

//echo "<pre>"; print_r($_SESSION); echo "</pre>"; exit;

$database="photos";

include("../../include/auth.inc"); // includes session_start();
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

ini_set('display_errors',1);

include("../../include/connectROOT.inc"); 

if(@$_POST['submit']=="Delete Video Link")
	{
	$pid=$_POST['pid'];
	$sql = "DELETE from photos.videos where pid='$pid'";
//	echo "$sql"; exit;
	$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
	
	header("Location: video_links.php");
	}


?>
