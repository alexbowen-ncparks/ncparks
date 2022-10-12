<?php

session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}

$project_category=$_POST['project_category'];
$project_name=$_POST['project_name'];
$project_status=$_POST['project_status']; $project_status=addslashes($project_status);
$project_id=$_POST['project_id'];$project_id=addslashes($project_id);

//echo $question;
//exit;


include("../../include/connect.php");


$database="mamajone_cookiejar";
$table="projects";


////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query="update $table set project_category='$project_category', 
project_name='$project_name',project_status='$project_status'
where project_id='$project_id' ";
//mysqli_query($connection, $query) or die ("Error updating Database $query");

$result = mysqli_query($connection, $query) or die ("Couldn't execute query 1.  $query");

//The number of rows returned from the MySQL query.
//$num=mysqli_num_rows($result);

 ////mysql_close();
 
header("location: welcome.php");

 ?>

















