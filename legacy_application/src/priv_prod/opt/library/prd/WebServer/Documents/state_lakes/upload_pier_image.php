<?php

// ********** ACTION
// includes deletion of previous file since a timestamp is used to get around browser cacheing 
$num=count($_FILES['file_upload']['tmp_name']);

// echo "<pre>"; print_r($_FILES); echo "</pre>";
// exit;

for($i=0;$i<$num;$i++)
	{
	$temp_name=$_FILES['file_upload']['tmp_name'][$i];
	if($temp_name==""){continue;}

	if(!is_uploaded_file($_FILES['file_upload']['tmp_name'][$i])){exit;}

	$image_name = $_FILES['file_upload']['name'][$i];
	$exp=explode(".",$image_name);
	$ext=array_pop($exp);
	$park_code = $_POST['park'];
	$pier_id = $_POST['pier_id'];

// 	$sql = "SELECT image_link from pier_image_upload where pier_id='$pier_id'"; //echo "$sql"; exit;
// 	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
// 	$row=mysqli_fetch_assoc($result);
// 	$existing_map=$row['image_link'];
// 
// 	if(!empty($existing_map))
// 		{
// 		unlink($existing_map);
// 		}

	$sql="INSERT pier_image_upload (park,pier_id,image_name) "."VALUES ('$park','$pier_id','$image_name')";

	// echo "$sql <br />";exit;
	$result = @mysqli_query($connection,$sql) or die("$sql<br />Error #". mysqli_errno($connection) . ": " . mysqli_error($connection));

	$mid= mysqli_insert_id($connection);

	// echo "$sql <br />mid = $mid";exit;   
	$uploaddir = "upload_pier"; // make sure www has r/w permissions on this folder

	//    echo "$uploaddir"; exit;
	if (!file_exists($uploaddir)) {mkdir ($uploaddir, 0777);}


	$sub_folder=$uploaddir."/".$park;
	if (!file_exists($sub_folder)) {mkdir ($sub_folder, 0777);}
		//echo "$sub_folder"; exit;

	$ts=time();
	$file_name="pier_".$pier_id."_".$mid."_".$ts.".".$ext;

	$uploadfile = $sub_folder."/".$file_name;
	move_uploaded_file($temp_name,$uploadfile);// create file on server
	chmod($uploadfile,0777);

	$sql = "UPDATE pier_image_upload set image_link='$uploadfile' where id='$mid'";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
}
?>