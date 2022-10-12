<?php
    		// This creates a thumbnail using ImageMagick
    		
// Check image type
$var_ft=explode(".",$uploadfile);
$file_type=array_pop($var_ft);

// name thumbnail
$var_ft=explode("/",$uploadfile);
$file=array_pop($var_ft);
array_push($var_ft, "tn_".$file);
$tn=implode("/",$var_ft);

$non_pdf=array("doc","docx","xls","xlsx");
if($file_type!="pdf")
	{
	if(!in_array($file_type, $non_pdf))
		{
		$image = new Imagick($uploadfile); 
		$image->thumbnailImage(200, 0); 
		//echo $image;
		$image->writeImage($tn);
		$image->clear();
		$image->destroy();
		}
	}
else
	{
	$new_tn=str_replace(".pdf",".jpg",$tn); // if original image was a PDF
	//header("Content-type: image/jpeg"); // for testing
	$img = new Imagick($uploadfile); 
	$img->setImageFormat("jpg");
	$img->thumbnailImage(200, 0); 
	$img->writeImage($new_tn);
// 	echo "$img"; exit;   // for testing
	$img->clear();
	$img->destroy();
	}
?>