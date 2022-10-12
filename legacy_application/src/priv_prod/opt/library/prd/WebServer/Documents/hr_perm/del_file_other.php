<?php

date_default_timezone_set('America/New_York');
$database="hr_perm"; 
$dbName="hr_perm";

session_start();
$level=$_SESSION['rtp']['level'];
//if($level<1){exit;}

include_once("../../include/iConnect.inc");
extract($_GET);
$sql="SELECT file_link from hr_forms_other where id='$id'"; //echo "$sql"; exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
$row=mysqli_fetch_assoc($result);
extract($row);
if(!empty($file_link))
	{
	
	$sql="DELETE from hr_forms_other where id='$id'"; //echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	unlink($file_link);
	}

header("Location: edit_form.php?id=$track_id");



?>