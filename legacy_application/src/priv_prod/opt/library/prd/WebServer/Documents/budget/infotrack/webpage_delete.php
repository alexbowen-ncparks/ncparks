<?php

session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}
extract($_REQUEST);

//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

//$project_category=$_REQUEST['project_category'];
//$project_name=$_REQUEST['project_name'];
//$user=$myusername;

//echo $project_category;
//echo $project_name;
//echo $user;
//exit;


include("../../include/connect.php");


$database="mamajone_cookiejar";
$table="project_notes";


////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query1="delete from $table where project_note_id='$project_note_id' ";

mysqli_query($connection, $query1) or die ("couldn't execute query 1. $query1");


////mysql_close();

echo "WebPage: named: $project_category-$project_name<br />Description: $project_note has been successfully deleted";

echo "</br> </br>";

echo "<A href=welcome.php>Return HOME </A>";

?>
