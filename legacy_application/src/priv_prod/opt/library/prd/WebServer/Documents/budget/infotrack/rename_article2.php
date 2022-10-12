<?php

session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}

extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
//echo "<pre>";print_r($_SESSION);"</pre>";exit;

include("../../include/connect.php");
$database="mamajone_cookiejar";
$table="project_articles";


////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");


if($project_category_new==""){echo "<font color='red' size='5'>Error Message:</font> <font color='blue'>Missing Values on your Form. Please enter all 3 Form Values</font><br />Click the BACK button on your Browser to return to the Form";exit;}
if($project_name_new==""){echo "<font color='red' size='5'>Error Message:</font> <font color='blue'>Missing Values on your Form. Please enter all 3 Form Values</font><br />Click the BACK button on your Browser to return to the Form";exit;}
if($project_note_new==""){echo "<font color='red' size='5'>Error Message:</font> <font color='blue'>Missing Values on your Form. Please enter all 3 Form Values</font><br />Click the BACK button on your Browser to return to the Form";exit;}
if($weblink_new==""){echo "<font color='red' size='5'>Error Message:</font> <font color='blue'>Missing Values on your Form. Please enter all 3 Form Values</font><br />Click the BACK button on your Browser to return to the Form";exit;}

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


$query1="update $table set project_category='$project_category_new',
         project_name='$project_name_new',project_note='$project_note_new',
		 weblink='$weblink_new'
		 where project_note_id='$project_note_id' ";

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

//header("location: articles_menu.php");
header("location: articles_personal_search.php?&search_term=$search_term");


?>