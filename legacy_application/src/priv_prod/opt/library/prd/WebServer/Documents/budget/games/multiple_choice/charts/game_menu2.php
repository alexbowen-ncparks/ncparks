<?php
session_start();
$player=$_SESSION['myusername'];
extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//{echo "<pre>";print_r($_SESSION);"</pre>";}//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
include("connect.php");// database connection parameters
//include("charts/chart1.php");//exit;// database connection parameters

$query1="select pid from players where player='$player' ";

//echo "query1=$query1";exit;

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

//$num1=mysqli_num_rows($result1);
$row1=mysqli_fetch_array($result1);

extract($row1);//returns $pid
/*
$query5="SELECT game_name,games.gid,qcount,author FROM games
 WHERE 1 order by game_name ";	
//echo "query5=$query5";	
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);
*/
/*
$query5="SELECT games.gid, games.game_name, (sum( scores.points )*10) as 'points'
FROM games
LEFT JOIN scores ON games.gid = scores.gid
WHERE scores.pid = '$pid'
OR scores.gid IS NULL
GROUP BY games.gid,scores.pid";
*/

$query5="SELECT games.gid, games.game_name, (sum( scores.points )*10) as 'points'
FROM games
LEFT JOIN scores ON games.gid = scores.gid and scores.pid='$pid'
where scores.gid IS NOT NULL
GROUP BY games.gid,scores.pid
union
SELECT games.gid, games.game_name, (sum( scores.points )*10) as 'points'
FROM games
LEFT JOIN scores ON games.gid = scores.gid and scores.pid='$pid'
where scores.gid IS NULL
GROUP BY games.gid,scores.pid";


//echo "query5=$query5";

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);




echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">";
echo "<head>"; 
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />";
echo "<title>Game Menu2</title>"; 
echo "<link rel=\"stylesheet\" href=\"css/stylesheet1.css\" />"; 
include("js/games_js.php");
echo "<script src=\"http://code.jquery.com/jquery-1.9.1.js\"></script>";
echo "<script language=\"javascript\" type=\"text/javascript\" src=\"js/js1.js\"></script>";
echo "<script type=\"text/javascript\">
$(document).ready(function(){
	$(\"button\").click(function()	{
		$('#timer1').load('timer1.html');	

});
});

</script>";

echo "<script type=\"text/javascript\"> function onRow(rowID)
{var row=document.getElementById(rowID);
var curr=row.className;
if(curr.indexOf(\"normal\")>=0)row.className=\"highlight\";else row.className=\"normal\"
 } 
</script>";






echo "</head>"; 
echo "<body>"; 



//echo "pid=$pid";
//echo "<br />";
//echo "player=$player";
//echo "<br />";
//echo "<table border=5 cellspacing=5>";

	  
//echo "</table>";
//echo "<h2>Games:$num5</h2>";

//echo "<div id=\"header\">";
echo "<div id=\"timer1\">
<button>ShowTimer</button>
</div>";

/*
echo "<br />";
//echo "query5a=$query5a";

//echo "<h2>Scores:$num5a</h2>";
echo "
<div id=\"scores\" class='column3of3'>";

echo "<table>";

echo 

"<tr> 
       <th>Player</th>";
 //echo "<th>Game</th>";
//echo " <th>ScoreID</th>";
echo " <th>Score</th>
                  
              
</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row5a=mysqli_fetch_array($result5a)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row5a);

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
$score=round($score);
echo 

"<tr>

<td>$player</td>";
//echo "<td>$game_name</td>";
//echo "<td>$sid</td>";
echo "<td>$score</td>
                    
</tr>";


}

echo "</table>"; 
echo "</div>";
*/
//echo "<br />";


echo "<div id=\"games\" class='column2of3' width='100%'>";
echo "<table>";

echo 

"<tr> 
       <th>Game</th>
       <th>Points</th>";
//echo "<th>Author</th>";
                  
              
echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row5=mysqli_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row5);

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
//($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr class=\"normal\" id=\"row$gid\" 
onclick=\"clicksound.playclip();onRow(this.id)\">

<td onMouseOver=\"this.bgColor='red'\" onMouseOut=\"this.bgColor='lightcyan'\"><a href=\"game_menu2.php?gid2=$gid&gidS=none\">$game_name</a></td>
<td>$points</td>

                    
</tr>";


}

echo "</table>";
echo "</div>";
/*
echo "<div id=\"timer1\" class='column2of4'>
<button>ShowTimer</button>
</div>";
*/
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
/* 
$query5a="select 
players.player,games.game_name,scores.sid,sum(points)*10 as 'score'
from scores
left join players on scores.pid=players.pid
left join games on scores.gid=games.gid
where 1
group by scores.pid,sid,games.gid
order by sid desc 
";
 */
 
 
/*
echo "<div id=\"commentary\" class='column4of4'>";
echo "<p>Senor Antonio conduce por 130</p>";
echo "</div>";
*/

//echo "</body></html>";
//exit;}
//echo "gid2=$gid2";echo "<br />";
//echo "gidS=$gidS";
if($gid2 != "" and $gidS == "none")

{

$query2="select max(sid)+1 as 'sid' from scores where 1 ";

//echo "query2=$query2";exit;

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

//$num2=mysqli_num_rows($result2);
$row2=mysqli_fetch_array($result2);

extract($row2);


$query3="insert into scores(sid,pid,gid,qid,answer)
         select '$sid','$pid','$gid2',qid,answer from questions
         where gid='$gid2'
         ";

//echo "query3=$query3";exit;

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

//echo "pid=$pid";
//echo "<br />";
//echo "gid=$gid";
//echo "<br />";
//echo "sid=$sid";
//echo "<br />";
//header("location: game_play.php?sid=$sid&gid=$gid");
//$gidS=$gid2;
//$gid2="";
include("game_play.php");
//exit;
}
if($gidS != "none" and $gidS != ""){include("game_play.php");}
?>



















	














