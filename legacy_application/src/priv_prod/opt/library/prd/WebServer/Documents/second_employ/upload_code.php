<?php
//echo "<pre>"; print_r($_REQUEST); print_r($_FILES); echo "</pre>"; EXIT;
//echo "<pre>"; print_r($_FILES); echo "</pre>"; EXIT;
// ****** uploads
		if(isset($_FILES['file_upload']) and $_FILES['file_upload']['size']>0)
			{
	//echo "t=$tempID"; exit;
	date_default_timezone_set('America/New_York');

				$temp_name=$_FILES['file_upload']['tmp_name'];
				
				$size=$_FILES['file_upload']['size'];

		// Delete any previously uploaded file for this id
		$sql_r="SELECT `request` from se_list where id='$id'";
		$result_r = @mysqli_query($connection,$sql_r) or die("$sql_r Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		$row_request=mysqli_fetch_assoc($result_r);
		$exist_file=$row_request['request'];
		$path_request="/opt/library/prd/WebServer/Documents/second_employ/".$exist_file;

//echo "p=$path_request";exit;
		@unlink($path_request);

						$app=explode(".",$_FILES['file_upload']['name']);
						$count=count($app)-1;
				// generate random number
				// needed to prevent browser caches from failing to download any re-uploaded file
				// also protects against someone else downloading by 
				$ran=rand(1000,9999);
			$file_name=$pass_se_dpr."_".$tempID."_".$ran.".".$app[$count];
			
		//	$file_name=$pass_se_dpr."_".$tempID.".".$app[$count];
					
		//		echo "$file_name"; exit;
				
	$uploaddir = "uploads"; // make sure www has r/w permissions on this folder
				
						if (!file_exists($uploaddir))
							{
							mkdir ($uploaddir, 0777);
							//chmod($uploaddir,0777);
							}
								$year=date("Y");
								$sub_folder=$uploaddir."/".$year;
								if (!file_exists($sub_folder))
									{
									mkdir ($sub_folder, 0777);
								//	chmod($sub_folder,0777);
									}
				   
						$uploadfile = $sub_folder."/".$file_name;
				
						move_uploaded_file($temp_name,$uploadfile);// create file on server
						//	chmod($uploadfile,0777);
					
						$sql="UPDATE se_list SET request='$uploadfile' where id='$id'";
					//	echo "<br />$sql"; 
						$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
						//	 exit;
			
			}
//******* end uploads
	
?>