<?php
echo "<tr bgcolor='#66FFFF'><td>Upload a <b>File</b> (.doc, .docx, .pdf, .pptx, .xlsx, .txt, .ai, .psd, .wav) :</td><td><input type='file' name='files[]'><td></tr>";
//echo "<pre>"; print_r($_FILES); echo "</pre>"; exit;
if (!empty($_FILES))
	{
//echo "<pre>"; print_r($_FILES); echo "</pre>";// exit;
	date_default_timezone_set('America/New_York');
	   $num=count($_FILES['files']['name']);
	
	
	for($i=0;$i<$num;$i++)
		{
		$temp_name=$_FILES['files']['tmp_name'][$i];
		if($temp_name==""){continue;}

		if(!is_uploaded_file($_FILES['files']['tmp_name'][$i]))
			{
			//	echo "<pre>";
			//	print_r($_FILES);  print_r($_REQUEST);
			//	echo "</pre>";
			exit;
			}
		$file_name = $_FILES['files']['name' ][$i];
		$exp=explode(".",$file_name);
		$ext=array_pop($exp);
		$file_type = explode("/",$_FILES['files']['type'][$i]);

		$sql="INSERT INTO item_upload_file (item_id,file_name) "."VALUES ('$item_id','$file_name')";
		$result = @mysqli_query($connection, $sql) or die("$sql<br />Error #". mysqli_errno($connection) . ": " . mysqli_error($connection));

		$upload_id= mysqli_insert_id($connection);
		
		$year=date("Y");
		$ts=time();
		$uploaddir = "upload_file/".$year; // make sure www has r/w permissions on this folder

		//    echo "$uploaddir"; exit;
		if (!file_exists($uploaddir)) {mkdir ($uploaddir, 0777);}

		$new_name="program_file_".$item_id."_".$ts;
		$uploadfile = $uploaddir."/".$new_name.".".$ext;
		move_uploaded_file($temp_name,$uploadfile);// create file on server
		chmod($uploadfile,0777);
		$path_to_file="/opt/library/prd/WebServer/Documents/program_share/".$uploadfile;

		if(file_exists($path_to_file))
			{
			$sql = "UPDATE item_upload_file set file_link='$uploadfile' where upload_id='$upload_id'";
			$result = @mysqli_query($connection, $sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
			
			include("activity_query.php");
			}
			else
			{echo "There was a problem and the file was not uploaded. Contact Tom Howard for assistance."; exit;}
		}
	
	}
	
// *****************************

		if(!empty($upload_id_array[0]))
			{
	//		echo "upload<pre>"; print_r($upload_id_array); echo "</pre>"; // exit;
	$upload_id_array=array_unique($upload_id_array);
			foreach($upload_id_array as $i=>$value)
				{
				$file_name=$file_name_array[$i];
				$file_link=$file_link_array[$i];
				$item_comment=$comment_array[$i];
				if($i==0)
					{echo "<tr bgcolor='aliceblue'><td align='right'>Uploaded File: </td>";}
					else
					{echo "<tr bgcolor='aliceblue'><td></td>";}
				if(!empty($file_link))
					{
					$view="View";
					$file_type="file";
					if(substr($file_link,-4)==".jpg" or substr($file_link,-4)=="jpeg")
						{
						$view="<img src=$file_link width='350'>";
						$file_type="thumbnail image";
						}
					echo "<td><font color='purple'>$file_name</font> <a href='$file_link' target='_blank'>$view</a></td>";
					if(($level>3 or $entered_by==$_SESSION['program_share']['tempID']))
						{
						echo "<td><a href='del_file.php?upload_id=$value' onclick=\"return confirm('Are you sure you want to delete this Document?')\">Delete</a> $file_type</td>";
						}
					}
				echo "</tr>";
				}
				
				if(!empty($pass_upload))
					{
					$view="View";
					$file_type="file";
					if(substr($pass_upload,-4)==".jpg" or substr($pass_upload,-4)=="jpeg")
						{
						$view="<img src=$pass_upload width='350'>";
						$file_type="thumbnail image";
						}
					echo "<tr bgcolor='aliceblue'><td></td><td><font color='purple'>$pass_file_name</font> <a href='$pass_upload' target='_blank'>$view</a></td>";				
					echo "<td><a href='del_file.php?upload_id=$pass_upload_id' onclick=\"return confirm('Are you sure you want to delete this Document?')\">Delete</a> $file_type</td>";
					echo"</tr>";
					}
			}
			else
			{
			if(!empty($pass_upload))
				{
				$view="View";
				$file_type="file";
				if(substr($pass_upload,-4)==".jpg" or substr($pass_upload,-4)=="jpeg")
					{
					$view="<img src=$pass_upload width='350'>";
						$file_type="thumbnail image";
					}
				echo "<td></td><td><font color='purple'>$pass_file_name</font> <a href='$pass_upload' target='_blank'>$view</a></td>";				
				echo "<td><a href='del_file.php?upload_id=$pass_upload_id' onclick=\"return confirm('Are you sure you want to delete this Document?')\">Delete</a> $file_type</td></tr>";
				}
			}
?>