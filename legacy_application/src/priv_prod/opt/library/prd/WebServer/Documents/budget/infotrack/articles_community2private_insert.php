<?php

session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}

extract($_REQUEST);
$today_date=date("Ymd");
//echo "<pre>";print_r($_SERVER);echo "<pre>";//exit;
//echo "<pre>";print_r($_SESSION);echo "<pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo "<br />";
//echo $today_date;exit;

include("../../include/connect.php");

$database="mamajone_cookiejar";


////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query="insert ignore into project_articles(user,system_entry_date,project_category,project_name,
project_note,weblink)
select '$myusername','$today_date',project_category,project_name,project_note,weblink
from project_articles_community where project_note_id='$project_note_id' ";

mysqli_query($connection, $query) or die ("Couldn't execute query .  $query");
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.


//The number of rows returned from the MySQL query.
//$num=mysqli_num_rows($result);

////mysql_close();

//echo "Update Successful";

//echo "<br /><br />";

//echo "<A href=welcome.php>Return HOME </A>";


header("location: articles_menu.php?&project_category=$project_category&category_selected=y");



?>





