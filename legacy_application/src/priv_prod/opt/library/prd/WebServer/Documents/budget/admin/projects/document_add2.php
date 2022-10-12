<?php

session_start();
$myusername=$_SESSION['myusername'];
$date=date("Ymd");

if(!isset($myusername)){
header("location:index.php");
}

$project_note_id=$_POST['project_note_id'];
define('PROJECTS_UPLOADPATH','documents/');
$document=$_FILES['document']['name'];
//echo $document;
$target=PROJECTS_UPLOADPATH.$myusername."_".$date."_".$project_note_id."_".$document;
move_uploaded_file($_FILES['document']['tmp_name'], $target);
// echo "upload_successful";
include("../../include/connect.php");


$database="mamajone_cookiejar";
$table="project_notes";


////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query="update $table set link='$target'
where project_note_id='$project_note_id' ";
mysqli_query($connection, $query) or die ("Error updating Database $query");

echo "update successful";
echo "<H3 ALIGN=center><A href=welcome.php>Return HOME </A></H3>";

?>