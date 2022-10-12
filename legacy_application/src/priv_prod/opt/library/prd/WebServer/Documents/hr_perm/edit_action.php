<?php
mysqli_select_db($connection,$dbName);
//echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
extract($_POST);
if(@$_POST["submit_form"]=="Delete Person")
	{
	$sql="SELECT link from web_links where track_id='$id'"; echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	if(mysqli_num_rows($result)>0)
		{
		$row=mysqli_fetch_assoc($result);
		extract($row);
		unlink($link);
		$sql="DELETE from web_links where track_id='$id'"; //echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		}
	
	$sql="DELETE FROM applicants where id='$id'"; //echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	
	echo "That person has been removed."; exit;
	}

$skip=array("id","submit_form","track");	
FOREACH($_POST as $fld=>$value)
	{
	if(in_array($fld,$skip)){continue;}
	$temp[]=$fld."='".$value."'";
	}
$temp[]="`track`=concat(`track`,'-','".$_POST['track']."')";
$clause=implode(",",$temp);
$id=$_POST['id'];

if(!isset($ARRAY_forms))
	{
	$sql="SELECT * from required_forms_2";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_forms[]=$row['form_name'];
		}
	}
	
$sql="UPDATE applicants set $clause where id='$id'"; //echo "$sql"; exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

if(isset($_FILES['file_upload']['tmp_name']))
	{
//	echo "<pre>"; print_r($ARRAY_forms); echo "</pre>"; // exit;
//	echo "<pre>"; print_r($_FILES); echo "</pre>"; //exit;
	
	foreach($_FILES['file_upload']['tmp_name'] as $index=>$value)
		{
		if(empty($value)){continue;}
		
			$temp_name=$_FILES['file_upload']['tmp_name'][$index];
			$name=addslashes($_FILES['file_upload']['name'][$index]);
			$error=$_FILES['file_upload']['error'][$index];
		if($error==0){
			if($temp_name==""){continue;}
			
			$e=explode(".",$_FILES['file_upload']['name'][$index]);
			$ext=array_pop($e);
			$form=str_replace(" ","_",$ARRAY_forms[$index]);
			$form_name="HR_".$form."_".$_POST['tempID'];
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

	$sql="INSERT INTO hr_forms SET track_id='$id', tempID='$tempID', form_name='$form', file_link='$uploadfile' ";
//	echo "$sql<br />"; exit;
	$result = @mysqli_query($connection,$sql);
	if(mysqli_errno($connection)=="1062")
		{echo "<font color='red' size='+1'>The photo was not uploaded. Please delete the existing photo before trying to upload another one.</font>";}
			}
		
		
		}
	}


//******************Other File********************

if(isset($_FILES['file_upload_other']['tmp_name']))
	{
//	echo "<pre>"; print_r($ARRAY_forms); echo "</pre>"; // exit;
//	echo "<pre>"; print_r($_FILES); echo "</pre>"; exit;
	
	foreach($_FILES['file_upload_other']['tmp_name'] as $index=>$value)
		{
		if(empty($value)){continue;}
		
			$temp_name=$_FILES['file_upload_other']['tmp_name'][$index];
			$name=addslashes($_FILES['file_upload_other']['name'][$index]);
			$error=$_FILES['file_upload_other']['error'][$index];
		if($error==0){
			if($temp_name==""){continue;}
			
			$e=explode(".",$_FILES['file_upload_other']['name'][$index]);
			$ext=array_pop($e);
			$form=str_replace(" ","_",$name);
			$form_name="HR_".$form."_".$_POST['tempID'];
			$file_name = $form_name.".".$ext;
    
//echo " $file_name"; exit;

		$uploaddir = "uploads_other"; // make sure www has r/w permissions on this folder

		if (!file_exists($uploaddir))
			{mkdir ($uploaddir, 0777);chmod($uploaddir,0777);}
			
		$year=date("Y");
		$sub_folder=$uploaddir."/".$year;
		if (!file_exists($sub_folder))
			{mkdir ($sub_folder, 0777);chmod($sub_folder,0777);}
   
    
		$uploadfile = $sub_folder."/".$file_name;

		move_uploaded_file($temp_name,$uploadfile);// create file on server
    		chmod($uploadfile,0777);

	$sql="INSERT INTO hr_forms_other SET track_id='$id', tempID='$tempID', form_name='$form', file_link='$uploadfile' ";
//	echo "$sql<br />"; exit;
	$result = @mysqli_query($connection,$sql);
	if(mysqli_errno($connection)=="1062")
		{echo "<font color='red' size='+1'>The photo was not uploaded. Please delete the existing photo before trying to upload another one.</font>";}
			}
		
		
		}
	}

?>