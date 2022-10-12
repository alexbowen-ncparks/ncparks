<?php	
//  *************** upload to server *******************
ini_set('display_errors',1);
$VAR=$_POST['VAR'];
//echo "4 $VAR <pre>"; print_r($_POST);   print_r($_FILES); echo "</pre>"; exit;
if(isset($_FILES[$VAR]['tmp_name']))
	{
//echo "7<pre>"; print_r($_POST);   print_r($_FILES); echo "</pre>"; exit;
$database="second_employ";
include("../../include/iConnect.inc");
date_default_timezone_set('America/New_York');
mysqli_select_db($connection, $database);
	$error=$_FILES[$VAR]['error'];
	if($error==0){
			$temp_name=$_FILES[$VAR]['tmp_name'];
			if($temp_name==""){continue;}
			$name=$_FILES[$VAR]['name'];
			$name=str_replace("'","",$name);
			$name=addslashes($name);
		extract($_POST);
		$form_name="SE_".$VAR."_".$pass_se_dpr."_".time();
		$e=explode(".",$_FILES[$VAR]['name']);
		$ext=array_pop($e);
		$file_name = $form_name.".".$ext;

//echo " $file_name"; exit;

		$uploaddir = "upload_".$VAR; // make sure www has r/w permissions on this folder
		if (!file_exists($uploaddir))
			{mkdir ($uploaddir, 0777);chmod($uploaddir,0777);}
		
		$year=date("Y");
		$sub_folder=$uploaddir."/".$year;
		if (!file_exists($sub_folder))
			{mkdir ($sub_folder, 0777);chmod($sub_folder,0777);}


		$uploadfile = $sub_folder."/".$file_name;

		move_uploaded_file($temp_name,$uploadfile);// create file on server
			chmod($uploadfile,0777);
		
		$table="upload_".$VAR;
		$sql="REPLACE $table SET final_id='$id', se_dpr='$pass_se_dpr', file_name='$name', link='$uploadfile' ";
		$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
		}
	}

header("Location: edit.php?edit=$id&submit=edit");
	
?>