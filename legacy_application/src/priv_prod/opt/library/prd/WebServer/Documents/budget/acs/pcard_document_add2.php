<?php
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/authBUDGET.inc");
//include("../../../include/activity.php");
$date=date("Ymd");
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST); echo "</pre>"; 
//exit;
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;

//$project_note_id=$_POST['project_note_id'];

define('PROJECTS_UPLOADPATH','documents/');
$document=$_FILES['document']['name'];
$doc_mod=$document;
//$doc_mod=$document;
//$document=$myusername."_".$date."_".$message_note_id;
//echo $document;//exit;


if($travel!='y'){$document="pcu_".$admin_num."_".$report_date;}
if($travel=='y'){$document="pcu_".$admin_num."_travel_".$report_date;}
//echo "<br />";
//echo $document;

//exit;
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
//echo "upload_successful"; //exit;
 
$doc_location1="documents/".$document;
$doc_location2="/budget/acs/documents/".$document;

//echo "<br />doc_location=$doc_location<br />";

//exit; 
 
if($travel != 'y')
{	
$query="update pcard_unreconciled set document_location='$doc_location1'
where admin_num='$admin_num' and report_date='$report_date' ";
mysqli_query($connection, $query) or die ("Error updating Database $query");


$query2="update pcard_report_dates_compliance set document_location='$doc_location2'
where admin_num='$admin_num' and report_date='$report_date' ";
mysqli_query($connection, $query2) or die ("Error updating Database $query2");
}


if($travel == 'y')
{	
$query="update pcard_unreconciled set document_location2='$doc_location1'
where admin_num='$admin_num' and report_date='$report_date' ";
mysqli_query($connection, $query) or die ("Error updating Database $query");


$query2="update pcard_report_dates_compliance set document_location2='$doc_location2'
where admin_num='$admin_num' and report_date='$report_date' ";
mysqli_query($connection, $query2) or die ("Error updating Database $query2");
}






echo "<font color='red' size='5'>update successful</font>";
//exit;

if($budget_office != 'y')
{	
echo "<H3 ALIGN=left><A href='pcard_recon.php?admin_num=$admin_num&report_date=$report_date&xtnd_start=$xtnd_start&xtnd_end=$xtnd_end&submit=Find'>Return HOME</A></H3>";
}

if($budget_office == 'y')
{	
echo "<H3 ALIGN=left><A href='/budget/aDiv/pcard_weekly_reports.php?report_date=$report_date'>Return HOME</A></H3>";
}









?>