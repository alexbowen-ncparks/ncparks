<?php
extract($_REQUEST);
session_start();
$myusername=$_SESSION['myusername'];
$webserver=$_SERVER['SERVER_NAME'];
if(!isset($myusername)){
header("location:index.php");
}
//extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);echo "</pre>";//exit;
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
//echo $webserver;exit;

include("../../include/connect.php");
////mysql_connect($host,$username,$password);
$database="mamajone_cookiejar";
$table="projects";
$table2="project_notes";
$table3="project_notes_count";
$table4="members";
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
@mysql_select_db($database) or die( "Unable to select database");

include("../../include/activity.php");//exit;

$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from projects_customformat
WHERE 1 and user_id='$myusername'
";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;
echo "body_bg:$body_bg";
echo "<br />";
echo "table_bg:$table_bg";
echo "<br />";
echo "table_bg2:$table_bg2";

echo "<html>";
echo "<head>
<title>Home</title>";

include ("css/test_style.php");
echo "</head>";


include("widget1.php");//exit;

echo "</html>";


 ?>


