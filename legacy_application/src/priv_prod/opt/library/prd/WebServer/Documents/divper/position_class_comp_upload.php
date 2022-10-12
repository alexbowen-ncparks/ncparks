<?php
ini_set('display_errors',1);
$database="divper";
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);

date_default_timezone_set('America/New_York');

// extract($_REQUEST);

//print_r($_FILES); 
//echo "<pre>"; print_r($_REQUEST); print_r($_FILES); echo "</pre>"; //exit;
//exit;

if ($submit == "Add File")
	{
	
	extract($_FILES);
	$size = $_FILES['file_upload']['size'];
	
	
	if($size>"100000"){echo "The file you attempted to upload is larger than 1mb You will need to rescan the PDF at a size less than 1mb.<br /><br />Click your browser's back button to return to the upload page.";exit;}
	
	if($size<"50"){echo "You did not select a file to upload.<br /><br />Click your browser's back button to return to the upload page.";exit;}
	
	$type = $_FILES['file_upload']['name']; 
	$var = explode(".",$type);
	$ext=array_pop($var);
	
	if($ext!="pdf"){echo "You did not select a PDF file to upload.<br /><br />Click your browser's back button to return to the upload page.";exit;}
	
		
	$file = $beacon_num."_".$_REQUEST['form_name'].".".$ext;
	
	
	if(!is_uploaded_file($file_upload['tmp_name']))
		{
		print_r($_FILES);  print_r($_REQUEST);
		exit;
		}
	
	
	$folder="position_desc_files"; //make sure www has r/w permissions on this folder
	if (!file_exists($folder)) {mkdir ($folder, 0777);}
	
			$file=str_replace("/","_",$file);
			$file=str_replace(",","_",$file);
			$file=str_replace(" ","_",$file);
			$file=str_replace("'","_",$file);
			$file=str_replace("#","_",$file);
		//	$remove_file=str_replace(" ","_",$remove_file);
	

	$folder = "position_desc_files/class_comp";
	if (!file_exists($folder)) {mkdir ($folder, 0777);}
	
		
	$uploadfile = $folder."/".$file;
//	echo "$uploadfile";exit;
	
	$delete_file=$folder."/".$file;
	@unlink($delete_file);
	
	move_uploaded_file($file_upload['tmp_name'],$uploadfile);// create file on server
	
	$sql = "REPLACE position_class_comp_pdf set beacon_num='$beacon_num', form_name='$form_name', beacon_title='$beacon_title', file_link='$uploadfile'";
	//  echo "$sql";exit;
	$result = @mysqli_query($connection,$sql) or die(" $sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	
//	echo "$delete_file";
	
	header("Location: position_files.php?beacon_num=$beacon_num");
	exit;	}
?>