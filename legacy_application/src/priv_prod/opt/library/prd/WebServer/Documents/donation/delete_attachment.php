<?php

//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; exit;

$database="divper";
include("../../include/iConnect.inc"); // database connection parameters
$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");
       
extract($_REQUEST);

$sql="SELECT link FROM donor_attachment where file_id='$pass_id' and donor_id='$id'";
$result = @mysqli_QUERY($connection,$sql); //ECHO "$sql";
$row=mysqli_fetch_assoc($result);
extract($row);

if($link)
	{
	unlink($link);
	//rmdir($link);
	
	$sql="DELETE from donor_attachment where file_id='$pass_id'";
	$result=mysqli_QUERY($connection,$sql);
	
	header("Location: form.php?id=$id&submit_label=Find&1");
	exit;
	}


?>