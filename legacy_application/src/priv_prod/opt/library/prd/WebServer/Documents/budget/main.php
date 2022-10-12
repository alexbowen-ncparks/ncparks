<?php
session_start();

$active_file=$_SERVER['SCRIPT_NAME'];
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$user_id=$_SESSION['budget']['beacon_num'];

extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
//$project_category=stripslashes($project_category);
//echo $project_category;


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../../budget/~f_year.php");

$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from infotrack_customformat
WHERE 1 and user_id='$user_id'
";

//echo "query10=$query10";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;

echo "<html>";
echo "<head>
<title>Main</title>";

include ("test_style.php");


echo "</head>";

echo "<body>";

echo "<a href='/budget/main.php'>
	<img src='jori_dune.jpg' width='400' height='100' />
	</a>";
	
//include("report_header1.php");
echo "<br />";
echo "<br />";
echo "<br />";



$query4="select * from main_menu where 1 
         order by menu_name,report_name";
		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);













//echo "<table border='1'>";
//echo "<tr>";
//echo "<TD valign='top'>";
echo "<div style='height:500px;width:900px;overflow:scroll;'>";
echo "<TABLE BORDER='1'>";


while ($row4=mysqli_fetch_array($result4)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4);

if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
           <td>$id</td>   
           <td>$menu_name</td>
           <td>$report_name</td>		   
           <td><a href='$link' target='_blank'>$link</a></td> 
	          
</tr>";

}

 echo "</table>";
 
 //echo "</td>";
 echo "</div>";
 //echo "<TD>";
 //echo "<TABLE BORDER='1'>";
 //echo "<tr>";
 //echo "<td>";
 //echo "<object data='http://duckduckgo.com/' width='700' height='400'> <embed src='http://duckduckgo.com/' width='700' height='400'> </embed> Error: Embedded data could not be displayed. </object>";
 //echo "<img src='jori_dune.jpg' width='700' height='400' />";
 
 //echo "</td>";
 //echo "</TR>";
//echo "</TABLE>";
//echo "</td>";
//echo "</tr>";
//echo "</table>";


echo "</body></html>";
 /*
exit;}

if($category_selected =='y' and $name_selected == '') 
{



$query4="select distinct project_name from infotrack_projects_community where 1 
         and project_category='$project_category'
         order by project_name";
		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);



//echo "<br />"; 
//echo "<td><font color='brown'>Projects:</font><font color='red'> $num4 </font></td>";

//$project_category2=stripslashes($project_category);
if($myusername=='tony')
{
echo "<table>";
//echo "<tr>";

echo "<form name='form2' method=post autocomplete='off' action=add_new_blog.php>";
echo "<tr>";
echo "<td><font color='brown' size='5'>Group</font></td><td><font color='brown' size='5' class=cartRow>$project_category</font></td>";
echo "</tr>";
echo "<tr>";
echo "<td><font color='brown' size='5'>Folder</font></td><td><input name='project_name' type='text' size='20' id='project_name'></td>";
echo "</tr>";
echo "<tr>";
echo "<td><font color='brown' size='5'>Title</font></td><td><input name='project_note' type='text' size='20' id='project_note'></td>";
echo "</tr>";
echo "<tr>";
echo "<td><font color='brown' size='5'>Summary</font></td><td><textarea name= 'blog_post_content' rows='2' cols='50' ></textarea></td><td><input type='submit' name='submit' value='Add_Folder'></td></tr>";
echo "<input type='hidden' name='project_category' value='$project_category'>";
echo "<input type='hidden' name='note_group' value='$note_group'>";	
	  		 
      // echo "<tr><th>Weblink</th><td><textarea name= 'weblink' rows='1' cols='40'></textarea></td></tr>";
	  // echo "<tr><td colspan='4' align='center'><input type='submit' value='UPDATE'></td></tr>";
echo "</form>";	

 echo "</table>";
  
 echo "<br />";
 }
 
 else
 
 {
 echo "<table>";
 echo "<tr>";
 echo "<td align='center'><font color='brown' size='5' class=cartRow>$project_category</font>";
 echo "</tr>";
 echo "</table>";
 }

echo "<table border='1'>";
echo "<tr>";
echo "<TD valign='top'>";
echo "<TABLE BORDER='1'>";
 
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
  echo "<td><a href='projects_menu.php?folder=$folder&project_category=$project_category&category_selected=y&project_name=$project_name&name_selected=y&note_group=web'>$project_name</a></td> 
	          
</tr>";

}

 echo "</table>";

echo "</td>";
 echo "<TD>";
 echo "<TABLE BORDER='1'>";
 echo "<tr>";
 echo "<td>";
 echo "<object data='http://duckduckgo.com/' width='700' height='400'> <embed src='http://duckduckgo.com/' width='700' height='400'> </embed> Error: Embedded data could not be displayed. </object>";
 echo "</td>";
 echo "</TR>";
echo "</TABLE>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "</body></html>";
 
exit;}

}

if($name_selected == 'y' and $blog_post=='')
{
$query4="select distinct project_note from infotrack_projects_community where 1 
         and project_category='$project_category' and project_name='$project_name'
         order by project_note";
		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);


if($myusername=='tony')
{
echo "<table>";

echo "<form name='form3' method='post' autocomplete='off' action=add_new_post.php>";

echo "<tr>";
echo "<td><font color='brown' size='5'>Group</font></td><td><font color='brown' size='5' class=cartRow>$project_category</font></td>";
echo "</tr>";

echo "<tr>";
echo "<td><font color='brown' size='5'>Folder</font></td><td><font color='brown' size='5' class=cartRow>$project_name</font></td>";
echo "</tr>";

echo "<tr>";
echo "<td><font color='brown' size='5'>Title</font></td><td><input name='project_note' type='text' size='20' id='project_note'></td>";
echo "</tr>";

echo "<tr>";
echo "<td><font color='brown' size='5'>Summary</font></td><td><textarea name= 'blog_post_content' rows='5' cols='50' ></textarea></td>"; 
echo "</tr>";

echo "<td><input type='submit' name='submit' value='Add_Post'></td>";
echo "</tr>";	
echo "<input type='hidden' name='project_category' value='$project_category'>";	
//echo "<input type='hidden' name='folder' value='$folder'>";	
echo "<input type='hidden' name='project_name' value='$project_name'>";	
echo "<input type='hidden' name='note_group' value='web'>";	
	  		 
      // echo "<tr><th>Weblink</th><td><textarea name= 'weblink' rows='1' cols='40'></textarea></td></tr>";
	  // echo "<tr><td colspan='4' align='center'><input type='submit' value='UPDATE'></td></tr>";
echo "</form>";	

 echo "</table>";
  
 echo "<br />";
 }
 
 else
 
{
 echo "<table>";
 echo "<tr>";
 echo "<td align='center'><font color='brown' size='5' class=cartRow>$project_name</font>";
 echo "</tr>";
 echo "</table>";
}
 
echo "<table border='1'>";
echo "<tr>";
echo "<TD valign='top'>";
echo "<TABLE BORDER='1'>";
 

//echo "<table border=1>";
//echo "<td><font size=5 color=brown class='cartRow'><b>Projects</b></font></td>";
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
  echo "<td><a href='project1_menu_web.php?folder=$folder&project_category=$project_category&category_selected=y&project_name=$project_name&name_selected=y&note_group=web&project_note=$project_note'>$project_note</a></td> 
	          
</tr>";

}

 echo "</table>";

 echo "</td>";
 echo "<TD>";
 echo "<TABLE BORDER='1'>";
 echo "<tr>";
 echo "<td>";
 echo "<object data='http://duckduckgo.com/' width='700' height='400'> <embed src='http://duckduckgo.com/' width='700' height='400'> </embed> Error: Embedded data could not be displayed. </object>";
 echo "</td>";
 echo "</TR>";
echo "</TABLE>";
echo "</td>";
echo "</tr>";
echo "</table>"; 
echo "</body>";
echo "</html>";
 
 
exit;}
*/
?>