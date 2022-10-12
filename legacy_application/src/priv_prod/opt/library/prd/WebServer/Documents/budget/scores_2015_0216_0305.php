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
//echo "<br />";

//include("../../../budget/menus2.php");
include("../../../budget/menu1314.php");

$query22="select center_desc,center from center where parkcode='$concession_location'   ";	

//echo "query22=$query22<br />";//exit;		  

$result22 = mysql_query($query22) or die ("Couldn't execute query 22.  $query22");
		  
$row22=mysql_fetch_array($result22);

extract($row22);

$center_location = str_replace("_", " ", $center_desc);

if($level==5){$center_location='Financial Services Group';}
echo "<br />";
echo "<table align='center' cellspacing='5'><tr><th><img height='35' width='35' src='/budget/infotrack/icon_photos/checkers_board1.png' alt='games icon'><font color='blue'>$center_location</font></img><br /><font color='brown' size='5'><b>Learning Games</b></font></th></tr></table>";

echo "<br />";
include ("widget1.php");

//include("widget1.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

echo "<br />";



$query1="select pid as 'pid_S' from players where player='$player' ";

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
if($view=='y')
{

$query2="select qcount from games where gid='$gid' ; ";

$result2 = mysql_query($query2) or die ("Couldn't execute query 2.  $query2");
$row2=mysql_fetch_array($result2);
extract($row2);

$query2a="select player as 'scores_player' from players where pid='$pid' ; ";
//echo "query2a=$query2a<br />";
$result2a = mysql_query($query2a) or die ("Couldn't execute query 2a.  $query2a");
$row2a=mysql_fetch_array($result2a);
extract($row2a);
$scores_player=substr($scores_player,0,-2);
//echo "scores_player=$scores_player";

$query3b="select games.game_name,sum(round(points*(100/$qcount),1)) as 'game_points'
from scores
left join games on scores.gid=games.gid
where scores.pid='$pid' and scores.sid='$sid'
group by scores.pid,scores.sid ; ";
//echo "query3b=$query3b";
$result3b = mysql_query($query3b) or die ("Couldn't execute query 3b.  $query3b");
$row3b=mysql_fetch_array($result3b);
extract($row3b); 
//echo "<table border><tr><th>$game_name-$game_points</th></tr></table>";
$query3a="select scores.qid,questions.question,questions.a,questions.b,questions.c,questions.d,
scores.answer as 'correct_answer',scores.choice as 'your_answer',round(points*(100/$qcount),1) as 'points'
from scores 
left join questions on scores.gid=questions.gid and scores.qid=questions.qid
where scores.pid='$pid' and scores.sid='$sid'
group by scores.pid,scores.qid; ";

$result3a = mysql_query($query3a) or die ("Couldn't execute query3a. $query3a");

$num3a=mysql_num_rows($result3a);
echo "<br />";
//echo "<table><tr><th>Results</th></tr></table>";
echo "<table border='1' align='center' cellspacing='10'>";
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
$query3a="select players.player,games.game_name,scores.gid,sum(round(points*(100/qcount),1)) as 'score',scores.sed,scores.pid,scores.sid
from scores
left join games on scores.gid=games.gid
left join players on scores.pid=players.pid
where 1 and valid_record='y'
group by scores.pid,scores.sid
order by games.game_name asc,players.player asc,scores.sed asc; ";
}else
{
$query3a="select players.player,games.game_name,scores.gid,sum(round(points*(100/qcount),1)) as 'score',scores.sed,scores.pid,scores.sid
from scores
left join games on scores.gid=games.gid
left join players on scores.pid=players.pid
where 1 and scores.pid='$pid_S' and valid_record='y'
group by scores.pid,scores.sid
order by scores.sed desc,games.game_name asc,players.player asc; ";
//echo "query3a=$query3a";//exit;
}


$result3a = mysql_query($query3a) or die ("Couldn't execute query3a. $query3a");

$num3a=mysql_num_rows($result3a);
echo "<br />";
//echo "<table><tr><th>Results</th></tr></table>";
$player2=substr($player,0,-2);
//echo "<table><tr><th><font color='green'>$player2</font></th></tr></table>";

//echo "<table><tr><th>Games Played ($num3a)</th></tr></table>";
//echo "<br />";
if($num3a != 0)
{
echo "<table border='1' align='center' cellspacing='10'>";

echo "<tr>"; 
echo "<th>Game</th>";
if($level==5)
{
echo "<th>Player</th>";
}       
echo "<th>Score</th>";
echo "<th>Date</th>";
if($beacnum=='60032793')
{
echo "<th>Pid</th>";
}
if($beacnum=='60032793')
{
echo "<th>Sid</th>";
}               
              
echo "</tr>";

//echo "edit=$edit";

while ($row3a=mysql_fetch_array($result3a)){

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

echo "<tr$t>";

echo "<td align='center'>$game_name</td>";
if($level==5)
{
echo "<td align='center'>$player</td>";
}
echo "<td align='center'>$score</td>";
echo "<td align='center'>$sed</td>";
if($beacnum=='60032793')
{
echo "<td align='center'>$pid</td>";
}
if($beacnum=='60032793')
{
echo "<td align='center'>$sid</td>";
}
echo "<td><a href=\"scores.php?view=y&pid=$pid&sid=$sid&gid=$gid\">View</a></td>";
//if($level=='5' and $pid_S=='1'){echo "<td><a href=\"score_hide.php?sid=$sid\">Remove</a></td>";}
//if($level=='5'){echo "<td><a href=\"score_hide.php?sid=$sid&pid=$pid\">Remove</a></td>";}
if($level>'0'){echo "<td><a href=\"score_hide.php?sid=$sid&pid=$pid\">Remove</a></td>";}
       
	  
	   

                   
}     
}        
              
           
echo "</tr>";
echo "</table>";
echo "</body>";
echo "</html>";





?>