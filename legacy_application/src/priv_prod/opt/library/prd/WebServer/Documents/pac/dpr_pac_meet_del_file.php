<?php
//These are placed outside of the webserver directory for security
$database="pac";
include("../../include/auth.inc"); // used to authenticate users
$database="pac";
include("../../include/iConnect.inc"); // database connection parameters
 if($connection==""){echo "Failed to connect to database.";exit;}
mysqli_select_db($connection,$database);

extract($_REQUEST);

if ($id)
	{	 
	//  echo "l=$link";exit;
	unlink($link);
	
	$sql="UPDATE meetings set file_link=trim(BOTH ',' from replace(file_link,'$link','')) where id='$id'";
	//ECHO "$sql";exit;
	$result=mysqli_QUERY($connection,$sql);
	
	$sql="UPDATE meetings set file_link=replace(file_link,',,',',') where id='$id'";
	//ECHO "$sql";exit;
	$result=mysqli_QUERY($connection,$sql);
	
	header("Location: pac_cal.php?edit=$id");
	exit;
	}


if ($source)
{
 
//  echo "l=$link";exit;
unlink($link);

$sql="UPDATE chop_comment set file_link=trim(BOTH ',' from replace(file_link,'$link','')) where id='1'";
//ECHO "$sql";exit;
$result=mysqli_QUERY($connection,$sql);

$sql="UPDATE chop_comment set file_link=replace(file_link,',,',',') where id='1'";
//ECHO "$sql";exit;
$result=mysqli_QUERY($connection,$sql);

header("Location: /pac/pac_chop_comment.php");
exit;
}
?>