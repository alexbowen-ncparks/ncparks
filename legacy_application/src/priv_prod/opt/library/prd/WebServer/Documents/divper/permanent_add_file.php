<?php
$database="divper";
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);
// extract($_REQUEST);

//print_r($_FILES); 
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; //exit;
//exit;

if ($submit == "Add File")
	{
	
	extract($_FILES);
	$size = $_FILES['file_upload']['size'];
	
	
	if($size>"500000"){echo "The file you attempted to upload is larger than 500kb. You will need to rescan the PDF at a size less than 500kb.<br /><br />Click your browser's back button to return to the upload page.";exit;}
	
	
//	$type = $_FILES['file_upload']['type']; 
//	$var = explode("/",$type);
//	$ext=$var[1];
	
	$type = $_FILES['file_upload']['name']; 
	$var = explode(".",$type);
	$ext=array_pop($var);
	
//	if($ext=="msword"){$ext="doc";}
//	if($ext=="octet-stream"){$ext="docx";}
//	if($ext=="vnd.openxmlformats-officedocument.wordprocessingml.document"){$ext="docx";}
//	if($ext=="vnd.openxmlformats-officedocument.spreadsheetml.sheet"){$ext="xlsx";}
//	if($ext=="vnd.ms-excel"){$ext="xlsx";}
	$file = $_REQUEST['form_name'].".".$ext;
	
	
	//print_r($_FILES); print_r($_REQUEST);exit;
//	echo "f=$file<pre>";print_r($_FILES); print_r($_REQUEST);echo "</pre>"; exit;
	
	if(!is_uploaded_file($file_upload['tmp_name'])){print_r($_FILES);  print_r($_REQUEST);
	exit;}
	
	
	$uploaddir = "file_upload/"; // make sure www has r/w permissions on this folder
	
			$file=str_replace("/","_",$file);
			$file=str_replace(",","_",$file);
			$file=str_replace(" ","_",$file);
			$file=str_replace("'","_",$file);
			$file=str_replace("#","_",$file);
	
	$file=$beacon_num.$file;
	//echo "f=$file"; exit;
	
	
	$newdate=date("Y-m-d");
		$dir = explode("-",$newdate);
		$dirname = $dir[0];
		$folder = "permanent_files/".$dirname;
	if (!file_exists($folder)) {mkdir ($folder, 0777);}
	
		$dirname = $dir[0]."/".$dir[1];
		$folder = "permanent_files/".$dirname;
	if (!file_exists($folder)) {mkdir ($folder, 0777);}
	
	  //  $folder = "file_upload/CABE_2009/03/;
		
	$uploadfile = $folder."/".$file;
//	echo "$uploadfile";exit;
	
	move_uploaded_file($file_upload['tmp_name'],$uploadfile);// create file on server
	
	$sql = "REPLACE permanent_uploads set form_name='$form_name', beacon_num='$beacon_num', file_link='$uploadfile'";
	//  echo "$sql";exit;
	$result = @mysqli_query($connection,$sql) or die("c=$connection $sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		mysqli_CLOSE($connection);
	
		
		header("Location: vacant_form_upload.php?beacon_num=$beacon_num&posTitle=$posTitle");
	exit;	}
?>