<?php

session_start();

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
$tempID=$_SESSION['budget']['tempID'];
$player=$_SESSION['budget']['tempID'];


extract($_REQUEST);

//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../../budget/~f_year.php");

$query1="select pid from players where player='$player' ";
//echo "query1=$query1<br />";
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
$row1=mysqli_fetch_array($result1);
extract($row1); //returns $pid


if($gidS == '')
{
echo "<br />";
include ("games_slideshow3.php");
}
echo "<br /><br />";

if($gid2 != "" and $gidS == "none")

{

$query5a="select count(sid) as 'sidC' from scores where 1 ";
$result5a = mysqli_query($connection, $query5a) or die ("Couldn't execute query 5a.  $query5a");


$row5a=mysqli_fetch_array($result5a);

extract($row5a);


if($sidC=="0"){$sid="1";}

else
{
$query2="select max(sid)+1 as 'sid' from scores where 1 ";



$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


$row2=mysqli_fetch_array($result2);

extract($row2);
}
$sed=date("Ymd");
$query3="insert into scores(sid,pid,gid,qid,answer,sed)
         select '$sid','$pid','$gid2',qid,answer,'$sed' from questions
         where gid='$gid2'
         ";



$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

include("game_play.php");
//exit;
}
/*
$gid=108;
$gid2=108;

if($score=="yes")
{
$query4="update scores
         set choice='$choice'
		 where sid='$sid' and pid='$pid' and gid='$gid' and qid='$qid'		 
         ";
echo "query4=$query4<br />";

$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");


$query5="update scores
         set points='1'
		 where sid='$sid' and pid='$pid' and gid='$gid' and qid='$qid' and choice=answer             		 
         ";

echo "query5=$query5<br />";
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");


$qid=($qid+1);

}

$query6="select count(sid) as 'sid_count' from scores where pid='$pid' and gid='$gid' ";

echo "query6=$query6<br />";

$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");


$row6=mysqli_fetch_array($result6);

extract($row6);

echo "sid_count=$sid_count<br />"; //exit;


if($sid_count == 0)

{


$query6a="select max(sid)+1 as 'sid' from scores where 1 ";

echo "query6a=$query6a<br />";

$result6a = mysqli_query($connection, $query6a) or die ("Couldn't execute query 6a.  $query6a");


$row6a=mysqli_fetch_array($result6a);

extract($row6a);

echo "sid=$sid<br />";

$sed=date("Ymd");

$query6b="insert into scores(sid,pid,gid,qid,answer,sed)
         select '$sid','$pid','$gid2',qid,answer,'$sed' from questions
         where gid='$gid2'
         ";


echo "query6b=$query6b<br />"; //exit;		 
		 

$result6b = mysqli_query($connection, $query6b) or die ("Couldn't execute query 6b.  $query6b");


//exit;
}


$query6c="select min(qid) as 'qidF' from questions where gid='$gid' ";
echo "query6c=$query6c<br />";
$result6c = mysqli_query($connection, $query6c) or die ("Couldn't execute query 6c.  $query6c");
$row6c=mysqli_fetch_array($result6c);
extract($row6c); //returns $qidF (First question in Game)
echo "qidF=$qidF<br />";

$query6d="select max(qid) as 'qidL' from questions where gid='$gid' ";
echo "query6d=$query6d<br />";
$result6d = mysqli_query($connection, $query6d) or die ("Couldn't execute query 6d.  $query6d");
$row6d=mysqli_fetch_array($result6d);
extract($row6d); //returns $qidL (Last question in Game)

echo "qidL=$qidL<br />";

$qid_count=$qidL-$qidF+1;

echo "qid_count=$qid_count<br />";

if($qid>$qidL)
{

$query6e="select games.game_name,image_location,sum(round(points*(100/$qid_count),1)) as 'game_points'
from scores
left join games on scores.gid=games.gid
where scores.pid='$pid' and scores.sid='$sid'
group by scores.pid,scores.sid ; ";

echo "query6e=$query6e";

$result6e = mysqli_query($connection, $query6e) or die ("Couldn't execute query 6e.  $query6e");
$row6e=mysqli_fetch_array($result6e);
extract($row6e);
 
//echo "<table border><tr><th>$game_name-$game_points</th></tr></table>";
$query6f="select scores.qid,questions.question,questions.a,questions.b,questions.c,questions.d,
scores.answer as 'correct_answer',scores.choice as 'your_answer',round(points*(100/$qid_count),1) as 'points'
from scores 
left join questions on scores.gid=questions.gid and scores.qid=questions.qid
where scores.pid='$pid' and scores.sid='$sid'
group by scores.pid,scores.qid; ";

echo "query6f=$query6f<br />";

$result6f = mysqli_query($connection, $query6f) or die ("Couldn't execute query6f. $query6f");

$num6f=mysqli_num_rows($result6f);
echo "<br />";
//echo "<table><tr><th>Results</th></tr></table>";
$game_points=round($game_points);

echo "game_points=$game_points<br />";





//echo "<table border='1' align='center' cellspacing='10'>";
echo "<table border='1'>";
//echo "<tr><th>$player</th></tr>";

echo "<tr>";

echo "<td>";
echo "<img src='$image_location' width='300' height='200'>";

echo "</td>";
echo "<td>";
echo "<table>";
echo "<tr><th colspan='6' class='homequiz'><font class='cartRow'>$game_name</font><br />Score: $game_points";
if($game_points==100){echo "  <img src='/budget/infotrack/icon_photos/target_dart1.png' width='50' height='50'>";}
echo "</th></tr>";	   
                
echo "</tr>";

while ($row6f=mysqli_fetch_array($result6f)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row6f);
//$ca=$c;
//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
//if($points=='10'){$bgc="lightgreen";} else {$bgc="lightpink";}
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
echo "</td>";
echo "</tr>";
echo "</table>";

exit;
}

if($qid==''){$qid=$qidF;}

$query6g="select *
from questions 
where questions.gid='$gid'
and qid='$qid'
";

echo "query6g=$query6g<br />";//exit;
//echo "<br />";
	 
$result6g = mysqli_query($connection, $query6g) or die ("Couldn't execute query 6g.  $query6g");
//$num4=mysqli_num_rows($result4);
$row6g=mysqli_fetch_array($result6g);//echo "<br />";
extract($row6g);


$query6h="select 
sum(points)*10 as 'Gscore'
from scores
where sid='$sid' and gid='$gid' and pid='$pid'
";

echo "query6h=$query6h";

$result6h = mysqli_query($connection, $query6h) or die ("Couldn't execute query 6h.  $query6h");

$row6h=mysqli_fetch_array($result6h);//echo "<br />";
extract($row6h);


$query6j="select game_name,help_location,image_location from games where gid='$gid' ";

echo "query6j=$query6j";

$result6j = mysqli_query($connection, $query6j) or die ("Couldn't execute query 6j.  $query6j");

$row6j=mysqli_fetch_array($result6j);//echo "<br />";
extract($row6j);

echo "<table border='0' width='700' align='center' cellspacing='0' cellpadding='0' width='100%' >"; 
//echo "<table align='center'>";
echo "<tr>";
echo "<td>";
echo "<img height='200' width='300' src='$image_location' title='' alt='picture of green check mark'></img>";
echo "</td>";
echo "<td>";
echo "<table align='left'>"; 
//echo "<table cellspacing='20' border='0' width='700' align='center' cellspacing='0' cellpadding='0' width='100%' >"; 
echo "<tr><th>$game_name";
if($help_location != ''){echo "<a href='$help_location' target='_blank'><img src='/budget/infotrack/icon_photos/info2.png' width='50' height='50' title='help'></a>";}
echo "</th></tr>";

//echo "<br />";
//echo "<tr>";
//echo "<td>";
//echo "Question: $question<br />";
echo "<tr><td bgcolor='springgreen'>$question</td></tr>";
//echo "<br />";
echo "<tr><td onMouseOver=\"this.bgColor='lightgreen'\" onMouseOut=\"this.bgColor='lightcyan'\"><a href='games/multiple_choice/game_play_module.php?score=yes&sid=$sid&gid=$gid&qid=$qid&choice=a'>$a</a></td></tr>";
echo "<tr><td onMouseOver=\"this.bgColor='lightgreen'\" onMouseOut=\"this.bgColor='lightcyan'\"><a href='games/multiple_choice/game_play_module.php?score=yes&sid=$sid&gid=$gid&qid=$qid&choice=b'>$b</a></td></tr>";
echo "<tr><td onMouseOver=\"this.bgColor='lightgreen'\" onMouseOut=\"this.bgColor='lightcyan'\"><a href='games/multiple_choice/game_play_module.php?score=yes&sid=$sid&gid=$gid&qid=$qid&choice=c'>$c</a></td></tr>";
echo "<tr><td onMouseOver=\"this.bgColor='lightgreen'\" onMouseOut=\"this.bgColor='lightcyan'\"><a href='games/multiple_choice/game_play_module.php?score=yes&sid=$sid&gid=$gid&qid=$qid&choice=d'>$d</a></td></tr>";


echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>";
*/

//echo "</div>";


//echo "</body>";
//echo "</html>";

?>