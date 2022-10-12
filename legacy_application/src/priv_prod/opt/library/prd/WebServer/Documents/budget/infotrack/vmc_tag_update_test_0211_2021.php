<?php


$pre_split_total=153.07;
$post_split_total=(13.60 + 82.27 + 13.60 + 30.00 + 13.60);


if($pre_split_total==$post_split_total)

	{echo "<font color='green'><b>okay</b></font> $pre_split_total $post_split_total<br >" ;}
	else
	{echo "<font color='red'><b>error</b></font> $pre_split_total $post_split_total<br />" ;}

echo "<br />";
if($pre_split_total>$post_split_total)
	{
	$dif=$pre_split_total - $post_split_total;
	echo "<font color='green'><b>pre greater</b></font> $dif $pre_split_total $post_split_total" ;}
if($pre_split_total<$post_split_total)
	{echo "<font color='green'><b>post greater</b></font>$pre_split_total $post_split_total" ;}


 ?>




















