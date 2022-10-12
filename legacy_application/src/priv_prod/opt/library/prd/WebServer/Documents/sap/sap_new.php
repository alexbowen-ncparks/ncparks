<?php
//print_r($_REQUEST);
//print_r($_SESSION);EXIT;
// called from Secure Server login.php
ini_set('display_errors',1);
$fp=fopen("https://www.ncstateparks.net:443/divper/zLinux.php?parkcode=FALA",'r');

if(!$fp)
{echo "no go"; exit;}
else
{$read=fgets($fp);}

$array=explode("^",$read);
foreach($array as $k=>$v)
	{
	$person[$k]=explode("*",$v);
	}
echo "<pre>";
print_r($person);
echo "</pre>";
?>
