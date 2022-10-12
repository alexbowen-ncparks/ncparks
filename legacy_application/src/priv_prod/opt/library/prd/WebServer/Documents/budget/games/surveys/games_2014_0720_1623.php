<?php
session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
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



$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../../budget/~f_year.php");

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

$query11="SELECT filegroup
from concessions_filegroup
WHERE 1 and filename='$active_file'
";
//echo "query11=$query11";exit;
$result11=mysql_query($query11) or die ("Couldn't execute query 11. $query11");

$row11=mysql_fetch_array($result11);

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
include("../../../budget/menu1314.php");
//include("menu1314_test.php");
include ("widget1.php");
//echo "filegroup=$filegroup";
echo "<br />";

$query1="select pid from survey_players where player='$player' ";

$result1 = mysql_query($query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysql_fetch_array($result1);

extract($row1);//returns $pid
/*
$query5="SELECT games.gid, games.game_name, (sum( scores.points )*10) as 'points'
FROM games
LEFT JOIN scores ON games.gid = scores.gid and scores.pid='$pid'
where scores.gid IS NOT NULL and valid_record='y'
GROUP BY games.gid,scores.pid
union
SELECT games.gid, games.game_name, (sum( scores.points )*10) as 'points'
FROM games
LEFT JOIN scores ON games.gid = scores.gid and scores.pid='$pid'
where scores.gid IS NULL
GROUP BY games.gid,scores.pid";
*/
if($level=='5')
{
$query5="SELECT survey_games.gid,survey_games.game_name,survey_games.author,survey_games.status,qcount
FROM survey_games
where 1
GROUP BY survey_games.gid
order by game_name; ";
}
else
{
$query5="SELECT survey_games.gid,survey_games.game_name,survey_games.author,survey_games.status
FROM survey_games
where 1 and status='show'
GROUP BY survey_games.gid
order by game_name; ";
}

$result5 = mysql_query($query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysql_num_rows($result5);
//echo "line 110 ok<br />";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">";
echo "<head>"; 
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />";
//echo "<meta http-equiv=\"refresh\" content=\"30\">";
echo "<title>Game Menu2</title>"; 
echo "<link rel=\"stylesheet\" href=\"css/stylesheet1.css\" />"; 
include("js/games_js.php");

echo "<script src=\"http://code.jquery.com/jquery-1.9.1.js\"></script>";

echo "<script type=\"text/javascript\">
$(document).ready(function(){
	$(\"button\").click(function()	{
		$('#note_tracker').load('/budget/infotrack/note_tracker.php?folder=community&project_note_id=692');	

});
});

</script>";



/*
echo "<script type=\"text/javascript\"> function onRow(rowID)
{var row=document.getElementById(rowID);
var curr=row.className;
if(curr.indexOf(\"normal\")>=0)row.className=\"highlight\";else row.className=\"normal\"
 } 
</script>";
*/
echo "</head>"; 
echo "<body>"; 
//if($notes=='y')

//{include("/budget/infotrack/note_tracker.php?folder=community&project_note_id=692'");}
//load('/budget/infotrack/note_tracker.php?folder=community&project_note_id=692');	
//echo "<div id=\"note_tracker\">
//<button>NoteTracker</button>
//</div>";
//if($notes=='y'){include("note_tracker.php");}
//echo "line153 ok<br />";exit;
if($notes=='y'){include("../../../budget/infotrack/note_tracker.php");}
include("report_header1.php");
//include("../../../budget/~f_year.php");

echo "<div id=\"games\" class='column2of3' width='100%'>";
//echo "<table width='75%' align='center'><tr><th>$player Points</th></tr></table>";
//$player2=substr($player,0,-2);
//echo "<table border='1'><tr><th>$player2</th>";

if($level=='5')
{echo "<table><tr><th>
<a href=\"questions.php\">Create Survey</a>
</th>";
echo "</tr></table>";
}
echo "<br />";
echo "<table border='1'>";
//echo "<tr><th>$player</th></tr>";
echo 

"<tr>"; 
 //echo "<th>Author</th>";
 echo "<th>Survey</th>";
       
if($level=='5')
{
 echo "<th>Action</th>";
 }      
    
                
              
echo "</tr>";

while ($row5=mysql_fetch_array($result5)){

extract($row5);
if($status=='hide'){$bgc="lightpink";} else {$bgc="lightgreen";}


$author2=substr($author,0,-2);
//$author2=substr($author,0,4);

/*
echo 

"<tr bgcolor=\$bgc\ class=\"normal\" id=\"row$gid\" 
onclick=\"clicksound.playclip();onRow(this.id)\">

<td onMouseOver=\"this.bgColor='red'\" onMouseOut=\"this.bgColor='lightcyan'\"><a href=\"games.php?gid2=$gid&gidS=none\">$game_name</a></td>
<td>$author2</td>";
*/

echo 
"<tr bgcolor='$bgc'>";

//echo "<td>$author2</td>";

echo"<td onMouseOver=\"this.bgColor='red'\" onMouseOut=\"this.bgColor='$bgc'\"><a href=\"games.php?gid2=$gid&gidS=none\">$game_name</a></td>";

//echo "line213 ok<br />";exit;

if($level=='5')
{
//echo "<td>$status</td>";
echo "<td>
				  <form method='post' action='status_change.php'>
				  <input type='hidden' name='gid' value='$gid'>
				  <input type='hidden' name='status' value='$status'>
				  <input type='submit' name='submit2' value='Survey Show'>
				  </form><form method='post' action='game_edit.php'>
				  <input type='hidden' name='gid' value='$gid'>
				  <input type='hidden' name='qcount_S' value='$qcount'>
				  <input type='submit' name='submit2' value='Survey Change'>
				  </form></td>
				  <td>";
}
                    
echo "</tr>";


}

echo "</table>";
//echo "<table><tr><td><a href=\"game_reset.php?pid=$pid\">Reset</a></td></tr></table>";
echo "</div>";
 
if($gid2 != "" and $gidS == "none")

{

$query5a="select count(sid) as 'sidC' from survey_scores where 1 ";
$result5a = mysql_query($query5a) or die ("Couldn't execute query 5a.  $query5a");

//$num2=mysql_num_rows($result2);
$row5a=mysql_fetch_array($result5a);

extract($row5a);

//echo "sidC=$sidC";exit;
if($sidC=="0"){$sid="1";}
//exit;
else
{
$query2="select max(sid)+1 as 'sid' from survey_scores where 1 ";

//echo "query2=$query2";exit;

$result2 = mysql_query($query2) or die ("Couldn't execute query 2.  $query2");

//$num2=mysql_num_rows($result2);
$row2=mysql_fetch_array($result2);

extract($row2);
}
$sed=date("Ymd");
$query3="insert into survey_scores(sid,pid,gid,qid,answer,sed)
         select '$sid','$pid','$gid2',qid,answer,'$sed' from survey_questions
         where gid='$gid2'
         ";

//echo "query3=$query3";exit;

$result3 = mysql_query($query3) or die ("Couldn't execute query 3.  $query3");
//echo "line276 ok<br />";exit;
include("game_play.php");
//exit;
}
if($gidS != "none" and $gidS != ""){include("game_play.php");}
?>



















	














