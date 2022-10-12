<?php
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/authBUDGET.inc");
include("../../../include/activity.php");
$date=date("Ymd");
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;

//$project_note_id=$_POST['project_note_id'];

define('PROJECTS_UPLOADPATH','documents/');
$document=$_FILES['document']['name'];
if($document==""){echo "<font color='red' size='5'><b>No Document Found. <br /><br />Please hit back button on Browser to Upload Document</b></font>";exit;}
$doc_mod=$document;
//$document=$myusername."_".$date."_".$message_note_id;
//echo $document;//exit;
$document=$tempid."_".$date."_".$id;
//echo "<br />";
//echo $document;
$ext=explode(".",$doc_mod);
$num=count($ext)-1;
$ext1=$ext[$num];
$document.=".".$ext1;
//echo $document;
//echo "<pre>";print_r($ext);echo "</pre>";exit;

//$document=str_replace(" ","_",$document);
//$document=str_replace("%20","_",$document);

//echo $document;
//$target=PROJECTS_UPLOADPATH.$myusername."_".$date."_".$message_note_id."_".$document;
$target=PROJECTS_UPLOADPATH.$document;
move_uploaded_file($_FILES['document']['tmp_name'], $target);
// echo "upload_successful";


$query="update cid_vendor_invoice_payments set document_location='$target'
where id='$id' ";
mysqli_query($connection, $query) or die ("Error updating Database $query");

echo "<font color='red' size='5'>update successful</font>";
echo "<H3 ALIGN=left><A href=acs.php?id=$id&m=invoices>Return HOME</A></H3>";

?>