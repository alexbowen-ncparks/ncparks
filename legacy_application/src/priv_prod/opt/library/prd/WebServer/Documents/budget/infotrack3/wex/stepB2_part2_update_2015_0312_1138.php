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
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters

echo "<pre>";print_r($_REQUEST);"</pre>";exit;

/*
if($submit2=='Update')
{
$query1="update questions SET";
for($j=0;$j<$num3a;$j++){
$query2=$query1;
$question_new=addslashes($question[$j]);
$a_new=addslashes($a[$j]);
$b_new=addslashes($b[$j]);
$c_new=addslashes($c[$j]);
$d_new=addslashes($d[$j]);
    $query2.=" question='$question_new',";
	$query2.=" a='$a_new',";
	$query2.=" b='$b_new',";
	$query2.=" c='$c_new',";
	$query2.=" d='$d_new',";
	$query2.=" answer='$correct_answer[$j]'";
	$query2.=" where qid='$qid[$j]'";
		

$result2=mysql_query($query2) or die ("Couldn't execute query 2. $query2");

//exit;



}	
$query5="delete from questions where gid='$gid' and answer= '' ";


$result5=mysql_query($query5) or die ("Couldn't execute query5. $query5");


$game_qcount_query="SELECT count(qid) as 'game_qcount' from questions where gid='$gid' ";
		 
//echo "query1=$query1<br />";		 

$result_qcount_query = mysql_query($game_qcount_query) or die ("Couldn't execute game_qcount_query  $game_qcount_query");

$row_qcount_query=mysql_fetch_array($result_qcount_query);
extract($row_qcount_query);

//echo "game_qcount=$game_qcount<br />";

$query4="update games set qcount='$game_qcount' where gid='$gid' ";

$result4=mysql_query($query4) or die ("Couldn't execute query 4. $query4");



header("location: /budget/games/multiple_choice/game_edit.php?gid=$gid");
}



//{header("location: /budget/games/multiple_choice/game_edit.php?gid=$gid");} 

*/


 ?>




















