<?php

session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}

include("../../include/connect.php");

echo "<html>";
echo "<head>";
echo "<title> View Status ReportsP</title>";
echo "</head>";
echo "<body bgcolor=#FFFFb4>";
echo "<H1 ALIGN=left > <font color=red><i>Project Status Reports</i></font></H1>";
echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";

echo
"<form method=post action=project_status_reports2.php>";
echo "<font size=5>"; 
echo "<select name='project_status'>";
echo "<option value='open'> open </option>";
echo "<option value='closed'> closed </option>";

echo "</select>";

echo "<input type='submit' name='submit' value='submit'>";

echo "</form>";



echo "</body>";
echo "</html>";

?>





