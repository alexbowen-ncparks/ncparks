<?php
$path="/opt/library/prd/WebServer/Documents/photo_point/photos/2014";
if ($handle = opendir($path))
	{
		echo "Entries:<br />";

		/* This is the correct way to loop over the directory. */
		while (false !== ($entry = readdir($handle)))
		{
		if($entry=="."){continue;}
		if($entry==".."){continue;}
	
		$exp=explode(".",$entry);
		$ext=array_pop($exp);
	//	echo "<br />";
		if(empty($ext))
			{
			$old_name=$path."/".$entry;
			$new_name=$path."/".$entry."JPG";
		//	echo "ext=$ext<br .>";
		//	echo "$old_name<br />$new_name";
	//		rename($old_name, $new_name);
	//		exit;
			}
			
	//	echo "<br /><br />";
		}

		closedir($handle);
	}
?>
