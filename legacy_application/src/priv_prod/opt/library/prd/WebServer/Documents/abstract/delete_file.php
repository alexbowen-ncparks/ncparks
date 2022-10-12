<?php
ini_set('display_errors',1);
$path="/opt/library/prd/WebServer/Documents/";

$remove=$path."divper/position_desc_files/2011";

echo "$remove<br /><br />";

if(is_file($remove))
	{
	unlink($remove);
	echo "$remove was deleted";
	}

if(is_dir($remove))
	{
	rmdir($remove);
	echo "$remove was deleted";
	}

?>