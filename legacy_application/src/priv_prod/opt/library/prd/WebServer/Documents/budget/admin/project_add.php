<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

echo "<html>";
echo "<head>";
echo "<title> Project ADD </title>";
echo "</head>";
echo "<body bgcolor=#FFFFb4>";
echo "<H1 ALIGN=left > <font color=red><i>Project ADD</i></font></H1>";
echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";

echo
"<form method=post action=project_add2.php>";
echo "<font size=5>"; 
echo "project_category:<input name='project_category' type='text' id=project_category>";
echo "<br />";
echo "project_name:<input name='project_name' type='text' id=project_name>";
echo "<br /><br />";
echo "project_note:<textarea name= project_note rows=3 cols=75></textarea>";
echo "<br />";
echo "<br />";
echo "Weblink:<textarea name= weblink rows=3 cols=75></textarea>";

/*echo "<br />";


echo "project_start_date:<input name='project_start_date' type='text' id=project_start_date>";
echo "<br />";
echo "project_end_date:<input name='project_end_date' type='text' id=project_end_date>";
echo "<br />";
echo "project_status:<input name='project_status' type='text' id=project_status>";
*/

echo "&emsp";
echo "<input type=submit value=UPDATE>";

echo "</form>";



echo "</body>";
echo "</html>";

?>





