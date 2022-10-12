<?php
$num=count($_FILES['file_upload']['name']);

//echo "<pre>"; print_r($_FILES); echo "</pre>"; exit;
for($i=1;$i<=$num;$i++)
	{
	$temp_name=$_FILES['file_upload']['tmp_name'][$i];
	if($temp_name==""){continue;}
	
	$old_name=$_FILES['file_upload']['name'][$i];
	$exp1=explode(".",$old_name);
	$ext=array_pop($exp1);
	
	if(empty($year)){$year=date('y');}
	$uploaddir = "uploads/".$year; // make sure www has r/w permissions on this folder
	
	//    echo "$uploaddir"; exit;
	if (!file_exists($uploaddir)) {mkdir ($uploaddir, 0777);}

	$month=date('m');
	$uploaddir = "uploads/".$year."/".$month;
	if (!file_exists($uploaddir)) {mkdir ($uploaddir, 0777);} 

	$ts=time();
	$new_name=$pass_id."_".$i."_".$ts.".".$ext;
	
	$uploadfile = $uploaddir."/".$new_name;
	move_uploaded_file($temp_name,$uploadfile);// create file on server
	chmod($uploadfile,0777);
	
	$sql = "REPLACE file_upload set pass_id='$pass_id', file_num='$i', old_name='$old_name', link='$uploadfile'";
	$result = @mysqli_query($connection, $sql);
	
	if($_FILES['file_upload']['type'][$i]=="image/jpeg")
		{
		$tn_image=$uploaddir."/ztn.".$new_name;
		$img = new Imagick($uploadfile); 
		$img->setImageFormat("jpg");
		$img->thumbnailImage(200, 0); 
		$img->writeImage($tn_image);
		//echo "$img"; exit;   // for testing
		$img->clear();
		$img->destroy();
		}
	if($_FILES['file_upload']['type'][$i]=="image/png")
		{
		$tn_image=$uploaddir."/ztn.".$new_name;
		$img = new Imagick($uploadfile); 
		$img->setImageFormat("png");
		$img->thumbnailImage(200, 0); 
		$img->writeImage($tn_image);
		//echo "$img"; exit;   // for testing
		$img->clear();
		$img->destroy();
		}
	}
function createthumb($name,$filename,$new_w,$new_h){
	// global $gd2;
	global $old_x,$old_y;
	$system=explode(".",$name);
	if (preg_match("/jpg|jpeg/",$system[1]))
		{
	//	echo "<pre>"; print_r($system); echo "</pre>";  exit;
		$src_img=imagecreatefromjpeg($name);
		}
	if (preg_match("/png/",$system[1])){$src_img=imagecreatefrompng($name);}

//echo "n=$name s=$src_img"; exit;

	$old_x=imageSX($src_img);
	$old_y=imageSY($src_img);
	if ($old_x > $old_y) {
		$thumb_w=$new_w;
		$thumb_h=$old_y*($new_h/$old_x);
	}
	if ($old_x < $old_y) {
		$thumb_w=$old_x*($new_w/$old_y);
		$thumb_h=$new_h;
	}
	if ($old_x == $old_y) {
		$thumb_w=$new_w;
		$thumb_h=$new_h;
	}

$dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);
imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 

	if (preg_match("/png/",$system[1])){
		imagepng($dst_img,$filename); 
	} else {
		imagejpeg($dst_img,$filename); 
//include("addShadow.php");
	}
	imagedestroy($dst_img); 
	imagedestroy($src_img); 
}	
?>