<?php 

$dir = opendir('2009/'); 

while ($read = readdir($dir)) 
{
if ($read[0]!='.') 
{ 
$log_list[]=$read; 
}
}

closedir($dir); 

?>