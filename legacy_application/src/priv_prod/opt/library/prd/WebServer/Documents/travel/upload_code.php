<?php
// ****** uploads
			if(isset($_FILES['file_upload']))
				{
				foreach($_FILES['file_upload']['tmp_name'] as $k=>$v)
					{
					$temp_name=$_FILES['file_upload']['tmp_name'][$k];
					
					$size=$_FILES['file_upload']['size'][$k];
								if($size==0){continue;}
									
					//echo "m1=$mid $temp_name"; 
								if($temp_name==""){continue;}
								$app=explode(".",$_FILES['file_upload']['name'][$k]);
								$count=count($app)-1;
						// generate random number
						// needed to prevent browser caches from failing to download any re-uploaded file
						$ran=rand(1000,9999);
								$file_name = $pass_tadpr."_".$k."_".$ran.".".$app[$count];
						
				//	echo "m=$mid $file_name"; exit;
					
							$uploaddir = "uploads"; // make sure www has r/w permissions on this folder
					
							if (!file_exists($uploaddir))
								{
								mkdir ($uploaddir, 0777);
// 								chmod($uploaddir,0777);
								}
									$year=date("Y");
									$sub_folder=$uploaddir."/".$year;
									if (!file_exists($sub_folder))
										{
										mkdir ($sub_folder, 0777);
// 										chmod($sub_folder,0777);
										}
					   
							$uploadfile = $sub_folder."/".$file_name;
					
							move_uploaded_file($temp_name,$uploadfile);// create file on server
// 								chmod($uploadfile,0777);
						
							$sql="UPDATE tal SET $k='$uploadfile' where id='$id'";
					//		echo "<br />$sql";  //exit;
							$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
								
						}
				}
//******* end uploads
	
?>