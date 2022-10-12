<?php

session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}

//echo "hello";
$note_url=$_POST['link'];
//echo $note_url;
//exit;
header("location:".$note_url);
?>