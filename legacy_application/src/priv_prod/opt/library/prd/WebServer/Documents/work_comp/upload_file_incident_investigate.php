<?php
//unlink("upload_form19/2014/form19_.pdf");
//unlink("upload_form19/2014/form19_5.pdf");
//echo "<pre>"; print_r($_FILES); echo "</pre>"; exit;
if ($_FILES['files']['error'][0] == 0)
	{
	date_default_timezone_set('America/New_York');
	   $num=count($_FILES['files']['name']);
	
	
		for($i=0;$i<$num;$i++){
				$temp_name=$_FILES['files']['tmp_name'][$i];
			if($temp_name==""){continue;}
		
			if(!is_uploaded_file($_FILES['files']['tmp_name'][$i])){
		//	echo "<pre>";
		//	print_r($_FILES);  print_r($_REQUEST);
		//	echo "</pre>";
			exit;}
				$file_name = $_FILES['files']['name' ][$i];
				$file_name=str_replace("\'","_",$file_name);
				$file_name=mysqli_real_escape_string($connection,$file_name);
				$file_type = $_FILES['files']['type'][$i];
			if($file_type!="application/pdf"){echo "Your file must be a PDF.";exit;}	
			
	$sql="REPLACE form_incident_investigate_upload (wc_id,file_name) "."VALUES ('$wc_id','$file_name')";

//	echo "$sql <br />";exit;
	$result = @mysqli_query($connection, $sql) or die("$sql<br />Error #". mysqli_errno($connection) . ": " . mysqli_error($connection));

		$id= mysqli_insert_id($connection);
	// remove any existing file for form19
			$sql = "SELECT file_link from form_incident_investigate_upload  where wc_id='$wc_id'";
			$result = @mysqli_query($connection, $sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
			$row=mysqli_fetch_assoc($result);
			if(!empty($row['file_link']))
				{
				$path_to_file="/opt/library/prd/WebServer/Documents/work_comp/".$row['file_link'];
				unlink($path_to_file); //echo "$path_to_file"; exit;
				}
				//ECHO "$sql yes"; exit;
	$year=date("Y");
	$ts=time();
	$uploaddir = "upload_form_incident_investigate/".$year; // make sure www has r/w permissions on this folder

	//    echo "$uploaddir"; exit;
	if (!file_exists($uploaddir)) {mkdir ($uploaddir, 0777);}

	$new_name="upload_form_incident_investigate_".$wc_id."_".$ts;
	$uploadfile = $uploaddir."/".$new_name.".pdf";
	move_uploaded_file($temp_name,$uploadfile);// create file on server
		chmod($uploadfile,0777);
	$path_to_file="/opt/library/prd/WebServer/Documents/work_comp/".$uploadfile;

		if(file_exists($path_to_file))
			{
			$sql = "UPDATE form_incident_investigate_upload set file_link='$uploadfile' where id='$id'";
			$result = @mysqli_query($connection, $sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
			}
			else
			{echo "There was a problem and the file was not uploaded. Contact Tom Howard for assistance."; exit;}
		}
	
	}
?>