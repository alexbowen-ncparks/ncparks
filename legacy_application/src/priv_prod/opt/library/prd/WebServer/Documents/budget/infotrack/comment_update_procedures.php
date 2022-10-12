<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

//$file = "articles_menu.php";
//$lines = count(file($file));


//$table="infotrack_projects";
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";exit;

//$active_file=$_SERVER['SCRIPT_NAME'];
//$active_file_request=$_SERVER['REQUEST_URI'];


$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$infotrack_location=$_SESSION['budget']['select'];
$infotrack_center=$_SESSION['budget']['centerSess'];
//echo "infotrack_location=$infotrack_location";//exit;

if($infotrack_location=="ADM"){$infotrack_location="ADMI";}
//echo "<br />infotrack_location=$infotrack_location";exit;
$system_entry_date=date("Ymd");
extract($_REQUEST);

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters






$query1="update procedures_comments SET";
for($j=0;$j<$num4b;$j++){
$query2=$query1;
//$comment_note2=addslashes($comment_note[$j]);
$comment_note2=$comment_note[$j];
	$query2.=" comment_note='$comment_note2',";
	$query2.=" status='$status[$j]'";
	$query2.=" where cid='$cid[$j]'";
		

$result=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");
}	
/*
if($project_note=='games')
{
header("location: /budget/games/multiple_choice/notes.php?comment=y&add_comment=y&project_note_id=$project_note_id&folder=community&category_selected=y&name_selected=y");
}
*/
//echo "project_note=$project_note";exit;



header("location: procedures.php?comment=y&add_comment=y&folder=community&pid=$pid");

 
 ?>




















