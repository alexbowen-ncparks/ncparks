<?php

session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}

$date=$_POST['date'];
$project_category=$_POST['project_category'];
$project_name=$_POST['project_name'];
$project_note=$_POST['project_note'];
$weblink=$_POST['weblink'];
$date=date("Ymd");
//$project_start_date=$_POST['project_start_date'];
//$project_end_date=$_POST['project_end_date'];
//$project_status=$_POST['project_status'];


include("../../include/connect.php");
$database="mamajone_cookiejar";
$table="projects";
$table2="project_notes";

////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query="insert into $table(user_id,project_category,project_name,created,share_provider) 
values ('$myusername','$project_category','$project_name','$date','$myusername')";

mysqli_query($connection, $query) or die ("Couldn't execute query 1.  $query");

$query2="insert into $table2(user,system_entry_date,project_category,project_name,project_note,weblink,author) 
values ('$myusername','$date','$project_category','$project_name','$project_note','$weblink','$myusername')";

mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


// frees the connection to MySQL
////mysql_close();

//echo "Update Successful";

//echo "<br /><br />";

//echo "<A href=welcome.php>Return HOME </A>";

header("location: welcome.php");


?>
