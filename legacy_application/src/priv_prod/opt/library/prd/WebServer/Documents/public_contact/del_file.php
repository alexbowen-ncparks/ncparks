<?php
if($level>4)
	{
	ini_set('display_errors',1);
	}

$database="public_contact"; 
$dbName=$database;
include("../../include/iConnect.inc"); // include iConnect.inc with includes no_inject.php
mysqli_select_db($connection,$dbName);
$sql="SELECT record_id, link from uploads where id='$id'"; 
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_error($connection));
$row=mysqli_fetch_assoc($result);
extract($row);

$var_ft=explode("/",$link);
$file=array_pop($var_ft);

// check if PDF
$ck_file=explode(".", $link);
$test=array_pop($ck_file);

if($test=="pdf" or $test=="PDF")
	{
	$file=str_replace(".pdf", ".jpg", $file);
	}
array_push($var_ft, "tn_".$file);
$tn=implode("/",$var_ft);

unlink($tn);
unlink($link);

$sql="DELETE from uploads where id='$id'"; 
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_error($connection));

include("contact.php");
?>