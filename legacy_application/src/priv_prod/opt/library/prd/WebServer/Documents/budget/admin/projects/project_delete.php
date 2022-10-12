<?php

session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}

$project_category=$_REQUEST['project_category'];
$project_name=$_REQUEST['project_name'];
$user=$myusername;

//echo $project_category;
//echo $project_name;
//echo $user;
//exit;


include("../../include/connect.php");


$database="mamajone_cookiejar";
$table1="projects";
$table2="project_notes";


////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query1="delete from $table1 where project_category ='' and project_name= '' ";

mysqli_query($connection, $query1) or die ("couldn't execute query 1. $query1");

$query2="delete from $table2 where project_category ='' and project_name= '' ";

mysqli_query($connection, $query2) or die ("couldn't execute query 2. $query2");

$query3="delete from $table1 where project_category ='$project_category' and project_name= '$project_name' and user_id='$user' ";

mysqli_query($connection, $query3) or die ("couldn't execute query 3. $query3");

$query4="delete from $table2 where project_category ='$project_category' and project_name= '$project_name' and user='$user' ";

mysqli_query($connection, $query4) or die ("couldn't execute query 4. $query4");





////mysql_close();

echo "Project: $project_category $project_name has been successfully deleted";

echo "</br> </br>";

echo "<A href=welcome.php>Return HOME </A>";

?>
