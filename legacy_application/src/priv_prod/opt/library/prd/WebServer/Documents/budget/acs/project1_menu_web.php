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
$pcode=$_SESSION['budget']['select'];



//echo "<pre>";print_r($_SERVER);"</pre>";

//echo "active_file=$active_file<br />";
//echo "active_file_request=$active_file_request<br />";


extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//if($level=='5' and $tempID !='Dodd3454')
//echo "pcode=$pcode";
//{echo "<pre>";print_r($_SESSION);"</pre>";}//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;


//include("../../../include/connectBUDGET.inc");// database connection parameters
//include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
//include("../../budget/~f_year.php");
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 
//echo "f_year=$f_year";


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

$query11="SELECT filegroup,report_name
from infotrack_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);


include ("report_header4.php");
include ("test_style.php");
//echo "<br />";
//include ("report_header3.php");
//include ("report_header2.php");

//echo "</head>";
//include("report_header1.php");
echo "<br />";

if($comment=='')
{

if($folder=='community')
{


if($level<'3'){$location=$pcode;} 


if($location != ""){$where2=" and location = '$location' ";}
if(!isset($where2)){$where2="";}

$query4="select * from infotrack_projects_community where 1 $where2 order by project_note_id desc";

//echo $query4;exit;		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);
//echo "query4=$query4";exit;

$query5a="select count(record_complete) as 'closed'
          from infotrack_projects_community where 1 $where2
		  and record_complete='y' ";
		  
//echo "query3h=$query3h<br />";		  
		  
		  
$result5a = mysqli_query($connection, $query5a) or die ("Couldn't execute query 5a.  $query5a");
		  
$row5a=mysqli_fetch_array($result5a);

extract($row5a);

echo "closed=$closed";

}



echo "<table>";
echo "<tr>";

//echo "<font size=5>"; 
echo "<th>Location</th></tr>";
echo "<tr>";
echo "<form method='post' action='project1_menu_web.php?folder=community'>";
echo "<td><input name='location' type='text' value='$location'></td>";
echo "<td><input type='submit' name='submit' value='search'></td>";
echo "</form>";
echo "<td>";
echo "</tr>";
echo "</table>";
echo "<br />";

echo "<table border=1>";
//echo "<tr><th>Alerts</th><th>Count</th></tr>";
echo "<tr bgcolor='lightgreen'><td>Closed</td><td>$doc_yes</td></tr>";
echo "<tr bgcolor='lightpink'><td>Open</td><td>$doc_no</td></tr>";
echo "</table><br />";

echo "<table border=1>";
//echo "<br />";
echo "<tr>";
echo "<th><font color='brown'>Location</font></th><th><font color='brown'>Alerts</font></th><th><font color='brown'>Comments </th></font>";
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
echo "<td>$location</td>";
echo "<td><a href='$weblink' target='_blank'>$project_note</a></td>";
//echo "<td></td><td></td>"; 
echo "<td><a href='project1_menu_web.php?comment=y&add_comment=y&folder=$folder&project_category=$project_category&category_selected=y&project_name=$project_name&name_selected=y&note_group=$note_group&project_note_id=$project_note_id'>Comments</a></td>"; 
	          
echo "</tr>";

}

 echo "</table>";
 }
 
if($comment=='y') 
//{echo "<font color='brown' size='5'>Oops:Comments feature is under Construction. Sorry for inconvenience<br /><br />Click the BACK button on your Browser to return to previous Page</font><br />";exit;}
 {

if($show_order==''){$order2="order by comment_id asc";}
if($show_order=='newest'){$order2="order by comment_id desc";}
if($show_order=='oldest'){$order2="order by comment_id asc";}


if($folder=='community')
{

$query4a="select project_note from infotrack_projects_community where project_note_id='$project_note_id' ";

//echo $query4a;echo "<br />";		 
$result4a = mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");
$num4a=mysqli_num_rows($result4a);


$query4b="select user,comment_note from infotrack_projects_community_com where 1 and project_note_id='$project_note_id' $order2 ";

//echo "$query4b";		 
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
echo "<td><textarea name= 'comment_note' rows='3' cols='75' ></textarea></td>";            
      
	  if($folder=='personal'){echo "<td><input type=submit name=submit value=Add_Note></td>";}
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
      
	 
echo "</table>";
}
//echo "<br />";


if($show_order==''){$shade_newest="class=cartRow";}
if($show_order=='newest'){$shade_newest="class=cartRow";}
if($show_order=='oldest'){$shade_oldest="class=cartRow";}

//echo "shade_oldest=$shade_oldest";
echo "<table><tr>";

echo "<td><a href='project1_menu_web.php?comment=y&add_comment=y&project_note_id=$project_note_id&folder=$folder&category_selected=y&name_selected=y&show_order=newest'><font size='3' $shade_newest>Newest on top</font></a></td>";
echo "<td><a href='project1_menu_web.php?comment=y&add_comment=y&project_note_id=$project_note_id&folder=$folder&category_selected=y&name_selected=y&show_order=oldest'><font size='3' $shade_oldest>Oldest on top</font></a></td>";

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
$user=substr($user,0,-2);

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
 