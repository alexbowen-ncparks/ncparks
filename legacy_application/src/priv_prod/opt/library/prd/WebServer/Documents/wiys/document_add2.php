<?php
ini_set('display_errors',1);
include_once("../../include/get_parkcodes.php");

$database="wiys";
include("../../include/connectROOT.inc");
mysql_select_db($database,$connection);

include("../../include/auth.inc");
extract($_REQUEST);
//date_default_timezone_set('America/New_York');

//$date=date("Ymd");

//echo "<pre>";print_r($_FILES);echo "</pre>"; 
//echo "<pre>";print_r($_SESSION);echo "</pre>";
//exit;

//$project_note_id=$_POST['project_note_id'];

define('PROJECTS_UPLOADPATH','schedule/');
$document=$_FILES['document']['name'];

if(empty($_FILES['document']['tmp_name']))
	{
	echo "No file was selected for upload.";
	exit;
	}

$doc_mod=$document;


$document=$park_code."_work_schedule";

$ext=explode(".",$doc_mod);
$num=count($ext)-1;
$ext1=$ext[$num];
$document.=".".$ext1;


//echo $document; exit;
//$target=PROJECTS_UPLOADPATH.$myusername."_".$date."_".$message_note_id."_".$document;
$target=PROJECTS_UPLOADPATH.$document;
move_uploaded_file($_FILES['document']['tmp_name'], $target);


$query="replace schedule set park_code='$park_code', document_location='$target'";
mysql_query($query) or die ("Error updating Database $query");

echo "<font color='red' size='5'>Upload successful</font> => $document";
echo "<H3 ALIGN=left>You may close this window.</H3>";

?>