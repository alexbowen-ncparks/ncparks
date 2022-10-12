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
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

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
include("../../budget/menu1314.php");
//include ("widget1.php");

//include("widget1.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

echo "<br />";



//$query1="select pid from players where player='$player' ";

//echo "query1=$query1";exit;

//$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

//$num1=mysqli_num_rows($result1);
//$row1=mysqli_fetch_array($result1);

//extract($row1);

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


echo "<html>";
echo "<head>"; 
echo "<link rel=\"stylesheet\" href=\"css/stylesheet1.css\" />"; 
echo "</head>"; 
echo "<body>";
echo "<table><tr><th>New Game</th></tr></table>";
echo "<br />";
echo "<table><form action='questions.php' method='post'>";
echo "<tr>";

//echo "<td align='center'>GameID<br><input type='text' name='gid' value='$gid' size='5' READONLY></td>";
//$today=date(Ymd);
//echo "<td align='center'>Allocation Date<br><input type='text' name='allocation_date' value='$today' size='12' READONLY></td>";

echo "<td align=\"center\">GameName<br><input type=\"text\" name=\"game\" value=\"$game\" size=\"50\" autocomplete=\"off\"></td>";

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
$game2=urldecode($game2);
//echo "game2=$game2";echo "<br />";
$game2=addslashes($game2);
$rec2add=count($correct);
$query1a="insert into games set pid='$pid',game_name='$game2',qcount='$rec2add',author='$player' ";
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
$ques=addslashes($question[$j]);
$ans1a=addslashes($ans1[$j]);
$ans2a=addslashes($ans2[$j]);
$ans3a=addslashes($ans3[$j]);
$ans4a=addslashes($ans4[$j]);
	$query3.=", question='$ques'";
	$query3.=", a='$ans1a'";
	$query3.=", b='$ans2a'";
	$query3.=", c='$ans3a'";
	$query3.=", d='$ans4a'";
	$query3.=", answer='$correct[$j]'";
		//$v1=str_replace(",","",$allocation_amount[$j]);
	//$query.=", allocation_amount='$v1'";
		//$just=addslashes($justification[$j]);
	//$query.=", justification='$just'";
		
//echo "$query<br><br>";
if($correct[$j]!=""){
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");
//echo "query3=$query3";
}
	}
header("location: games.php");
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

echo "<html>";
echo "<head>"; 
echo "<link rel=\"stylesheet\" href=\"css/stylesheet1.css\" />"; 
echo "</head>"; 

echo "<body>";
echo "<table><tr><th>GameName: $game</th></tr></table>";echo "<br /><br />";
echo "<form method='POST'>";
//echo "<table border='1'>";

//echo "</table>";//exit;
echo "<table border='1'>";
echo "<tr><th>line</th><th>Question</th><th>Answer1</th><th>Answer2</th><th>Answer3</th><th>Answer4</th></tr>";
for($i=1;$i<=$questionC;$i++){
echo "<tr><td align=\"center\">$i</td>
<td><textarea name=\"question[$i]\" rows=\"4\" cols=\"30\">$question</textarea></td>
<td><input type=\"text\" name=\"ans1[$i]\" value=\"$ans1\" size=\"17\"><input type='radio' name='correct[$i]' value='a'></td>
<td><input type=\"text\" name=\"ans2[$i]\" value=\"$ans2\" size=\"17\"><input type='radio' name='correct[$i]' value='b'></td>
<td><input type=\"text\" name=\"ans3[$i]\" value=\"$ans3\" size=\"17\"><input type='radio' name='correct[$i]' value='c'></td>
<td><input type=\"text\" name=\"ans4[$i]\" value=\"$ans4\" size=\"17\"><input type='radio' name='correct[$i]' value='d'></td>
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