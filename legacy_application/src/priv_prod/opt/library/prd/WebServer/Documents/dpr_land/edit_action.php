<?php
// mysqli_select_db($connection,$dbName);
// echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
$tempID=$_SESSION[$database]['tempID'];
$skip=array("select_table","submit_form","date_added", "date_edited","source");
if(!empty($source))
	{
	$skip[]="county_code";
	$skip[]="project_status";
	}
$ck_field=$select_table."_id";
// echo "$ck_field";

// table naming scheme didn't follow other tables for id
include("reassign_id_fld.php");
	
if(array_key_exists($ck_field,$_POST))
	{
	$id_field=$ck_field;
	$skip[]=$ck_field;   // skips this field during update
	$id_value=${$ck_field};
	}

if(@$_POST["submit_form"]=="Delete Item")
	{
// 	echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
	$select_table=$_POST['select_table'];
	$id_fld=$_POST['id_fld'];
	$id=$_POST[$id_fld];
	
// 	$sql="SELECT link from file_upload where track_id='$id'"; //echo "$sql"; exit;
// 	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
// 	if(mysqli_num_rows($result)>0)
// 		{
// 		$row=mysqli_fetch_assoc($result);
// 		extract($row);
// 		unlink($link);
// 		$sql="DELETE from file_upload where track_id='$id'"; //echo "$sql"; exit;
// 		$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
// 		}

	$sql="DELETE FROM $select_table where $id_fld='$id'"; //echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	
		header("Location: search_form_tables.php?select_table=$select_table");
		exit;
	}
// echo "<pre>"; print_r($_POST); echo "</pre>";
$skip[]="id_fld";	
FOREACH($_POST as $fld=>$value)
	{
	if(in_array($fld,$skip)){continue;}
	if($value == NULL)
		{
		$temp[]=$fld."= NULL";
		continue;
		}
	
	$temp[]=$fld."='".$value."'";
	}
$clause=implode(",",$temp);
$d=date("Y-m-d")." ".substr($tempID,0,-3);
$clause.=", `date_edited`='$d'";
$sql="UPDATE $select_table set $clause where $id_field='$id_value'";
//   echo "$sql"; exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

$record_updated=1;

// if(isset($_FILES['file_upload']['tmp_name']))
// 	{
// //echo "<pre>"; print_r($_FILES); echo "</pre>"; exit;
// 			$temp_name=$_FILES['file_upload']['tmp_name'];
// 			$name=addslashes($_FILES['file_upload']['name']);
// 			$error=$_FILES['file_upload']['error'];
// 		if($error==0){
// 			if($temp_name==""){continue;}
// 			
// 			$e=explode(".",$_FILES['file_upload']['name']);
// 			$ext=array_pop($e);
// 			
// 			$form_name="LF_".$park_code."_".$id;
// 			$file_name = $form_name.".".$ext;
//     
// //echo " $file_name"; exit;
// 
// 		$uploaddir = "uploads"; // make sure www has r/w permissions on this folder
// 
// 		if (!file_exists($uploaddir))
// 			{mkdir ($uploaddir, 0777);chmod($uploaddir,0777);}
// 			
// 		$year=date("Y");
// 		$sub_folder=$uploaddir."/".$year;
// 		if (!file_exists($sub_folder))
// 			{mkdir ($sub_folder, 0777);chmod($sub_folder,0777);}
//    
//     
// 		$uploadfile = $sub_folder."/".$file_name;
// 
// 		move_uploaded_file($temp_name,$uploadfile);// create file on server
//     		chmod($uploadfile,0777);
// 
// 	$sql="INSERT INTO file_upload SET track_id='$id', file_name='$name', link='$uploadfile' ";
// 	$result = @mysqli_query($connection,$sql);
// 	if(mysqli_errno($connection)=="1062")
// 		{echo "<font color='red' size='+1'>The photo was not uploaded. Please delete the existing photo before trying to upload another one.</font>";}
// 			}
// 	}
	
?>