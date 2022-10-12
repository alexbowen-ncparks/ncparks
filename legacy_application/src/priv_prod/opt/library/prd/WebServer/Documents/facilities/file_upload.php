<?php
//echo "<pre>"; print_r($_FILES);print_r($_POST);echo "</pre>"; exit;
date_default_timezone_set('America/New_York');
$skip=array("submit","resume");

// ************  attachment upload

if(isset($_FILES['file_upload']['tmp_name']))
	{
			$temp_name=$_FILES['file_upload']['tmp_name'];
			$name=addslashes($_FILES['file_upload']['name']);
			$error=$_FILES['file_upload']['error'];
		if($error==0){
			if($temp_name==""){continue;}
			
			$e=explode(".",$_FILES['file_upload']['name']);
			$ext=array_pop($e);
				$attachment_num=$_REQUEST['attachment_num'];
			$form_name="housing_".$attachment_num;
			$file_name = $park_abbr."_".$doi_id."_".$form_name.".".$ext;
    
//echo "m=$mid $file_name"; exit;

		$uploaddir = "uploads/attachment"; // make sure www has r/w permissions on this folder

		if (!file_exists($uploaddir))
			{mkdir ($uploaddir, 0777);chmod($uploaddir,0777);}
				$year=date("Y");
				$sub_folder=$uploaddir."/".$year;
				if (!file_exists($sub_folder))
					{mkdir ($sub_folder, 0777);chmod($sub_folder,0777);}
   
    
		$uploadfile = $sub_folder."/".$file_name;

		move_uploaded_file($temp_name,$uploadfile);// create file on server
    		chmod($uploadfile,0777);
    
		$sql="INSERT housing_attachment SET title='$name',link='$uploadfile', gis_id='$gis_id'";
//		echo "$sql";exit;
		$result = mysqli_query($connection, $sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
			}
	}

?>