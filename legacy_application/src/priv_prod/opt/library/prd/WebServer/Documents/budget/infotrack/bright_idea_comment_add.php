<?php

session_start();


//$file = "articles_menu.php";
//$lines = count(file($file));


//$table="infotrack_projects";
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;
//echo "<pre>";print_r($_SESSION);"</pre>";exit;

extract($_REQUEST);

if($comment_note==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");

$date=date("Ymd");
//$comment_note=addslashes($comment_note);

$query2=" insert into mission_bright_ideas2 set
cid='$cid',player2='$scorer',scorer_note2='$comment_note',
score_date2='$date',status2='fi' ";

//echo "query2=$query2";exit;
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

header("location: /budget/infotrack/bright_idea_steps2_v2.php?cid=$cid");





?>














