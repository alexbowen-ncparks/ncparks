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
//echo "submit2=$submit2";
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
if($submit2=='Update')
{
$query1="update survey_questions SET";
for($j=0;$j<$num3a;$j++){
$query2=$query1;
$question_new=addslashes($question[$j]);
$example_answer_new=addslashes($example_answer[$j]);

    $query2.=" question='$question_new',";
	$query2.=" example_answer='$example_answer_new'";
	$query2.=" where qid='$qid[$j]'";
		

$result=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");
}	
/*
if($project_note=='games')
{
header("location: /budget/games/multiple_choice/notes.php?comment=y&add_comment=y&project_note_id=$project_note_id&folder=community&category_selected=y&name_selected=y");
}
*/
//echo "project_note=$project_note";exit;

header("location: /budget/games/surveys/game_edit.php?gid=$gid");
}

/*
if($submit2=='Duplicate')
{
//echo "line 54 ok";exit;
if($new_game==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
//echo "<br />pid_S=$pid_S";
//echo "<br />new_game=$new_game";
//echo "<br />qcount_S=$qcount_S";
//echo "<br />author=$player";
$game_name=addslashes($new_game);
$query1a="insert into survey_games set pid='$pid_S',game_name='$game_name',qcount='$qcount_S',author='$player' ";
//echo "query1a=$query1a";exit;
$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a. $query1a");

$query1b="select max(gid) as 'gid' from survey_games where pid='$pid_S' ";
$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b. $query1b");
$row1b=mysqli_fetch_array($result1b);
extract($row1b); 
//echo "query1b=$query1b";echo "<br />";
//echo "<br />gid=$gid";echo "<br />";exit;

$query2="INSERT INTO survey_questions SET gid='$gid' ";
for($j=0;$j<$qcount_S;$j++){
$query3=$query2;
$ques=addslashes($question[$j]);
$ans1a=addslashes($a[$j]);
$ans2a=addslashes($b[$j]);
$ans3a=addslashes($c[$j]);
$ans4a=addslashes($d[$j]);
	$query3.=", question='$ques'";
	$query3.=", a='$ans1a'";
	$query3.=", b='$ans2a'";
	$query3.=", c='$ans3a'";
	$query3.=", d='$ans4a'";
	$query3.=", answer='$correct_answer[$j]'";
		//$v1=str_replace(",","",$allocation_amount[$j]);
	//$query.=", allocation_amount='$v1'";
		//$just=addslashes($justification[$j]);
	//$query.=", justification='$just'";
		
//echo "$query<br><br>";
if($correct_answer[$j]!=""){
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");
//echo "query3=$query3";
}
	}



header("location: /budget/games/surveys/game_edit.php?gid=$gid");
}

*/

//{header("location: /budget/games/multiple_choice/game_edit.php?gid=$gid");} 
 ?>




















