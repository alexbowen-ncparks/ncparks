<?php
ini_set('display_errors',1);
$database="program_share";
$title="I&E Mind Meld";
//include("../_base_top.php");

if($_SESSION['program_share']['level'] <0)
	{
	echo "<br /><br />This application is still being developed."; exit;
	}
	
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 

extract($_GET);

$sql="SELECT * FROM item_upload_thumb where upload_id='$upload_id'";
$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
$row=mysqli_fetch_assoc($result);
extract($row);
$file="/opt/library/prd/WebServer/Documents/program_share/".$thumb_link;
unlink($file);

$exp=explode("/",$file);
			$temp=array_pop($exp);
			$thumb=implode("/",$exp)."/tn_".$temp;
unlink($thumb);
$sql="DELETE FROM item_upload_thumb where upload_id='$upload_id'";
$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));

header("Location: program.php?item_id=$item_id");
?>