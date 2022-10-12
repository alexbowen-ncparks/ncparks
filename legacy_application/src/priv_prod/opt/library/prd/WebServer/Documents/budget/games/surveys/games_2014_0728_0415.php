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

include("../../../budget/menu1314.php");

echo "<br />";
if($survey_selected=='')
{
$query1="select pid from survey_players where player='$player' ";

$result1 = mysql_query($query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysql_fetch_array($result1);

extract($row1);//returns $pid

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




echo "</head>"; 
echo "<body>"; 

$query2="select center_desc,center from center where parkcode='$parkcode'   ";	

//echo "query1d=$query1d<br />";//exit;		  

$result2 = mysql_query($query2) or die ("Couldn't execute query 2.  $query2");
		  
$row2=mysql_fetch_array($result2);

extract($row2);

$center_location = str_replace("_", " ", $center_desc);

if($level==5){$center_location='Raleigh Financial Services Group';}


$survey_icon="<img height='60' width='60' src='/budget/infotrack/icon_photos/feedback1.png' alt='picture of Feedback box'></img>";

if($level==1){$park_header=$concession_location;}
if($level==2){$park_header=$concession_location;}
if($level==5){$park_header='Financial Services Group';}

echo "<table><tr><th align='center'><font size='5' color='brown'>$park_header Surveys $survey_icon</th></tr></table>";


include("surveys_widget2_v2.php");




echo "<div id=\"games\" class='column2of3' width='100%'>";


if($level=='5')
{echo "<table><tr><th>
<a href=\"questions.php\">Create Survey</a>
</th>";
echo "</tr></table>";
}
echo "<br />";

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


echo 
"<tr bgcolor='$bgc'>";


echo"<td onMouseOver=\"this.bgColor='red'\" onMouseOut=\"this.bgColor='$bgc'\" nowrap><a href='games.php?survey_selected=y&gid=$gid'>$game_name</a></td>";



if($level=='5')
{


 
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
echo "</body>";
echo "</html>";
 }
if($survey_selected!='')
{
$gid=1;
echo "<body>"; 

$query2="select center_desc,center from center where parkcode='$parkcode'   ";	

//echo "query1d=$query1d<br />";//exit;		  

$result2 = mysql_query($query2) or die ("Couldn't execute query 2.  $query2");
		  
$row2=mysql_fetch_array($result2);

extract($row2);

$center_location = str_replace("_", " ", $center_desc);

if($level==5){$center_location='Raleigh Financial Services Group';}


$survey_icon="<img height='60' width='60' src='/budget/infotrack/icon_photos/feedback1.png' alt='picture of Feedback box'></img>";

if($level==1){$park_header=$concession_location;}
if($level==2){$park_header=$concession_location;}
if($level==5){$park_header='Financial Services Group';}

echo "<table><tr><th align='center'><font size='5' color='brown'>$park_header Surveys $survey_icon</th></tr></table>";


include("surveys_widget2_v2.php");


$query3a="select survey_scores.qid,survey_scores.question,survey_scores.park_answer
from survey_scores
where survey_scores.gid='$gid'
and survey_scores.playstation='$concession_location'
order by survey_scores.qid; ";

$result3a = mysql_query($query3a) or die ("Couldn't execute query3a. $query3a");

$num3a=mysql_num_rows($result3a);
//echo "<br />";

//echo "<table><tr><th>Survey Form</th></tr></table>";
//echo "<br />";
//echo "<table><tr><th>Results</th></tr></table>";
echo "<table border='1'>";
//echo "<tr><th>$player</th></tr>";
$game_points=round($game_points);


echo 

"<tr><td>$survey_purpose</td>

</tr>";
//echo "<br />$qcount Questions</th></tr>
echo "</table>";

echo "<br />";
echo "<table border='1'>";
echo "<tr>";	   
//echo "<th>ID</th>";
echo "<th align='center'>Question</th>";
echo "<th align='center'>Park Answer<br />Answer</th>";
//echo "<th align='center'>Park<br />Answer</th>";
                
              
echo "</tr>";
//if($edit!='y'){

//echo  "<form method='post' autocomplete='off' action='/budget/games/surveys/survey_submit_update.php'>";
if($level!= 5)
{
//echo  "<form method='post' autocomplete='off' action='survey_submit_update.php'>";




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

//echo "<td>$qid</td>";
//echo "<td><input type='text' name='qid[]' size='1' value='$qid' readonly='readonly'></font></td>";
echo "<td>$question</td> ";
echo "<td>$park_answer</td> ";
//echo "<td><textarea name='park_answer[]' cols='40' rows='3'>$park_answer</textarea></td> ";
//echo "<td><textarea name='qid[]' cols='3' rows='3' readonly>$qid</textarea></td> ";

echo "</tr>";
} 
/*
if($level=='5')
{
echo "<tr><td><input type='submit' name='submit2' value='Update'></td></tr>";
echo "<tr><td>New Quiz Name<br /><input type='text' name='new_game'><input type='submit' name='submit2' value='Duplicate'></td></tr>";
}
*/

//echo "<tr><td><input type='submit' name='submit2' value='Submit Survey'></td></tr>";

/*
if($correct_answer=='a'){echo "<td><font color='blue'>$a</font></td>";}else{echo "<td>$a</td>";}
if($correct_answer=='b'){echo "<td><font color='blue'>$b</font></td>";}else{echo "<td>$b</td>";}
if($correct_answer=='c'){echo "<td><font color='blue'>$c</font></td>";}else{echo "<td>$c</td>";}
if($correct_answer=='d'){echo "<td><font color='blue'>$d</font></td>";}else{echo "<td>$d</td>";}
*/
//echo "<td>$correct_answer</td>";
//echo "<td>$your_answer</td>";
//echo "<td>$points</td>";

//echo "<input type='hidden' name='gid' value='$gid'>";
//echo "<input type='hidden' name='pid_S' value='$pid_S'>";
//echo "<input type='hidden' name='qcount_S' value='$qcount_S'>";
//echo "<input type='hidden' name='player' value='$player'>";
//echo "<input type='hidden' name='num3a' value='$num3a'>";
//echo "<input type='hidden' name='project_note' value='$project_note'>";
//echo   "</form>";             
}          

echo "</table>";

echo "</body>";
echo "</html>";
}
?>





