<?php
session_start();
$beacnum=$_SESSION['budget']['beacon_num'];
date_default_timezone_set('America/New_York');
$date=date("Ymd");
$date2=time();

extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;

//$project_note_id=$_POST['project_note_id'];

define('PROJECTS_UPLOADPATH','documents/');
$document=$_FILES['document']['name'];
$doc_mod=$document;
//$document=$myusername."_".$date."_".$message_note_id;
//echo $document;//exit;
$document="concessions_documents_".$project_note_id;
//echo "<br />";
//echo $document;
$ext=explode(".",$doc_mod);
$num=count($ext)-1;
$ext1=$ext[$num];
$document.=".".$ext1;


//$document=str_replace(" ","_",$document);
//$document=str_replace("%20","_",$document);
//echo $document;
$target=PROJECTS_UPLOADPATH.$document;
move_uploaded_file($_FILES['document']['tmp_name'], $target);
chmod($target, 0775);

// echo "upload_successful";
//include("../../../include/connectBUDGET.inc");
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

$table="concessions_documents";


$query="update $table set weblink='$target'
where project_note_id='$project_note_id' ";
mysqli_query($connection, $query) or die ("Error updating Database $query");

echo "update successful";
echo "<H3 ALIGN=left><A href=documents_personal_search.php?eid=$project_note_id>Return HOME </A></H3>";

?>