<?php
//echo "<table>";
//echo "<tr>";
//echo "<th><font color='brown'>Comment</font></th>";
//echo "</tr>";

echo "<td>";

echo "<script language='javascript' type='text/javascript'>
      window.onload = function() {
      document.getElementById('input3').focus();
}

function validateForm()
{
var x=document.forms['form3']['input3'].value;
if (x==null || x=='')
  {
  alert('Comment missing');
  return false;
  }
}


</script>


";

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters

extract($_REQUEST);
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
$query4b="SELECT mission_bright_ideas.cid,gid,park,player,player_note,play_date,scorer,score_title,scorer_note,score_date,status,cid2,player2,scorer_note2,score_date,status2
from mission_bright_ideas
left join mission_bright_ideas2 
on mission_bright_ideas.cid=
mission_bright_ideas2.cid
where mission_bright_ideas.cid='$cid' order by cid2 ";
$result4b = mysqli_query($connection, $query4b) or die ("Couldn't execute query 4b.  $query4b");
$num4b=mysqli_num_rows($result4b);
//echo "query4b=$query4b";

echo "<form method='post' action='/budget/infotrack/bright_idea_comment_add.php' name='form3' onsubmit='return validateForm()'  >";
//if($level>'3')
//{
//echo "<td><input name='location' type='text'  value='$concession_location' autocomplete='off'></td>";

//echo "<td><input name='location' type='text' placeholder='ParkCode receiving message' id='input4' </td>";



//}

echo "<td><textarea name= 'comment_note' rows='3' cols='115' placeholder='Type Comment here' id='input3' ></textarea><br />";            
      
echo "<input type=submit name=submit value=Add_Comment></td>";
	  //echo "<input type='hidden' name='project_category' value='$project_category'>";	   
	 //echo "<input type='hidden' name='project_name' value='$project_name'>";	   
	 echo "<input type='hidden' name='cid' value='$cid'>";	   
	 echo "<input type='hidden' name='scorer' value='$scorer'>";	   
	 echo "</form>";
echo "</tr>";
      
	 
echo "</table>";

//echo "<br />";

/*
if($show_order==''){$shade_oldest="class=cartRow";}
if($show_order=='newest'){$shade_newest="class=cartRow";}
if($show_order=='oldest'){$shade_oldest="class=cartRow";}

echo "<table><tr>";
echo "<td><a href='/budget/infotrack/notes.php?comment=y&add_comment=y&project_note=$project_note&folder=community&category_selected=y&name_selected=y&show_order=newest'><font size='3' $shade_newest>Newest on top</font></a></td>";
echo "<td><a href='/budget/infotrack/notes.php?comment=y&add_comment=y&project_note=$project_note&folder=community&category_selected=y&name_selected=y&show_order=oldest'><font size='3' $shade_oldest>Newest on bottom</font></a></td>";

echo "</tr></table>"; 
*/
echo "<br />";
if($message=='1'){echo "<font color='red' size='5'><b>Update Successful</b></font>";$message=="";}
//echo "<br />num4b=$num4b";
if($num4b==0){echo "<br /><table><tr><td><font  color=red>No Notes1</font></td></tr></table>";}
if($num4b!=0)
{
//echo "<h2 ALIGN=left><font color=brown class=cartRow>Records: $num5</font></h2>";
/*
if($num4b==1)
{echo "<br /><table><tr><td><font  color=red>$num4b</font></td></tr></table>";}

if($num4b>1)
{echo "<br /><table><tr><td><font  color=red>$num4b</font></td></tr></table>";}
*/

echo "<table border='1'>";

echo  "<form method='post' autocomplete='off' action='/budget/infotrack/bright_idea_comment_update.php'>";
while ($row4b=mysqli_fetch_array($result4b)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4b);
$system_entry_date=date('m-d-y', strtotime($system_entry_date));
$countid=number_format($countid,0);
$rank=$rank+1;

//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
$user=substr($user,0,-2);
//if($status=='fi'){$color='light green';}else{$color='light pink';}
if($status2=="fi"){$bgc="lightgreen";} else {$bgc="lightgreen";}

echo "<tr bgcolor='$bgc'>"; 

echo "<td><textarea name='scorer_note2[]' cols='115' rows='6'>$scorer_note2</textarea></td> ";
echo "<td><textarea name='cid2[]' cols='3' rows='1' readonly='readonly'>$cid2</textarea></td> ";

echo "</tr>";

}

echo "<tr><td colspan='8' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";

echo "<input type='hidden' name='cid' value='$cid'>";
echo "<input type='hidden' name='num4b' value='$num4b'>";
echo   "</form>";
 echo "</table>";
 }


 ?>
 
