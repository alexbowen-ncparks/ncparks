<?php
session_start();


//$file = "articles_menu.php";
//$lines = count(file($file));


//$table="infotrack_projects";
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

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
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;


//include("../../../include/connectBUDGET.inc");// database connection parameters
//include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
//include("../../budget/~f_year.php");
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database);

include("/opt/library/prd/WebServer/include/activity.php"); // connection parameters
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

$query11="SELECT filegroup,report_name
from infotrack_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);

if($name_selected != 'y')
{



echo "<html>";
echo "<head>
<title>InfoTrack</title>";

include ("test_style.php");


echo "</head>";
include("report_header4.php");

echo "<br />";

include("report_header3.php");
echo "<br />";


if($category_selected !='y') 

{

if($folder=='community')
{
//$name = mysqli_real_escape_string($name);
$query4="select distinct project_category from infotrack_projects_community where 1 
         order by project_category";
		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);
} 



echo "<table>";
while ($row4=mysqli_fetch_array($result4)){

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



echo "</body></html>";
 
exit;}

if($category_selected =='y' and $name_selected == '') 
{


if($folder=='community')
{
//$project_category = addslashes($project_category);
$query4="select distinct project_name from infotrack_projects_community where 1 
         and project_category='$project_category'
         order by project_name";
		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);
}

  
 echo "<br />";
 echo "<table>";
//echo "<br />";
//echo "<br />";
//echo "</tr>";


//echo "<table border=1>";
//echo "<td><font size=5 color=brown class='cartRow'><b>Projects</b></font></td>";
while ($row4=mysqli_fetch_array($result4)){

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
  echo "<td><a href='project1_menu.php?folder=$folder&project_category=$project_category&category_selected=y&project_name=$project_name&name_selected=y&note_group=web'>$project_name</a></td> 
	          
</tr>";

}

 echo "</table>";
 
echo "
</div>
</body>
</html>";
 
exit;}

}


?>