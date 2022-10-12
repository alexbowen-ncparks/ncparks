<?php 
/*
	Function createthumb($name,$filename,$new_w,$new_h)
	creates a resized image
	variables:
	$name		Original filename
	$filename	Filename of the resized image
	$new_w		width of resized image
	$new_h		height of resized image
*/	
function createthumb($name,$filename,$new_w,$new_h)
	{
//	 echo "$name $filename $new_w $new_h"; exit;
		global $old_x,$old_y;
		$system=explode(".",$name);
		
		if (preg_match("/jpg|jpeg/",$system[1]))
			{
				//	echo "imagecreatefromjpeg doesn't work";
				//	exit;
			$src_img=imagecreatefromjpeg($name);
				
		
			}
			
		if (preg_match("/png/",$system[1]))
			{
			$src_img=imagecreatefrompng($name);
			}
			
		$old_x=imageSX($src_img); //echo "$old_x"; exit;
		$old_y=imageSY($src_img);
		if ($old_x > $old_y)
			{
				$thumb_w=$new_w;
				$thumb_h=$old_y*($new_h/$old_x);
			}
		if ($old_x < $old_y)
			{
				$thumb_w=$old_x*($new_w/$old_y);
				$thumb_h=$new_h;
			}
		if ($old_x == $old_y)
			{
				$thumb_w=$new_w;
				$thumb_h=$new_h;
			}
		
	$dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);
//	$dst_img=imagecreatetruecolor($thumb_w,$thumb_h);
	imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 
		if (preg_match("/png/",$system[1]))
			{
				imagepng($dst_img,$filename); 
			}
			else
			{
			imagejpeg($dst_img,$filename); 
		//	imagejpeg($dst_img); 
			}
		imagedestroy($dst_img); 
		imagedestroy($src_img); 
	}
?>
