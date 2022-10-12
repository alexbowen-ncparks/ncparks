<?php
$database="pac";
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);

extract($_REQUEST);

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
	$file=$parkcode."_".$file;
	$uploadfile = $uploaddir.$file;
	move_uploaded_file($file_upload['tmp_name'],$uploadfile);// create file on server
	
	$TABLE="pac.meetings";
	if($source=="CHOP"){
		$id=1;
		$TABLE="pac.chop_comment";}
	
	  $sql = "UPDATE $TABLE set file_link=concat_ws(',',file_link,'$uploadfile') where id='$id'";
	//  echo "$sql";exit;
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#");
		mysqli_CLOSE($connection);
	if($source!="CHOP"){header("Location: pac_cal.php?edit=$id");}
		else
		{header("Location: pac_chop_comment.php");}
	exit;	}
?>