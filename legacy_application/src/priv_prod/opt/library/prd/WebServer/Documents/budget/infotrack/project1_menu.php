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
$location=$_SESSION['budget']['select'];



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
//echo "<br />";
//echo $filegroup;

/*
echo "<html>";
echo "<head>
<title>InfoTrack</title>";
*/

include ("report_header4.php");
include ("test_style.php");
//echo "<br />";
//include ("report_header3.php");
//include ("report_header2.php");

//echo "</head>";
//include("report_header1.php");
echo "<br />";

//include("report_header3.php");
//echo "<br /><br />";

if($note_group=='web')
{
include("project1_menu_web.php");
}

if($note_group=='document')
{
include("project1_menu_documents.php");
}

if($note_group=='note')
{
include("project1_menu_notes.php");
}

if($note_group=='message')
{
include("project1_menu_messages.php");
}

if($note_group=='photo')
{
include("project1_menu_photos.php");
}

if($note_group=='')
{
include("project1_menu_all.php");
}



echo "</body></html>";
 

?>