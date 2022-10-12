<?php
if(isset($_FILES['file_upload']['tmp_name']))
	{
//echo "<pre>"; print_r($_FILES); echo "</pre>"; exit;
			$temp_name=$_FILES['file_upload']['tmp_name'];
			$name=addslashes($_FILES['file_upload']['name']);
			$error=$_FILES['file_upload']['error'];
	if($error==0)
		{
		if($temp_name==""){continue;}
		date_default_timezone_set('America/New_York');
		
		$e=explode(".",$_FILES['file_upload']['name']);
		$ext=array_pop($e);
		
		$ts=time();
		$stored_name=$park."_100_Anniversary_".$eid."_".$ts.".".$ext;
		//echo " $stored_name"; //exit;

		$uploaddir = "uploads"; // make sure www has r/w permissions on this folder
		if (!file_exists($uploaddir))
		{mkdir ($uploaddir, 0777);chmod($uploaddir,0777);}

		$year=date("Y");
		$sub_folder=$uploaddir."/".$year;
		if (!file_exists($sub_folder))
		{mkdir ($sub_folder, 0777);chmod($sub_folder,0777);}

		$uploadfile = $sub_folder."/".$stored_name;

		move_uploaded_file($temp_name,$uploadfile);// create file on server
		chmod($uploadfile,0777);

		$sql="INSERT INTO file_upload SET eid='$eid', file_name='$name', link='$uploadfile' ";
//echo "$sql";exit;
		$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
		}
	}

?>