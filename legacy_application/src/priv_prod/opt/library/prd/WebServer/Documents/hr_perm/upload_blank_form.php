<?php

// echo "<pre>"; print_r($_FILES); echo "</pre>"; exit;

$error=$_FILES['file_upload']['error'][$id];
if($error==0)
	{
	$temp_name=$_FILES['file_upload']['tmp_name'][$id];

	$var_file_name=$_FILES['file_upload']['name'][$id];
	$var_file_name=str_replace(" ","_",$var_file_name);
	$file_name=str_replace("'","",$var_file_name);


	//echo " $file_name"; exit;

	$uploaddir = "hr_perm_blank_forms"; // make sure www has r/w permissions on this folder

	if (!file_exists($uploaddir))
	{mkdir ($uploaddir, 0777);chmod($uploaddir,0777);}

	// $year=date("Y");
// 	$sub_folder=$uploaddir."/".$year;
// 	if (!file_exists($sub_folder))
// 	{mkdir ($sub_folder, 0777);chmod($sub_folder,0777);}


	$uploadfile = $uploaddir."/".$file_name;

	move_uploaded_file($temp_name,$uploadfile);// create file on server
	chmod($uploadfile,0777);

		$sql="UPDATE blank_forms 
		set form_name='$form_name', link='$uploadfile'
		where id='$id'"; 
// 		echo "$sql"; //exit;
		$result = mysqli_query($connection,$sql) or die();
	}

?>