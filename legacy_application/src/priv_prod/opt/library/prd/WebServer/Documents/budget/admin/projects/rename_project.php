<?php

session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}

include("../../include/connect.php");
//include("../../include/register_validation.php");

$database="mamajone_cookiejar";
$table="projects";

$project_category=$_REQUEST['project_category'];
$project_name=$_REQUEST['project_name'];

////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
$query="SELECT project_category,project_name
FROM $table
WHERE 1 and project_category='$project_category' and project_name='$project_name' and user_id='$myusername'
ORDER BY project_category,project_name ";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result = mysqli_query($connection, $query) or die ("Couldn't execute query 1.  $query");

//The number of rows returned from the MySQL query.
$num=mysqli_num_rows($result);
//echo "n=$num";
//exit;

// frees the connection to MySQL
 ////mysql_close();


echo "<html>";
echo "<head>";
echo "<title> Project ADD </title>";
echo "</head>";
echo "<body bgcolor=#FFFFb4>";
echo "<H1 ALIGN=left > <font color=red><i>Rename Project </i></font></H1>";
echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";
echo "<br />";

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



echo "</body>";
echo "</html>";

?>





