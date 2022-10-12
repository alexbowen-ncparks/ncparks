<?php	
//  *************** upload to server *******************
ini_set('display_errors',1);
if(isset($_FILES['specs']['tmp_name']))
	{
//echo "<pre>"; print_r($_POST);   print_r($_FILES); echo "</pre>"; //exit;
$database="dpr_rema";
//$title="REMA Project Tracking Application";
//include("../_base_top.php");
include("../../include/iConnect.inc");
date_default_timezone_set('America/New_York');
mysqli_select_db($connection, $database);
	$error=$_FILES['specs']['error'];
	if($error==0){
			$temp_name=$_FILES['specs']['tmp_name'];
			if($temp_name==""){continue;}
			$name=$_FILES['specs']['name'];
			$name=str_replace("'","",$name);
			$name=addslashes($name);
		extract($_POST);
		$form_name="DPR_specs_".$proj_number."_".time();
		$e=explode(".",$_FILES['specs']['name']);
		$ext=array_pop($e);
		$file_name = $form_name.".".$ext;

//echo " $file_name"; exit;

		$uploaddir = "upload_specs"; // make sure www has r/w permissions on this folder
		if (!file_exists($uploaddir))
			{mkdir ($uploaddir, 0777);chmod($uploaddir,0777);}
		
		$year=date("Y");
		$sub_folder=$uploaddir."/".$year;
		if (!file_exists($sub_folder))
			{mkdir ($sub_folder, 0777);chmod($sub_folder,0777);}


		$uploadfile = $sub_folder."/".$file_name;

		move_uploaded_file($temp_name,$uploadfile);// create file on server
			chmod($uploadfile,0777);

		$sql="INSERT INTO upload_specs SET proj_id='$proj_id', proj_number='$proj_number', file_name='$name', link='$uploadfile' ";
		$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
		}
	}

header("Location: project.php?id=$proj_id");
	
?>