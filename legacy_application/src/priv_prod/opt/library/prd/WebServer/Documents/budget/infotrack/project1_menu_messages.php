<?php
if($folder=='personal')
{

$query4="select project_note,document_location,note_group,project_note_id from infotrack_projects where 1 
         and user='$tempID' 
		 and project_category='$project_category'
		 and project_name='$project_name'
		 and note_group='$note_group'
         order by project_note_id desc";

//echo $query4;		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);
}

if($folder=='community')
{
$query4="select project_note,document_location,note_group,project_note_id from infotrack_projects_community
         where 1 
         and project_category='$project_category'
		 and project_name='$project_name'
		 and note_group='$note_group'
         order by project_note_id desc";

//echo $query4;		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);
}






//echo "<table border=1>";


//echo "<table><tr><td><font color='brown'>Category:</font><font color='red'> $project_category </font></td></tr></table>";
//echo "<table border=1><tr><td><font color='brown'>Project Name:</font><font color='red'> $project_name </font></td></tr></table>";
//echo "<table><tr><td><font color='brown'>Notes:</font><font color='red'> $num4 </font></td></tr></table>";
//echo "<table><tr><td><font color='brown'>Notes:</font><font color='red'> $num4 </font></td></tr></table>";
/*
echo "<br />";
include("report_header2.php");
echo "<br />";
*/



//echo "<table border=1><tr><td><font size=5 color=brown class='cartRow'><b>$project_category</b></font></td></tr></table>";

//echo "<br />";
//include("report_header2.php");
//echo "<br />";

//echo "<table border=1><tr><td>$num4</td></tr></table>";
//echo "<table border=5 cellspacing=5>";
//echo "<table>";
//echo "<tr>";
if($add_record=='')
{
echo "<table><tr>";
echo "<td><a href='project1_menu.php?folder=$folder&project_category=$project_category&category_selected=y&project_name=$project_name&name_selected=y&note_group=$note_group&add_record=y'>Add</a></td>";
echo "</tr></table>"; 
}

if($add_record=='y' and $note_group=='message')
{

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;

//echo "<th align=left><A href='articles_community_edit.php'>Download from Community</A></th><th><A href='article_add.php?&add_your_own=y'>Add your own</A></th>";
//echo "<tr><th align=left><A href='articles_community_edit.php'>Community</A></th></tr>";
echo "<table>";
echo "<th><font color='brown'>Message</font></th>";
echo "<tr>";

//echo "<td></td>";
echo "<form method=post action=message_add.php>";
echo "<td><textarea name= 'project_note' rows='2' cols='20' ></textarea></td>";       
      if($folder=='personal'){echo "<td><input type=submit name=submit value=Add_Message></td>";}
	  if($folder=='community'){echo "<td><input type=submit name=submit value=Add_Message></td>";}
	  echo "<input type='hidden' name='project_category' value='$project_category'>";	   
	 echo "<input type='hidden' name='project_name' value='$project_name'>";	   
	 echo "<input type='hidden' name='note_group' value='$note_group'>";	   
	 echo "<input type='hidden' name='folder' value='$folder'>";	   
	 echo "</form>";
echo "</tr>";
      // echo "<tr><th>Weblink</th><td><textarea name= 'weblink' rows='1' cols='40'></textarea></td></tr>";
	  // echo "<tr><td colspan='4' align='center'><input type='submit' value='UPDATE'></td></tr>";
	 // echo "</table>";
	 // echo "<input type='hidden' name='project_category' value='$project_category'>";	
	 
echo "</table>";
}
echo "<br />";



echo "<table border=1>";

//echo "<tr><td><font color='brown'>WebPages:</font><font color='red'> $num4 </font></td></tr>";


while ($row4=mysqli_fetch_array($result4)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4);
$countid=number_format($countid,0);
$rank=$rank+1;

if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}


echo 

"<tr$t>"; 
//echo "<td>$rank</td>";  
echo "<td><a href='$document_location'>$project_note</a></td> 
	          
</tr>";

}

 echo "</table>";
 
 ?>
 