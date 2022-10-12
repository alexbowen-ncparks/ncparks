<?php
ini_set('display_errors',1);

$db="photo_point";
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection, $database);

date_default_timezone_set('America/New_York');

extract($_REQUEST);

//echo "<pre>"; print_r($_REQUEST); print_r($_FILES); echo "</pre>"; exit;

if (!empty($del_photo))
	{
//	$exp=explode(".",$del_photo);
	$sql = "SELECT * from pp_photos where id='$del_photo'";  //echo "$sql"; exit;
	$result = @mysqli_query($connection, $sql) or die("c=$connection $sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$row=mysqli_fetch_assoc($result); extract($row);
	
//	$unit_prescription="fire_prescription/2013/CABE_38_prescription_2013-03-22_16:41:32.txt";
	$sql = "DELETE FROM pp_photos where id='$del_photo'";
//	  echo "$unit_prescription<br />$sql"; //exit;
	$result = @mysqli_query($connection, $sql) or die("c=$connection $sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	
	unlink($photo_link);
	$exp=explode("/",$photo_link);
	$tn=array_pop($exp);
	$tn_link=implode("/",$exp)."/ztn.".$tn;
	unlink($tn_link);
	
		header("Location: pp_units.php?park_code=$park_code&unit_id=$unit_id");
	exit;
	}

if (!empty($del_file))
	{
	$sql = "SELECT * from pp_files where id='$del_file'";  //echo "$sql"; exit;
	$result = @mysqli_query($connection, $sql) or die(" $sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$row=mysqli_fetch_assoc($result); extract($row);
	
	$sql = "DELETE FROM pp_files where id='$del_file'";
//	  echo "$unit_prescription<br />$sql"; //exit;
	$result = @mysqli_query($connection, $sql) or die(" $sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	
	unlink($file_link);
	
		header("Location: pp_units.php?park_code=$park_code&unit_id=$unit_id");
	exit;
	}
if ($submit == "Update")
	{
	extract($_FILES);
	$size = $_FILES['file_upload_pp_photo']['size'];
	$file_size = $_FILES['file_upload_pp_file']['size'];
		
	if($size>10)    // photo
		{
		$type = $_FILES['file_upload_pp_photo']['type']; 
		@$photo_name = $_FILES['file_upload_pp_photo']['name'];
		@$exp=explode(".",$photo_name);
		@$ext=array_pop($exp);
		
		@$file_name=str_replace(" ","_",$photo_name);
		@$photo_name=str_replace("?","_",$photo_name);
		@$photo_name=str_replace("'","",$photo_name)." at ".formatSizeUnits($size);
		
		$var = explode("/",$type);
		
		@$file = $_REQUEST['pp_code']."_".$_REQUEST['date']."_".$_REQUEST['season']."_".$_REQUEST['direction'].".".$ext;
		
//		echo "$file<pre>";print_r($_FILES); print_r($_REQUEST);echo "</pre>"; exit;
		
		if(!is_uploaded_file($_FILES['file_upload_pp_photo']['tmp_name']))
			{
			print_r($_FILES);  print_r($_REQUEST);
			exit;
			}
		
		$folder="photos"; //make sure www has r/w permissions on this folder
		if (!file_exists($folder)) {mkdir ($folder, 0777);}
		
		$year=date('Y');
		$folder.="/".$year; //make sure www has r/w permissions on this folder
		if (!file_exists($folder)) {mkdir ($folder, 0777);}
		
		$uploadfile = $folder."/".$file;
//		echo "$uploadfile";exit;
		
//		$delete_file=$folder."/".$remove_file;
//		unlink($delete_file);
		
		move_uploaded_file($_FILES['file_upload_pp_photo']['tmp_name'],$uploadfile);// create file on server
		$photo_db="photo_link='$uploadfile', photo_name='$photo_name'";
		
		// This creates a thumbnail using ImageMagick
		$tn=$folder."/ztn.".$file;

		$image = new Imagick($uploadfile); 
		$image->thumbnailImage(200, 0); 
		$image->writeImage($tn);
		$image->clear();
		$image->destroy();
		}
		else
		{
		$photo_db="";
		}

	if($file_size>10)  // file
		{
		$type = $_FILES['file_upload_pp_file']['type']; 
		$file_name = $_FILES['file_upload_pp_file']['name'];
		$exp=explode(".",$file_name);
		$ext=array_pop($exp);
		
		$file_name=str_replace(" ","_",$file_name);
		$file_name=str_replace("?","_",$file_name);
		$file_name=str_replace("'","",$file_name)." at ".formatSizeUnits($file_size);
		
		$var = explode("/",$type);
		
		$time=time();
		$file = $_REQUEST['pp_code']."_".$_REQUEST['date']."_".$time.".".$ext;
		
//		echo "$file<pre>";print_r($_FILES); print_r($_REQUEST);echo "</pre>"; exit;
		
		if(!is_uploaded_file($_FILES['file_upload_pp_file']['tmp_name']))
			{
			print_r($_FILES);  print_r($_REQUEST);
			exit;
			}
		
		$folder="files"; //make sure www has r/w permissions on this folder
		if (!file_exists($folder)) {mkdir ($folder, 0777);}
		
		$year=date('Y');
		$folder.="/".$year; //make sure www has r/w permissions on this folder
		if (!file_exists($folder)) {mkdir ($folder, 0777);}
		
		$uploadfile = $folder."/".$file;
//		echo "$uploadfile";exit;
		
//		$delete_file=$folder."/".$remove_file;
//		unlink($delete_file);
		$date=$_REQUEST['date'];
		move_uploaded_file($_FILES['file_upload_pp_file']['tmp_name'],$uploadfile);// create file on server
		$file_db="date='$date', file_link='$uploadfile', file_name='$file_name'";
	
		}
		else
		{
		$file_db="";
		}
	}

// Update	
$pp_name=str_replace(',','',$pp_name);
$pp_name=str_replace("'",'',$pp_name);
// $distance=addslashes($distance);
// $pp_name=addslashes($pp_name);
// $comment=addslashes($comment);
$lon=-(abs($lon));

	$sql = "UPDATE photo_point
	set pp_code='$pp_code', category='$category', burn_unit='$burn_unit',park_code='$park_code', pp_name='$pp_name', year='$year', season='$season', lat='$lat', lon='$lon', distance='$distance', date='$date', comment='$comment' where unit_id='$unit_id'";
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
//	  echo "$sql";exit;
//if($level<4){$sql="";}
	$result = @mysqli_query($connection, $sql) or die("$sql Error #". mysqli_error($connection));
	
	if(!empty($photo_db))
		{
		$sql = "INSERT INTO pp_photos
		set unit_id='$unit_id', pp_code='$pp_code', direction='$direction', $photo_db";
	//	  echo "$sql";exit;
		$result = @mysqli_query($connection, $sql) or die(" $sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		}
		
	if(!empty($file_db))
		{
		$sql = "INSERT INTO pp_files
		set unit_id='$unit_id', pp_code='$pp_code', $file_db";
	//	  echo "$sql";exit;
		$result = @mysqli_query($connection, $sql) or die(" $sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		}
	header("Location: pp_units.php?unit_id=$unit_id");
	exit;
	
	
function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
}
?>