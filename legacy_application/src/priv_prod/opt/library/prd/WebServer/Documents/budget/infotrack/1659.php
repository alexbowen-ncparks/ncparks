<?php
echo "<table>";
echo "<tr>";
//echo "<th><font color='brown'>Comment</font></th>";
echo "</tr>";

//echo "<td></td>";

echo "<script language='javascript' type='text/javascript'>
      window.onload = function() {
      document.getElementById('input3').focus();
}

function validateForm()
{
var x=document.forms['form3']['input3'].value;
var y=document.forms['form3']['input4'].value;
if (x==null || x=='')
  {
  alert('Please enter Comment');
  return false;
  }
 if (y==null || y=='')
  {
  alert('Please enter ParkCode');
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
where mission_bright_ideas.cid='295' order by cid2 ";
$result4b = mysqli_query($connection, $query4b) or die ("Couldn't execute query 4b.  $query4b");
$num4b=mysqli_num_rows($result4b);
echo "query4b=$query4b";

echo "<form method='post' action='/budget/infotrack/comment_add.php' name='form3' onsubmit='return validateForm()'  >";
if($level>'3')
{
//echo "<td><input name='location' type='text'  value='$concession_location' autocomplete='off'></td>";

echo "<td><input name='location' type='text' placeholder='ParkCode receiving message' id='input4' </td>";



}

echo "<td><textarea name= 'comment_note' rows='6' cols='75' placeholder='Type Comment here' id='input3' ></textarea></td>";            
      
echo "<td><input type=submit name=submit value=Add_Comment></td>";
	  //echo "<input type='hidden' name='project_category' value='$project_category'>";	   
	 //echo "<input type='hidden' name='project_name' value='$project_name'>";	   
	 echo "<input type='hidden' name='project_note' value='$project_note'>";	   
	 //echo "<input type='hidden' name='weblink' value='$weblink'>";	   
	 echo "<input type='hidden' name='note_group' value='$note_group'>";	   
	 echo "<input type='hidden' name='folder' value='$folder'>";	   
	 echo "<input type='hidden' name='project_note_id' value='$project_note_id'>";	   
	 echo "<input type='hidden' name='tempID' value='$tempID'>";	   
	 echo "<input type='hidden' name='concession_location' value='$concession_location'>";	   
	 echo "</form>";
echo "</tr>";
      
	 
echo "</table>";

//echo "<br />";


if($show_order==''){$shade_oldest="class=cartRow";}
if($show_order=='newest'){$shade_newest="class=cartRow";}
if($show_order=='oldest'){$shade_oldest="class=cartRow";}

//echo "shade_oldest=$shade_oldest";
echo "<table><tr>";
echo "<td><a href='/budget/infotrack/notes.php?comment=y&add_comment=y&project_note=$project_note&folder=community&category_selected=y&name_selected=y&show_order=newest'><font size='3' $shade_newest>Newest on top</font></a></td>";
echo "<td><a href='/budget/infotrack/notes.php?comment=y&add_comment=y&project_note=$project_note&folder=community&category_selected=y&name_selected=y&show_order=oldest'><font size='3' $shade_oldest>Newest on bottom</font></a></td>";

echo "</tr></table>"; 

echo "<br />";
if($message=='1'){echo "<font color='red' size='5'><b>Update Successful</b></font>";$message=="";}
//echo "<br />num4b=$num4b";
if($num4b==0){echo "<br /><table><tr><td><font  color=red>No Notes1</font></td></tr></table>";}
if($num4b!=0)
{
//echo "<h2 ALIGN=left><font color=brown class=cartRow>Records: $num5</font></h2>";
if($num4b==1)
{echo "<br /><table><tr><td><font  color=red>Notes: $num4b</font></td></tr></table>";}

if($num4b>1)
{echo "<br /><table><tr><td><font  color=red>Notes: $num4b  </font></td></tr></table>";}


echo "<table border='1'>";

echo "<tr>
<th><font color='brown'>cid</font></th>
<th><font color='brown'>cid2</font></th>
<th><font color='brown'>player2</font></th>
<th><font color='brown'>scorer_note2</font></th>
<th><font color='brown'>status2</font></th>

</tr>";

echo  "<form method='post' autocomplete='off' action='/budget/infotrack/alert_comment_update.php'>";
while ($row4b=mysqli_fetch_array($result4b)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4b);
$system_entry_date=date('m-d-y', strtotime($system_entry_date));
$countid=number_format($countid,0);
$rank=$rank+1;

if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
$user=substr($user,0,-2);
//if($status=='fi'){$color='light green';}else{$color='light pink';}
if($status2=="fi"){$bgc="lightgreen";} else {$bgc="lightpink";}
/*
echo "<tr bgcolor='$bgc'>"; 
 echo "<td><font color='brown'>$park</font></td>";
 echo "<td><font color='brown'>$user</font></td>";
 echo "<td>$system_entry_date</font></td>"; 
 echo "<td><textarea name='comment_note[]' cols='70' rows='6'>$comment_note</textarea></td> ";
echo "<td><font color=$color><input type='text' size='1' name='status[]' value='$status'></font></td>";
echo "<td><input type='text' size='1' name='comment_id[]' value='$cid' readonly='readonly'</td>";
echo "</tr>";
*/
echo "<tr bgcolor='$bgc'>"; 
echo "<td><font color='brown'>$cid</font></td>";
//echo "<td><font color='brown'>$gid</font></td>";
//echo "<td><font color='brown'>$park</font></td>";
//echo "<td><font color='brown'>$player</font></td>";
//echo "<td><font color='brown'>$player_note</font></td>";
//echo "<td><font color='brown'>$play_date</font></td>";
//echo "<td><font color='brown'>$scorer</font></td>";
//echo "<td><font color='brown'>$score_title</font></td>";
//echo "<td><font color='brown'>$scorer_note</font></td>";
//echo "<td><font color='brown'>$score_date</font></td>";
//echo "<td><font color='brown'>$status</font></td>";
echo "<td><font color='brown'>$cid2</font></td>";
echo "<td><font color='brown'>$player2</font></td>";
echo "<td><font color='brown'>$scorer_note2</font></td>";
//echo "<td><font color='brown'>$score_date</font></td>";
echo "<td><font color='brown'>$status2</font></td>";
echo "</tr>";






}
/*
if($level=='5')
{
echo "<tr><td colspan='8' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";
}
*/
echo "<input type='hidden' name='project_note_id' value='$project_note_id'>";
echo "<input type='hidden' name='num4b' value='$num4b'>";
echo "<input type='hidden' name='project_note' value='$project_note'>";
echo   "</form>";
 echo "</table>";
 }


 ?>
 
