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


echo "<table border=\"1\">";
echo "<tr><td>File Uploaded: </td>
   <td>" . $_FILES["upload_file"]["name"] . "</td></tr>";
echo "<tr><td>File Type: </td>
   <td>" . $_FILES["upload_file"]["type"] . "</td></tr>";
echo "<tr><td>File Size: </td>
   <td>" . ($_FILES["upload_file"]["size"] / 1024) . " Kb</td></tr>";
echo "<tr><td>Name of Temp File: </td>
   <td>" . $_FILES["upload_file"]["tmp_name"] . "</td></tr>";
echo "</table>";

echo "<pre>";print_r($_REQUEST);"</pre>";exit;



define('PROJECTS_UPLOADPATH','property_photos/');
$document=$_FILES['document']['name'];
$doc_mod=$document;
//$doc_mod=$document;
//$document=$myusername."_".$date."_".$message_note_id;
//echo $document;//exit;
//$document="pcard_unreconciled".$source_id;
$document=$source_table."_".$source_id;//echo $document;//exit;
//echo "<br />";
//echo "<br />";
//echo $document;//exit;
$ext=explode(".",$doc_mod);
//echo "<pre>";print_r($ext);echo "</pre>";//exit;
$num=count($ext)-1;
$ext1=$ext[$num];
$document.=".".$ext1;
//echo $document;//exit;
//echo "<br />";
//echo "<pre>";print_r($ext);echo "</pre>";exit;

//$document=str_replace(" ","_",$document);
//$document=str_replace("%20","_",$document);

//echo $document;
//$target=PROJECTS_UPLOADPATH.$myusername."_".$date."_".$message_note_id."_".$document;
$target=PROJECTS_UPLOADPATH.$document;
move_uploaded_file($_FILES['document']['tmp_name'], $target);
// echo "upload_successful";
//echo $target;//exit;


include("../include/connect.php");

//$db_name="mamajone_roaring"; // Database name
//$tbl_name="property_photos"; // Table name

// Connect to server and select databse.
////mysql_connect("$host", "$username", "$password")or die("cannot connect");
mysql_select_db("$db_name")or die("cannot select DB");

?>