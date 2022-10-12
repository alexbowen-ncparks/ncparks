<?php
if($comment=='')
{

if($folder=='community')
{
$query4="select project_note,weblink,note_group,project_note_id,record_complete from infotrack_projects_community
         where 1 
         and project_category='$project_category'
		 and project_name='$project_name'
		 and note_group='$note_group'
		 and comment_id=''
         order by project_note_id desc";

//echo $query4;		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);
//echo "query4=$query4";exit;


}

/*
if($add_record=='')
{
echo "<table><tr>";
echo "<td><a href='project1_menu.php?folder=$folder&project_category=$project_category&category_selected=y&project_name=$project_name&name_selected=y&note_group=$note_group&add_record=y'>Add</a></td>";
echo "</tr></table>"; 
echo "<br />";
}
*/
/*
if($add_record=='y' and $note_group=='web')
{

echo "<table>";
echo "<tr>";
echo "<th><font color='brown'>Page Title</font></th><th><font color='brown'>Page Address</th></font>";
echo "</tr>";

//echo "<td></td>";
echo "<form method=post action=article_add2.php>";
echo "<tr>";
echo "<td><textarea name= 'project_note' rows='1' cols='20' ></textarea></td>            
      <td><textarea name= 'web_address' rows='1' cols='20'></textarea></td>";
	  if($folder=='personal'){echo "<td><input type=submit name=submit value=Add_WebPage></td>";}
	  if($folder=='community'){echo "<td><input type=submit name=submit value=Add_WebPage></td>";}
echo "</tr>";	  
	  echo "<input type='hidden' name='project_category' value='$project_category'>";	   
	 echo "<input type='hidden' name='project_name' value='$project_name'>";	   
	 echo "<input type='hidden' name='note_group' value='$note_group'>";	   
	 echo "<input type='hidden' name='folder' value='$folder'>";	   
	 echo "</form>";

	 
echo "</table>";
//echo "<br />";
echo "<br />";
}
*/
if($level < '3' and $location==''){$location=$pcode;}


echo "<table>";
echo "<tr>";

//echo "<font size=5>"; 
echo "<th>Location</th></tr>";
echo "<tr>";
echo "<form method='post' action='fixed_assets_doc_lookup.php'>";
echo "<td><input name='location' type='text' value='$location'></td>";
//echo "<td><input name='center' type='text' value='$center'></td>";
//echo "<td><input name='account' type='text' value='$account' ></td>";
//echo "<td><input name='calyear' type='text' value='$calyear' ></td>";
echo "<td><input type='submit' name='submit' value='search'></td>";
echo "</form>";
echo "<td>";
/*
echo "<form method='post' action='fixed_assets_doc_lookup.php'>";
echo "<input type='hidden' name='center'  value=''>";
echo "<input type='hidden' name='location'  value=''>";
echo "<input type='hidden' name='account'  value=''>";
echo "<input type='hidden' name='calyear'  value='' >";
echo "<input type='submit' name='submit' value='reset'>";
echo "</td>"; 
echo "</form>";	 
*/ 
echo "</tr>";
echo "</table>";
echo "<br />";

$header_var_location="&location=$location";
$header_var_center="&center=$center";
$header_var_account="&account=$account";
$header_var_calyear="&calyear=$calyear";
echo "<table border=1><tr><th>Alerts</th><th>Count</th></tr>
              <tr bgcolor='lightgreen'><td>Closed</td><td>$doc_yes</td></tr>
              <tr bgcolor='lightpink'><td>Open</td><td>$doc_no</td></tr>
	   </table><br />";
echo "<table border=1>";
//echo "<br />";
echo "<tr>";
echo "<th><font color='brown'>Alerts</font></th><th><font color='brown'>Comments </th></font>";
echo "</tr>";

//echo "<table border=1>";

//echo "<tr><td><font color='brown'>WebPages:</font><font color='red'> $num4 </font></td></tr>";


while ($row4=mysqli_fetch_array($result4)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4);
$countid=number_format($countid,0);
$rank=$rank+1;
$rank2="(".$rank.")";
//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
if($record_complete=="y"){$bgc="lightgreen";} else {$bgc="lightpink";}

echo 

"<tr bgcolor='$bgc'>"; 
//echo "<td>$rank2</td>";  
echo "<td><a href='$weblink' target='_blank'>$project_note</a></td>";
//echo "<td></td><td></td>"; 
echo "<td><a href='project1_menu.php?comment=y&add_comment=y&folder=$folder&project_category=$project_category&category_selected=y&project_name=$project_name&name_selected=y&note_group=$note_group&project_note_id=$project_note_id'>Comments</a></td>"; 
	          
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


echo "<table>";
echo "<tr>";
echo "<td><font color=brown class='cartRow'>$project_note</font></td>";

echo "</tr>";
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
echo "<td><textarea name= 'comment_note' rows='5' cols='75' ></textarea></td>";            
      
	  if($folder=='personal'){echo "<td><input type=submit name=submit value=Add_Note></td>";}
	  if($folder=='community'){echo "<td><input type=submit name=submit value=Add_Note></td>";}
	  echo "<input type='hidden' name='project_category' value='$project_category'>";	   
	 echo "<input type='hidden' name='project_name' value='$project_name'>";	   
	 echo "<input type='hidden' name='project_note' value='$project_note'>";	   
	 //echo "<input type='hidden' name='weblink' value='$weblink'>";	   
	 echo "<input type='hidden' name='note_group' value='$note_group'>";	   
	 echo "<input type='hidden' name='folder' value='$folder'>";	   
	 echo "<input type='hidden' name='project_note_id' value='$project_note_id'>";	   
	 echo "</form>";
echo "</tr>";
      
	 
echo "</table>";
}
//echo "<br />";


if($show_order==''){$shade_newest="class=cartRow";}
if($show_order=='newest'){$shade_newest="class=cartRow";}
if($show_order=='oldest'){$shade_oldest="class=cartRow";}

//echo "shade_oldest=$shade_oldest";
echo "<table><tr>";

echo "<td><a href='project1_menu.php?comment=y&add_comment=y&project_note_id=$project_note_id&folder=$folder&project_category=$project_category&category_selected=y&project_name=$project_name&name_selected=y&note_group=$note_group&show_order=newest'><font size='3' $shade_newest>Newest on top</font></a></td>";
echo "<td><a href='project1_menu.php?comment=y&add_comment=y&project_note_id=$project_note_id&folder=$folder&project_category=$project_category&category_selected=y&project_name=$project_name&name_selected=y&note_group=$note_group&show_order=oldest'><font size='3' $shade_oldest>Oldest on top</font></a></td>";

echo "</tr></table>"; 

echo "<br />";


echo "<table>";

//echo "<tr><td><font color='brown'>Member</font></td><td><font color='brown'>Comment</font></td></tr>";


while ($row4b=mysqli_fetch_array($result4b)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4b);
$countid=number_format($countid,0);
$rank=$rank+1;

if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
$user=substr($tempid,0,-2);

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
 