<?php
session_start();

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
$player=$_SESSION['budget']['tempID'];


extract($_REQUEST);

//echo "$report_date<br />";exit;


//echo $concession_location;
/*
if($level=='5' and $tempID !='Dodd3454')
{
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
}
*/
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters

$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from concessions_customformat
WHERE 1 
";

$result10=mysql_query($query10) or die ("Couldn't execute query 10. $query10");

$row10=mysql_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;
/*
if($level=='5' and $tempID !='Dodd3454')
{
echo "body_bg:$body_bg";
echo "<br />";
echo "table_bg:$table_bg";
echo "<br />";
echo "table_bg2:$table_bg2";
}
*/
$query11="SELECT filegroup
from concessions_filegroup
WHERE 1 and filename='$active_file'
";
//echo "query11=$query11";exit;
$result11=mysql_query($query11) or die ("Couldn't execute query 11. $query11");

$row11=mysql_fetch_array($result11);

extract($row11);
echo "<br />";

//include("../../../budget/menus2.php");
include("../../../budget/menu1314.php");
include ("widget1.php");

//include("widget1.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

echo "<br />";



$query1="select pid as 'pid_S' from survey_players where player='$player' ";

//echo "query1=$query1";exit;

$result1 = mysql_query($query1) or die ("Couldn't execute query 1.  $query1");

//$num1=mysql_num_rows($result1);
$row1=mysql_fetch_array($result1);

extract($row1);



//echo "user=$user";
//$game2=($game);
//echo "game2=$game2";
//$query1="select max(gid)+1 as 'gid' from games where 1";
//echo "query1=$query1";echo "<br />";//exit;
//$result1 = mysql_query($query1) or die ("Couldn't execute query 1. $query1");
//$row1=mysql_fetch_array($result1);
//extract($row1); //returns NEW GameID $gid


echo "<html>";
echo "<head>"; 
echo "<link rel=\"stylesheet\" href=\"css/stylesheet1.css\" />"; 
echo "</head>"; 
echo "<body>";
//echo "<table><tr><td>Scores Page Under Construction</td></tr></table>";exit;
//echo "<table><form action='questions.php' method='post'>";
//echo "<tr>";

//$qcount='40';


$query2="select game_name,author,qcount from survey_games where gid='$gid' ; ";

$result2 = mysql_query($query2) or die ("Couldn't execute query 2.  $query2");
$row2=mysql_fetch_array($result2);
extract($row2);
$author2=substr($author,0,-2);
//$query2a="select player as 'scores_player' from players where pid='$pid' ; ";
//echo "query2a=$query2a<br />";
//$result2a = mysql_query($query2a) or die ("Couldn't execute query 2a.  $query2a");
//$row2a=mysql_fetch_array($result2a);
//extract($row2a);
//$scores_player=substr($scores_player,0,-2);
//echo "scores_player=$scores_player";

/*
$query3b="select games.game_name,sum(round(points*(100/$qcount),1)) as 'game_points'
from scores
left join games on scores.gid=games.gid
where scores.pid='$pid' and scores.sid='$sid'
group by scores.pid,scores.sid ; ";
*/
//echo "query3b=$query3b";
//$result3b = mysql_query($query3b) or die ("Couldn't execute query 3b.  $query3b");
//$row3b=mysql_fetch_array($result3b);
//extract($row3b); 
//echo "<table border><tr><th>$game_name-$game_points</th></tr></table>";
$query3a="select survey_questions.qid,survey_questions.question,survey_questions.a,survey_questions.b,survey_questions.c,survey_questions.d,
survey_questions.answer as 'correct_answer'
from survey_questions 
where survey_questions.gid='$gid'
group by survey_questions.qid 
order by survey_questions.qid; ";

$result3a = mysql_query($query3a) or die ("Couldn't execute query3a. $query3a");

$num3a=mysql_num_rows($result3a);
//echo "<br />";

echo "<table><tr><th>Game Change</th></tr></table>";
//echo "<br />";
//echo "<table><tr><th>Results</th></tr></table>";
echo "<table border='1'>";
//echo "<tr><th>$player</th></tr>";
$game_points=round($game_points);


echo 

"<tr><th><font class='cartRow'>$game_name<br />$author2</font></th><th><font class='cartRow'>$scores_player<br />Questions: $qcount</font></th></tr>
<tr></table>";
echo "<br />";
echo "<table border='1'><tr>	   
       <th>ID</th>
       <th>Question</th>
       <th>A</th>
       <th>B</th>
       <th>C</th>
       <th>D</th>
       <th>Correct Answer</th> ";
                
              
echo "</tr>";
//if($edit!='y'){

echo  "<form method='post' autocomplete='off' action='/budget/games/surveys/game_update.php'>";




while ($row3a=mysql_fetch_array($result3a)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3a);
//$ca=$c;
//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
//if($points=='10'){$bgc="lightgreen";} else {$bgc="lightpink";}
if($points=='0'){$bgc="lightpink";} else {$bgc="lightgreen";}

echo 

"<tr bgcolor='$bgc'>";

//echo "<td>$qid</td>";
echo "<td><input type='text' name='qid[]' size='1' value='$qid' readonly='readonly'></font></td>";
echo "<td><textarea name='question[]' cols='25' rows='8'>$question</textarea></td> ";
echo "<td><textarea name='a[]' cols='15' rows='8'>$a</textarea></td> ";
echo "<td><textarea name='b[]' cols='15' rows='8'>$b</textarea></td> ";
echo "<td><textarea name='c[]' cols='15' rows='8'>$c</textarea></td> ";
echo "<td><textarea name='d[]' cols='15' rows='8'>$d</textarea></td> ";
echo "<td><input type='text' name='correct_answer[]' size='1' value='$correct_answer'></font></td>";
echo "</tr>";
} 
if($level=='5')
{
echo "<tr><td><input type='submit' name='submit2' value='Update'></td></tr>";
echo "<tr><td>New Quiz Name<br /><input type='text' name='new_game'><input type='submit' name='submit2' value='Duplicate'></td></tr>";
}


/*
if($correct_answer=='a'){echo "<td><font color='blue'>$a</font></td>";}else{echo "<td>$a</td>";}
if($correct_answer=='b'){echo "<td><font color='blue'>$b</font></td>";}else{echo "<td>$b</td>";}
if($correct_answer=='c'){echo "<td><font color='blue'>$c</font></td>";}else{echo "<td>$c</td>";}
if($correct_answer=='d'){echo "<td><font color='blue'>$d</font></td>";}else{echo "<td>$d</td>";}
*/
//echo "<td>$correct_answer</td>";
//echo "<td>$your_answer</td>";
//echo "<td>$points</td>";

echo "<input type='hidden' name='gid' value='$gid'>";
echo "<input type='hidden' name='pid_S' value='$pid_S'>";
echo "<input type='hidden' name='qcount_S' value='$qcount_S'>";
echo "<input type='hidden' name='player' value='$player'>";
echo "<input type='hidden' name='num3a' value='$num3a'>";
//echo "<input type='hidden' name='project_note' value='$project_note'>";
echo   "</form>";             
           

echo "</table>";




echo "</body>";
echo "</html>";





?>