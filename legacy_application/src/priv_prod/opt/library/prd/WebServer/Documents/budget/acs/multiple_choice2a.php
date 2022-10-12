<?php
session_start();
$level=$_SESSION['level'];
$user=$_SESSION['myusername'];


extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//if($level=='5' and $tempID !='Dodd3454')
//echo "pcode=$pcode";
//{echo "<pre>";print_r($_SESSION);"</pre>";}//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
include("budget_connect.php");// database connection parameters

//$query4="select  * from choices where gid='1' and qid='1'";

$gid='1';
if($qid==""){$qid='1';}
if($qid>'10'){
$query5="update questions_scored,choices
set questions_scored.answer=choices.correct
where questions_scored.user='$user'
and questions_scored.score_id='$sid'
and questions_scored.game_id=choices.gid
and questions_scored.qid=choices.qid
";

//echo $query5;exit;		 
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
//$num5=mysqli_num_rows($result5);
//$row5=mysqli_fetch_array($result5);

//extract($row5);
$query6="update questions_scored set points='1'
where user='$user'
and score_id='$sid'
and game_id='$gid'
and choice=answer";


$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$query7="select sum(points) as 'user_score' from questions_scored where user='$user' and score_id='$sid' & game_id='$gid' ";

//echo "query7=$query7";exit;

$result7 = mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");

//$num7=mysqli_num_rows($result7);
$row7=mysqli_fetch_array($result7);

extract($row7);

$query8="update scores set user_score='$user_score' where user='$user' and id='$sid' and game_id='$gid' and complete='n' ";

$result8 = mysqli_query($connection, $query8) or die ("Couldn't execute query 8.  $query8");

$query9="select count(score_id) as 'total_score' from questions_scored
         where user='$user' and score_id='$sid' and game_id='$gid' ";

$result9 = mysqli_query($connection, $query9) or die ("Couldn't execute query 9.  $query9");

$row9=mysqli_fetch_array($result9);

extract($row9);

$query10="update scores set total_score='$total_score' where user='$user' and id='$sid' and game_id='$gid' and complete='n' ";

$result10 = mysqli_query($connection, $query10) or die ("Couldn't execute query 10.  $query10");

$query11="update scores set complete='y' where user='$user' and id='$sid' and game_id='$gid' ";

$result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11");

$query12="select sum(user_score) as 'user_score' from scores where user='$user' and id='$sid' and game_id='$gid' and complete='y' ";

$result12 = mysqli_query($connection, $query12) or die ("Couldn't execute query 12.  $query12");

$row12=mysqli_fetch_array($result12);

extract($row12);



echo "Final Score: $user_score";echo "<br />";echo "Play New Game";exit;
}

$query4="select questions.question,choices.a,choices.b,choices.c,choices.d
from questions 
left join choices on questions.id=choices.qid
where questions.game_id='$gid'
and questions.id='$qid'
";

//echo $query4;exit;		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);
$row4=mysqli_fetch_array($result4);

extract($row4);

echo "<html>"; 
echo "<head>"; 
echo "<title>Multiple_choice2</title>"; 
echo "<link rel='stylesheet' href='/games/multiple_choice/multiple_choice2.css' />"; 
include("../js/games_js.php");
echo "</head>"; 
echo "<body>"; 
echo "<div align='left'>"; 
echo "<table><tr><th>Quiz 2</th></tr></table>";
echo "choice=$choice";
echo "<br />"; 
echo "<form name='mc_test'>"; 
echo "<table border='0' cellspacing='0' cellpadding='0' width='100' >"; 
echo "<tr><td>Question: $question<br /><br />A)$a<br />B)$b<br />C)$c<br />D)$d<br /><br /><br /></td></tr>"; 
echo "<tr align='left'>"; 
echo "<td>Answer:&nbsp;"; 
echo "		  <select name=\"choice\" size='1' onChange=\"MM_jumpMenu('parent',this,0)\" >"; 
echo "            <option value='-----'>----</option>"; 
echo "            <option value='score.php?gid=$gid&qid=$qid&choice=a'>a</option>"; 
echo "            <option value='score.php?gid=$gid&qid=$qid&choice=b'>b</option>"; 
echo "            <option value='score.php?gid=$gid&qid=$qid&choice=c'>c</option>"; 
echo "            <option value='score.php?gid=$gid&qid=$qid&choice=d'>d</option>"; 
echo "          </select> "; 
//echo "		  <input type=\"button\" value=\"&lt;&lt;Back\" name=\"B1\""; 
//echo "          onClick=\"if (whichone&gt;1){whichone--;generatequestions()}\"> "; 
//echo "		  <input type=\"button\" value=\"Next&gt;&gt;\" name=\"B2\""; 
//echo "          onClick=\"if (whichone&lt;=total){whichone++;generatequestions()}\">"; 
echo "</td>"; 
echo "</tr>"; 
//echo "<tr align=\"left\">"; 
//echo "<td>Solution:"; 
//echo "<input type=\"text\" name=\"thesolution\" size=\"35\">"; 
//echo "</td>"; 
//echo "</tr>"; 
//echo "<tr>"; 
echo "</table>";		  
echo "</form>";
 
echo "</div>"; 
echo "</body>"; 
echo "</html>";
?>