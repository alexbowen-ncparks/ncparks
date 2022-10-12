<?php

session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}

extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);"</pre>";
echo "<pre>";print_r($_SESSION);"</pre>";//exit;


include("../../include/connect.php");
//include("../../include/register_validation.php");

$database="mamajone_cookiejar";
$table="projects_menu";

//$project_category=$_REQUEST['project_category'];
//$project_name=$_REQUEST['project_name'];

////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
$query="SELECT category,topic
FROM $table
WHERE 1 and category='$category' and topic='$topic' and username='$myusername'
ORDER BY category,topic ";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result = mysqli_query($connection, $query) or die ("Couldn't execute query 1.  $query");
$row=mysqli_fetch_array($result);
extract($row);
//The number of rows returned from the MySQL query.
$num=mysqli_num_rows($result);
//The number of rows returned from the MySQL query.
//echo "n=$num";
//exit;
$query10="SELECT body_bgcolor
from projects_customformat
WHERE 1 and user_id='$myusername'
";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;

// frees the connection to MySQL
 ////mysql_close();


echo "<html>";
echo "<head>";
echo "<title> WebTool Rename </title>";
echo "</head>";
//echo "<body bgcolor=#FFFFb4>";

echo "<style type='text/css'>
body { background-color: $body_bg; }
table { background-color: $body_bg; font-color: blue; font-size: 10;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}
</style>";

echo "<H1 ALIGN=left > <font color=red><i>WebTool Rename </i></font></H1>";
echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";
//echo "<br />";
/*
echo
"<form method=post action=rename_project2.php>";
echo "<font size=5>"; 
echo "project_category-OLD:<input name='project_category' type='text' id='project_category' value='$project_category'>";
echo "project_name-OLD:<input name='project_name' type='text' id='project_name' value='$project_name'>";
echo "<br /><br />";
echo "project_category-NEW:<input name='project_category_new' type='text' id='project_category_new' >";
echo "project_name-NEW:<input name='project_name_new' type='text' id='project_name_new'>";


echo "    <input type=submit value=UPDATE>";

echo "</form>";
*/
echo "<form method='post' action='rename_webtool2.php'>";
echo "<font color=blue size=5>";

//echo  "user:<input name='user' type='text' id=user value=\"$user\">";
//echo "<br />system_entry_date:<input name='system_entry_date' type='text' id=system_entry_date value=\"$system_entry_date\">";
//echo "<br />Category:<input name='project_category' type='text' id=project_category size=50 value=\"$project_category\">";
//echo "<br />Topic:<input name='project_name' type='text' id=project_name size=50 value=\"$project_name\">";

echo "<table border=1>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	   echo "<tr><th><font color='blue'>WebTool</font></th><th><font color='blue'>Category</font></th><th><font color='blue'>Topic</font></th></tr>";
	   echo "<tr><td>Current</td><td><font color='blue'><input name='category' type='text' readonly='readonly' id='category' value='$category'></font></td><td><input name='topic' type='text' readonly='readonly' id='topic' value='$topic'></td></tr>";
       echo "<tr><td>New</td><td><font color='blue'><input name='category_new' type='text' id='category_new'></font></td><td><input name='topic_new' type='text' id='topic_new'></td><td><input type='submit' value='UPDATE'></td></tr>";
	  // echo "<tr><td colspan='4' align='center'><input type='submit' value='UPDATE'></td></tr>";
	  echo "</table>";
	  
	 echo "</form>";

     echo "</body>";
     echo "</html>";

	  
	  /* echo "<tr><td><font color='blue'>end_date</font></td><td><input type='text' name='end_date' ></td></tr>";
	   echo "<tr><td><font color='blue'>project_category</font></td><td><input type='text' name='project_category' ></td></tr>";
	   echo "<tr><td><font color='blue'>project_name</font></td><td><input type='text' name='project_name' ></td></tr>";
	   echo "<tr><td><font color='blue'>step_group</font></td><td><input type='text' name='step_group' ></td></tr>";
	   echo "<tr><td><font color='blue'>step</td></font><td><input type='text' name='step' ></td></tr>";
	   echo "<tr><td><font color='blue'>link</td></font><td><input type='text' name='link' ></td></tr>";
	   echo "<tr><td><font color='blue'>weblink</font></td><td><input type='text' name='weblink' ></td></tr>";
	   echo "<tr><td><font color='blue'>status</font></td><td><input type='text' name='status' ></td></tr>";
	   	   echo "</table>";
*/
//echo "<br /> <br />";
//echo "<input type='submit' value='UPDATE'>";


?>





