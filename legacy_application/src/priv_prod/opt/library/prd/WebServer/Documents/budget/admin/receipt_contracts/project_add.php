<?php

session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
include("../../../../include/connectBUDGET.inc");// database connection parameters

echo "<html>";
echo "<head>";
echo "<title> Project ADD </title>";
echo "</head>";
echo "<body bgcolor=#FFF8DC>";
echo "<H1 ALIGN=left > <font color=brown><i>Create Project</i></font></H1>";
echo "<H3 ALIGN=CENTER > <A href=main.php> Return HOME </A></H3>";

echo
"<form method=post action=project_add2.php>";
echo "<font size='5' color='blue'>"; 
echo "ProjectCategory<input name='project_category' type='text' id=project_category size='30'>";
echo "<br />";
echo "ProjectName<input name='project_name' type='text' id=project_name size='30'>";
echo "StepGroup<input name='step_group' type='text' id=step_group size='30'>";
echo "<br />";
//echo "Name&nbsp&nbsp&nbsp&nbsp&nbsp<input name='project_note' type='text' id=project_note>";
echo "StepName&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<textarea name= 'step' rows='1' cols='40'</textarea>";


echo "&emsp";
echo "<input type=submit value=UPDATE>";

echo "</form>";



echo "</body>";
echo "</html>";

?>





