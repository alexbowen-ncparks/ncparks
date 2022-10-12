<?php

//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; exit;

$db="war";
include("../../include/connect_i_ROOT.inc"); // database connection parameters
$database="war";

$db = mysqli_select_db($connection,$database)       or die ("Couldn't select database");
       
extract($_REQUEST);

if(isset($pass_file_id))
	{
	$fld="file_link as link";
	$fam_id="family_id_file as pass_id";
	$table="family_upload_file";
	$id=$pass_file_id;
	}
	
if(isset($pass_photo_id))
	{
	$fld="photo_link as link";
	$fam_id="family_id_photo as pass_id";
	$table="family_upload_photo";
	$id=$pass_photo_id;
	}
	
$sql="SELECT $fld FROM $table where id='$id'";
$result = @MYSQLI_QUERY($connection,$sql); //ECHO "$sql";
$row=mysqli_fetch_assoc($result);
extract($row);

if($link)
	{
	unlink($link);
	if(!empty($pass_photo_id))
		{
		$exp=explode("/", $link);
		$thumb="ztn.".array_pop($exp);
		$th_link=implode("/",$exp)."/".$thumb;
		unlink($th_link);
		}
	$sql="DELETE from $table where id='$id'";
	$result=MYSQLI_QUERY($connection,$sql);
	
	header("Location: family_action.php?edit=$pass_record_id");
	exit;
	}


?>