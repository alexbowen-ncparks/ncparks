<?php
if(empty($no_thumb))
	{
	echo "<tr bgcolor='#DBB8FF'><td>Upload the <b>Thumbnail Image</b>: (.jpg, .jpeg, .png)<br />
	It represents the activity shown on the Welcome page.</td><td><input type='file' name='files_tn[]'><td></tr>";
	}
	else
	{
	echo "<tr bgcolor='#DBB8FF'><td>Upload the <b>Thumbnail Image</b>: (.jpg, .jpeg, .png)<br />
	It represents the activity shown on the Welcome page.</td><td><td></tr>";
	}
//echo "<pre>"; print_r($upload_thumb_array); echo "</pre>"; //exit;
if (!empty($_FILES['files_tn']))
	{
//echo "<pre>"; print_r($_FILES); echo "</pre>";// exit;
	date_default_timezone_set('America/New_York');
	   $num=count($_FILES['files_tn']['name']);
	
	
	for($i=0;$i<$num;$i++)
		{
		$temp_name=$_FILES['files_tn']['tmp_name'][$i];
		if($temp_name==""){continue;}

		if(!is_uploaded_file($_FILES['files_tn']['tmp_name'][$i]))
			{
			//	echo "<pre>";
			//	print_r($_FILES);  print_r($_REQUEST);
			//	echo "</pre>";
			exit;
			}
		$thumb_name = $_FILES['files_tn']['name' ][$i];
		$exp=explode(".",$thumb_name);
		$ext=array_pop($exp);
		$file_type = explode("/",$_FILES['files_tn']['type'][$i]);
		$format=$file_type[1];
		if(!in_array($format,$accepted_images))
			{
			echo "<h2><font color='red'>f=$format Thumbnail image is not an acceptable format. It must be either .jpg, .jpeg, or .png.</font></h2>";
			}
			else
			{
			$sql="INSERT INTO item_upload_thumb (item_id,thumb_name) "."VALUES ('$item_id','$thumb_name')";
			$result = @mysqli_query($connection, $sql) or die("$sql<br />Error #". mysqli_errno($connection) . ": " . mysqli_error($connection));

			$upload_id= mysqli_insert_id($connection);

			$year=date("Y");
			$ts=time();
			$uploaddir = "upload_thumb/".$year; // make sure www has r/w permissions on this folder

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
				$image->thumbnailImage(350, 0); 
				$target="/opt/library/prd/WebServer/Documents/program_share/".$thumb;
				$image->writeImage($target);
				$image->destroy();
				}	
			if(file_exists($path_to_file))
				{
				$sql = "UPDATE item_upload_thumb set thumb_link='$uploadfile' where upload_id='$upload_id'";
				$result = @mysqli_query($connection, $sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
				}
				else
				{
				echo "There was a problem and the file was not uploaded. Contact Tom Howard for assistance."; 
				exit;
				}
			
		include("activity_query.php");
			}
		}
	
	}
	
// *****************************

if(!empty($upload_thumb_array[0]))
	{
//		echo "image<pre>"; print_r($upload_thumb_array); echo "</pre>"; // exit;
	$upload_thumb_array=array_unique($upload_thumb_array);
	foreach($upload_thumb_array as $i=>$value)
		{
		$image_id=$upload_thumb_array[$i];
		$image_name=$thumb_name_array[$i];
		$thumb_link=$thumb_link_array[$i];
		if($i==0)
			{echo "<tr bgcolor='#EBD6FF'><td align='right'>Uploaded Thumbnail: </td>";}
			else
			{echo "<tr bgcolor='#EBD6FF'><td></td>";}
		if(!empty($thumb_link))
			{
			$view="View";
			$exp=explode("/",$thumb_link);
			$temp=array_pop($exp);
			$thumb=implode("/",$exp)."/tn_".$temp;
				$view="<img src=$thumb>";
			echo "<td>resized to 350 pixels for display on \"Welcome\" page.
			<br /><a href='$thumb_link' target='_blank'>$view</a>
			<br /><font color='purple'>$thumb_name</font> ";
			if(($level>3 or $entered_by==$_SESSION['program_share']['tempID']))
				{
				echo "<br /><a href='del_thumb.php?upload_id=$thumb_id' onclick=\"return confirm('Are you sure you want to delete this Image?')\">Delete</a> thumbnail";
				}
			echo "</td>";
			}
		echo "</tr>";
		}
		
	}
?>