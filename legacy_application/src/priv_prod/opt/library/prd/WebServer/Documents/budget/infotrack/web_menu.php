<?php
session_start();


$file = "articles_menu.php";
$lines = count(file($file));


$table="infotrack_projects";
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

$active_file=$_SERVER['SCRIPT_NAME'];
$active_file_request=$_SERVER['REQUEST_URI'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$infotrack_location=$_SESSION['budget']['select'];
$infotrack_center=$_SESSION['budget']['centerSess'];




//echo "<pre>";print_r($_SERVER);"</pre>";

//echo "active_file=$active_file<br />";
//echo "active_file_request=$active_file_request<br />";


extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//if($level=='5' and $tempID !='Dodd3454')

//{echo "<pre>";print_r($_SESSION);"</pre>";}//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;


include("../../../include/connectBUDGET.inc");// database connection parameters
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");

//echo "f_year=$f_year";


//if($beacnum !="60032793" and $beacnum != '60033162'){echo "<font color='red' size='5'>Message:"; print_r($_SESSION['budget']['tempID']);echo " does not have access to this report</font>";exit;}


/*
if($level=='5' and $tempID !='Dodd3454')
{
echo "beacon_number:$beacnum";
echo "<br />";
echo "infotrack_location:$infotrack_location";
echo "<br />";
echo "infotrack__center:$infotrack_center";
echo "<br />";
}
*/
$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from infotrack_customformat
WHERE 1 and user_id='$tempID'
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
$query11="SELECT filegroup,report_name
from infotrack_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);
echo "<br />";
//echo $filegroup;

echo "<html>";
echo "<head>
<title>InfoTrack</title>";

include ("test_style.php");


echo "</head>";
include("report_header1.php");
echo "<br />";

//include("report_header3.php");
echo "<br />";

if($folder=='personal')
{

$query4="select project_note,weblink,note_group,project_note_id from infotrack_projects where 1 
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
$query4="select project_note,weblink,note_group,project_note_id from infotrack_projects_community
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
echo "<td><a href='web_menu.php?folder=$folder&project_category=$project_category&category_selected=y&project_name=$project_name&name_selected=y&note_group=web&add_record=y'>Add</a></td>";
echo "</tr></table>"; 
}

if($add_record=='y')
{

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;

//echo "<th align=left><A href='articles_community_edit.php'>Download from Community</A></th><th><A href='article_add.php?&add_your_own=y'>Add your own</A></th>";
//echo "<tr><th align=left><A href='articles_community_edit.php'>Community</A></th></tr>";
echo "<table>";
echo "<th><font color='brown'>Page Title</font></th><th><font color='brown'>Page Address</th></font>";
echo "<tr>";

//echo "<td></td>";
echo "<form method=post action=article_add2.php>";
echo "<td><textarea name= 'project_note' rows='2' cols='20' ></textarea></td>            
      <td><textarea name= 'web_address' rows='2' cols='20'></textarea></td>";
	  if($folder=='personal'){echo "<td><input type=submit name=submit value=Add_WebPage></td>";}
	  if($folder=='community'){echo "<td><input type=submit name=submit value=Add_WebPage></td>";}
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
echo "<td><a href='$weblink'>$project_note</a></td> 
	          
</tr>";

}

 echo "</table>";





echo "</body></html>";
 

?>
