<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$player=$tempid;
$playstation=$_SESSION['budget']['select'];
//echo $tempid;
extract($_REQUEST);
$today=date("Ymd", time() );
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "<pre>";print_r($_SESSION);"</pre>";
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo "playstation=$playstation<br />";
//echo "player=$player<br />";
if($submit2=='Submit Survey')
//{echo "hello world";}


{
$query1="update survey_scores SET";
for($j=0;$j<$num3a;$j++){
$query2=$query1;
$park_answer_new=($park_answer[$j]);

    $query2.=" player='$player',";
	$query2.=" park_answer='$park_answer_new',";
	$query2.=" system_entry_date='$today'";
	$query2.=" where gid='$gid' and playstation='$playstation' and qid='$qid[$j]'";
		

$result=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");
}	
//echo "query2=$query2<br /><br />";

//header("location: /budget/games/surveys/game_edit.php?gid=$gid");
header("location: games.php");
//echo "update successful<br />";
}


 ?>




















