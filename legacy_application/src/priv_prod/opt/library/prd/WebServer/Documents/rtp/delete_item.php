<?php

if(empty($_SESSION))
	{
	session_start();
	}
if(empty($_SESSION['rtp']['set_cycle'])){echo "Contact Tom Howard."; exit;}

date_default_timezone_set('America/New_York');
$database="rtp"; 
$dbName="rtp";

include("../../include/iConnect.inc");
mysqli_select_db($connection,$dbName);
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
 
$skip=array("id","var_table","project_file_name","source","submit_form");

if($_SESSION['rtp']['set_cycle']=="pa"){$TABLE="attachments_pa";}
if($_SESSION['rtp']['set_cycle']=="fa"){$TABLE="attachments";}

if(!empty($track_id))
	{
	$sql="SELECT project_file_name, link from $TABLE where track_id='$track_id'"; 
//	echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	if(mysqli_num_rows($result)>0)
		{
		$row=mysqli_fetch_assoc($result);
		extract($row);
		unlink($link);
		$sql="DELETE from $TABLE where track_id='$track_id'"; //echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		}
	
// 	$sql="DELETE FROM items where id='$id'"; //echo "$sql"; exit;
// 	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
// 	
	// echo "That item has been removed."; exit;
	header("Location: view_form.php?var=attachments&project_file_name=$project_file_name");
	}
	

?>