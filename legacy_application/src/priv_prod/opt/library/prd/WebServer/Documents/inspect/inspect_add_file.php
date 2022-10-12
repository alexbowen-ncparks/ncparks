<?php
$database="inspect";
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);

extract($_REQUEST);

if ($submit == "Add File")
	{
	extract($_FILES);
	$size = $_FILES['file_upload']['size'];
	$type = $_FILES['file_upload']['type'];
	$file = $_FILES['file_upload']['name'];
	$mapName = $file;
	//$ext = substr(strrchr($file, "."), 1);// find file extention, png e.g.
//	echo "<pre>"; print_r($_FILES); print_r($_REQUEST);echo "</pre>";exit;
	
	if(!is_uploaded_file($file_upload['tmp_name']))
		{
		print_r($_FILES);  
		print_r($_REQUEST);
		exit;
		}
	
	 
//	$ext = explode("/",$type);
//	$uploaddir = "file_upload/"; // make sure www has r/w permissions on this folder
	
	$uploaddir="file_upload";
	
	$file=str_replace("'","_",$file);
	$file=str_replace(",","_",$file);
	$file=str_replace(" ","_",$file);
	$file=str_replace("/","_",$file);
	
		$folder = $uploaddir."/".$parkcode;
	if (!file_exists($folder)) {mkdir ($folder, 0777);}
	if (!file_exists($folder)) {echo "Directory $folder was NOT created.";exit;}
	
	if(empty($passYear))
		{
		date_default_timezone_set('America/New_York');
		$passYear=date('Y');
		}
		$folder .= "/".$passYear;
	if (!file_exists($folder)) {mkdir ($folder, 0777);}
		
	$uploadfile=$folder."/".$file;
//echo "$uploadfile"; exit;
	move_uploaded_file($file_upload['tmp_name'],$uploadfile);// create file on server
	
	if (!file_exists($uploadfile))
		{
		ECHO "File upload was not successful.";
		echo "<br />$uploadfile";
		exit;
		}
	
	$TABLE="inspect.document";
	//if($source=="inspect"){$id=1;$TABLE="pac_cal.chop_comment";}
	
	  $sql = "UPDATE $TABLE set file_link=concat_ws(',',file_link,'$uploadfile') where id='$id'";
	//  echo "$sql";exit;
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysql_errno($connection) . ": " . mysql_error($connection));
	
	header("Location: add_park_comments.php?passYear=$passYear&id=$id&a=view");
	exit;	
	}
?>