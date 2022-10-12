<?php
date_default_timezone_set('America/New_York');
$database="dpr_land"; 
$dbName="dpr_land";

include("../../include/iConnect.inc");//  includes no_inject_i.php
mysqli_select_db($connection,$dbName);
// echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
// extract($_POST);

if(!empty($delete))
	{
	$sql="SELECT * FROM documents where table_name='$select_table' and documents_id='$documents_id'";
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$row=mysqli_fetch_assoc($result);
// 	echo "<pre>"; print_r($row); echo "</pre>";  exit;
	$document_link=$row[$document_link];
	unlink($document_link);
	
	$sql="DELETE FROM documents where table_name='$select_table' and documents_id='$documents_id'";
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$table_id=$table_record_id;
	
	include("edit_form.php");
	EXIT;
	}

		
if(!empty($_FILES))
	{
	if(isset($_FILES['file_upload']['tmp_name']))
		{
// 		echo "<pre>"; print_r($_FILES); echo "</pre>"; exit;
		$temp_name=$_FILES['file_upload']['tmp_name'];
		$name=addslashes($_FILES['file_upload']['name']);
		$_POST['document_name']=$name;
		$error=$_FILES['file_upload']['error'];
		if($error==0)
			{
			if($temp_name==""){continue;}

			$e=explode(".",$_FILES['file_upload']['name']);
			$ext=array_pop($e);
			$temp=time();
			$file_name = $select_table."_".$temp.".".$ext;

			//echo " $file_name"; exit;

			$uploaddir = "document_upload"; // make sure www has r/w permissions on this folder

			if (!file_exists($uploaddir))
			{mkdir ($uploaddir, 0777);chmod($uploaddir,0777);}

			$year=date("Y");
			$sub_folder=$uploaddir."/".$year;
			if (!file_exists($sub_folder))
			{mkdir ($sub_folder, 0777);chmod($sub_folder,0777);}
			$uploadfile = $sub_folder."/".$file_name;

			move_uploaded_file($temp_name,$uploadfile);// create file on server
			chmod($uploadfile,0777);

			$sql="INSERT INTO documents SET document_name='$name', document_link='$uploadfile'";
// 			echo "$sql<br />"; //exit;
			$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
			$documents_table_id=mysqli_insert_id($connection);
				}
			}
	}
$skip=array("select_table","submit_form","date_added", "date_edited", "primary_key_fld","target_table");
$ck_field=$select_table."_id";

// table naming scheme didn't follow other tables for id
include("reassign_id_fld.php");
	
if(array_key_exists($ck_field,$_POST))
	{
	$id_field=$ck_field;
	$skip[]=$ck_field;   // skips this field during update
	$id_value=${$ck_field};
	}

include("form_arrays.php");  // get $ARRAY_county_id_table


// echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;

	if(!empty($_POST['countyname']) and empty($_POST['countyid']))
		{
// 		echo "hello<pre>"; print_r($ARRAY_county_id_table); echo "</pre>";
		$_POST['countyid']=$ARRAY_county_id_table[$_POST['countyname']];
		}
// echo "<pre>"; print_r($_POST); echo "</pre>"; exit;

$val=array();
FOREACH($_POST as $fld=>$value)
	{
	if(in_array($fld,$skip)){continue;}
	if($value == NULL)
		{
		$val[]=$fld."= NULL";
		continue;
		}
	if($fld=="table_record_id"){$table_record_id=$value;}
	$val[]=$fld."='".$value."'";
	}
// echo "<pre>"; print_r($val); echo "</pre>"; // exit;
$clause=implode(",",$val);
$clause.=", `date_added`=now()";
$target=$select_table;
if(!empty($target_table)){$target="documents";} // from upload_doc_form.php inside edit_form.php

if(empty($documents_table_id))
	{
	$sql="INSERT into $target set $clause";
	}
	else
	{
	$sql="UPDATE $target set $clause where documents_id='$documents_table_id'";
	}

//   echo "$sql"; exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
$land_leases_id=mysqli_insert_id($connection);
if($result)
	{
	$submit_admin="Edit ".$table_id;
	$table_id=$table_record_id;
// 	echo "p=$table_record_id;"; exit;
	include("edit_form.php");
	}

?>