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



$project_category=$_REQUEST['project_category'];
$project_name=$_REQUEST['project_name'];
$date=date("Ymd");


echo "<html>";
echo "<head>";
echo "<title> Project_Notes</title>";
echo "</head>";
echo "<body bgcolor=#FFFFb4>";
echo "<H1 ALIGN=left > <font color=red><i>Add Note</i></font></H1>";

echo "<H3 ALIGN=center><A href=welcome.php>Return HOME </A></H3>";


echo
"<form method=post action=add_notes2.php>";
echo "<font size=5>"; 
echo "<input type='hidden' name='date' value='$date'>";


echo "<input type='hidden' name='user' value='$tempid'>";

echo "project_category:";
echo "<select name=project_category>";
echo "<option value=$project_category>";
echo $project_category;
echo "</option>";
echo "</select>";


echo "<br />";
echo "project_name:";
echo "<select name=project_name>";
echo "<option value=$project_name>";
echo $project_name;
echo "</option>";
echo "</select>";

 

echo "<br /><br />";
echo "project_note:<textarea name= project_note rows=3 cols=75></textarea>";
echo "<br />";
echo "<br />";
echo "Weblink:<textarea name= weblink rows=3 cols=75></textarea>";


//echo "link:<textarea name= link rows=2 cols=50 readonly='yes'></textarea>";
echo "<br />";
echo "<br />";


echo "<input type=submit value=UPDATE>";

echo "</font>";


echo "</form>";
echo "</body>";
echo "</html>";

?>





