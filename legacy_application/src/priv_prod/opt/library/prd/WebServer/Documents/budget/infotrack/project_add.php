<?php

session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}

extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";
//print_r($_SESSION);echo "</pre>";

include("../../include/connect.php");
$database="mamajone_cookiejar";
$table="projects";
$table2="project_notes";
$table3="project_notes_count";
$table4="members";

////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
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
echo "<title> Project ADD </title>";
echo "<style type='text/css'>

body { background-color: $body_bg; }
table { background-color: $body_bg; font-color: blue; font-size: 10;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}
</style>";

echo "</head>";
echo "<body bgcolor=#FFF8DC>";
echo "<H1 ALIGN=left > <font color=brown><i>Create Notebook</i></font></H1>";
echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";

echo
"<form method=post action=project_add2.php>";
/*echo "Category<input name='project_category' type='text' id=project_category size='30'>";
echo "<br />";
echo "Topic&nbsp&nbsp&nbsp&nbsp&nbsp<input name='project_name' type='text' id=project_name size='30'>";
echo "<br />";
//echo "Name&nbsp&nbsp&nbsp&nbsp&nbsp<input name='project_note' type='text' id=project_note>";
echo "Note&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<textarea name= 'project_note' rows='1' cols='40'</textarea>";

echo "<br />";

echo "Weblink<textarea name= 'weblink' rows='1' cols='40'></textarea>";

echo "&emsp";
echo "<input type=submit value=UPDATE>";

echo "</form>";
*/
echo "<table border=1>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	   echo "<tr><th><font color='red'>Category</font></th><td><input name='project_category' type='text' size='30' id=project_category></td></tr>";
	   echo "<tr><th><font color='red'>Topic</th></font><td><input name='project_name' type='text' id=project_name size='30'></td></tr>";
       echo "<tr><th><font color='blue'>Note</th></font><td><textarea name= 'project_note' rows='2' cols='20'></textarea></td></tr>";
       echo "<tr><th><font color='blue'>WebLink</th></font><td><textarea name= 'weblink' rows='2' cols='20'></textarea></td></tr>";
      // echo "<tr><th>Weblink</th><td><textarea name= 'weblink' rows='1' cols='40'></textarea></td></tr>";
	  // echo "<tr><td colspan='4' align='center'><input type='submit' value='UPDATE'></td></tr>";
	  echo "</table>";
	  echo "<input type=submit value=UPDATE>";
	 echo "</form>";

     echo "</body>";
     echo "</html>";

















echo "</body>";
echo "</html>";

?>





