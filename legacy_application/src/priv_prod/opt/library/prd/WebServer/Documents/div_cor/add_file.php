<?php
$database="div_cor";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection,$database);
//session_start();
//$level=$_SESSION['div_cor']['level'];
//print_r($_SESSION);//exit;

extract($_REQUEST);

//unlink("file_upload/2010_02/pier_letter.pdf"); exit;

if ($submit == "Add File")
	{
	extract($_FILES);
	$size = $_FILES['file_upload']['size'];
	$type = $_FILES['file_upload']['type'];
	$file = $_FILES['file_upload']['name'];
	
	//print_r($_FILES); print_r($_REQUEST);exit;
	if(!is_uploaded_file($file_upload['tmp_name'])){print_r($_FILES);  print_r($_REQUEST);
	exit;}
	
	 
	date_default_timezone_set('America/New_York');
	$uploaddir = "file_upload/"; // make sure www has r/w permissions on this folder
	$uploaddir = "file_upload/".date('Y_m')."/";
	if (!is_writable($uploaddir)) {mkdir ($uploaddir);}
	
	
	$file=str_replace("'","",$file);
	$file=str_replace(" ","_",$file);
	$file=str_replace(",","_",$file);
	$file=str_replace("#","_",$file);  //echo "$file";exit;
	$uploadfile = $uploaddir.$file;
	move_uploaded_file($file_upload['tmp_name'],$uploadfile);// create file on server
	
	$uploadfile = addslashes($uploadfile);
	
	  $sql = "UPDATE corre set file_link=concat_ws(',',file_link,'$uploadfile') where id='$id'";
	//  echo "$sql";exit;
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		mysqli_CLOSE($connection);
	header("Location: display_item.php");
	exit;	}
?>