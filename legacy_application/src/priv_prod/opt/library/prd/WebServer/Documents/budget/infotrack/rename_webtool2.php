<?php

session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}

extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";exit;

include("../../include/connect.php");
$database="mamajone_cookiejar";
$table="projects_menu";


////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");


if($category_new==""){echo "<font color='red' size='5'>Error Message:</font> <font color='blue'>You must enter a Value for both the NEW Category & NEW Topic to RE-name your WebTool</font><br />Click the BACK button on your Browser to return to the Form";exit;}
if($topic_new==""){echo "<font color='red' size='5'>Error Message:</font> <font color='blue'>You must enter a Value for both the NEW Category & NEW Topic to RE-name your WebTool</font><br />Click the BACK button on your Browser to return to the Form";exit;}

//$project_category=$_POST['project_category'];
//$project_name=$_POST['project_name'];
//$project_category_new=$_POST['project_category_new'];
//$project_name_new=$_POST['project_name_new'];

//include("../../include/connect.php");
//$database="mamajone_cookiejar";
//$table1="projects";
//$table2="project_notes";

//////mysql_connect($host,$username,$password);
//@mysql_select_db($database) or die( "Unable to select database");


$query1="update projects_menu set category='$category_new',topic='$topic_new' where
         menu_name='webtools' and menu_type='private' and category='$category'
		 and topic='$topic' and username='$myusername' ";

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$query2="update projects_menu set menu_display=concat(category,'_',topic) 
         where username='$myusername'";

mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


header("location: welcome.php");


?>