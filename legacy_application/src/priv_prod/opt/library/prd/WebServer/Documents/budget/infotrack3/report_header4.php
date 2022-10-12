<?php


//if($folder=="personal"){$shade_personal="class=cartRow";}
//if($folder=="community"){$shade_community="class=cartRow";}

if($category_selected==''){
echo "<table border=2 cellspacing=2>";
echo "<tr>";
echo
"<td><table border='1'><tr><td><font class='cartRow'><a href='projects_menu4.php?folder=$folder&add_record=y'>ProjectTracker</a></font></td></tr></table></td>";
echo "<form method=post autocomplete='off' action=projects_menu.php>";


       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	   //echo "<td align='center'><font color='brown'><input name='project_category' type='text' size='20' id='project_category'></td>"; 
	  //echo "<td align='center'><font color='brown'><textarea name='project_category' cols='25' rows='1'></textarea></td>";
	  echo "<td align='center'><font color='brown' size='5'><input name='project_category' type='text' size='20' id='project_category'></td>";
      
	   
	   //echo "<td></td>";
	   //echo "<td>Name</td>";
	   //echo "<td><input name='project_name' type='text' size='20' id='project_name'></td>";
       echo "<td><input type='submit' name='submit' value='Add_Project'>";			 
	   echo "</tr>";
	   	   
      // echo "<tr><th>Weblink</th><td><textarea name= 'weblink' rows='1' cols='40'></textarea></td></tr>";
	  // echo "<tr><td colspan='4' align='center'><input type='submit' value='UPDATE'></td></tr>";
	  echo "<input type='hidden' name='folder' value='$project_category'>";	
	  echo "<input type='hidden' name='note_group' value='$note_group'>";	
	  echo "<input type='hidden' name='folder' value='$folder'>";	
	  echo "<input type='hidden' name='category_selected' value='y'>";	
	  echo "<input type='hidden' name='add_record' value='y'>";	
	  echo "</form>";
 echo "</table>"; 
}

if($category_selected =='y' and $name_selected == '') 
{

echo "<table border='1'>";
echo "<tr>
<td><table border='1'><tr><td><font class='cartRow'><a href='projects_menu.php?folder=$folder&add_record=y'><img height='50' width='50' src='/budget/infotrack/icon_photos/mission_icon_photos_219.jpg' alt='teleconference' title='Teleconference'></img><br /><font color='brown'>Tele<br />Conference</font></a></font></td></tr></table></td>";

echo "<form method=post autocomplete='off' action=article_project_add.php>";
echo "<td align='center'><font color='brown' size='5' class=cartRow>$project_category</font><input name='project_name' type='text' size='20' id='project_name'>
      <input type='submit' name='submit' value='Add_Folder'></td>";
echo "</tr>";	
echo "<input type='hidden' name='project_category' value='$project_category'>";	
echo "<input type='hidden' name='folder' value='$folder'>";	
echo "<input type='hidden' name='note_group' value='$note_group'>";	
	  		 
    
echo "</form>";	

 echo "</table>";
 
}

if($category_selected =='y' and $name_selected == 'y' and $note_group == '') 
{

echo "<table border='1'>";
echo "<tr>

<td><font class='cartRow'><a href='projects_menu.php?folder=$folder&add_record=y'>ProjectTracker</a></font></td>

<td><a href='projects_menu.php?folder=$folder&project_category=$project_category&category_selected=y&add_record=y'><font size=5 color=brown class=cartRow><b>$project_category</b></font></a></td>

<td><font size=5 color=brown class=cartRow><b>$project_name</b></font></td>";




echo "</table>";
 
}

if($category_selected =='y' and $name_selected == 'y' and $note_group != '') 
{

if($note_group=='web'){$shade_web="class='cartRow'";}
if($note_group=='document'){$shade_documents="class='cartRow'";}
if($note_group=='note'){$shade_notes="class='cartRow'";}
if($note_group=='photo'){$shade_photos="class='cartRow'";}
if($note_group=='audio'){$shade_audio="class='cartRow'";}
if($note_group=='video'){$shade_video="class='cartRow'";}


echo "<table border='1'>";

echo "<tr>";
/*
echo "<td><font class='cartRow'><a href='projects_menu.php?folder=$folder&add_record=y'><img height='50' width='50' src='/budget/infotrack/icon_photos/mission_icon_photos_219.jpg' alt='teleconference' title='Teleconference'></img><br /><font color='brown'>Tele<br />Conference</font></a></font></td>";
*/

echo "<td><font class='cartRow'><img height='50' width='50' src='/budget/infotrack/icon_photos/mission_icon_photos_219.jpg' alt='teleconference' title='Teleconference'></img><br /><font color='brown'>Tele<br />Conference</font></font></td>";






echo "<td><a href='projects_menu.php?folder=$folder&project_category=$project_category&category_selected=y&add_record=y'><font size=5 color=brown class=cartRow><b>$project_category</b></font></a></td>";

echo "<td><font size=5 color=brown class=cartRow><b>$project_name</b></font></td>";








echo "</tr></table></td>";


echo "</table>";
 
}

?>
