<?php
$order1="order by project_note_id desc";
if($comment=='')
{

if($folder=='personal')
{

$query4="select user,system_entry_date,project_note,document_location,note_group,comment_id,project_note_id from 
         infotrack_projects where 1 
         and user='$tempID' 
		 and project_category='$project_category'
		 and project_name='$project_name'
		 and note_group='$note_group'
		 and comment_id=''
         $order1 ";

//echo $query4;		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);
}

if($folder=='community')
{
$query4="select user,system_entry_date,project_note,document_location,note_group,comment_id,project_note_id from
         infotrack_projects_community
         where 1 
         and project_category='$project_category'
		 and project_name='$project_name'
		 and note_group='$note_group'
		 and comment_id=''
         $order1 ";

//echo $query4;		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);
//echo "query4=$query4";
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

//if($add_record=='y' and $note_group=='note' ) change to row below on 7/2/12
if($add_record=='y' and $note_group=='note' and $tempID='tony' ) 
{

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;

//echo "<th align=left><A href='articles_community_edit.php'>Download from Community</A></th><th><A href='article_add.php?&add_your_own=y'>Add your own</A></th>";
//echo "<tr><th align=left><A href='articles_community_edit.php'>Community</A></th></tr>";
echo "<table>";
echo "<tr>";
echo "<th><font color='brown'>Note#</font></th>";
echo "</tr>";
echo "<tr>";
//echo "<td></td>";
echo "<form method=post action=note_add.php>";
echo "<td><input type='text' name='note_title' value='$note_title'></textarea></td>";     
      if($folder=='personal'){echo "<td><input type=submit name=submit value=Enter></td>";}
	  if($folder=='community'){echo "<td><input type=submit name=submit value=Enter></td>";}
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
/*
echo "<table border=1>";
echo "<tr>";
echo "<td><font size=5 color=brown class=cartRow><b>$project_name</b></font></td>";
echo "</tr>";
echo "</table>";
*/
echo "<br />";
echo "<table border=1>";

//echo "<tr><td><font color='brown'>WebPages:</font><font color='red'> $num4 </font></td></tr>";
//echo "<tr><td><font color=brown>Member</font></td><td><font color=brown>Note</font></td></tr>";


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

//echo "<td>$system_entry_date</td>"; 
//echo "<td>$user</td>"; 

echo "<td>$project_note</td>"; 
echo "<td><a href='project1_menu.php?comment=y&add_comment=y&folder=$folder&project_category=$project_category&category_selected=y&project_name=$project_name&name_selected=y&note_group=$note_group&project_note_id=$project_note_id'>Comments</a></td>"; 
//echo "<td>$comment_id</td>"; 
//echo "<td>$project_note_id</td>"; 
	          
echo "</tr>";
}

 echo "</table>";
 
 }
 
 if($comment=='y') 
//{echo "<font color='brown' size='5'>Oops:Comments feature is under Construction. Sorry for inconvenience<br /><br />Click the BACK button on your Browser to return to previous Page</font><br />";exit;}
 {
 
if($show_order==''){$order2="order by project_note_id desc";}
if($show_order=='newest'){$order2="order by project_note_id desc";}
if($show_order=='oldest'){$order2="order by project_note_id asc";}

//echo "order2=$order2";
//$order2="order by project_note_id desc";



if($folder=='personal')
{

$query4a="select project_note from infotrack_projects where project_note_id='$project_note_id' ";

//echo $query4;		 
$result4a = mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");
$num4a=mysqli_num_rows($result4a);

$query4b="select user,project_note,comment_note,weblink,note_group,project_note_id from infotrack_projects where 1 
         and user='$tempID' 
		 and project_category='$project_category'
		 and project_name='$project_name'
		 and note_group='$note_group'
		 and comment_id='$project_note_id'
		 $order2 ";

//echo $query4;		 
$result4b = mysqli_query($connection, $query4b) or die ("Couldn't execute query 4b.  $query4b");
$num4b=mysqli_num_rows($result4b);

}

if($folder=='community')
{

$query4a="select project_note from infotrack_projects_community where project_note_id='$project_note_id' ";

//echo $query4;		 
$result4a = mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");
$num4a=mysqli_num_rows($result4a);


$query4b="select user,project_note,comment_note,weblink,note_group,project_note_id from infotrack_projects_community
         where 1 
         and project_category='$project_category'
		 and project_name='$project_name'
		 and note_group='$note_group'
		 and comment_id='$project_note_id'
         $order2 ";

//echo $query4;		 
$result4b = mysqli_query($connection, $query4b) or die ("Couldn't execute query 4b.  $query4b");
$num4b=mysqli_num_rows($result4b);
//echo "query4=$query4";exit;


}
$row4a=mysqli_fetch_array($result4a);
extract($row4a);


//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;

//echo "<th align=left><A href='articles_community_edit.php'>Download from Community</A></th><th><A href='article_add.php?&add_your_own=y'>Add your own</A></th>";
//echo "<tr><th align=left><A href='articles_community_edit.php'>Community</A></th></tr>";


echo "<table>";
echo "<tr>";
//echo "<td><font color='brown'>Comments</font></td>";
echo "<td><font color=brown class='cartRow'>$project_note</font></td>";
echo "</table>";
echo "<br />";


if($add_comment=='')
{
echo "<table><tr>";
echo "<td><a href='project1_menu.php?comment=y&add_comment=y&project_note_id=$project_note_id&folder=$folder&project_category=$project_category&category_selected=y&project_name=$project_name&name_selected=y&note_group=$note_group'>Add</a></td>";
echo "</tr></table>"; 
}

if($add_comment=='y')
{


echo "<table>";
echo "<tr>";
//echo "<th><font color='brown'>Comment</font></th>";
echo "</tr>";

//echo "<td></td>";
echo "<form method=post action=comment_add.php>";
echo "<td><textarea name= 'comment_note' rows='5' cols='80' ></textarea></td>";            
      
	  if($folder=='personal'){echo "<td><input type=submit name=submit value=Add_Comment></td>";}
	  if($folder=='community'){echo "<td><input type=submit name=submit value=Add_Comment></td>";}
	  echo "<input type='hidden' name='project_category' value='$project_category'>";	   
	 echo "<input type='hidden' name='project_name' value='$project_name'>";	   
	 echo "<input type='hidden' name='project_note' value='$project_note'>";	   
	 //echo "<input type='hidden' name='weblink' value='$weblink'>";	   
	 echo "<input type='hidden' name='note_group' value='$note_group'>";	   
	 echo "<input type='hidden' name='folder' value='$folder'>";	   
	 echo "<input type='hidden' name='project_note_id' value='$project_note_id'>";	   
	 echo "</form>";
echo "</tr>";
      // echo "<tr><th>Weblink</th><td><textarea name= 'weblink' rows='1' cols='40'></textarea></td></tr>";
	  // echo "<tr><td colspan='4' align='center'><input type='submit' value='UPDATE'></td></tr>";
	 // echo "</table>";
	 // echo "<input type='hidden' name='project_category' value='$project_category'>";	
	 
echo "</table>";
}
//echo "<br />";

//echo "query4b=$query4b";
if($show_order==''){$shade_newest="class=cartRow";}
if($show_order=='newest'){$shade_newest="class=cartRow";}
if($show_order=='oldest'){$shade_oldest="class=cartRow";}

//echo "shade_oldest=$shade_oldest";
echo "<table><tr>";

echo "<td><a href='project1_menu.php?comment=y&add_comment=y&project_note_id=$project_note_id&folder=$folder&project_category=$project_category&category_selected=y&project_name=$project_name&name_selected=y&note_group=$note_group&show_order=newest'><font size='3' $shade_newest>Newest on top</font></a></td>";
echo "<td><a href='project1_menu.php?comment=y&add_comment=y&project_note_id=$project_note_id&folder=$folder&project_category=$project_category&category_selected=y&project_name=$project_name&name_selected=y&note_group=$note_group&show_order=oldest'><font size='3' $shade_oldest>Oldest on top</font></a></td>";

echo "</tr></table>"; 

echo "<br />";
//echo "query4b=$query4b";


echo "<table>";

//echo "<tr><td><font color='brown'>Member</font></td><td><font color='brown'>Comment</font></td></tr>";


while ($row4b=mysqli_fetch_array($result4b)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4b);
$countid=number_format($countid,0);
$rank=$rank+1;

if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}


echo 

"<tr$t>"; 
//echo "<td>$rank</td>"; 
 echo "<td><font color='brown'>$user</font></td>"; 
echo "<td>$comment_note</td>"; 

	          
echo "</tr>";

}

 echo "</table>";

 }
 
  
 ?>
 