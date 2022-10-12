<?php
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
}

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

$tempID2=substr($tempID,0,-2);
if($tempID2=='Kno'){$tempID2='Knott';}
//echo "tempID2=$tempID2";

//echo "beacnum=$beacnum";

//echo "<pre>";print_r($_SERVER);"</pre>";

//echo "active_file=$active_file<br />";
//echo "active_file_request=$active_file_request<br />";


extract($_REQUEST);


//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//if($level=='5' and $tempID !='Dodd3454')
//echo "pcode=$pcode";
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
if($folder==''){$folder='community';}
if($add_record==''){$add_record='y';}


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters

mysql_select_db($database, $connection); // database 

//include("../../../../include/activity.php");// database connection parameters

include("../../../include/activity.php");// database connection parameters
//echo "f_year=$f_year";

$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from infotrack_customformat
WHERE 1 and user_id='$tempID'
";

echo "query10=$query10<br />";
$result10=mysql_query($query10) or die ("Couldn't execute query 10. $query10");

$row10=mysql_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;
/*2/4/15
$query11="SELECT filegroup,report_name
from infotrack_filegroup
WHERE 1 and filename='$active_file'
";
echo "query11=$query11<br />";
$result11=mysql_query($query11) or die ("Couldn't execute query 11. $query11");

$row11=mysql_fetch_array($result11);

extract($row11);
*/

if($name_selected != 'y')
{



echo "<html>";
echo "<head>
<title>InfoTrack</title>";

include ("test_style.php");
//include ("projects.css");
echo "<link rel='stylesheet' type='text/css' href='projects.css' />";

echo "</head>";
//include("report_header4.php");
include("../../budget/menu1314.php");
echo "<br />";

include("report_header3.php");
echo "<br />";


if($category_selected !='y') 

{

if($folder=='community')
{
//$name = mysql_real_escape_string($name);

//Query for "Categories"
$query4="select distinct project_category from infotrack_projects_community4 where 1 
         order by project_category";
		 
$result4 = mysql_query($query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysql_num_rows($result4);

//Query for Players currently online

$unixtime=time();
echo "unixtime=$unixtime<br />";
$last5min=$unixtime-300;
echo "last5min=$last5min<br />";

$query4_players="select distinct tempid as 'players_online'
                 from activity_1314 where time1 > '$last5min' 
                 order by players_online";
		 
$result4_players = mysql_query($query4_players) or die ("Couldn't execute query 4_players.  $query4_players");
$num4_players=mysql_num_rows($result4_players);




/*

$query1="SELECT max(end_date)as 'end_date' from project_steps where 1
         and project_category='$project_category' and project_name='$project_name' ";

$result1 = mysql_query($query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysql_fetch_array($result1);
extract($row1);//brings back max (end_date) as $end_date
*/


} 



echo "<div class='column1of4'>";

echo "<table>";
echo "<tr><td><font color='brown'>Topics</font></td>";
while ($row4=mysql_fetch_array($result4)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4);
//$project_category = addslashes($project_category);
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
               
           <td><a href='projects_menu.php?folder=$folder&project_category=$project_category&category_selected=y&add_record=y'>$project_category</a></td> 
	          
</tr>";

}

 echo "</table>";

echo "</div>";
echo "<div align='center' class='column2of4'>";
echo "<table>";
echo "<tr><td><font color='brown'> Players Online</font></td>";
while ($row4_players=mysql_fetch_array($result4_players)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4_players);
//$project_category = addslashes($project_category);
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
               
           <td><a href=''>$players_online</a></td> 
	          
</tr>";

}

 echo "</table>";


echo "</div>";


echo "</body></html>";
 
exit;}

if($category_selected =='y' and $name_selected == '') 
{


if($folder=='community')
{
//$project_category = addslashes($project_category);
$query4="select distinct project_name from infotrack_projects_community4 where 1 
         and project_category='$project_category'
         order by project_name";
		 
$result4 = mysql_query($query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysql_num_rows($result4);


$unixtime=time();
echo "unixtime=$unixtime<br />";
$last5min=$unixtime-300;
echo "last5min=$last5min<br />";

/* 2/4/15

$query4_players="select distinct tempid as 'players_online'
                 from activity_1314 where time1 > '$last5min'
                 and project_category='$project_category'				 
                 order by players_online";
	
*/

$query4_players="select distinct tempid as 'players_online'
                 from activity_1314 where time1 > '$last5min'
                 order by players_online";







	
$result4_players = mysql_query($query4_players) or die ("Couldn't execute query 4_players.  $query4_players");
$num4_players=mysql_num_rows($result4_players);

}

  
 echo "<br />";
 
echo "<div class='column1of4'>";
 
 echo "<table>";
 echo "<tr><td><font color='brown'>Topics</font></td>";
//echo "<br />";
//echo "<br />";
//echo "</tr>";


//echo "<table border=1>";
//echo "<td><font size=5 color=brown class='cartRow'><b>Projects</b></font></td>";
while ($row4=mysql_fetch_array($result4)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4);
//$project_category = addslashes($project_category);
//echo $project_category;exit;
$countid=number_format($countid,0);
$rank=$rank+1;



if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}


echo 

"<tr$t>"; 
  //echo "<td>$rank</td>";   
  echo "<td><a href='project1_menu.php?folder=$folder&project_category=$project_category&category_selected=y&project_name=$project_name&name_selected=y&note_group=web&add_record=y'>$project_name</a></td> 
	          
</tr>";

}

 echo "</table>";
 
 echo "</div>";
 
 echo "<div align='center' class='column2of4'>";
echo "<table>";
echo "<tr><td><font color='brown'> Players Online</font></td>";
while ($row4_players=mysql_fetch_array($result4_players)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4_players);
//$project_category = addslashes($project_category);
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
               
           <td><a href=''>$players_online</a></td> 
	          
</tr>";

}

 echo "</table>";


echo "</div>"; 
 
 
echo "</body>";
echo "</html>";
 
exit;}

}


?>