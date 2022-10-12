<?php
//echo "<pre>"; print_r($_FILES);echo "</pre>"; //exit;

$skip=array("submit","resume");


// ************  attachment upload

if(isset($_FILES['file_upload_uof']['tmp_name']))
	{
	$temp_name=$_FILES['file_upload_uof']['tmp_name'];
	$name=addslashes($_FILES['file_upload_uof']['name']);
	$error=$_FILES['file_upload_uof']['error'];
		if($error==0 and !empty($temp_name))
			{

			$e=explode(".",$_FILES['file_upload_uof']['name']);
			$ext=array_pop($e);
				$attachment_num=$_REQUEST['attachment_num'];
				$attachment_time=time(); // to prevent cacheing problem if file re-uploaded
			$form_name="PR63_Use_of_Force_".$attachment_num."_".$attachment_time;
			$file_name = $parkcode."_".$ci_num."_".$form_name.".".$ext;

			//echo "m=$mid $file_name"; exit;

			$uploaddir = "uploads/use_of_force"; // make sure www has r/w permissions on this folder

			if (!file_exists($uploaddir))
			{mkdir ($uploaddir, 0777);chmod($uploaddir,0777);}
				$year=date("Y");
				$sub_folder=$uploaddir."/".$year;
				if (!file_exists($sub_folder))
					{mkdir ($sub_folder, 0777);chmod($sub_folder,0777);}


			$uploadfile = $sub_folder."/".$file_name;

			move_uploaded_file($temp_name,$uploadfile);// create file on server
			chmod($uploadfile,0777);

			$sql="INSERT attachment_uof SET title='$name',link='$uploadfile', ci_num='$ci_num'";
			//		echo "$sql";exit;
			$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
			}
	}

?>