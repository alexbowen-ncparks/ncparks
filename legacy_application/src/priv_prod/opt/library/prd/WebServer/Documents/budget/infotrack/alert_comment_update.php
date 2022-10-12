<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
$query1="update infotrack_projects_community_com SET";
for($j=0;$j<$num4b;$j++){
$query2=$query1;
$comment_note2=addslashes($comment_note[$j]);
	$query2.=" comment_note='$comment_note2',";
	$query2.=" status='$status[$j]'";
	$query2.=" where comment_id='$comment_id[$j]'";
		

$result=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");
}	
/*
if($project_note=='games')
{
header("location: /budget/games/multiple_choice/notes.php?comment=y&add_comment=y&project_note_id=$project_note_id&folder=community&category_selected=y&name_selected=y");
}
*/
//echo "project_note=$project_note";exit;

/*
if($project_note=='games' or $project_note=='cash_receipts' or $project_note=='user_activity' or $project_note=='park_budgets')
{
*/
header("location: /budget/infotrack/notes.php?comment=y&add_comment=y&project_note=$project_note&folder=community&category_selected=y&name_selected=y");
/*
}
else
{header("location: project1_menu_web.php?comment=y&add_comment=y&folder=community&project_category=&category_selected=y&project_name=&name_selected=y&note_group=&project_note_id=$project_note_id&message=1");}
*/
 
 ?>




















