<?php
$database="divper";
//include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); 
mysqli_select_db($connection,'divper'); // database

//echo "<pre>"; print_r($_REQUEST); echo "</pre>";
//echo "<pre>"; print_r($_FILES); echo "</pre>";

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
	
	 
	$ext = explode("/",$type);
	$uploaddir = "PAC/file_upload/"; // make sure www has r/w permissions on this folder
	
	$file=str_replace(",","_",$file);
	$file=str_replace(" ","_",$file);
	$file=str_replace("#","_",$file);
	$file=str_replace("'","_",$file);
	$file=str_replace("\"","_",$file);
	$file=str_replace("&","_",$file);
	$uploadfile = $uploaddir.$file;
	move_uploaded_file($file_upload['tmp_name'],$uploadfile);// create file on server
	$date=date("Y-m-d");
	$gc="File $file uploaded on $date.";
	
	
	  $sql = "UPDATE labels set file_link=concat_ws(',',file_link,'$uploadfile'), general_comments=concat_ws(' ',general_comments,'$gc') where id='$id'";
	//  echo "$sql";exit;
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		mysqli_CLOSE($connection);
	header("Location: dpr_labels_find.php?id=$id&submit_label=Find&pass=$pass");
	exit;	}
?>