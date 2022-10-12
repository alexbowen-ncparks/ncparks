<?php

//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; exit;

$database="le";
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");
       
// extract($_REQUEST);

$sql="SELECT link FROM attachment where id='$pass_id'";
$result = @mysqli_QUERY($connection,$sql); //ECHO "$sql";
$row=mysqli_fetch_assoc($result);
extract($row);

if($link)
	{
	unlink($link);
	//rmdir($link);
	
	$sql="DELETE from attachment where id='$pass_id'";
	$result=mysqli_QUERY($connection,$sql);
	
	header("Location: pr63_form_reg.php?id=$id&ci_num=$ci_num");
	exit;
	}


?>