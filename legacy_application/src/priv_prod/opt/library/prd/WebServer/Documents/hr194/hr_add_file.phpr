<?php
$database="hr";
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);

// echo "<pre>"; print_r($_FILES); echo "</pre>";  //exit;
// 
// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
//exit;
date_default_timezone_set('America/New_York');

if ($submit == "Add File")
	{	
	extract($_FILES);
	$size = $_FILES['file_upload']['size'];
	
	
	if($size>"3072000"){echo "The file you attempted to upload is larger than 3072kb. You will need to rescan the PDF at a size less than 3072kb.<br /><br />Click your browser's back button to return to the upload page.";exit;}
	
	
	$type = $_FILES['file_upload']['type']; 
	$var = explode("/",$type);
	$ext=$var[1];
	
	if($ext=="msword"){$ext="doc";}
	if($ext=="octet-stream"){$ext="docx";}
	if($ext=="vnd.openxmlformats-officedocument.wordprocessingml.document")
		{$ext="docx";}
	$file = $_POST['form_name'].".".$ext;
	
	if(!is_uploaded_file($file_upload['tmp_name'])){print_r($_FILES);  print_r($_POST);
	exit;}
	
	 if(!$parkcode){echo "Must have a parkcode in order to proceed.";exit;}
	
	$uploaddir = "file_upload/"; // make sure www has r/w permissions on this folder
	
	// Not needed if filename passed from upload_forms.php
	// It will already be clean.
			//$file=str_replace("/","_",$file);
			//$file=str_replace(",","_",$file);
			//$file=str_replace(" ","_",$file);
			//$file=str_replace("'","_",$file);
	$Lname=str_replace("\\'","_",$Lname);
// 	echo "$Lname"; exit;
	$Lname=str_replace("'","_",$Lname);
	$Fname=str_replace("'","_",$Fname);
	$file=str_replace(" ","_",$file);
	$file=$Lname.$Fname.$beacon_num.$file;
	
	$newdate=date("Y-m-d");
		$dir = explode("-",$newdate);
		$dirname = $parkcode."_".$dir[0];
		$folder = "file_upload/".$dirname;
	if (!file_exists($folder)) {mkdir ($folder, 0777);}
	
		$dirname = $parkcode."_".$dir[0]."/".$dir[1];
		$folder = "file_upload/".$dirname;
	if (!file_exists($folder)) {mkdir ($folder, 0777);}
	
	  //  $folder = "file_upload/CABE_2009/03/;
		
	$uploadfile = $folder."/".$file;
// 	echo "$uploadfile";exit;
	
	move_uploaded_file($file_upload['tmp_name'],$uploadfile);// create file on server
	
	$TABLE="hr_forms";
	
	$sql = "REPLACE $TABLE set parkcode='$parkcode', form_name='$form_name', tempID='$tempID', beacon_num='$beacon_num', file_link='$uploadfile'";
	//  echo "$sql";exit;
	$result = @mysqli_query($connection,$sql) or die();
	
	if(@$pd_107)
		{
		$database="hr";
		mysqli_select_db($connection,$database);
		
		$TABLE="employ_position";
// 		session_start();
		//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
		
		$sql = "UPDATE $TABLE set process_num='$process_num' where tempID='$tempID' and beacon_num='$beacon_num' and parkcode='$parkcode'";
		//  echo "$sql";exit;
		$result = @mysqli_query($connection,$sql) or die();
			mysqli_CLOSE($connection);
		}
		
		header("Location: upload_forms.php?parkcode=$parkcode&tempID=$tempID&beacon_num=$beacon_num");
	exit;
	}
?>