<?php

mysqli_select_db($connection,$dbName);
//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
$skip=array("submit_form");
$require_array=array("Lname","Fname","ssn_last4");
FOREACH($_POST as $fld=>$value)
	{
	if(in_array($fld,$skip)){continue;}
	if(in_array($fld,$require_array) and empty($value)){$empty_array[]=$fld;}
	if($fld=="track")
		{
		$var_date=date("Y-m-d H:i:s");
		$value="concat('[','$value',' @ ', '$var_date',']')";		
		$temp[]=$fld."=".$value;
		continue;
		}
	$temp[]=$fld."='".$value."'";
	}
	
$tempID=$_POST['Lname'].$_POST['ssn_last4'];
$temp[]="tempID='".$tempID."'";
$clause=implode(",",$temp);

if(empty($empty_array))
	{
	$sql="INSERT INTO applicants SET $clause";
// 	echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die( mysqli_errno($connection)=="1062"?"Action could not be completed since it would create a duplicate record.":"");
	$ci_num=mysqli_insert_id($connection);
	}

if(isset($_FILES['file_upload']['tmp_name']))
	{
echo "<pre>"; print_r($_FILES); echo "</pre>"; exit;
			$temp_name=$_FILES['file_upload']['tmp_name'];
			$name=addslashes($_FILES['file_upload']['name']);
			$error=$_FILES['file_upload']['error'];
		if($error==0){
			if($temp_name==""){continue;}
			
			$e=explode(".",$_FILES['file_upload']['name']);
			$ext=array_pop($e);
			
			$form_name="LF_".$park_code."_".$ci_num;
			$file_name = $form_name.".".$ext;
    
//echo " $file_name"; exit;

		$uploaddir = "uploads"; // make sure www has r/w permissions on this folder

		if (!file_exists($uploaddir))
			{mkdir ($uploaddir, 0777);chmod($uploaddir,0777);}
			
		$year=date("Y");
		$sub_folder=$uploaddir."/".$year;
		if (!file_exists($sub_folder))
			{mkdir ($sub_folder, 0777);chmod($sub_folder,0777);}
   
    
		$uploadfile = $sub_folder."/".$file_name;

		move_uploaded_file($temp_name,$uploadfile);// create file on server
    		chmod($uploadfile,0777);

	$sql="INSERT INTO file_upload SET track_id='$ci_num', file_name='$name', link='$uploadfile' ";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
			}
	}
	
?>