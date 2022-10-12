<?php
include("../../include/iConnect.inc"); // database connection parameters
	$database="hr";
	mysqli_select_db($connection,$database);
date_default_timezone_set('America/New_York');	

extract($_REQUEST);

session_start();

//echo "<pre>"; print_r($_SESSION); echo "</pre>";  exit;
//exit;

if ($submit == "Add File")
	{	
	extract($_FILES);
	$size = $_FILES['letter_upload']['size'];
//	$type = $_FILES['letter_upload']['type']; 
	$file_name = $_FILES['letter_upload']['name']; 
	$var=explode(".",$file_name);
	$ext=array_pop($var);
	
	// old method which didn't work properly with some PDF files, got ".adobe" instead of ".pdf"
//	$var = explode("/",$type);
//	$ext=$var[1];
	
//	if($ext=="msword"){$ext="doc";}
//	if($ext=="octet-stream"){$ext="docx";}
	
	$file = $_REQUEST['form_name'].".".$ext;
	
	
	//print_r($_FILES); print_r($_REQUEST);exit;
	if(!is_uploaded_file($letter_upload['tmp_name']))
		{
		print_r($_FILES);  print_r($_REQUEST);
		exit;
		}
	
	 if(!$parkcode){echo "Must have a parkcode in order to proceed.";exit;}
	
	$uploaddir = "letter_upload/"; // make sure www has r/w permissions on this folder
	
	// Not needed if filename passed from upload_forms.php
	// It will already be clean.
			//$file=str_replace("/","_",$file);
			//$file=str_replace(",","_",$file);
			//$file=str_replace(" ","_",$file);
			//$file=str_replace("'","_",$file);
	
	$file=$Lname.$Fname.$beacon_num.$file;
	
	$newdate=date("Y-m-d");
		$dir = explode("-",$newdate);
		$dirname = $parkcode."_".$dir[0];
		$folder = "letter_upload/".$dirname;
	if (!file_exists($folder)) {mkdir ($folder, 0777);}
	
		$dirname = $parkcode."_".$dir[0]."/".$dir[1];
		$folder = "letter_upload/".$dirname;
	if (!file_exists($folder)) {mkdir ($folder, 0777);}
	
	  //  $folder = "letter_upload/CABE_2009/03/;
		
	$uploadfile = $folder."/".$file;
	//echo "$uploadfile";exit;
	
	move_uploaded_file($letter_upload['tmp_name'],$uploadfile);// create file on server
	
	$user=$_SESSION['logname'];
	
	$time=date("Y-m-d, g:i a");
	
	$stamp=$user."@".$time;
	$TABLE="hr_letter";
	
	$sql = "REPLACE $TABLE set parkcode='$parkcode', form_name='$form_name', tempID='$tempID', beacon_num='$beacon_num', file_link='$uploadfile', comments=concat('$stamp','*',comments)";
	//  echo "$sql";exit;
	$result = @mysqli_query($connection,$sql) or die(" $sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		mysqli_CLOSE($connection);
	
		header("Location: upload_separation.php?parkcode=$parkcode&tempID=$tempID&beacon_num=$beacon_num");
	exit;	
	}
?>