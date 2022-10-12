<?php
//   echo "<pre>"; print_r($_POST); print_r($_FILES);echo "</pre>"; exit;

$database="le";
include("../../include/iConnect.inc"); // database connection parameters
$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");
extract($_REQUEST);


// *********** Delete ***********
if(isset($del))
	{
	$sql="SELECT pr63_id, link FROM le_images where id='$del'";
		$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		$row=mysqli_fetch_assoc($result);
		$im=$row['link'];
		$pr63_id=$row['pr63_id'];
		$path_parts=pathinfo($im);
//echo "<pre>"; print_r($path_parts); echo "</pre>";  exit;
				$tn=$path_parts['dirname']."/ztn.".$path_parts['basename'];
		unlink($im);
		$tn=str_replace(".pdf",".jpg",$tn); // if original image was a PDF
		unlink($tn);
		
	$sql="DELETE FROM le_images where id='$del'";
//		echo "$sql";exit;
		$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		
		header("Location: pr63_form_reg.php?id=$pr63_id");
	exit;
	}
	
	
// *********** Add ***********
if($submit=="Add Image(s)")
	{

	if(isset($_FILES['file_upload']['tmp_name']))
		{
include_once("tnModified.php");// loads functions to make thumbnail
			foreach($_FILES['file_upload']['tmp_name'] as $k=>$v)
				{
				$temp_name=$_FILES['file_upload']['tmp_name'][$k];
				$error=$_FILES['file_upload']['error'][$k];
				if($error>0){continue;}
					if($error==0)
						{
						if($temp_name==""){continue;}
				
						$ran=rand(1000,9999);
						$e=explode(".",$_FILES['file_upload']['name'][$k]);
						$n=count($e);
						$ext=$e[$n-1];
						$file_name = $form_name.$parkcode.$ran.".".$ext;				
			//echo "$file_name<br />"; 						
						}
//exit;
		$uploaddir = "uploads/$form_name"; // make sure www has r/w permissions on this folder

		if (!file_exists($uploaddir))
			{mkdir ($uploaddir, 0777);chmod($uploaddir,0777);}
				$year=date("Y");
				$sub_folder=$uploaddir."/".$year;
				if (!file_exists($sub_folder))
					{mkdir ($sub_folder, 0777);chmod($sub_folder,0777);}
   
    
		$uploadfile = $sub_folder."/".$file_name;

		move_uploaded_file($temp_name,$uploadfile);// create file on server
    		chmod($uploadfile,0777);

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
    		$size=getimagesize($uploadfile);
    	//	echo "<pre>"; print_r($size); echo "</pre>";  exit;
    		$size=mysqli_real_escape_string($size[3]);
    		$in=str_replace("'","",$image_name[$k]);
		$sql="INSERT le_images SET pr63_id='$id', parkcode='$parkcode', link='$uploadfile', image_name='$in', imagesize='$size'";
	//	echo "$sql<br />";//exit;
		$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
			}
		}

	header("Location: pr63_form_reg.php?id=$id&file=$mime");
	}
?>