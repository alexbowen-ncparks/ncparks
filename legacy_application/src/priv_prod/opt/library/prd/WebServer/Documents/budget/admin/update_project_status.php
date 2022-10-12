<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);

//print_r($_SESSION);
//ECHO "<PRE>";PRINT_r($_REQUEST);echo "</pre>";;
$project_category=$_REQUEST['project_category'];
$project_name=$_REQUEST['project_name'];

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

$table="projects";

////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
$query="SELECT * FROM $table where 1 and project_category='$project_category' and project_name='$project_name' and user_id='$myusername' ";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result = mysqli_query($connection, $query) or die ("Couldn't execute query 1.  $query");

//The number of rows returned from the MySQL query.
$num=mysqli_num_rows($result);

// frees the connection to MySQL
 ////mysql_close();
 
 $row=mysqli_fetch_array($result);
 extract($row);

   
echo "<html>";
echo "<head>";
echo "<title>Update Project Status</title>";
echo "</head>";
echo "<body bgcolor=tan>";

echo "<H1 ALIGN=CENTER > <font color=red>Update Project Status</font></H1>";
echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";

echo "<br/>";


echo "<form name='update_project_status2' method='post' action='update_project_status2.php'>";

echo "<font color=blue size=5>";



echo "<br />project_category:<input name='project_category' type='text' readonly='readonly'id=category size=50 value=\"$project_category\">";
echo "<br />project_name:<input name='project_name' type='text' id=project_name size=50 value=\"$project_name\">";
echo "<br />project_status:<input name='project_status' type='text' id=project_status size=50 value=\"$project_status\">";
echo "<br />project_id:<input name='project_id' type='text' id=project_id size=50 value=\"$project_id\">";

echo "<br /> <br />";
echo "<input type='submit' name='submit'
value='UPDATE'>";

echo "</form>";

echo "</font>";


echo "</body>";
echo "</html>";

?>

 
 
 
  















