<?php
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
$database="fixed_assets";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, $database)
       or die ("Couldn't select database $database");
       
extract($_REQUEST);
$sql="SELECT photo_upload from surplus_track where id='$id'";
$result=mysqli_query($connection,$sql);
$row=mysqli_fetch_assoc($result);
extract($row);
$path_to_file="/opt/library/prd/WebServer/Documents/fixed_assets/".$photo_upload;
//echo "p = $path_to_file"; exit;
unlink($path_to_file);
$sql="UPDATE surplus_track SET photo_upload='' where id='$id'";
$result=mysqli_query($connection,$sql);

header("location: surplus_equip_form.php?location=$location&act=review");
?>