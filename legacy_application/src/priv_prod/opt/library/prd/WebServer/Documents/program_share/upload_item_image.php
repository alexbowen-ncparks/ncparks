<?php
echo "<tr bgcolor='yellow'><td>Upload any <b>Image used</b> in activity: (.jpg, .jpeg, .png)</td><td><input type='file' name='files_img[]'><td></tr>";
//echo "<pre>"; print_r($_FILES); echo "</pre>"; exit;
if (!empty($_FILES))
	{
//echo "<pre>"; print_r($_FILES); echo "</pre>";// exit;
	date_default_timezone_set('America/New_York');
	   $num=count($_FILES['files_img']['name']);
	
	
	for($i=0;$i<$num;$i++)
		{
		$temp_name=$_FILES['files_img']['tmp_name'][$i];
		if($temp_name==""){continue;}

		if(!is_uploaded_file($_FILES['files_img']['tmp_name'][$i]))
			{
			//	echo "<pre>";
			//	print_r($_FILES);  print_r($_REQUEST);
			//	echo "</pre>";
			exit;
			}
		$image_name = $_FILES['files_img']['name' ][$i];
		$exp=explode(".",$image_name);
		$ext=array_pop($exp);
		$file_type = explode("/",$_FILES['files_img']['type'][$i]);

		$sql="INSERT INTO item_upload_image (item_id,image_name) "."VALUES ('$item_id','$image_name')";
		$result = @mysqli_query($connection, $sql) or die("$sql<br />Error #". mysqli_errno($connection) . ": " . mysqli_error($connection));

		$upload_id= mysqli_insert_id($connection);
		
		$year=date("Y");
		$ts=time();
		$uploaddir = "upload_image/".$year; // make sure www has r/w permissions on this folder

		//    echo "$uploaddir"; exit;
		if (!file_exists($uploaddir)) {mkdir ($uploaddir, 0777);}

		$new_name="program_file_".$item_id."_".$ts;
		$uploadfile = $uploaddir."/".$new_name.".".$ext;
		$thumb = $uploaddir."/tn_".$new_name.".".$ext;
		move_uploaded_file($temp_name,$uploadfile);// create file on server
		chmod($uploadfile,0777);
		$path_to_file="/opt/library/prd/WebServer/Documents/program_share/".$uploadfile;

		if($file_type[0]="image")
			{			
			$image = new Imagick($path_to_file); 
			$image->thumbnailImage(200, 0); 
			$target="/opt/library/prd/WebServer/Documents/program_share/".$thumb;
			$image->writeImage($target);
			$image->destroy();
			
			}	
		if(file_exists($path_to_file))
			{
			$sql = "UPDATE item_upload_image set image_link='$uploadfile' where upload_id='$upload_id'";
			$result = @mysqli_query($connection, $sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
			
			include("activity_query.php");
			}
			else
			{echo "There was a problem and the file was not uploaded. Contact Tom Howard for assistance."; exit;}
		}
	
	}
	
// *****************************

if(!empty($upload_image_array[0]))
	{
//		echo "image<pre>"; print_r($upload_image_array); echo "</pre>"; // exit;
	$upload_image_array=array_unique($upload_image_array);
	foreach($upload_image_array as $i=>$value)
		{
		$image_name=$image_name_array[$i];
		$image_id=$upload_image_array[$i];
		$file_link=$image_link_array[$i];
		if($i==0)
			{echo "<tr bgcolor='beige'><td align='right'>Uploaded Image: </td>";}
			else
			{echo "<tr bgcolor='beige'><td></td>";}
		if(!empty($file_link))
			{
			$view="View";
			$exp=explode("/",$file_link);
			$temp=array_pop($exp);
			$thumb=implode("/",$exp)."/tn_".$temp;
				$view="<img src=$thumb>";
			echo "<td><a href='$file_link' target='_blank'>$view</a><br /><font color='purple'>$image_name</font>";
			if(($level>3 or $entered_by==$_SESSION['program_share']['tempID']))
				{
				echo "<br /><a href='del_image.php?upload_id=$image_id' onclick=\"return confirm('Are you sure you want to delete this Image?')\">Delete</a>";
				}
			echo "</td>";
			}
		echo "</tr>";
		}
		
	}
?>