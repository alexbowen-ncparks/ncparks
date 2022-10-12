<?php

session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}
extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);echo "<pre>";//exit;
//print_r($_SESSION);echo "</pre>";
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
//$project_id=$_REQUEST['project_id'];


include("../../include/connect.php");


$database="mamajone_cookiejar";
$table="projects_menu";


////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query="update $table set menu_status='archive'
where id='$id' ";
//mysqli_query($connection, $query) or die ("Error updating Database $query");

$result = mysqli_query($connection, $query) or die ("Couldn't execute query .  $query");

//The number of rows returned from the MySQL query.
//$num=mysqli_num_rows($result);

 ////mysql_close();
 
header("location: welcome.php");

 ?>

















