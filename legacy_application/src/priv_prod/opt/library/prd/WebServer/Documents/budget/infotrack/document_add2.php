<?php

session_start();


//$file = "articles_menu.php";
//$lines = count(file($file));


//$table="infotrack_projects";
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

$active_file=$_SERVER['SCRIPT_NAME'];
$active_file_request=$_SERVER['REQUEST_URI'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$infotrack_location=$_SESSION['budget']['select'];
$infotrack_center=$_SESSION['budget']['centerSess'];


$system_entry_date=date("Ymd");
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
//echo $system_entry_date;exit;
//print_r($_SESSION);echo "</pre>";exit;


//if($project_category==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}
//if($project_name==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}
if($document_title==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}
//if($web_address==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}

include("../../../include/connectBUDGET.inc");// database connection parameters
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");


//$date=$_POST['date'];
//$project_category=$_POST['project_category'];
//$project_name=$_POST['project_name'];
//$project_note=$_POST['project_note'];
//$weblink=$_POST['weblink'];
$date=date("Ymd");
//$project_start_date=$_POST['project_start_date'];
//$project_end_date=$_POST['project_end_date'];
//$project_status=$_POST['project_status'];

if($submit=='add_document' and $folder=='personal')

{
$query1="insert ignore into infotrack_projects
(user,system_entry_date,project_category,project_name,project_note,weblink,note_group) 
values ('$tempID','$system_entry_date','$project_category','$project_name',
'$document_title','$web_address','document')";

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
}

//echo "ok";exit;
if($submit=='add_document' and $folder=='community')

{

$query2="insert ignore into infotrack_projects_community
(user,system_entry_date,project_category,project_name,project_note,weblink,note_group) 
values ('$tempID','$system_entry_date','$project_category','$project_name',
'$document_title','$web_address','document')";

mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

}

if($folder=='personal'){$source_table='infotrack_projects' ;}
if($folder=='community'){$source_table='infotrack_projects_community' ;}

//echo "source_table=$source_table";exit;

$query3="select max(project_note_id) as 'source_id' from $source_table
         where user='$tempID' and note_group='document' ";

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$row3=mysqli_fetch_array($result3);

extract($row3);

define('PROJECTS_UPLOADPATH','documents/');
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

$query4="update $source_table set document_location='$target'
where project_note_id='$source_id' ";
mysqli_query($connection, $query4) or die ("Error updating Database $query4");

//echo "<font color='red' size='5'>update successful</font>";

header("location: project1_menu.php?folder=$folder&project_category=$project_category&category_selected=y&project_name=$project_name&note_group=$note_group&name_selected=y&add_record=y");



?>