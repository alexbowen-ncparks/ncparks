<?php
//echo "<pre>"; print_r($_FILES);echo "</pre>"; //exit;

// ************  attachment upload

if(isset($_FILES['file_upload']['tmp_name']))
	{
	$j=0;
			$temp_name=$_FILES['file_upload']['tmp_name'];
			$original_name=$_FILES['file_upload']['name'];
			$original_name=str_replace(" ","_",$original_name);
			$original_name=str_replace("'","",$original_name);
			$original_name=str_replace("?","",$original_name);
			$original_name=addslashes($original_name);
			$error=$_FILES['file_upload']['error'];
		if($error==0){
			if($temp_name==""){exit;}
			
			$e=explode(".",$_FILES['file_upload']['name']);
			$ext=array_pop($e);
			$j++;
			if(empty($_REQUEST['id']))
				{$_REQUEST['id']=$id;}
				$attachment_num=$_REQUEST['id']."_".$j;
			$form_name="anniversary_100_".$attachment_num;
			$file_name = $form_name.".".$ext;
    
//echo "m=$mid $file_name"; exit;

		$uploaddir = "uploads/attachment_100"; // make sure www has r/w permissions on this folder

		if (!file_exists($uploaddir))
			{mkdir ($uploaddir, 0777);chmod($uploaddir,0777);}
				$year=date("Y");
				$sub_folder=$uploaddir."/".$year;
				if (!file_exists($sub_folder))
					{mkdir ($sub_folder, 0777);chmod($sub_folder,0777);}
   
    
		$uploadfile = $sub_folder."/".$file_name;

		move_uploaded_file($temp_name,$uploadfile);// create file on server
    		chmod($uploadfile,0777);
    
		$sql="INSERT uploads SET original_name='$original_name', link='$uploadfile', id='$id'";
//		echo "$sql";exit;
		$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
			}
	}

?>