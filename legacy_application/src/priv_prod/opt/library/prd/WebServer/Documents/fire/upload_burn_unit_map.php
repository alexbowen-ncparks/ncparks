<?php
//echo "Under development: <pre>"; print_r($_REQUEST); print_r($_FILES); echo "</pre>";  exit;
ini_set('display_errors',1);

if (!empty($_GET['del']))
	{
	$database="fire";
	include("../../include/iConnect.inc");
	extract($_POST);
	mysqli_select_db($connection,$database)
	   or die ("Couldn't select database");
	extract($_GET);
	$sql="SELECT link from fire_park_map where park_code='$park_code' and map_num='$del'"; //echo "$sql";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$row=mysqli_fetch_assoc($result);
	extract($row);
	$pp=pathinfo($link); //echo "<pre>"; print_r($pp); echo "</pre>";  exit;
	$path="/opt/library/prd/WebServer/Documents/fire/fire_park_map/";
	$file=$path.$pp['basename'];  //echo "$file"; exit;
	@unlink($file);
	$file=$path."ztn.".$pp['filename'].".jpg";  //echo "$file"; exit;
	@unlink($file);
	$sql="DELETE from fire_park_map where park_code='$park_code' and map_num='$del'"; //echo "$sql";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	mysqli_CLOSE();
	header("Location: /fire/units.php?park_code=$park_code");
	exit;
	}
	
if ($_POST['submit'] == "Upload")
	{
	$database="fire";
	include("../../include/iConnect.inc");
	extract($_POST);
	mysqli_select_db($connection,$database)
	   or die ("Couldn't select database");
   
//	$num=count($_FILES['files']['name']);
	$num=5;

	for($i=1;$i<=$num;$i++)
		{
		$temp_name=$_FILES['files']['tmp_name'][$i];
		$submitted_name=addslashes($_FILES['files']['name'][$i]);
		$file_type=$_FILES['files']['type'][$i];
		if($temp_name==""){continue;}

		if(!is_uploaded_file($_FILES['files']['tmp_name'][$i]))
			{
			echo "no go for file $i";
			exit;
			}
		$name=$_FILES['files']['name'][$i];
		$exp=explode(".",$name);
		$ext=array_pop($exp);
		$file_name = $park_code."_fire_map_$i.".$ext;
	
		$uploaddir = "fire_park_map"; // make sure www has r/w permissions on this folder

		//    echo "$uploaddir"; exit;
		if (!file_exists($uploaddir)) {mkdir ($uploaddir, 0777);}

		$uploadfile = $uploaddir."/".$file_name;
		move_uploaded_file($temp_name,$uploadfile);// create file on server
		chmod($uploadfile,0777);
		
		$sql = "REPLACE fire_park_map set park_code='$park_code', map_num='$i',map_name='$submitted_name', link='$uploadfile'";
		$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

		if($file_type!="application/pdf")
			{
			$image = new Imagick($uploadfile); 
			$image->thumbnailImage(200, 0); 
			//echo $image;
			$image->writeImage($uploaddir."/ztn.".$file_name);
			$image->clear();
			$image->destroy();
			}
			else
			{
			$new_tn=str_replace(".pdf",".jpg",$file_name); // if original image was a PDF
			//header("Content-type: image/jpeg"); // for testing
			$img = new Imagick($uploadfile); 
			$img->setImageFormat("jpg");
			$img->thumbnailImage(200, 0); 
			$img->writeImage($uploaddir."/ztn.".$new_tn);
			$img->clear();
			$img->destroy();
			}
		}

	mysqli_CLOSE();
	header("Location: /fire/units.php?park_code=$park_code");
	exit;
	} 

?>