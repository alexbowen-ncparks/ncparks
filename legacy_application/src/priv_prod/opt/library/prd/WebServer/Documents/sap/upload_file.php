<?php
$dbTable="permits";

//		ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
include("../../include/iConnect.inc");// database connection parameters
$database="sap";
mysqli_select_db($connection,$database)
       or die ("Couldn't select database");
       
extract($_REQUEST);

//print_r($_FILES); 
//echo "<pre>"; print_r($_REQUEST); print_r($_FILES); echo "</pre>";  exit;
//exit;

if ($submit == "Add File")
	{
	extract($_FILES);
	$size = $_FILES['file_upload']['size'];
	
	
	if($size>"2000000"){echo "The file you attempted to upload is larger than 2MB. You will need to rescan the PDF at a size less than 2MB. (Try scanning in black/white instead of color.)<br /><br />Click your browser's back button to return to the upload page.";exit;}
	
	
	$type = $_FILES['file_upload']['type']; 
	$var = explode("/",$type);
	$ext=$var[1];
	
	$file=$parkcode."_SAP_".$_REQUEST['permit_number'].".".$ext;
	
//	echo "$file";exit;
	
//print_r($_FILES); print_r($_REQUEST);exit;
	if(!is_uploaded_file($_FILES['file_upload']['tmp_name']))
		{
		print_r($_FILES);  print_r($_REQUEST);
		exit;
		}
	
	 if(!$parkcode){echo "Must have a parkcode in order to proceed.";exit;}
	
	$uploaddir = "file_upload"; // make sure www has r/w permissions on this folder
	if (!file_exists($uploaddir)) {mkdir ($uploaddir, 0777);}
		//else{echo "$uploaddir exits"; exit;}

	// Not needed if filename passed from upload_forms.php
	// It will already be clean.
			//$file=str_replace("/","_",$file);
			//$file=str_replace(",","_",$file);
			//$file=str_replace(" ","_",$file);
			//$file=str_replace("'","_",$file);
	
	
	$newdate=date("Y-m-d");
		$dir = explode("-",$newdate);
		$dirname = $parkcode."_".$dir[0];
		$folder = "file_upload/".$dirname;
	if (!file_exists($folder)) {mkdir ($folder, 0777);}
		//else{echo "$folder exits"; exit;}
	
		$dirname = $parkcode."_".$dir[0]."/".$dir[1];
		$folder = "file_upload/".$dirname;
	if (!file_exists($folder)) {mkdir ($folder, 0777);}
		//else{echo "$folder exits"; exit;}
	
	  //  $folder = "file_upload/CABE_2009/03/;
		
	$uploadfile = $folder."/".$file;
//	echo "$uploadfile";exit;

	
if (move_uploaded_file($_FILES['file_upload']['tmp_name'], $uploadfile))
	{
//	echo "hello Denise";exit;
	} 
	else 
	{
	echo '<pre>';
    		echo "Permission Problem or Possible file upload attack!\n";
		echo "Here is some more debugging info:\n";
		echo "target = $uploadfile\n";
		print_r($_FILES); exit;
	echo "</pre>";
	}

//	move_uploaded_file($_FILES['tmp_name'],$uploadfile);// create file on server
	
	$TABLE="permits";
	
	$sql = "UPDATE $TABLE set link='$uploadfile' where id='$id'";
	//  echo "$sql";exit;
	$result = @mysqli_query($connection,$sql) or die("c=$connection $sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		mysqli_CLOSE($connection);
	}
		
		header("Location: permits.php?e=1&id=$id");
	exit;	
?>