<?php

session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";
//print_r($_SESSION);echo "</pre>";exit;



//$project_category=$_REQUEST['project_category'];
//$project_name=$_REQUEST['project_name'];
//$user=$myusername;

//echo $project_category;
//echo $project_name;
//echo $user;
//exit;


include("../../include/connect.php");


$database="mamajone_cookiejar";
$table="projects_menu";


////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query1="delete from $table where category ='' and topic= '' ";

mysqli_query($connection, $query1) or die ("couldn't execute query 1. $query1");

$query2="delete from $table 
         where username='$myusername' 
         and menu_name='webtools'
		 and menu_type='private'
		 and category='$category'
		 and topic='$topic' ";
       		 

mysqli_query($connection, $query2) or die ("couldn't execute query 3. $query3");



////mysql_close();

echo "WebTool: $category $topic has been successfully deleted";

echo "</br> </br>";

echo "<A href=welcome.php>Return HOME </A>";

?>
