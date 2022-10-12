<?php

session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}

extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";
//print_r($_SESSION);echo "</pre>";exit;

if($category==""){echo "<font color='red' size='5'>Error Message:</font> <font color='blue'>You must enter a Value for both Category & Topic to ADD a New WebTool</font><br />Click the BACK button on your Browser to return to the Form";exit;}
if($topic==""){echo "<font color='red' size='5'>Error Message:</font> <font color='blue'>You must enter a Value for both Category & Topic to ADD a New Webtool</font><br />Click the BACK button on your Browser to return to the Form";exit;}


//$date=$_POST['date'];
//$project_category=$_POST['project_category'];
//$project_name=$_POST['project_name'];
//$project_note=$_POST['project_note'];
//$weblink=$_POST['weblink'];
$date=date("Ymd");
//$project_start_date=$_POST['project_start_date'];
//$project_end_date=$_POST['project_end_date'];
//$project_status=$_POST['project_status'];


include("../../include/connect.php");
$database="mamajone_cookiejar";
$table="projects_menu";


////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query="insert ignore into $table(username,menu_name,menu_type,category,topic,web_address,menu_status) 
values ('$myusername','webtools','private','$category','$topic','$web_address','open')";

mysqli_query($connection, $query) or die ("Couldn't execute query 1.  $query");


$query2="update projects_menu set menu_display=concat(category,'_',topic) where username='$myusername' ";

mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


// frees the connection to MySQL
////mysql_close();

//echo "Update Successful";

//echo "<br /><br />";

//echo "<A href=welcome.php>Return HOME </A>";

header("location: webtools_menu.php");


?>
