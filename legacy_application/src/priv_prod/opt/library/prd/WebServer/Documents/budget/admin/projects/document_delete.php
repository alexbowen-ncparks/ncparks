<?php

session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}

$project_note_id=$_POST['project_note_id'];


include("../../include/connect.php");


$database="mamajone_cookiejar";
$table="project_notes";


////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query="update $table set link='' where project_note_id='$project_note_id' ";

mysqli_query($connection, $query) or die ('Error updating Database');

////mysql_close();

echo "Update Successful-Document for project_note_ID# $project_note_id was deleted";

echo "</br> </br>";

echo "<A href=welcome.php>Return HOME </A>";

?>
