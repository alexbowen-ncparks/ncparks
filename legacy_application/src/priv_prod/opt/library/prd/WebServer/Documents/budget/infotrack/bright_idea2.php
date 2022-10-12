<?php
//echo "hello world";//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}



//$file = "articles_menu.php";
//$lines = count(file($file));


$table="infotrack_projects";
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

$active_file=$_SERVER['SCRIPT_NAME'];
$active_file_request=$_SERVER['REQUEST_URI'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$playstation=$_SESSION['budget']['select'];
$playstation_center=$_SESSION['budget']['centerSess'];
//$pcode=$_SESSION['budget']['select'];

if($playstation=='ADM'){$playstation='ADMI';}
$player=$tempID;
$position=$beacnum;
//echo "playstation=$playstation<br />";
//echo "player=$player<br />";exit;
//echo "<pre>";print_r($_SERVER);"</pre>";

//echo "active_file=$active_file<br />";
//echo "active_file_request=$active_file_request<br />";


extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//if($level=='5' and $tempID !='Dodd3454')
//echo "pcode=$pcode";
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;


//include("../../../include/connectBUDGET.inc");// database connection parameters
//include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
//include("../../budget/~f_year.php");
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 




//include("../../budget/menu1314_v3.php");
include("../../budget/menu1314.php");
echo "<br />";
echo "<table align='center'><tr>";
echo "<td bgcolor='darkseagreen'><img height='50' width='50' src='/budget/infotrack/icon_photos/light_bulb1.png' alt='picture of light bulb'></img></td>";
echo "<th>\"Bright\" Ideas for NC State Parks</th></tr>
</table>";
echo "<br />";
include("fyear_header_bright_ideas.php");
//echo "<br />";
include("bright_idea_sectors.php");
//echo "<table>";
//echo "<tr>";
//echo "<th><font color='brown'>Comment</font></th>";
//echo "</tr>";

if($position=='60032793') //accountant 
{


echo "<script language='javascript' type='text/javascript'>
      window.onload = function() {
      document.getElementById('input3').focus();
}

function validateForm()
{
var x=document.forms['form3']['input3'].value;
var y=document.forms['form3']['input4'].value;
var z=document.forms['form3']['input5'].value;
if (x==null || x=='')
  {
  alert('Bright Idea missing info');
  return false;
  }
  
  if (y==null || y=='')
  {
  alert('Bright Idea missing info');
  return false;
  }  
  
  if (z==null || z=='')
  {
  alert('Bright Idea missing info');
  return false;
  }  
  
 
}

</script>


";

echo "<form method='post' action='bright_idea_add.php' name='form3' onsubmit='return validateForm()'  >";
echo "<table><tr>";
//echo "<td>";
//echo "<td><textarea name= 'player_note' rows='3' cols='100' placeholder='Bright Idea' id='input3' ></textarea></td>";
//echo"<br />"; 

echo "<td><textarea name= 'score_title' rows='1' cols='30' placeholder='Title' id='input4' ></textarea></td>";


  
//echo "<td><input type='text' name='incrementor' placeholder='Incrementor' id='input5' ></td>";

      
      
	  
//echo "<td><input type=submit name=submit value=Add_Comment></td>";
echo "<td><input type=submit name=submit value=Share></td>";
	  echo "<input type='hidden' name='gid' value='4'>";	   
	  echo "<input type='hidden' name='sector' value='$sector'>";	   
	 
echo "</tr>";
      

//include("charts/score_mission_bright_ideas_chart2_summary.php");

//echo"</td>";
//echo "</tr>
echo "</table>";
echo "</form>";
}

echo "<br />";

$player=$tempID;
//echo "playstation=$playstation<br />";
//echo "player=$player<br />";//exit;
/*
if($playstation=='ADMI' and $position=='60032781')  //budget officer 
{
$query4b="select * from mission_bright_ideas where 1 and gid='4' and fyear='$fyear'  order by cid desc ";
//echo "line 50 query4b=$query4b<br />";//exit;
}
*/
if($playstation=='ADMI' and ($position=='60032793' or $position=='60036015' or $position=='60032791' or $position=='60032997' or $position=='60032781'))   //accountant or accounts receivable (Rumble) purchasing officer (Barbour)  accounts payable (Gooding) budget officer (dodd)
{
$query4b="select * from mission_bright_ideas where 1 and gid='4' and fyear='$fyear' and park='$sector' order by score_title asc ";
echo "line 50 query4b=$query4b<br />"; //exit;
}

/*
if($playstation!='ADMI')
{
$query4b="select * from mission_bright_ideas where 1 and gid='4' and park='$playstation' and fyear='$fyear' order by cid desc ";
//echo "line 56 query4b=$query4b<br />";//exit;
}
*/

//echo "query4b=$query4b<br />";	
 
$result4b = mysqli_query($connection, $query4b) or die ("Couldn't execute query 4b.  $query4b");
$num4b=mysqli_num_rows($result4b);



//echo "num4b=$num4b<br />";	

echo "<table><tr><th>Count: $num4b</th>";
if($position=='60032793'){echo "<td><a href='bright_idea2.php?edit=y&sector=$sector'>Edit</a></td>";}
echo "</tr></table>";	
//echo "playstation=$playstation<br />";
//echo "player=$player<br />";exit;


//echo "query4b=$query4b";//exit;
//echo "<br /><table><tr><td><font  color=red>Bright Ideas: $num4b  </font></td></tr></table><br />";
echo "<table border='5'>";
/*
echo "<tr>";
//echo "<td><font color='brown'>Location</font></td>";
echo "<td align='center'><font color='brown'>Player</font></td>";
//echo "<td align='center'><font color='brown'>Date</font></td>";
echo "<td align='center'><font color='brown'>Comment</font></td>";
echo "<td><font color='brown'>Status</font></td>";
echo "<td><font color='brown'>ID</font></td>";

echo "</tr>";
*/
if($edit=='y')
{
echo  "<form method='post' autocomplete='off' action='bright_idea_update.php'>";
while ($row4b=mysqli_fetch_array($result4b)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4b);
$countid=number_format($countid,0);
$rank=$rank+1;
//$system_entry_date2=date("F j, Y", strtotime($system_entry_date));
$play_date2=date("n/d/y", strtotime($play_date));
$score_date2=date("n/d/y", strtotime($score_date));
//echo "date2=$date2";

if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
$player2=substr($player,0,-2);
$scorer2=substr($scorer,0,-2);
//echo "tempID=$tempID <br />";
//echo "user=$user <br />";
//echo "user2=$user2 <br />";
//if($status=='fi'){$color='light green';}else{$color='light pink';}
if($status=="fi"){$bgc="lightgreen";} else {$bgc="#dfe687";}
//include("scoring/score_mission_bright_ideas.php");
echo "<tr bgcolor='$bgc'>"; 
//echo "<tr$t>"; 
//echo "<td>$rank</td>";
 //echo "<td><font color='brown'>$park</font></td>";
 //echo "<td><font color='brown'>$user2</font></td>";
 //echo "<td>$system_entry_date</font></td>"; 
//echo "scorer_note=$scorer_note";exit;
/*
if($position=='60032793')
{
 if($scorer_note!='')
 
 {
 echo "<td>$park $player2 $score_title $play_date2 <textarea name='player_note[]' cols='100' rows='3' >$player_note</textarea><br />&nbsp&nbsp&nbsp&nbsp&nbsp $scorer2 $scorer_note $score_date2</td> ";
 }
 else 
 {
 echo "<td>$park $player2 $play_date2<br /><textarea name='player_note[]' cols='100' rows='3' >$player_note</textarea><br />&nbsp&nbsp&nbsp&nbsp&nbsp Thanks. Response coming soon</td> ";
 }
} 
*/
//echo "position=$position";
if($position=='60032793')  //accountant
{
/*
 if($scorer_note!='')
 
 {
echo "<td><font color='seagreen'><b>$complete of $total_points</b></font>";
include("charts/score_mission_bright_ideas_chart2.php");
echo"</td>";

 echo "<td>$park $player2 $score_title $play_date2 <textarea name='player_note[]' cols='100' rows='3' >$player_note</textarea>
 </td> ";
 
 }
 else 
 {
echo "<td><font color='seagreen'><b>$complete of $total_points</b></font>";
include("charts/score_mission_bright_ideas_chart2.php");
echo"</td>";

 echo "<td>$park $player2 $play_date2<br /><textarea name='player_note[]' cols='100' rows='3' >$player_note</textarea></td> ";
 }
 
*/
 
 echo "<td><font color='seagreen'><b>$complete of $total_points</b></font>";
include("charts/score_mission_bright_ideas_chart2.php");
echo"</td>";
//$player_note=str_replace("\r\n","\n",$player_note);
 //echo "<td>$park $player2 $score_title $play_date2 <textarea name='player_note[]' cols='100' rows='3' >$player_note</textarea></td> ";
 echo "<td>$score_title $play_date2<br /> <textarea name='player_note[]' cols='80' rows='6' >$player_note</textarea></td> ";
 
 
} 
/*
if($position!='60032793')
{
 if($scorer_note!='')
 
 {
 echo "<td>$park $player2 $score_title $play_date2 <textarea name='player_note[]' cols='100' rows='3' readonly='yes'>$player_note</textarea><br />&nbsp&nbsp&nbsp&nbsp&nbsp $scorer2 $scorer_note $score_date2</td> ";
 }
 else 
 {
 echo "<td>$park $player2 $play_date2<br /><textarea name='player_note[]' cols='100' rows='3' readonly='yes'>$player_note</textarea><br />&nbsp&nbsp&nbsp&nbsp&nbsp Thanks. Response coming soon</td> ";
 }
} 
*/

if($position!='60032793')  //accountant

{
/*
 if($scorer_note!='')
 
 {
 echo "<td>$park $player2 $score_title $play_date2 <textarea name='player_note[]' cols='100' rows='3' readonly='yes'>$player_note</textarea></td> ";
 }
 else 
 {
 echo "<td>$park $player2 $play_date2<br /><textarea name='player_note[]' cols='100' rows='3' readonly='yes'>$player_note</textarea></td> ";
 }
 
 */
 
 
 echo "<td><font color='seagreen'><b>$complete of $total_points</b></font>";
include("charts/score_mission_bright_ideas_chart2.php");
echo"</td>";

 //echo "<td>$park $player2 $score_title $play_date2 <textarea name='player_note[]' cols='100' rows='3' >$player_note</textarea></td> "; 
 echo "<td>$score_title $play_date2 <textarea name='player_note[]' cols='50' rows='6' >$player_note</textarea></td> "; 
 
 
} 

if($position=='60032793')  //accountant
{
echo "<td><font color=$color><input type='text' size='1' name='status[]' value='$status' ></font><br /><input type='text' size='1' name='complete[]' value='$complete'><br /><input type='text' size='1' name='total_points[]' value='$total_points'></td>";
}
else
{
echo "<td><font color=$color><input type='text' size='1' name='status[]' value='$status' readonly='readonly'></font></td>";
}





/*
if($position=='60032793')
{echo "<td><input type='text' size='1' name='cid[]' value='$cid' readonly='readonly'><br /><a href='bright_idea_steps2_v2.php?cid=$cid&blog=n'>Steps</a></td>";}
else
{echo "<td><input type='text' size='1' name='cid[]' value='$cid' readonly='readonly'></td>";}
*/
if($position=='60032793') //accountant
{echo "<td><input type='text' size='1' name='cid[]' value='$cid' readonly='readonly'></td>";}
else
{echo "<td><input type='text' size='1' name='cid[]' value='$cid' readonly='readonly'></td>";}
//echo "<td><input type='text' size='1' name='complete[]' value='$complete'></td>";

//echo "<td>$color</td>";


//echo "<td>$status</td>"; 

	          
echo "</tr>";

}
echo "<tr><th align='left'><input type='submit' name='submit2' value='Update'></th></tr>";
echo "<input type='hidden' name='pid' value='$pid'>";
echo "<input type='hidden' name='sector' value='$sector'>";
echo "<input type='hidden' name='num4b' value='$num4b'>";
echo   "</form>";
}

if($edit=='')
{
//echo  "<form method='post' autocomplete='off' action='bright_idea_update.php'>";
while ($row4b=mysqli_fetch_array($result4b)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4b);
$countid=number_format($countid,0);
$rank=$rank+1;
//$system_entry_date2=date("F j, Y", strtotime($system_entry_date));
$play_date2=date("n/d/y", strtotime($play_date));
$score_date2=date("n/d/y", strtotime($score_date));
//echo "date2=$date2";

if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
$player2=substr($player,0,-2);
$scorer2=substr($scorer,0,-2);
//echo "tempID=$tempID <br />";
//echo "user=$user <br />";
//echo "user2=$user2 <br />";
//if($status=='fi'){$color='light green';}else{$color='light pink';}
if($status=="fi"){$bgc="lightgreen";} else {$bgc="#dfe687";}
//include("scoring/score_mission_bright_ideas.php");
echo "<tr bgcolor='$bgc'>"; 

//if($position=='60032793')  //accountant
//{

 
 echo "<td><font color='seagreen'><b>$complete of $total_points</b></font>";
include("charts/score_mission_bright_ideas_chart2.php");
echo"</td>";
//$player_note=str_replace("\r\n","\n",$player_note);
 //echo "<td>$park $player2 $score_title $play_date2 <textarea name='player_note[]' cols='100' rows='3' >$player_note</textarea></td> ";
 $player_note=htmlspecialchars_decode($player_note);
 $player_note=nl2br($player_note);
 echo "<td>$score_title<br /> $play_date2</td><td>$player_note</td> ";
 
 
//} 

/*
if($position!='60032793')  //accountant

{

 
 
 echo "<td><font color='seagreen'><b>$complete of $total_points</b></font>";
include("charts/score_mission_bright_ideas_chart2.php");
echo"</td>";

 //echo "<td>$park $player2 $score_title $play_date2 <textarea name='player_note[]' cols='100' rows='3' >$player_note</textarea></td> "; 
 echo "<td>$score_title $play_date2 <textarea name='player_note[]' cols='100' rows='3' >$player_note</textarea></td> "; 
 
 
} 
*/
/*
if($position=='60032793')  //accountant
{
echo "<td><font color=$color><input type='text' size='1' name='status[]' value='$status' ></font></td>";
}
else
{
echo "<td><font color=$color><input type='text' size='1' name='status[]' value='$status' readonly='readonly'></font></td>";
}
*/




/*
if($position=='60032793')
{echo "<td><input type='text' size='1' name='cid[]' value='$cid' readonly='readonly'><br /><a href='bright_idea_steps2_v2.php?cid=$cid&blog=n'>Steps</a></td>";}
else
{echo "<td><input type='text' size='1' name='cid[]' value='$cid' readonly='readonly'></td>";}
*/
if($position=='60032793') //accountant
{echo "<td><input type='text' size='1' name='cid[]' value='$cid' readonly='readonly'></td>";}
else
{echo "<td><input type='text' size='1' name='cid[]' value='$cid' readonly='readonly'></td>";}


echo "<td>$color</td>";


//echo "<td>$status</td>"; 

	          
echo "</tr>";

}
//echo "<tr><th align='left'><input type='submit' name='submit2' value='Update'></th></tr>";
//echo "<input type='hidden' name='pid' value='$pid'>";
//echo "<input type='hidden' name='num4b' value='$num4b'>";
//echo   "</form>";
}
 echo "</table>";













 ?>
 