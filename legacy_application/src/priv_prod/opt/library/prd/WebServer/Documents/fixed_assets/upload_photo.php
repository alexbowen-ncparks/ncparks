<?php
ini_set('display_errors',1);

//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_FILES); echo "</pre>";  exit;
//echo "misc photo<pre>"; print_r($misc_photo); echo "</pre>";  //exit;

if(!empty($_FILES))
	{
foreach($_FILES['images']['name'] as $index=>$value)
		{
		if(!empty($value))
			{
			$exp=explode(".",$value);
			$ext=array_pop($exp);
	
			$upload_file = rand(1000,100000).".".$ext;
			$uploaddir = "uploads"; // make sure www has r/w permissions on this folder

			$year=date("Y");
			$sub_folder=$uploaddir."/".$year;
			if (!file_exists($sub_folder))
				{mkdir ($sub_folder, 0777);chmod($sub_folder,0777);}
					
			$target = "$sub_folder/$upload_file";
                    
			move_uploaded_file($_FILES['images']['tmp_name'][$index], $target);
					chmod($target,0777);
			
			@$var_fnu=$_POST['fn_unique'][$index];
			@$var_fn=$_POST['fas_num'][$index];
			
			if(!empty($var_fnu) )
				{
				$var_f="fn_unique";
				$var=$var_fnu;
				}
				else
				{
				$var_f="fas_num";
				$var=$var_fn;
				if($index<11)
					{					
					$var_f="fn_unique";
					$var=$misc_photo[$index];
					}
				}
			$sql="UPDATE surplus_track
			set photo_upload='$target'
			where $var_f='$var'
			"; 
	//		echo " s=$sql<br /><br />"; //exit;
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysql_error($connection));
	//		 echo " s=$sql"; exit;
			}
		}
	}


?>
