<?php

session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}

$project_id=$_POST['project_id'];
$copy_project_for=$_POST['copy_project_for'];
$project_category=$_POST['project_category'];
$project_name=$_POST['project_name'];



include("../../include/connect.php");
$database="mamajone_cookiejar";


////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query1="update projects set shared_users=concat(shared_users,',$copy_project_for') 
where project_id=$project_id";

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$query2="update projects set project_type='share' 
where project_id=$project_id";

mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");






//$query2="insert into project_notes(user,system_entry_date,project_category,project_name,project_note,link,weblink)
//select '$copy_project_for',system_entry_date,project_category,project_name,project_note,link,weblink
//from project_notes where user='$myusername' and project_category='$project_category' and project_name='$project_name' order by project_note_id ";

//mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

// frees the connection to MySQL
////mysql_close();


header("location: welcome.php");



?>
