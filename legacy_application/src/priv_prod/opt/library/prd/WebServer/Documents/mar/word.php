<?php
if($level>4)
	{
// 	echo $sql."<br />"; exit;
	}

// called from enter.php

$file_name="Monthly_Activity_Report_".date("Y-m-d").".doc";
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=$file_name");

// echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
echo "<body>";
$skip=array();
$reg_array=array("CORE"=>"Coastal Region","PIRE"=>"Piedmont Region","MORE"=>"Mountain Region",);

$ck_region="";
$ck_park="";
echo "<table>";
foreach($ARRAY AS $index=>$array)
	{
	extract($array);
	if($region!=$ck_region)
		{
		$var_reg=$region;
		if(array_key_exists($region, $reg_array)){$var_reg=$reg_array[$region];}
		if(array_key_exists($region, $sections)){$var_reg=$sections[$region];}
		echo "<tr><td colspan='3'><br /></td></tr>";
		echo "<tr><td colspan='3'><i><u><b>$var_reg</b></u></i></td></tr>";
		}
	
	if($park!=$ck_park)
		{
		echo "<tr><td colspan='5'><b>$park_name</b></td></tr>";
		}
		$comment=str_replace("•	","&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;", $comment);
		$comment=str_replace(" – ","&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;", $comment);
	$comment=nl2br($comment);
	echo "<tr><td> </td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><li><b>$title</b> - $comment [$date]</li></td></tr>";
	$ck_region=$region;
	$ck_park=$park;
	}
echo "</body>";
echo "</html>";

// 
// echo "<html>";
// echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
// echo "<body>";
// $skip=array();
// $c=count($ARRAY);
// echo "<table>";
// foreach($ARRAY AS $index=>$array)
// 	{
// 	if($index==0)
// 		{
// 		echo "<tr>";
// 		foreach($ARRAY[0] AS $fld=>$value)
// 			{
// 			if(in_array($fld,$skip)){continue;}
// 			echo "<th>$fld</th>";
// 			}
// 		echo "</tr>";
// 		}
// 	echo "<tr>";
// 	foreach($array as $fld=>$value)
// 		{
// 		if(in_array($fld,$skip)){continue;}
// 		echo "<td>$value</td>";
// 		}
// 	echo "</tr>";
// 	}
// echo "</body>";
// echo "</html>";
?>