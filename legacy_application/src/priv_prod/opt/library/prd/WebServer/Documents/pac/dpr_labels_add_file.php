<?php
ini_set('display_errors',1);
$database="divper";
//include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); 
mysqli_select_db($connection,'divper'); // database
extract($_REQUEST);

date_default_timezone_set('America/New_York');

echo "<pre>"; print_r($_REQUEST); echo "</pre>";
echo "<pre>"; print_r($_FILES); echo "</pre>";
//exit;
if ($submit == "Add File")
	{
	extract($_FILES);
	$size = $_FILES['file_upload']['size'];
	$type = $_FILES['file_upload']['type'];
	$file = $_FILES['file_upload']['name'];
	$mapName = $file;
	//$ext = substr(strrchr($file, "."), 1);// find file extention, png e.g.
	//print_r($_FILES); print_r($_REQUEST);exit;
	if(!is_uploaded_file($file_upload['tmp_name'])){print_r($_FILES);  print_r($_REQUEST);
	exit;}
	
	 
//	$ext = explode("/",$type);
	$uploaddir = "PAC/file_upload/"; // make sure www has r/w permissions on this folder
	
	$file=str_replace(",","_",$file);
	$file=str_replace(" ","_",$file);
	$file=str_replace("#","_",$file);
	$file=str_replace("'","_",$file);
	$file=str_replace("\"","_",$file);
	$file=str_replace("&","_",$file);
	$temp_array = explode(".",$file); 
	$ext = array_pop($temp_array);
	$time=time();
	$new_file=implode(".",$temp_array)."_".$time.".".$ext;
	$uploadfile = $uploaddir.$new_file;
	move_uploaded_file($file_upload['tmp_name'],$uploadfile);// create file on server
	$date=date("Y-m-d");
	$gc="File $new_file uploaded on $date.";
	
	
	  $sql = "UPDATE labels set file_link=concat_ws(',',file_link,'$uploadfile'), general_comments=concat_ws(' ',general_comments,'$gc') where id='$id'";
//	  echo "$sql";exit;
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#");
		mysqli_CLOSE($connection);
	header("Location: add_new.php?id=$id&submit_label=Find&park_code=$pass");
	exit;	}
?>