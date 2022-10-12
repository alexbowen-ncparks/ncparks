<?php
if(isset($_FILES['file_upload']['tmp_name']))
	{
// 	echo "<pre>"; print_r($_POST); echo "</pre>"; //exit;
// 	echo "<pre>"; print_r($_FILES); echo "</pre>"; //exit;
	$temp_name=$_FILES['file_upload']['tmp_name'];
	$name=addslashes($_FILES['file_upload']['name']);
	$error=$_FILES['file_upload']['error'];
	if($error==0)
		{
		if($temp_name==""){continue;}

		$e=explode(".",$_FILES['file_upload']['name']);
		$ext=array_pop($e);
		$form_name=$ticket_id."_".time();
		$file_name = $form_name.".".$ext;

// 		echo "$file_name"; exit;

		$uploaddir = "track_time_uploads"; // make sure www has r/w permissions on this folder

		if (!file_exists($uploaddir))
		{mkdir ($uploaddir, 0777);chmod($uploaddir,0777);}
		date_default_timezone_set('America/New_York');

		$year=date("Y");
		$sub_folder=$uploaddir."/".$year;
		if (!file_exists($sub_folder))
		{mkdir ($sub_folder, 0777);chmod($sub_folder,0777);}


		$uploadfile = $sub_folder."/".$file_name;

		move_uploaded_file($temp_name,$uploadfile);// create file on server
		chmod($uploadfile,0777);

		$sql="INSERT INTO track_time_uploads SET ticket_id='$ticket_id', file_name='$name', link='$uploadfile' ";

// 		echo "$sql";exit;
		$result = @mysqli_query($connection,$sql) or die("$sql Error 39#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		}
	}
	
?>