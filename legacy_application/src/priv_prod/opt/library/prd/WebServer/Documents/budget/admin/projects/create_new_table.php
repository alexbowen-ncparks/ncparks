<?php
$array1=range('a','z');
//echo "<pre>"; print_r($array1); echo "</pre>"; exit;
foreach($array1 as $num=>$letter)
	{
		$array2[]=$array1[$num].$letter;
	}
	
//echo "<pre>"; print_r($array2); echo "</pre>"; exit;	
	
	
foreach($array2 as $num=>$letter)
	{
		$array3[]=$array1[$num].$letter;
	}
//echo "<pre>"; print_r($array3); echo "</pre>"; exit;	
	$max_array=array_merge($array1,$array2,$array3);
echo "<pre>"; print_r($max_array); echo "</pre>";  exit;

$sql="CREATE  TABLE IF NOT EXISTS `$database`.`$new_table` (";
foreach($max_array as $k=>$letter)
	{
	if($k==$count){break;}
	$sql.="`$letter` text NOT NULL,";
	}
	$sql=rtrim($sql,",");
	
	if($php[0]>4)
	{$sql.=") ENGINE  =  MyISAM  DEFAULT CHARSET  = latin1;";}
	else
	{$sql.=");";}
	
//echo "$sql";exit;

?>