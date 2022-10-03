<?php
// ********* DELETE A FILE ***************************
  
//include("../../include/authFIND.inc"); // used to authenticate users

$database="div_cor";
include("../../include/iConnect.inc");// database connection parameters
extract($_REQUEST); //print_r($_REQUEST);
if ($id)
{
mysqli_select_db($connection,$database)
       or die ("Couldn't select database");

/*
$sql="SELECT link,mid,id from corre where id='$id'";
$result=mysqli_QUERY($sql);
$row=mysqli_fetch_array($result);
extract($row);
*/

unlink($link);

//$sql="DELETE FROM uploaded_file where mid='$mid'";
//$result=mysqli_QUERY($sql);

$link=addslashes($link);
//$link="http://149.168.1.196/div_cor/".$link;
$sql="UPDATE corre set file_link=trim(BOTH ',' from replace(file_link,'$link','')) where id='$id'";
//ECHO "$sql";exit;
$result=mysqli_QUERY($connection,$sql);

$sql="UPDATE corre set file_link=replace(file_link,',,',',') where id='$id'";
//ECHO "$sql";exit;
$result=mysqli_QUERY($connection,$sql);

header("Location: display_item.php");
exit;
}
?>