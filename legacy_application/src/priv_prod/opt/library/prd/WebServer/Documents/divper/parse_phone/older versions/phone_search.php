<?php 
extract($_REQUEST);

$open_file="phone_large.TXT";
$fo=fopen($open_file,'r');
$bill_txt = fread($fo, filesize($open_file));
fclose($fo);

$thisSearch=": S-4690";
$ex1=explode($thisSearch,$bill_txt);

$ex2=explode(": Employee Summary    ",$ex1[1]);


echo "<pre>c=$count"; print_r($ex2[0]); echo "</pre>";  exit;




?>