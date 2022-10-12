<?php

// called from edit.PHP
$num=count($_FILES['file_upload']['tmp_name']);

// echo "<pre>"; print_r($_FILES); echo "</pre>";  exit;

$temp_name=$_FILES['file_upload']['tmp_name'];
if($temp_name==""){continue;}

if(!is_uploaded_file($_FILES['file_upload']['tmp_name'])){exit;}

$doc_name = $_FILES['file_upload']['name'];
$exp=explode(".",$doc_name);
$ext=array_pop($exp);

$uploaddir = "uploads"; // make sure www has r/w permissions on this folder

if (!file_exists($uploaddir)) {mkdir ($uploaddir, 0777);}


$sub_folder=$uploaddir."/".date("Y");
if (!file_exists($sub_folder)) {mkdir ($sub_folder, 0777);}
	//echo "$sub_folder"; exit;

$ts=time();
$file_name=$select_table."_".$item_id."_".$ts.".".$ext;

$uploadfile = $sub_folder."/".$file_name;
move_uploaded_file($temp_name,$uploadfile);// create file on server
chmod($uploadfile,0777);

?>