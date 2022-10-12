<?php

// echo "<pre>"; print_r($_FILES); echo "</pre>";  //exit;
// //extract($_REQUEST);
// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;

date_default_timezone_set('America/New_York');
//echo "<table>";

$passYear=date('Y'); // used to create file storage folder hierarchy

if(!empty($_FILES['file_upload']['tmp_name']))
	{
	
	include("../../include/iConnect.inc");
	$database="facilities";

	mysqli_select_db($connection,"facilities"); // database

	$gis_id=$_POST['gis_id'];
	// ********** ACTION
	// includes deletion of previous file since a timestamp is used to get around browser cacheing 
	$num=count($_FILES['file_upload']['tmp_name']);

	// echo "<pre>"; print_r($_FILES); echo "</pre>";  exit;

	for($i=0;$i<$num;$i++)
		{
		$temp_name=$_FILES['file_upload']['tmp_name'][$i];
		if($temp_name==""){continue;}

		if(!is_uploaded_file($_FILES['file_upload']['tmp_name'][$i])){exit;}

		$original_file_name = $_FILES['file_upload']['name'][$i];
		$exp=explode(".",$original_file_name);
		$ext=array_pop($exp);

		$original_file_name = str_replace("/", "_", $original_file_name);
		$original_file_name = str_replace("'", "_", $original_file_name);
		$original_file_name = str_replace("\"", "_", $original_file_name);
		$original_file_name = str_replace(":", "_", $original_file_name);
		$original_file_name = str_replace(" ", "_", $original_file_name);
		
		// if(!empty($existing_map))
		// 	{
		// 	unlink($existing_map);
		// 	}

		$uploaddir = "uploads/facility_report"; // make sure www has r/w permissions on this folder

		if (!file_exists($uploaddir)) {mkdir ($uploaddir, 0777);}

		$sub_folder=$uploaddir."/".date("Y");
		if (!file_exists($sub_folder)) {mkdir ($sub_folder, 0777);}

		$ts=time();
		$file_name=$gis_id."_".$ts.".".$ext;
// echo "fn=$original_file_name<br />"; 
// echo "f=$file_name"; exit;
		$uploadfile = $sub_folder."/".$file_name;
// echo "$uploadfile"; exit;
		move_uploaded_file($temp_name,$uploadfile);// create file on server
// 		chmod($uploadfile,0777);

		$sql="INSERT INTO facility_attachment set gis_id='$gis_id', file_name='$original_file_name', link='$uploadfile'"; 
		$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	
// 		echo "$sql"; exit;
		}
header("Location: edit_fac.php?gis_id=$gis_id");
	}
// include_once("edit_fac.php");
?>