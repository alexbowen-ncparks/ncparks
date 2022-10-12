<?php
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
//include("../../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
//include("../../../budget/~f_year.php");

$query9="insert ignore into players(player)
         values('$player') ";

$result9=mysqli_query($connection, $query9) or die ("Couldn't execute query 9. $query9");


/*
$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from concessions_customformat
WHERE 1 
";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);
*/

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;
/*
$query11="SELECT filegroup
from concessions_filegroup
WHERE 1 and filename='$active_file'
";
//echo "query11=$query11";exit;
$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);
*/
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

$query22="select center_desc,center from center where parkcode='$concession_location'   ";	

//echo "query22=$query22<br />";//exit;		  

$result22 = mysqli_query($connection, $query22) or die ("Couldn't execute query 22.  $query22");
		  
$row22=mysqli_fetch_array($result22);

extract($row22);

$center_location = str_replace("_", " ", $center_desc);

if($level==5 or $beacnum=='60036015'){$center_location='Financial Services Group';}
echo "<br />";
echo "<table align='center'><tr><th><img height='35' width='35' src='/budget/infotrack/icon_photos/checkers_board1.png' alt='games icon'><font color='blue'>$center_location</font></img><br /><font color='brown' size='5'><b>Training Games</b></font></th></tr></table>";
echo "<br />";
if($game_overview=='y')
{



$query8="SELECT game_name,overview
from games
WHERE gid='$gid2' 
";

//echo "<br />query8=$query8<br />";

$result8=mysqli_query($connection, $query8) or die ("Couldn't execute query 8. $query8");

$row8=mysqli_fetch_array($result8);

extract($row8);


echo "<br />";
echo "<table align='center'>";
//echo "<tr><th>gid2</th><td>$gid2</td></tr>";
//echo "<tr><th>gidS</th><td>$gidS</td></tr>";
echo "<tr><th>Game</th><td>$game_name</td></tr>";
echo "<tr><th></th><td>$overview</td></tr>";
echo "<tr><th><a href=\"games.php?gid2=$gid2&gidS=none\">Play</a></th></tr>";
echo "</table>";
exit;}




//include("menu1314_test.php");
include ("widget1.php");
//echo "filegroup=$filegroup";
echo "<br />";

$query1="select pid from players where player='$player' ";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);

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
$query5="SELECT games.gid,games.game_name,games.author,games.status,qcount
FROM games
where 1
GROUP BY games.gid
order by gid desc; ";
}
/*
else
{
$query5="SELECT games.gid,games.game_name,games.author,games.status
FROM games
where 1 and status='show'
GROUP BY games.gid
order by gid desc; ";
}
*/

if($level!='5')
{
	
	
$query5="SELECT games.gid,games.game_name,games.author,games.status
FROM games
where 1 and ((status='show') or (status='hide' and author='$tempID'))
GROUP BY games.gid
order by gid desc; ";	
	
	
	
	
	
	
}









$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);

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
//if($notes=='y'){include("../../../budget/infotrack/note_tracker.php");}
//include("report_header1.php");
//include("../../../budget/~f_year.php");

echo "<div id=\"games\" class='column2of3' width='100%'>";
//echo "<table width='75%' align='center'><tr><th>$player Points</th></tr></table>";
//$player2=substr($player,0,-2);
//echo "<table border='1'><tr><th>$player2</th>";

//if($level=='5' or $beacnum=='60036015' or $beacnum=='60032991')
{echo "<table align='center'><tr><th>
<a href=\"questions.php\">Create Game</a>
</th>";
echo "</tr></table>";
}
echo "<br />";
echo "<table border='1'>";
//echo "<tr><th>$player</th></tr>";
echo 

"<tr>"; 
//echo "<th>Author</th>";
echo "<th>GameID</th>";
echo "<th>GameName</th>";
//echo "<th>Author</th>";
       
//if($level=='5' or $beacnum=='60036015')
{
 //echo "<th>Action</th>";
 }      
    
                
              
echo "</tr>";

while ($row5=mysqli_fetch_array($result5)){

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

echo "<td>$gid</td>";

echo"<td onMouseOver=\"this.bgColor='red'\" onMouseOut=\"this.bgColor='$bgc'\"><a href=\"games.php?gid2=$gid&gidS=none&game_overview=y\">$game_name</a></td>";

//echo "<td>$author2</td>";

if($level=='5' or $beacnum=='60036015')
{
//echo "<td>$status</td>";
echo "<td>";
echo "<form method='post' action='status_change.php'>
	  <input type='hidden' name='gid' value='$gid'>
	  <input type='hidden' name='status' value='$status'>
	  <input type='submit' name='submit2' value='Game Show'>
	  </form>";
echo "<form method='post' action='game_edit.php'>
	  <input type='hidden' name='gid' value='$gid'>
	  <input type='hidden' name='qcount_S' value='$qcount'>
	  <input type='submit' name='submit2' value='Game Change'>
	  </form>";
echo "<form method='post' action='scores.php'>
	  <input type='hidden' name='gidS' value='$gid'>
	  <input type='hidden' name='one_game_score' value='y'>
	  <input type='submit' name='submit2' value='Game Scores'>
	  </form>";	  
	  
	  
	  
	  
echo "</td>";
//echo "<td>";
}
   


if($level!='5' and $beacnum!='60036015')
{
if($author==$tempID)
{
//echo "<td>$status</td>";
echo "<td>";
echo "<form method='post' action='status_change.php'>
	  <input type='hidden' name='gid' value='$gid'>
	  <input type='hidden' name='status' value='$status'>
	  <input type='submit' name='submit2' value='Game Show'>
	  </form>";
echo "<form method='post' action='game_edit.php'>
	  <input type='hidden' name='gid' value='$gid'>
	  <input type='hidden' name='qcount_S' value='$qcount'>
	  <input type='submit' name='submit2' value='Game Change'>
	  </form>";
echo "<form method='post' action='scores.php'>
	  <input type='hidden' name='gidS' value='$gid'>
	  <input type='hidden' name='one_game_score' value='y'>
	  <input type='submit' name='submit2' value='Game Scores'>
	  </form>";	  
	  
	  
	  
	  
echo "</td>";
}

}




   
echo "</tr>";


}

echo "</table>";
//echo "<table><tr><td><a href=\"game_reset.php?pid=$pid\">Reset</a></td></tr></table>";
echo "</div>";
 
if($gid2 != "" and $gidS == "none")

{

$query5a="select count(sid) as 'sidC' from scores where 1 ";
$result5a = mysqli_query($connection, $query5a) or die ("Couldn't execute query 5a.  $query5a");

//$num2=mysqli_num_rows($result2);
$row5a=mysqli_fetch_array($result5a);

extract($row5a);

//echo "sidC=$sidC";exit;
if($sidC=="0"){$sid="1";}
//exit;
else
{
$query2="select max(sid)+1 as 'sid' from scores where 1 ";

//echo "query2=$query2";exit;

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

//$num2=mysqli_num_rows($result2);
$row2=mysqli_fetch_array($result2);

extract($row2);
}
$sed=date("Ymd");
$query3="insert into scores(sid,pid,gid,qid,answer,sed)
         select '$sid','$pid','$gid2',qid,answer,'$sed' from questions
         where gid='$gid2'
         ";

//echo "query3=$query3";exit;

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

include("game_play.php");
//exit;
}
if($gidS != "none" and $gidS != ""){include("game_play.php");}