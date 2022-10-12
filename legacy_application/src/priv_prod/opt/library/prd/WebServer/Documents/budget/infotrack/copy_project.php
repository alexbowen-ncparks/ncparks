<?php

session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}
$project_id=$_REQUEST['project_id'];
$project_category=$_REQUEST['project_category'];
$project_name=$_REQUEST['project_name'];
$notes=$_REQUEST['notes'];

include("../../include/connect.php");

$database="mamajone_cookiejar";
$table="projects";
$table2="project_notes";
$table3="project_notes_count";
$table4="members";

////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query="SELECT * FROM $table where 1 and project_category='$project_category' and project_name='$project_name'  and user_id='$myusername'  order by project_id desc";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result = mysqli_query($connection, $query) or die ("Couldn't execute query 1.  $query");

//The number of rows returned from the MySQL query.
$num=mysqli_num_rows($result);


$query10="SELECT *
from projects_customformat
WHERE 1 and user_id='$myusername'
";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;


echo "<html>";
echo "<head>";
echo "<title> Project Copy </title>";

echo "<style type='text/css'>

body { background-color: $body_bg; }
table { background-color: $body_bg; font-color: blue; font-size: 10;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}
</style>";

echo "</head>";
echo "<body bgcolor=#FFF8DC>";
echo "<H1 ALIGN=LEFT > <font color=brown><i>Notebook:$project_category $project_name-($notes Notes)</i> </font></H1>";
echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";

echo
"<form method=post action=copy_project2.php>";
echo "<font size=5>"; 
echo "Share Notebook with <input name='copy_project_for' type='text' id='copy_project_for'>";
echo "<input type='hidden' name='project_id' value='$project_id'>";
echo "<input type='hidden' name='project_category' value='$project_category'>";
echo "<input type='hidden' name='project_name' value='$project_name'>";

echo "<br /><br />";

/*echo "<br />";


echo "project_start_date:<input name='project_start_date' type='text' id=project_start_date>";
echo "<br />";
echo "project_end_date:<input name='project_end_date' type='text' id=project_end_date>";
echo "<br />";
echo "project_status:<input name='project_status' type='text' id=project_status>";
*/

//echo "&emsp";
echo "<input type=submit value=UPDATE>";

echo "</form>";



echo "</body>";
echo "</html>";

?>





