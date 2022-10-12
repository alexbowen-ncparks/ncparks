<?php
$database="divper";
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);

//print_r($_FILES); 
//echo "<pre>"; print_r($_REQUEST); print_r($_FILES);echo "</pre>";  //exit;
//exit;

if($_FILES['file_upload']['error']==1){echo "The file was too large.";exit;}

if ($submit == "Add File")
	{
	extract($_FILES);
	$size = $_FILES['file_upload']['size'];
	
	
	if($size>"500000"){echo "The file you attempted to upload is larger than 500kb. You will need to rescan the PDF at a size less than 500kb.<br /><br />Click your browser's back button to return to the upload page.";exit;}
	
	
	$type = $_FILES['file_upload']['type']; 
	$var = explode("/",$type);
	$ext=$var[1];
	
	if($ext=="msword")
		{$ext="doc";}
	if($ext=="octet-stream")
		{$ext="docx";}
	if($ext=="vnd.openxmlformats-officedocument.wordprocessingml.document")
		{$ext="docx";}
	if($ext=="vnd.openxmlformats-officedocument.spreadsheetml.sheet")
		{$ext="xlsx";}
	if($ext=="vnd.ms-excel")
		{$ext="xlsx";}
	
	if($form_name=="telephone")
		{
			if($ext!="pdf"){echo "The file format for the telephone references must be a PDF. Click your browser's back button to upload the PDF."; exit;}
		}
	else
		{
			if($ext!="doc" AND $ext!="docx"){echo "The file format for the $form_name must be a Word doc. Click your browser's back button to upload the Word doc.";exit;}
		}
	$form_name = $form_name.".".$ext;
	
	
	//print_r($_FILES); print_r($_REQUEST);exit;
	//echo "<pre>";print_r($_FILES); print_r($_REQUEST);echo "</pre>"; exit;
	
	if(!is_uploaded_file($file_upload['tmp_name'])){print_r($_FILES);  print_r($_REQUEST);
	exit;}
	
	
	//$tempID=$last_name.$ssn;
	//$file=$tempID."_".$beacon_num."_".$form_name;
	$file=$beacon_num."_".$form_name;
	
	$newdate=date("Y-m-d");
		$dir = explode("-",$newdate);
		$dirname = $dir[0];
		$folder = "applications/".$dirname;
	if (!file_exists($folder)) {mkdir ($folder, 0777);}
	
		$dirname = $dir[0]."/".$dir[1];
		$folder = "applications/".$dirname;
	if (!file_exists($folder)) {mkdir ($folder, 0777);}
	
		
	$uploadfile = $folder."/".$file;
	//echo "$uploadfile";exit;
	
	move_uploaded_file($file_upload['tmp_name'],$uploadfile);// create file on server
	
	$sql = "REPLACE application_uploads set user_name='$user_name', form_name='$form_name', beacon_num='$beacon_num', file_link='$uploadfile'";
	//  echo "$sql";exit;
	$result = @mysqli_query($connection,$sql) or die(" $sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		mysqli_CLOSE($connection);
	
		
		header("Location: recommend.php?beacon_num=$beacon_num");
	exit;	}
?>