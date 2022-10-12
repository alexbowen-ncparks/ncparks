<?php
 echo "id=$id <pre>"; print_r($_FILES); print_r($_POST); echo "</pre>";  exit;
$num=count($_FILES['file_upload']['tmp_name']);


for($i=0;$i<$num;$i++){
		$temp_name=$_FILES['file_upload']['tmp_name'][$i];
	if($temp_name==""){continue;}
	
	if(!is_uploaded_file($_FILES['file_upload']['tmp_name'][$i])){exit;}
	
		$map_name = $_FILES['file_upload']['name'][$i];
		$exp=explode(".",$map_name);
		$ext=array_pop($exp);
		$agency_id = $_POST['agency_id' ];
		$app_id = $id;

// $sql = "SELECT map_link from map_upload where app_id='$app_id'"; //echo "$sql"; exit;
// $result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
// $row=mysqli_fetch_assoc($result);
// $existing_map=$row['map_link'];
// 
// if(!empty($existing_map))
// 	{
// 	unlink($existing_map);
// 	}
	
$sql="REPLACE map_upload (agency_id,app_id,map_name) "."VALUES ('$agency_id','$app_id','$map_name')";
//echo "$sql <br />";exit;
$result = @mysqli_query($connection,$sql) or die("$sql<br />Error #". mysqli_errno($connection) . ": " . mysqli_error($connection));
$mid= mysqli_insert_id($connection);

$sql="INSERT INTO map_upload_history SELECT * from map_upload where mid='$mid'";
//echo "$sql <br />";exit;
$result = @mysqli_query($connection,$sql) or die("$sql<br />Error #". mysqli_errno($connection) . ": " . mysqli_error($connection));

$uploaddir = "uploads"; // make sure www has r/w permissions on this folder

//    echo "$uploaddir"; exit;
if (!file_exists($uploaddir)) {mkdir ($uploaddir, 0777);}


$sub_folder=$uploaddir."/".date("Y");
if (!file_exists($sub_folder)) {mkdir ($sub_folder, 0777);}
			//echo "$sub_folder"; exit;


$ts=time();
$file_name="rtp_map_".$mid."_".$ts.".".$ext;
    
$uploadfile = $sub_folder."/".$file_name;
move_uploaded_file($temp_name,$uploadfile);// create file on server
    chmod($uploadfile,0777);
    
$sql = "UPDATE map_upload set map_link='$uploadfile' where mid='$mid'";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
$sql = "UPDATE map_upload_history set map_link='$uploadfile' where mid='$mid'";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
}
?>