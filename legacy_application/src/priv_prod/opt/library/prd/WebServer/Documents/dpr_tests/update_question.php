<?php

	$skip=array("submit_form", "qid","test_number","page");
	$upper=array("answer");
// 	echo "5 s=$submit_form<pre>"; print_r($_POST); echo "</pre>";  exit;
	FOREACH($_POST as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		
		if(in_array($fld,$upper))
			{
			$value=strtoupper($value);
			}
		
		$value=str_replace("\R\N", "<br />", $value);
		$temp[]="`".$fld."`='".$value."'";
	
		}
	$clause=implode(", ",$temp);

	$sql="UPDATE questions set $clause where test_id='$test_number' and qid='$qid'"; 
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$test=$test_number;
	include("show_test.php");
		exit;
	
?>