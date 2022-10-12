<?php
//session_start();
//$myusername=$_SESSION['myusername'];
/*
$date=date("Ymd");
$system_entry_date=date("Ymd");
$date2=time();
$source_table="infotrack_projects_community";
*/
//$source_table="property_photos";

//if(!isset($myusername)){
//header("location: http://roaringgap.net/login.php");
//}

//echo "system_entry_date=$system_entry_date";
extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
echo "<pre>";print_r($_REQUEST);"</pre>";exit;



include("../include/connect.php");

//$db_name="mamajone_roaring"; // Database name
//$tbl_name="property_photos"; // Table name

// Connect to server and select databse.
////mysql_connect("$host", "$username", "$password")or die("cannot connect");
mysql_select_db("$db_name")or die("cannot select DB");

?>