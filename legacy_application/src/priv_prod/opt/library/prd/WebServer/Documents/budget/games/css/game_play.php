<?php

if($gidS=="none")
{$gid=$gid2;}
else
{$gid=$gidS;}

$query1="select pid from players where player='$player' ";
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
$row1=mysqli_fetch_array($result1);
extract($row1); //returns $pid

$query2="select min(qid) as 'qidF' from questions where gid='$gid' ";
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
$row2=mysqli_fetch_array($result2);
extract($row2); //returns $qidF (First question in Game)
//echo "qidF=$qidF";echo "<br />";

$query3="select max(qid) as 'qidL' from questions where gid='$gid' ";
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$row3=mysqli_fetch_array($result3);
extract($row3); //returns $qidL (Last question in Game)
//echo "qidL=$qidL";echo "<br />";



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
$query3a="select count(qid) as 'qidT' from scores
          where sid='$sid' and pid='$pid' and gid='$gid' ";
		  
//echo "query3a=$query3a";exit;		  
$result3a = mysqli_query($connection, $query3a) or die ("Couldn't execute query 3a.  $query3a");
$row3a=mysqli_fetch_array($result3a);
extract($row3a);

$query3b="select sum(points) as 'qidC' from scores
          where sid='$sid' and pid='$pid' and gid='$gid' ";
$result3b = mysqli_query($connection, $query3b) or die ("Couldn't execute query 3b.  $query3b");
$row3b=mysqli_fetch_array($result3b);
extract($row3b);

$qidCP=round($qidC*10);

//echo "qidC=$qidC";echo "<br />";
//echo "qidT=$qidT";echo "<br />";
//echo "qidCP=$qidCP";echo "<br />";

//echo "Game Over";echo "<br /><br />";
//echo "Results";
echo "<table>";
echo "<tr>";
echo "<th>GameOver</th><th></th>";
//echo "<td>PlayerID</td><td>$pid</td>";
//echo "<tr><td>GameID</td><td>$gid</td>";
//echo "<tr><td>ScoreID</td><td>$sid</td>";
echo "<tr><td>Points</td><td>$qidCP</td>";
echo "</tr>";
echo "</table>";
/*
echo "<br />";
echo "<table><tr>
<td><a href='game_menu2.php'>NewGame</a></td>
</tr></table>";
*/
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
exit;}

//echo "qid $qid";echo "<br />";//exit;


$query4="select *
from questions 
left join games on questions.gid=games.gid
where questions.gid='$gid'
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
from scores
where sid='$sid' and gid='$gid' and pid='$pid'
";

$result4a = mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");

$row4a=mysqli_fetch_array($result4a);//echo "<br />";
extract($row4a);

$query5a="select 
players.player,sum(points)*10 as 'score'
from scores
left join players on scores.pid=players.pid
where 1
group by scores.pid";
 
 
$result5a = mysqli_query($connection, $query5a) or die ("Couldn't execute query 5a.  $query5a"); 
$num5a=mysqli_num_rows($result5a);


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
<th>$game_name</th><th>$Gscore Points</th></tr>
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
echo "<div id=\"scores\" class='column1of3'>";
echo "<table width='75%'><tr><th>Player Points</th></tr></table>";
echo "<img src=\"charts/chart2.php\" alt=\"This is a chart of x\" />";
echo "</div>";




echo "</body>";
echo "</html>";

?>