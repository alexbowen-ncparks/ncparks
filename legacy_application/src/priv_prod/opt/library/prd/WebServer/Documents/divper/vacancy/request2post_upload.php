<?php
// ****** uploads
if(isset($_FILES['file_upload']))
	{
	foreach($_FILES['file_upload']['tmp_name'] as $k=>$v)
		{
		$temp_name=$_FILES['file_upload']['tmp_name'][$k];
		
		$size=$_FILES['file_upload']['size'][$k];
					if($size==0){continue;}
						
		if($temp_name==""){continue;}
		$app=explode(".",$_FILES['file_upload']['name'][$k]);
		$ext=array_pop($app);
			// generate timestamp
			// needed to prevent browser caches from failing to download any re-uploaded file
			$ran=time();
					$file_name = $beacon_num."_".$k."_".$ran.".".$ext;
			
	//	echo "$file_name"; exit;
		
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
			$fld=$k."_file";
				$sql="UPDATE request_to_post SET $fld='$uploadfile' where id='$id'";
	//			echo "<br />$sql";  exit;
				$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

// update file upload status
$fld=$k."_ck";
$sql = "UPDATE request_to_post SET $fld='y' where id='$id'";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));


// remove any previous files
			$check_a="/opt/library/prd/WebServer/Documents/divper/vacancy/".$existing_addendum;
			if(file_exists($check_a))
				{
//echo "$check_a"; exit;
				unlink($check_a);
				}
			$check_s="/opt/library/prd/WebServer/Documents/divper/vacancy/".$existing_skills;
			if(file_exists($check_s))
				{
				unlink($check_s);
				}
					
			}
	}
//******* end uploads
	
?>