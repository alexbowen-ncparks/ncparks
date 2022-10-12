<?php	
//  *************** upload to server *******************
ini_set('display_errors',1);
if(isset($_FILES['gov']['tmp_name']))
	{
//echo "<pre>"; print_r($_POST);   print_r($_FILES); echo "</pre>"; //exit;
$database="dpr_system";

include("../../include/iConnect.inc");
date_default_timezone_set('America/New_York');
mysqli_select_db($connection, $database);
	$error=$_FILES['gov']['error'];
	if($error==0){
			$temp_name=$_FILES['gov']['tmp_name'];
			if($temp_name==""){continue;}
			$name=$_FILES['gov']['name'];
			$name=str_replace("'","",$name);
			$name=addslashes($name);
		extract($_POST);
		$form_name="Gov_WORD_doc_".$park_code."_".time();
		$e=explode(".",$_FILES['gov']['name']);
		$ext=array_pop($e);
		$file_name = $form_name.".".$ext;

//echo " $file_name"; exit;

		$uploaddir = "upload_gov"; // make sure www has r/w permissions on this folder
		if (!file_exists($uploaddir))
			{mkdir ($uploaddir, 0777);chmod($uploaddir,0777);}
		
		$year=date("Y");
		$sub_folder=$uploaddir."/".$year;
		if (!file_exists($sub_folder))
			{mkdir ($sub_folder, 0777);chmod($sub_folder,0777);}


		$uploadfile = $sub_folder."/".$file_name;

		move_uploaded_file($temp_name,$uploadfile);// create file on server
			chmod($uploadfile,0777);

		$sql="UPDATE gov_2015 SET  link='$uploadfile' where id='$id'";
	//	echo "$sql"; exit;
		$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
		}
	}

header("Location: gov_book.php?park_code=$park_code");
	
?>