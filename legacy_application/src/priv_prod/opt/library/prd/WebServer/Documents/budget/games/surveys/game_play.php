<?php
echo "game_play.php line 2<br />";
if($gidS=="none")
{$gid=$gid2;}
else
{$gid=$gidS;}

$query1="select pid from survey_players where player='$player' ";
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
$row1=mysqli_fetch_array($result1);
extract($row1); //returns $pid

$query2="select min(qid) as 'qidF' from survey_questions where gid='$gid' ";
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
$row2=mysqli_fetch_array($result2);
extract($row2); //returns $qidF (First question in Game)
//echo "qidF=$qidF";echo "<br />";

$query3="select max(qid) as 'qidL' from survey_questions where gid='$gid' ";
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$row3=mysqli_fetch_array($result3);
extract($row3); //returns $qidL (Last question in Game)
//echo "qidL=$qidL";echo "<br />";

$qid_count=$qidL-$qidF+1;
//echo "qid_count=$qid_count";

/*

echo "player $player";echo "<br />";
echo "pid $pid";echo "<br />";
echo "gid $gid";echo "<br />";
echo "qidF $qidF";echo "<br />";
echo "qidL $qidL";echo "<br />";
echo "sid $sid";echo "<br />";
echo "<br />";
*/

if($qid==""){$qid=$qidF;}

if($qid>$qidL)
{
/*
echo "<table>";
echo "<tr>";
echo "<th>GameOver</th><th></th>";
echo "</tr>";
echo "</table>";
*/

/*
$sed=date("Ymd");
$query2a="insert into scores_history(sid,pid,gid,qid,answer,choice,points,sed)
select sid,pid,gid,qid,answer,choice,points,'$sed'
from scores where pid='$pid' and gid='$gidS' ; ";

$result2a = mysqli_query($connection, $query2a) or die ("Couldn't execute query2a. $query2a");
*/

$query3b="select survey_games.game_name,sum(round(points*(100/$qid_count),1)) as 'game_points'
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
survey_scores.answer as 'correct_answer',survey_scores.choice as 'your_answer',round(points*(100/$qid_count),1) as 'points'
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

"<tr><th><font class='cartRow'>$game_name</font></th><th><font class='cartRow'>Final Score: $game_points</font></th></tr>
	   
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

/*

$query3a="select count(qid) as 'qidT' from scores
          where sid='$sid' and pid='$pid' and gid='$gid' ";
		  

$result3a = mysqli_query($connection, $query3a) or die ("Couldn't execute query 3a.  $query3a");
$row3a=mysqli_fetch_array($result3a);
extract($row3a);

$query3b="select sum(points) as 'qidC' from scores
          where sid='$sid' and pid='$pid' and gid='$gid' ";
$result3b = mysqli_query($connection, $query3b) or die ("Couldn't execute query 3b.  $query3b");
$row3b=mysqli_fetch_array($result3b);
extract($row3b);

$qidCP=round($qidC*10);


echo "<table>";
echo "<tr>";
echo "<th>GameOver</th><th></th>";

echo "<tr><td>Points</td><td>$qidCP</td>";
echo "</tr>";
echo "</table>";


$query5a="select 
players.player,sum(points)*10 as 'score'
from scores
left join players on scores.pid=players.pid
where 1
group by scores.pid";
 
 
$result5a = mysqli_query($connection, $query5a) or die ("Couldn't execute query 5a.  $query5a"); 
$num5a=mysqli_num_rows($result5a);
echo "<div id=\"scores\" class='column1of3'>";
echo "<img src=\"charts/chart2.php\" alt=\"This is a chart of x\" />";
echo "</div>";
*/
exit;}

//echo "qid $qid";echo "<br />";//exit;
//echo "pid=$pid";

$query4="select *
from survey_questions 
where survey_questions.gid='$gid'
and qid='$qid'
";

//echo $query4;exit;
//echo "<br />";
	 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
//$num4=mysqli_num_rows($result4);
$row4=mysqli_fetch_array($result4);//echo "<br />";
extract($row4);


$query4a="select 
sum(points)*10 as 'Gscore'
from survey_scores
where sid='$sid' and gid='$gid' and pid='$pid'
";
//echo "query4a=$query4a";

$result4a = mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");

$row4a=mysqli_fetch_array($result4a);//echo "<br />";
extract($row4a);


$query4b="select game_name from survey_games where gid='$gid' ";

$result4b = mysqli_query($connection, $query4b) or die ("Couldn't execute query 4b.  $query4b");

$row4b=mysqli_fetch_array($result4b);//echo "<br />";
extract($row4b);




/*
$query5a="select 
players.player,sum(points)*10 as 'score'
from scores
left join players on scores.pid=players.pid
where 1
group by scores.pid";
 
 
$result5a = mysqli_query($connection, $query5a) or die ("Couldn't execute query 5a.  $query5a"); 
$num5a=mysqli_num_rows($result5a);
*/

//echo "<html>"; 
//echo "<head>"; 
//echo "<title>Game Play</title>"; 
//echo "<link rel='stylesheet' href='/games/multiple_choice/multiple_choice2.css' />"; 
//echo "<link rel=\"stylesheet\" href=\"css/stylesheet1.css\" />"; 
//include("js/games_js.php");
//echo "</head>"; 
//echo "<body>"; 
echo "<div id=\"questions\" class='column3of3'>";
echo "<form name='game_play1'>";
 
echo "<table border='0' cellspacing='0' cellpadding='0' width='100%' >"; 
echo "<tr>
<th>$game_name</th></tr>
<tr><td>Question: $question<br /><br />A)$a<br />B)$b<br />C)$c<br />D)$d<br /><br /><br /></td></tr>"; 
echo "<tr align='left'>"; 
echo "<td>Answer:&nbsp;"; 
echo "<select name=\"choice\" size='1' onChange=\"MM_jumpMenu('parent',this,0)\" >"; 
echo "<option value='-----'>----</option>"; 
echo "<option value='score.php?sid=$sid&gid=$gid&qid=$qid&choice=a'>a</option>"; 
echo "<option value='score.php?sid=$sid&gid=$gid&qid=$qid&choice=b'>b</option>"; 
echo "<option value='score.php?sid=$sid&gid=$gid&qid=$qid&choice=c'>c</option>"; 
echo "<option value='score.php?sid=$sid&gid=$gid&qid=$qid&choice=d'>d</option>";
echo "</select> "; 
echo "</td>"; 
echo "</tr>"; 
echo "</table>";
echo "</form>";
echo "</div>";
//echo "<div id=\"scores\" class='column1of3'>";
//echo "<table width='75%'><tr><th>Leaderboard</th></tr></table>";
//echo "<img src=\"charts/chart2.php\" alt=\"This is a chart of x\" />";
//echo "</div>";




echo "</body>";
echo "</html>";

?>