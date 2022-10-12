<?php

echo "<pre>"; print_r($_REQUEST); echo "</pre>"; //exit;

$database="facilities";
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");
       
extract($_REQUEST);

$sql="SELECT photo_num FROM spo_dpr_comments where gis_id='$gis_id'";
$result = @mysqli_QUERY($connection,$sql); //ECHO "$sql";
$row=mysqli_fetch_assoc($result);
extract($row);

$sql="SELECT link FROM photos.images where pid='$photo_num'";
$result = @mysqli_QUERY($connection,$sql); //ECHO "$sql";
$row=mysqli_fetch_assoc($result);
extract($row);


//echo "l=$link<br /><br />";  //exit;

		
if($link)
	{
$exp=explode("/",$link);
	$photo=array_pop($exp);
		$tn="ztn.".$photo;
		$tn_link="/photos/".implode("/",$exp)."/".$tn;
	unlink($tn_link);
//echo "l=$tn_link<br /><br />"; 
	
		$tn="640.".$photo;
		$tn_link="/photos/".implode("/",$exp)."/".$tn;
	unlink($tn_link);
//echo "l=$tn_link<br /><br />";  
	
		$tn_link=$link;
	unlink($tn_link);

//echo "l=$tn_link<br /><br />";  exit;
	
	$sql="DELETE from photos.images where pid='$photo_num'";
	$result = @mysqli_QUERY($connection,$sql); //ECHO "$sql";

	$sql="UPDATE spo_dpr_comments set photo_num='' where file_id='$pass_id'";
	$result=mysqli_QUERY($connection,$sql);
	
	header("Location: edit.php?gis_id=$gis_id");
	exit;
	}


?>