<?php

session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}

extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);echo "<pre>";//exit;
//echo "<pre>";print_r($_SESSION);echo "<pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

include("../../include/connect.php");

$database="mamajone_cookiejar";


////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query="insert ignore into projects_menu(username,menu_name,menu_type,category,topic,menu_display,
web_address,menu_status) select '$myusername',menu_name,menu_type,category,topic,menu_display,
web_address,menu_status from projects_menu_community where id='$id' ";

mysqli_query($connection, $query) or die ("Couldn't execute query .  $query");
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.


//The number of rows returned from the MySQL query.
//$num=mysqli_num_rows($result);

////mysql_close();

//echo "Update Successful";

//echo "<br /><br />";

//echo "<A href=welcome.php>Return HOME </A>";

header("location: webtools_menu.php");




?>





