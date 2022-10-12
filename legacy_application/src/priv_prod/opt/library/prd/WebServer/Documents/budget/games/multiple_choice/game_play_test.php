<?php
echo "hello world";


session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
$player=$_SESSION['budget']['tempID'];


extract($_REQUEST);

//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../../budget/~f_year.php");

$query9="insert ignore into players(player)
         values('$player') ";

$result9=mysqli_query($connection, $query9) or die ("Couldn't execute query 9. $query9");



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

$query11="SELECT filegroup
from concessions_filegroup
WHERE 1 and filename='$active_file'
";
//echo "query11=$query11";exit;
$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);

/*
if($level>'2')
{echo "<a href='/budget/home.php'>";}
else
{echo "<a href='/budget/menu.php?forum=blank'>";}
echo "<img width='50%' height='15%' src='/budget/nrid_logo.jpg' alt='roaring gap photos'></img>
		</a>";

echo "<br />";
*/
//echo "filegroup=$filegroup";exit;
//include("/budget/menus1314_test.php");
//include("../../../budget/menu1314.php");
include ("../../../budget/menu1415_v1.php");


















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

//3/10/2015
//$qid_count=$qidL-$qidF+1;
//echo "qid_count=$qid_count";

$query3a="select qcount as 'qid_count' from games where gid='$gid' ";
$result3a = mysqli_query($connection, $query3a) or die ("Couldn't execute query 3a.  $query3a");
$row3a=mysqli_fetch_array($result3a);
extract($row3a); //returns $qidF (First question in Game)





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

$query3b="select games.game_name,games.help_location,sum(round(points*(100/$qid_count),2)) as 'game_points'
from scores
left join games on scores.gid=games.gid
where scores.pid='$pid' and scores.sid='$sid'
group by scores.pid,scores.sid ; ";
echo "query3b=$query3b";
$result3b = mysqli_query($connection, $query3b) or die ("Couldn't execute query 3b.  $query3b");
$row3b=mysqli_fetch_array($result3b);
extract($row3b); 
//echo "<table border><tr><th>$game_name-$game_points</th></tr></table>";
$query3a="select scores.qid,questions.question,questions.a,questions.b,questions.c,questions.d,
scores.answer as 'correct_answer',scores.choice as 'your_answer',round(points*(100/$qid_count),2) as 'points'
from scores 
left join questions on scores.gid=questions.gid and scores.qid=questions.qid
where scores.pid='$pid' and scores.sid='$sid'
group by scores.pid,scores.qid; ";

$result3a = mysqli_query($connection, $query3a) or die ("Couldn't execute query3a. $query3a");

$num3a=mysqli_num_rows($result3a);
echo "<br />";
//echo "<table><tr><th>Results</th></tr></table>";
echo "<table border='1' align='center' cellspacing='10'>";
//echo "<tr><th>$player</th></tr>";
$game_points=round($game_points);

/*
echo "<tr><th>$game_name";
if($help_location != ''){echo "<a href='$help_location' target='_blank'><img src='/budget/infotrack/icon_photos/info2.png' width='50' height='50' title='help'></a>";}
echo "</th>
*/



//echo "<tr><th colspan='6'><font class='cartRow'>$game_name";
echo "<tr><th colspan='6'>$game_name";
if($help_location != ''){echo "<a href='$help_location' target='_blank'><img src='/budget/infotrack/icon_photos/info2.png' width='50' height='50' title='help'></a>";}
echo "</font><br />Score: $game_points";
if($game_points==100){echo "  <img src='/budget/infotrack/icon_photos/target_dart1.png' width='50' height='50'>";}
echo "</th></tr>";	   
    // echo "<th>ID</th>";
     echo "<th>Question</th>";
    echo "<th>A</th>";
    echo "<th>B</th>";
     echo "<th>C</th>";
     echo "<th>D</th>";
     //echo "<th>Correct Answer</th>";
   //  echo "<th>Your Answer</th>";
     echo "<th>Points</th>";
                
              
echo "</tr>";

while ($row3a=mysqli_fetch_array($result3a)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3a);
//$ca=$c;
//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
//if($points=='10'){$bgc="lightgreen";} else {$bgc="lightpink";}
$question=htmlspecialchars_decode($question);
$a=htmlspecialchars_decode($a);
$b=htmlspecialchars_decode($b);
$c=htmlspecialchars_decode($c);
$d=htmlspecialchars_decode($d);


if($points=='0'){$bgc="lightpink";} else {$bgc="lightgreen";}

echo 

"<tr bgcolor='$bgc'>";

//echo "<td>$qid</td>";
echo "<td>$question</td>";
if($correct_answer=='a'){echo "<td><font color='blue'>$a</font></td>";}else{echo "<td>$a</td>";}
if($correct_answer=='b'){echo "<td><font color='blue'>$b</font></td>";}else{echo "<td>$b</td>";}
if($correct_answer=='c'){echo "<td><font color='blue'>$c</font></td>";}else{echo "<td>$c</td>";}
if($correct_answer=='d'){echo "<td><font color='blue'>$d</font></td>";}else{echo "<td>$d</td>";}

//echo "<td>$correct_answer</td>";
//echo "<td>$your_answer</td>";
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
from questions 
where questions.gid='$gid'
and qid='$qid'
";

//echo $query4; //exit;
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
//echo "query4a=$query4a";

$result4a = mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");

$row4a=mysqli_fetch_array($result4a);//echo "<br />";
extract($row4a);


$query4b="select game_name,help_location from games where gid='$gid' ";

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
//echo "<div id=\"questions\" class='column3of3'>";
//echo "<div id=\"games\" class='column3of3' width='100%'>";
//echo "<form name='game_play1'>";

$question=htmlspecialchars_decode($question);
$question=nl2br($question);
$a=htmlspecialchars_decode($a);
$b=htmlspecialchars_decode($b);
$c=htmlspecialchars_decode($c);
$d=htmlspecialchars_decode($d);



echo "<table cellspacing='20' border='0' width='700' align='center' cellspacing='0' cellpadding='0' width='100%' >"; 
echo "<tr><th>$game_name";
if($help_location != ''){echo "<a href='$help_location' target='_blank'><img src='/budget/infotrack/icon_photos/info2.png' width='50' height='50' title='help'></a>";}
echo "</th></tr>";

//echo "<br />";
//echo "<tr>";
//echo "<td>";
//echo "Question: $question<br />";
echo "<tr><td bgcolor='springgreen'>$question</td></tr>";
//echo "<br />";
echo "<tr><td onMouseOver=\"this.bgColor='lightgreen'\" onMouseOut=\"this.bgColor='lightcyan'\"><a href='score.php?sid=$sid&gid=$gid&qid=$qid&choice=a'>$a</a></td></tr>";
echo "<tr><td onMouseOver=\"this.bgColor='lightgreen'\" onMouseOut=\"this.bgColor='lightcyan'\"><a href='score.php?sid=$sid&gid=$gid&qid=$qid&choice=b'>$b</a></td></tr>";
echo "<tr><td onMouseOver=\"this.bgColor='lightgreen'\" onMouseOut=\"this.bgColor='lightcyan'\"><a href='score.php?sid=$sid&gid=$gid&qid=$qid&choice=c'>$c</a></td></tr>";
echo "<tr><td onMouseOver=\"this.bgColor='lightgreen'\" onMouseOut=\"this.bgColor='lightcyan'\"><a href='score.php?sid=$sid&gid=$gid&qid=$qid&choice=d'>$d</a></td></tr>";


echo "</table>";



/*
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
*/
echo "</div>";
//echo "<div id=\"scores\" class='column1of3'>";
//echo "<table width='75%'><tr><th>Leaderboard</th></tr></table>";
//echo "<img src=\"charts/chart2.php\" alt=\"This is a chart of x\" />";
//echo "</div>";




echo "</body>";
echo "</html>";

?>