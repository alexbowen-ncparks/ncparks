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
if($level==1){$parkcode=$concession_location;}


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
//include ("widget1.php");
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
$query2="select center_desc,center from center where parkcode='$parkcode'   ";	

//echo "query1d=$query1d<br />";//exit;		  

$result2 = mysql_query($query2) or die ("Couldn't execute query 2.  $query2");
		  
$row2=mysql_fetch_array($result2);

extract($row2);

$center_location = str_replace("_", " ", $center_desc);

if($level==5){$center_location='Raleigh Financial Services Group';}

/*
echo "<table><tr><th><img height='25' width='25' src='/budget/infotrack/icon_photos/feedback1.png' alt='picture of Feedback box'><font color='blue'>$center_location $center</font></img><br /><font color='brown' size='5'><b>Surveys</b></font></th></tr></table>";
echo "<br /><br />";
*/
$survey_icon="<img height='60' width='60' src='/budget/infotrack/icon_photos/feedback1.png' alt='picture of Feedback box'></img>";

if($level==1){$park_header=$concession_location;}
if($level==2){$park_header=$concession_location;}
if($level==5){$park_header='Financial Services Group';}

echo "<table><tr><th align='center'><font size='5' color='brown'>$park_header Surveys $survey_icon</th></tr></table>";


include("surveys_widget2_v2.php");



//include("report_header1.php");
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
/*
echo "<table><tr><th></th><th><font color=blue>Completed</font></th></tr>
              <tr bgcolor='lightgreen'><td>yes</td><td align='center'>10</td></tr>
              <tr bgcolor='lightpink'><td>no</td><td align='center'>20</td></tr>";
             
echo "</table><br />";
*/
$yes=5;
$no=15;
$score=25;
echo "<table border=1>";

echo "<table><tr><th align='center' colspan='2'><font size='5' color='brown' ><b>Score: $score</b></font></font></th></tr>
              <tr bgcolor='lightgreen'><td>yes</td><td align='center'>$yes</td></tr>
              <tr bgcolor='lightpink'><td>no</td><td align='center'>$no</td></tr>";
           
echo "</table><br />";



echo "<table border='1'>";
//echo "<tr><th>$player</th></tr>";
echo 

"<tr>"; 
 //echo "<th>Author</th>";
 echo "<th>Survey Name</th>";
       
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

//echo"<td onMouseOver=\"this.bgColor='red'\" onMouseOut=\"this.bgColor='$bgc'\"><a href=\"games.php?gid2=$gid&gidS=none\">$game_name</a></td>";
echo"<td onMouseOver=\"this.bgColor='red'\" onMouseOut=\"this.bgColor='$bgc'\" nowrap><a href=''>$game_name</a></td>";

//echo "line213 ok<br />";exit;


//echo "<td>$status</td>";
//echo "<td>";

if($level=='5')
{
/*
				 echo "<form method='post' action='status_change.php'>
				  <input type='hidden' name='gid' value='$gid'>
				  <input type='hidden' name='status' value='$status'>
				  <input type='submit' name='submit2' value='Survey Show'>
				  </form><form method='post' action='game_edit.php'>
				  <input type='hidden' name='gid' value='$gid'>
				  <input type='hidden' name='qcount_S' value='$qcount'>
				  <input type='submit' name='submit2' value='Survey Change'>
				  </form>";
*/

 
echo "<td>
				<form method='post' action='survey_review.php'>
				  <input type='hidden' name='gid' value='$gid'>
				  <input type='hidden' name='qcount_S' value='$qcount'>
				  <input type='submit' name='submit2' value='Review Survey'>
				  </form></td>";				 
}
  


//echo "<td>$status</td>";
if($level!=5)
{
echo "<td>
				<form method='post' action='survey_submit.php'>
				  <input type='hidden' name='gid' value='$gid'>
				  <input type='hidden' name='qcount_S' value='$qcount'>
				  <input type='submit' name='submit2' value='Complete Survey'>
				  </form></td>";
}				 
 
echo "</tr>";


}

echo "</table>";
//echo "<table><tr><td><a href=\"game_reset.php?pid=$pid\">Reset</a></td></tr></table>";
echo "</div>";
 

?>



















	














