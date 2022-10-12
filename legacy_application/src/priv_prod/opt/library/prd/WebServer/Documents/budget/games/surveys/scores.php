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
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from concessions_customformat
WHERE 1 
";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

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
$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

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

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

//$num1=mysqli_num_rows($result1);
$row1=mysqli_fetch_array($result1);

extract($row1);



//echo "user=$user";
//$game2=($game);
//echo "game2=$game2";
//$query1="select max(gid)+1 as 'gid' from games where 1";
//echo "query1=$query1";echo "<br />";//exit;
//$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");
//$row1=mysqli_fetch_array($result1);
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
if($view=='y')
{

$query2="select qcount from survey_games where gid='$gid' ; ";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
$row2=mysqli_fetch_array($result2);
extract($row2);

$query2a="select player as 'scores_player' from survey_players where pid='$pid' ; ";
//echo "query2a=$query2a<br />";
$result2a = mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a.  $query2a");
$row2a=mysqli_fetch_array($result2a);
extract($row2a);
$scores_player=substr($scores_player,0,-2);
//echo "scores_player=$scores_player";

$query3b="select survey_games.game_name,sum(round(points*(100/$qcount),1)) as 'game_points'
from survey_scores
left join survey_games on survey_scores.gid=survey_games.gid
where survey_scores.pid='$pid' and survey_scores.sid='$sid'
group by survey_scores.pid,survey_scores.sid ; ";
//echo "query3b=$query3b";
$result3b = mysqli_query($connection, $query3b) or die ("Couldn't execute query 3b.  $query3b");
$row3b=mysqli_fetch_array($result3b);
extract($row3b); 
//echo "<table border><tr><th>$game_name-$game_points</th></tr></table>";
$query3a="select survey_scores.qid,survey_questions.question,survey_questions.a,survey_questions.b,survey_questions.c,survey_questions.d,
survey_scores.answer as 'correct_answer',survey_scores.choice as 'your_answer',round(points*(100/$qcount),1) as 'points'
from survey_scores 
left join survey_questions on survey_scores.gid=survey_questions.gid and survey_scores.qid=survey_questions.qid
where survey_scores.pid='$pid' and survey_scores.sid='$sid'
group by survey_scores.pid,survey_scores.qid; ";

$result3a = mysqli_query($connection, $query3a) or die ("Couldn't execute query3a. $query3a");

$num3a=mysqli_num_rows($result3a);
echo "<br />";
//echo "<table><tr><th>Results</th></tr></table>";
echo "<table border='1'>";
//echo "<tr><th>$player</th></tr>";
$game_points=round($game_points);
echo 

"<tr><th><font class='cartRow'>$game_name</font></th><th><font class='cartRow'>$scores_player<br />Final Score: $game_points</font></th></tr>
	   
       <th>ID</th>
       <th>Question</th>
       <th>A</th>
       <th>B</th>
       <th>C</th>
       <th>D</th>
       <th>Correct Answer</th>
       <th>Your Answer</th>
       <th>Points</th>";
                
              
echo "</tr>";
//if($edit!='y'){
while ($row3a=mysqli_fetch_array($result3a)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3a);
//$ca=$c;
//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
//if($points=='10'){$bgc="lightgreen";} else {$bgc="lightpink";}
if($points=='0'){$bgc="lightpink";} else {$bgc="lightgreen";}

echo 

"<tr bgcolor='$bgc'>";

echo "<td>$qid</td>";
echo "<td>$question</td>";
if($correct_answer=='a'){echo "<td><font color='blue'>$a</font></td>";}else{echo "<td>$a</td>";}
if($correct_answer=='b'){echo "<td><font color='blue'>$b</font></td>";}else{echo "<td>$b</td>";}
if($correct_answer=='c'){echo "<td><font color='blue'>$c</font></td>";}else{echo "<td>$c</td>";}
if($correct_answer=='d'){echo "<td><font color='blue'>$d</font></td>";}else{echo "<td>$d</td>";}

echo "<td>$correct_answer</td>";
echo "<td>$your_answer</td>";
echo "<td>$points</td>";
   

                   
}     
           
              
           
echo "</tr>";
echo "</table>";


exit;}
if($level=='5')
{
$query3a="select survey_players.player,survey_games.game_name,survey_scores.gid,sum(round(points*(100/qcount),1)) as 'score',survey_scores.sed,survey_scores.pid,survey_scores.sid
from survey_scores
left join survey_games on survey_scores.gid=survey_games.gid
left join survey_players on survey_scores.pid=survey_players.pid
where 1 and valid_record='y'
group by survey_scores.pid,survey_scores.sid
order by survey_scores.sed desc,survey_games.game_name asc,survey_players.player asc,survey_scores.sid asc; ";
}else
{
$query3a="select survey_players.player,survey_games.game_name,survey_scores.gid,sum(round(points*(100/qcount),1)) as 'score',survey_scores.sed,survey_scores.pid,survey_scores.sid
from survey_scores
left join survey_games on survey_scores.gid=survey_games.gid
left join survey_players on survey_scores.pid=survey_players.pid
where 1 and survey_scores.pid='$pid_S' and valid_record='y'
group by survey_scores.pid,survey_scores.sid
order by survey_scores.sed desc,survey_games.game_name asc,survey_players.player asc; ";
//echo "query3a=$query3a";//exit;
}


$result3a = mysqli_query($connection, $query3a) or die ("Couldn't execute query3a. $query3a");

$num3a=mysqli_num_rows($result3a);
echo "<br />";
//echo "<table><tr><th>Results</th></tr></table>";
$player2=substr($player,0,-2);
echo "<table><tr><th>$player2</th></tr></table>";

echo "<table><tr><th>Games Played ($num3a)</th></tr></table>";
echo "<br />";
echo "<table border='1'>";
//echo "<tr><th>$player</th></tr>";
echo 

"<tr> 
	   <th>Game</th>
       <th>Player</th>       
       <th>Score</th>
       <th>Date</th>
       <th>Pid</th>
       <th>Sid</th>
       ";
                
              
echo "</tr>";
//echo "edit=$edit";

while ($row3a=mysqli_fetch_array($result3a)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3a);
$score=round($score);
$player=substr($player,0,-2);
$sed=date('m-d-y', strtotime($sed));
//$ca=$c;
//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
//if($points=='10'){$bgc="lightgreen";} else {$bgc="lightpink";}
$table_bg2="cornsilk";
if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}
echo 

"<tr$t>";

echo "<td>$game_name</td>
       <td>$player</td>
       <td>$score</td>
	   <td>$sed</td>
	   <td>$pid</td>
	   <td>$sid</td>
	   <td><a href=\"scores.php?view=y&pid=$pid&sid=$sid&gid=$gid\">View</a></td>";
//if($level=='5' and $pid_S=='1'){echo "<td><a href=\"score_hide.php?sid=$sid\">Remove</a></td>";}
if($level=='5'){echo "<td><a href=\"score_hide.php?sid=$sid&pid=$pid\">Remove</a></td>";}
       
	  
	   

                   
}     
        
              
           
echo "</tr>";
echo "</table>";
echo "</body>";
echo "</html>";





?>