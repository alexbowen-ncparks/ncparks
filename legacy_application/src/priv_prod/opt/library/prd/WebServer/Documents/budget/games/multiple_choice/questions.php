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

//extract($_REQUEST);

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
//echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

$database="budget";
$db="budget";
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters

//echo "escape post<pre>"; print_r($esc_post); echo "</pre>"; // exit;

extract($esc_post);
mysqli_select_db($connection, $database); // database
//include("../../../../include/activity.php");// database connection parameters

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
$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);
echo "<br />";
/*
include("../../../budget/menus2.php");
*/
//include("../../../budget/menu1314.php");
//include ("../../../budget/menu1415_v1.php");
$query22="select center_desc,center from center where parkcode='$concession_location'   ";	

//echo "query22=$query22<br />";//exit;		  

$result22 = mysqli_query($connection, $query22) or die ("Couldn't execute query 22.  $query22");
		  
$row22=mysqli_fetch_array($result22);

@extract($row22);

@$center_location = str_replace("_", " ", $center_desc);

if($level==5 or $beacnum == '60036015'){$center_location='Financial Services Group';}
echo "<br />";
echo "<table align='center' cellspacing='5'><tr><th><img height='35' width='35' src='checkers_board1.png' alt='games icon'><font color='blue'>$center_location</font></img><br /><font color='brown' size='5'><b>Learning Games</b></font></th></tr></table>";
echo "<br />";
include ("widget1.php");

//include("widget1.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

echo "<br />";



$query1="select pid from players where player='$player' ";

//echo "query1=$query1";exit;

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

//$num1=mysqli_num_rows($result1);
$row1=mysqli_fetch_array($result1);

extract($row1);

echo "<html>";
echo "<head>"; 
echo "<link rel=\"stylesheet\" href=\"css/stylesheet1.css\" />"; 
echo "<link rel='stylesheet' type='text/css' href='bubble.css'>";
echo "</head>"; 





if($submit=="")
{

//echo "user=$user";
//$game2=($game);
//echo "game2=$game2";
//$query1="select max(gid)+1 as 'gid' from games where 1";
//echo "query1=$query1";echo "<br />";//exit;
//$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");
//$row1=mysqli_fetch_array($result1);
//extract($row1); //returns NEW GameID $gid



echo "<body>";
echo "<table align='center'><tr><th>Create QuizGame</th></tr></table>";
//echo "<br />";
echo "<div class='box sb2'>Step1 of 2<img src='green_check.png' alt='image of green check mark' height='30' width='30'><br /><br /><table><tr><td> A) Enter name of your QuizGame</td></tr><tr><td> B) Enter number of Questions (5-15)</td></tr><tr><td>C) Click: Show_Form</td></tr></table></div>";
echo "<table align='center'><form action='questions.php' method='post'>";
echo "<tr>";

//echo "<td align='center'>GameID<br><input type='text' name='gid' value='$gid' size='5' READONLY></td>";
//$today=date(Ymd);
//echo "<td align='center'>Allocation Date<br><input type='text' name='allocation_date' value='$today' size='12' READONLY></td>";

echo "<td align=\"center\">QuizName<br><input type=\"text\" name=\"game\" value=\"$game\" size=\"30\" autocomplete=\"off\"></td>";

echo "<td align=\"center\">#questions <br><input type=\"text\" name=\"questionC\" value=\"$questionC\" size='3' autocomplete=\"off\"></td>";

echo "<td><input type='submit' name='submit' value='Show_Form'>";
echo "</form>";
echo "</td>";

echo "</tr>";
echo "</table>";

echo "</body>";
echo "</html>";
exit;
}

if($submit=="Submit")
//{$rec2add=count($correct);echo "rec2add=$rec2add";}
{
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
$game2=addslashes(urldecode($game2));
//echo "game2=$game2";echo "<br />";
$game2=($game2);
$rec2add=count($correct);
$query1a="insert into games set pid='$pid',game_name='$game2',qcount='$rec2add',author='$player' ";
//echo "$query1a"; exit;
$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a. $query1a");
//echo "query1a=$query1a";

$query1b="select max(gid) as 'gid' from games where pid='$pid' ";
$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b. $query1b");
$row1b=mysqli_fetch_array($result1b);
extract($row1b); 
//echo "query1b=$query1b";echo "<br />";
//echo "gid=$gid";echo "<br />";//exit;


//$question=addslashes($question);
$query2="INSERT INTO questions SET gid='$gid' ";
for($j=1;$j<=$rec2add;$j++){
$query3=$query2;
$ques=($question[$j]);
$ans1a=($ans1[$j]);
$ans2a=($ans2[$j]);
$ans3a=($ans3[$j]);
$ans4a=($ans4[$j]);
	$query3.=", question='$ques'";
	$query3.=", a='$ans1a'";
	$query3.=", b='$ans2a'";
	$query3.=", c='$ans3a'";
	$query3.=", d='$ans4a'";
	$query3.=", answer='$correct[$j]'";
	$query3.=", fyi='$fyi[$j]'";
		//$v1=str_replace(",","",$allocation_amount[$j]);
	//$query.=", allocation_amount='$v1'";
		//$just=addslashes($justification[$j]);
	//$query.=", justification='$just'";
		
//echo "$query3<br><br>"; exit;
if($correct[$j]!=""){
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3"); //exit;
//echo "query3=$query3";
}
	}
header("location: games.php");
/*
echo "<table align='center'><tr><th><font color='red'>NEW Game Created</font></th></tr></table>"; 
if($tempID=='Adams9184')
{
	
	
$query5="SELECT games.gid,games.game_name,games.author,games.status
FROM games
where 1 and ((status='show') or (status='hide' and author='$tempID'))
and gid='$gid'
GROUP BY games.gid
order by game_name; ";	
	


$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);

echo "<table border='1' align='center'>";
//echo "<tr><th>$player</th></tr>";
echo 

"<tr>"; 
//echo "<th>Author</th>";
echo "<th>GameID</th>";
echo "<th>GameName</th>";
echo "<th>Author</th>";
       
if($level=='5' or $beacnum=='60036015')
{
 echo "<th>Action</th>";
 }      
    
                
              
echo "</tr>";

while ($row5=mysqli_fetch_array($result5)){

extract($row5);
if($status=='hide'){$bgc="lightpink";} else {$bgc="lightgreen";}


$author2=substr($author,0,-2);
//$author2=substr($author,0,4);



echo 
"<tr bgcolor='$bgc'>";
//echo "<td>$bgc</td>";
echo "<td>$gid</td>";

echo"<td onMouseOver=\"this.bgColor='red'\" onMouseOut=\"this.bgColor='$bgc'\"><a href=\"games.php?gid2=$gid&gidS=none&game_overview=y\">$game_name</a></td>";

echo "<td>$author2</td>";

if($level=='5' or $beacnum=='60036015')
{
//echo "<td>$status</td>";
echo "<td>
				  <form method='post' action='status_change.php'>
				  <input type='hidden' name='gid' value='$gid'>
				  <input type='hidden' name='status' value='$status'>
				  <input type='submit' name='submit2' value='Game Show'>
				  </form><form method='post' action='game_edit.php'>
				  <input type='hidden' name='gid' value='$gid'>
				  <input type='hidden' name='qcount_S' value='$qcount'>
				  <input type='submit' name='submit2' value='Game Change'>
				  </form></td>
				  <td>";
}
   


if($level!='5' and $beacnum!='60036015')
{
if($author==$tempID)
{
//echo "<td>$status</td>";
echo "<td>
				  <form method='post' action='status_change.php'>
				  <input type='hidden' name='gid' value='$gid'>
				  <input type='hidden' name='status' value='$status'>
				  <input type='submit' name='submit2' value='Game Show'>
				  </form><form method='post' action='game_edit.php'>
				  <input type='hidden' name='gid' value='$gid'>
				  <input type='hidden' name='qcount_S' value='$qcount'>
				  <input type='submit' name='submit2' value='Game Change'>
				  </form></td>
				  <td>";
}

}




   
echo "</tr>";


}

echo "</table>";
}
*/

 exit;
}

if($submit=="Show_Form")
{
//echo "gid=$gid";echo "<br />";//exit;
$game=stripslashes($game);
//echo "game=$game";echo "<br />";

//$game=addslashes($game);
//echo "game=$game";echo "<br />";
//echo "questionC=$questionC";echo "<br />";
//echo "submit=$submit";echo "<br /><br />";
/*
echo "<html>";
echo "<head>"; 
echo "<link rel=\"stylesheet\" href=\"css/stylesheet1.css\" />"; 
echo "</head>"; 
*/

echo "<body>";
echo "<table align='center'><tr><th>GameName: $game</th></tr></table>";echo "<br /><br />";
echo "<div class='box sb2'>Step2 of 2<img src='green_check.png' alt='image of green check mark' height='30' width='30'>
<table><tr><td>A) Enter Question in 1st Column</td></tr><tr><td>B) Enter minimum of 2 Answers</td></tr><tr><td>C) Click the circle next to the Correct Answer</td></tr><tr><td>D) Repeat for all Questions in Quiz</td></tr><tr><td>E) Click Submit to SAVE Quiz</td></tr></table></div>";
echo "<form method='POST'>";
//echo "<table border='1'>";

//echo "</table>";//exit;
echo "<table border='1' align='center'>";
echo "<tr><th>line</th><th>Question</th><th>Answer1</th><th>Answer2</th><th>Answer3</th><th>Answer4</th><th>FYI (Optional)</th></tr>";
for($i=1;$i<=$questionC;$i++){
echo "<tr><td align=\"center\">$i</td>
<td><textarea name=\"question[$i]\" rows=\"4\" cols=\"30\">$question</textarea></td>
<td><input type=\"text\" name=\"ans1[$i]\" value=\"$ans1\" size=\"17\"><input type='radio' name='correct[$i]' value='a'></td>
<td><input type=\"text\" name=\"ans2[$i]\" value=\"$ans2\" size=\"17\"><input type='radio' name='correct[$i]' value='b'></td>
<td><input type=\"text\" name=\"ans3[$i]\" value=\"$ans3\" size=\"17\"><input type='radio' name='correct[$i]' value='c'></td>
<td><input type=\"text\" name=\"ans4[$i]\" value=\"$ans4\" size=\"17\"><input type='radio' name='correct[$i]' value='d'></td>
<td><textarea name=\"fyi[$i]\" rows=\"4\" cols=\"30\" placeholder='Enter additional info for correct answer. This info will only show up at End of Quiz' >$fyi</textarea></td>
</tr>";
}
$game_encode=urlencode($game);
   echo "<tr>
   <td><input type='hidden' name='gid' value='$gid'></td>
   <td><input type='hidden' name='game2' value='$game_encode'></td>
   <td align='center'><input type='submit' name='submit' value='Submit'></td>
</tr></form></table></body></html>";


exit;
}







?>