<?php

//print_r($_FILES); 
// echo "<pre>"; print_r($_REQUEST); print_r($_FILES); echo "</pre>"; //exit;
//exit;

if (!empty($_GET['del']))
	{
	extract($_GET);
	$database="fire";
	include("../../include/iConnect.inc");
// 	include("../../include/get_parkcodes_reg.php");

	mysqli_select_db($connection,'fire');	
	$sql="SELECT contract_id, file_link FROM contract_uploads where park_code='$park_code' and doc_id='$doc_id'";
// 	ECHO "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query.");
	$row=mysqli_fetch_assoc($result);
	extract($row);
	unlink($file_link);
	
	$sql="DELETE FROM contract_uploads where park_code='$park_code' and doc_id='$doc_id'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query. $sql");
	header("Location: contracts.php?park_code=$park_code&contract_id=$contract_id");
	exit;
	}

if (!empty($_FILES['file_upload']['tmp_name']))
	{
	
	extract($_FILES);
	$size = $_FILES['file_upload']['size'];
		
	if($size>10)
		{
		
		$type = $_FILES['file_upload']['type']; 
		$file_name = $_FILES['file_upload']['name']; 
		$file_name=str_replace(" ","_",$file_name);
		$file_name=str_replace("?","_",$file_name);
		$file_name=str_replace("'","",$file_name);
		
		$var = explode(".",$file_name);
		$ext=array_pop($var);
		
		$time=date("Y-m-d H:i:s");
		$timestamp=str_replace(" ","_",$time);
		$file = $park_code."_document_".$timestamp.".".$ext;
		
		
		$folder="contracts"; //make sure www has r/w permissions on this folder
		if (!file_exists($folder)) {mkdir ($folder, 0777);}
		
		$year=date('Y');
		$folder.="/".$year; //make sure www has r/w permissions on this folder
		if (!file_exists($folder)) {mkdir ($folder, 0777);}
		
		$uploadfile = $folder."/".$file;
//		echo "$uploadfile";exit;
		
		move_uploaded_file($_FILES['file_upload']['tmp_name'],$uploadfile);// create file on server
		$file_link="file_link='$uploadfile', file_name='$file_name'";
		}
		else
		{
		$file_link="";
		}
	
	if(!empty($file_link))
		{
		$sql = "INSERT INTO contract_uploads
		set doc_type='$doc_type', contract_id='$id', park_code='$park_code', $file_link";
	//	  echo "$sql";exit;
		$result = @mysqli_query($connection,$sql) or die($sql." ".mysqli_error($connection));
		$doc_id=mysqli_insert_id($connection);
		}
	
	}

?>