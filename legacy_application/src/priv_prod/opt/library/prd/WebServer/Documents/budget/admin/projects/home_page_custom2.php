<?php

session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}

$background_color=$_POST['background_color'];


include("../../include/connect.php");
$database="mamajone_cookiejar";


////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query1="update projects_customformat set body_bgcolor='$background_color' where user_id='$myusername'";

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


////mysql_close();



header("location: home_page_custom.php");


?>
