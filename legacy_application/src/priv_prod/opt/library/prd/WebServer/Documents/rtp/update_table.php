<?php
if(empty($connection))
	{mysqli_select_db($connection,$dbName);}

ini_set('display_errors',1);
// echo "<pre>"; print_r($_POST);  print_r($_FILES); echo "</pre>";  exit;
$skip=array("id","var_table","project_file_name","source","submit_form");

IF(empty($_SESSION))
	{session_start();}


if(@$_POST["submit_form"]=="Delete Item")
	{
	$sql="SELECT link from attachments where track_id='$id'"; //echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	if(mysqli_num_rows($result)>0)
		{
		$row=mysqli_fetch_assoc($result);
		extract($row);
		unlink($link);
		$sql="DELETE from attachments where track_id='$id'"; //echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		}
	
	$sql="DELETE FROM items where id='$id'"; //echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	
	echo "That item has been removed from Lost and Found."; exit;
	}
	
FOREACH($_POST as $fld=>$value)
	{
	if(in_array($fld,$skip)){continue;}
	$temp[]=$fld."='".$value."'";
	}
if(!empty($temp))
	{
	$var_table=$_POST['var_table'];
	$project_file_name=$_POST['project_file_name'];
	$clause=implode(",",$temp);
	$sql="UPDATE $var_table set $clause where project_file_name='$project_file_name'"; 
	//echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	}

if(isset($_FILES['file_upload']['tmp_name']))
	{
//echo "<pre>"; print_r($_FILES); echo "</pre>"; exit;
			$temp_name=$_FILES['file_upload']['tmp_name'];
			$name=addslashes($_FILES['file_upload']['name']);
			$error=$_FILES['file_upload']['error'];
		if($error==0){
			if($temp_name==""){continue;}
			
			$e=explode(".",$_FILES['file_upload']['name']);
			$ext=array_pop($e);
			
			$form_name=$project_file_name."_".time();
			$file_name = $form_name.".".$ext;
    
//echo " $file_name"; exit;

		$uploaddir = "uploads"; // make sure www has r/w permissions on this folder
		
		if (!file_exists($uploaddir))
			{mkdir ($uploaddir, 0777);chmod($uploaddir,0777);}
			
		$year=$_SESSION['rtp']['set_year'];
		
		$sub_folder=$uploaddir."/".$year;
		if (!file_exists($sub_folder))
			{mkdir ($sub_folder, 0777);chmod($sub_folder,0777);}
   
		$sub_folder.="/".$project_file_name;
		if (!file_exists($sub_folder))
			{mkdir ($sub_folder, 0777);chmod($sub_folder,0777);}
    
		$uploadfile = $sub_folder."/".$file_name;  //echo "$subfolder <br />$uploadfile"; exit;

		move_uploaded_file($temp_name,$uploadfile);// create file on server
    		chmod($uploadfile,0777);

	$sql="INSERT INTO attachments SET project_file_name='$project_file_name', upload_file_name='$name', link='$uploadfile', stored_file_name='$file_name' "; //echo "$sql"; exit;
	$result = @mysqli_query($connection,$sql);
	if(mysqli_errno($connection)=="1062")
		{echo "<font color='red' size='+1'>The photo was not uploaded. Please contact the Recreational Trails Program staff for assistance.</font>";}
			}
	}
	
?>