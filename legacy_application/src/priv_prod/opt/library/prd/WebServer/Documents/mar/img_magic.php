<?php
date_default_timezone_set('America/New_York');

$temp_name=$_FILES['file_upload_photo']['tmp_name'];
$name=addslashes($_FILES['file_upload_photo']['name']);
$error=$_FILES['file_upload_photo']['error'];
if($error==0)
	{
	if($temp_name==""){continue;}

	$e=explode(".",$_FILES['file_upload_photo']['name']);
	$ext=array_pop($e);
		$attachment_num=$_REQUEST['attachment_num'];
	$form_name="family_".$attachment_num;
	$file_name = $park."_".$form_name.".".$ext;

	$uploaddir = "uploads"; // make sure www has r/w permissions on this folder

	if (!file_exists($uploaddir))
		{mkdir ($uploaddir, 0777);chmod($uploaddir,0777);}
		$year=date("Y");
		$sub_folder=$uploaddir."/".$year;
		if (!file_exists($sub_folder))
			{mkdir ($sub_folder, 0777);chmod($sub_folder,0777);}


	$uploadfile = $sub_folder."/".$file_name;

	move_uploaded_file($temp_name,$uploadfile);// create file on server
	chmod($uploadfile,0777);

	$sql="INSERT family_upload_photo SET tempID='$tempID', photo_link='$uploadfile', photo_name='$name', family_id_photo='$id'";
	//		echo "$sql";exit;
	$result = @mysqli_query($connection, $sql) or die("$sql Error 1#". mysqli_error($connection) );
	}



		// This creates a thumbnail using ImageMagick
	$tn=$sub_folder."/ztn.".$file_name;

// Check image type
$var_ft=explode(".",$uploadfile);
$file_type=array_pop($var_ft);

if($file_type!="pdf")
	{
	$image = new Imagick($uploadfile); 
	$image->thumbnailImage(200, 0); 
	//echo $image;
	$image->writeImage($tn);
	$image->clear();
	$image->destroy();
	}
else
	{
	$new_tn=str_replace(".pdf",".jpg",$tn); // if original image was a PDF
	//header("Content-type: image/jpeg"); // for testing
	$img = new Imagick($uploadfile); 
	$img->setImageFormat("jpg");
	$img->thumbnailImage(200, 0); 
	$img->writeImage($new_tn);
	//echo "$img"; exit;   // for testing
	$img->clear();
	$img->destroy();
	}
?>