<?php
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");
$date=date("Ymd");
extract($_REQUEST);

//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;

$source_table="cash_handling_plan_docs";
//if($source=="cdcs"){$source_table="cid_vendor_invoice_payments";}
/*
echo "source_table=$source_table<br />";
echo "source_id=$source_id<br />";
echo "location=$location<br />";
echo "center=$center<br />";
echo "account=$account<br />";
echo "calyear=$calyear<br />";
*/
//exit;

//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;

//$project_note_id=$_POST['project_note_id'];

define('PROJECTS_UPLOADPATH','sounds/');
$document=$_FILES['document']['name'];
if($document==""){echo "<font color='red' size='5'><b>No Document Found. <br /><br />Please hit back button on Browser to Upload Document</b></font>";exit;}
$doc_mod=$document;
//$doc_mod=$document;
//$document=$myusername."_".$date."_".$message_note_id;
//echo $document;//exit;
//$document="pcard_unreconciled".$source_id;
$document=$source_table."_".$source_id;//echo $document;//exit;
//echo "<br />";
//echo "<br />";
//echo $document;
$ext=explode(".",$doc_mod);
$num=count($ext)-1;
$ext1=$ext[$num];
$document.=".".$ext1;
//echo $document;//exit;
//echo "<br />";
//echo "<pre>";print_r($ext);echo "</pre>";exit;

//$document=str_replace(" ","_",$document);
//$document=str_replace("%20","_",$document);

//echo $document;
//echo "<br />";
//$target=PROJECTS_UPLOADPATH.$myusername."_".$date."_".$message_note_id."_".$document;
$target=PROJECTS_UPLOADPATH.$document;
//echo $target; exit;
move_uploaded_file($_FILES['document']['tmp_name'], $target);
// echo "upload_successful";
//echo $target; exit;

$query="update $source_table set document_location='$target'
where id='$source_id' ";
mysqli_query($connection, $query) or die ("Error updating Database $query");

echo "<font color='red' size='5'>update successful</font>";
echo "<H3 ALIGN=left><a href='procedures.php?comment=y&add_comment=y&folder=community&pid=$chp_id' target='_blank'>Return to Cash Handling Plan</a></H3>";

?>