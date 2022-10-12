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

$project_id=$_REQUEST['project_id'];
$project_category=$_REQUEST['project_category'];
$project_name=$_REQUEST['project_name'];
$notes=$_REQUEST['notes'];



echo "<html>";
echo "<head>";
echo "<title> Project Copy </title>";
echo "</head>";
echo "<body bgcolor=#FFFFb4>";
echo "<H1 ALIGN=LEFT > <font color=brown><i>ProjectName:$project_category $project_name-($notes Notes)</i> </font></H1>";
echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";

echo
"<form method=post action=copy_project2.php>";
echo "<font size=5>"; 
echo "Copy Project For:<input name='copy_project_for' type='text' id='copy_project_for'>";
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





