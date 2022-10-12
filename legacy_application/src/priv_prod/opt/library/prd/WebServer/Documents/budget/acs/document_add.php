<?php
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/authBUDGET.inc");
include("../../../include/activity.php");
extract($_REQUEST);
$vendor_name=urldecode($vendor_name);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;

//$project_note_id=$_POST['project_note_id'];
//echo $project_note_id;
//exit; 
echo "<html>";
echo "<head> <title>document_add</title></head>";
echo "<body>";
echo "<h3><font color='blue'>Record Successfully entered for $vendor_name-Invoice# $ncas_invoice_number</font></h3>";
echo "<h2><font color='red'>Please Upload Invoice for Fixed Asset Reporting(PDF Format Only). Thanks</font></h2>";


echo "<form enctype='multipart/form-data' method='post' action='document_add2.php'>";
echo "<input type='hidden' name='MAX_FILE_SIZE' value='20000000'>";
echo "<input type='file' id='document' name='document'>";
echo "<input type='hidden' name='id' value='$id'>";
//echo "<input type='hidden' name='message_category' value='$message_category'>";
//echo "<input type='hidden' name='message_name' value='$message_name'>";

echo "<br /> <br />";
echo "<input type='submit' value='add_document' name='submit'>";
echo "</form>";
echo "</body>";
echo "</html>";

?>