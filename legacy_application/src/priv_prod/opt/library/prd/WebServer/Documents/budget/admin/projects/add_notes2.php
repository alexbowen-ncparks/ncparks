<?php

session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}

$date=$_POST['date'];
$user=$_POST['user'];
$project_category=$_POST['project_category'];
$project_name=$_POST['project_name'];
$project_note=$_POST['project_note']; //$project_note=addslashes($project_note);
//echo $project_note; exit;
$source_page=$_POST['source_page']; //$source_page=addslashes($source_page);
$question=$_POST['link']; //$link=addslashes($link);
$weblink=$_POST['weblink']; //$weblink=addslashes($weblink);



include("../../include/connect.php");
$database="mamajone_cookiejar";
$table="project_notes";

////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query="insert into $table(user,system_entry_date,project_category,project_name,project_note,weblink) 
values ('$user','$date','$project_category','$project_name','$project_note','$weblink')";

mysqli_query($connection, $query) or die ("Couldn't execute query 1.  $query");

// frees the connection to MySQL
////mysql_close();


header("location: welcome.php");



?>
