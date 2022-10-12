<?php

session_start();

//echo "<pre>";print_r($_SESSION);"</pre>";exit;

if(!$_SESSION["budget"]["tempID"]){
header("location: /login_form.php?db=budget");
}
//echo "hello world";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters

extract($_REQUEST);
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

if($message_read=='n'){$message_read_new='y';}
if($message_read=='y'){$message_read_new='n';}

$query1="update infotrack_projects_community_com
         set message_read='$message_read_new' where comment_id='$comment_id'  ";
		 
//echo "query1=$query1<br />";exit;		 

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query");




header("location: notes.php?project_note=note_tracker&player_chosen=$player_chosen&park_chosen=$park_chosen");


?>