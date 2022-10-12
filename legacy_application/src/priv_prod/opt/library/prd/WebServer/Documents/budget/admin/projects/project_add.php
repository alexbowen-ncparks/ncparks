<?php

session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}

include("../../include/connect.php");


echo "<html>";
echo "<head>";
echo "<title> Project ADD </title>";
echo "</head>";
echo "<body bgcolor=#FFF8DC>";
echo "<H1 ALIGN=left > <font color=brown><i>Create Notebook</i></font></H1>";
echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";

echo
"<form method=post action=project_add2.php>";
echo "<font size='5' color='blue'>"; 
echo "Category<input name='project_category' type='text' id=project_category size='30'>";
echo "<br />";
echo "Topic&nbsp&nbsp&nbsp&nbsp&nbsp<input name='project_name' type='text' id=project_name size='30'>";
echo "<br />";
//echo "Name&nbsp&nbsp&nbsp&nbsp&nbsp<input name='project_note' type='text' id=project_note>";
echo "Note&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<textarea name= 'project_note' rows='1' cols='40'</textarea>";

//echo "project_note:<textarea name= project_note rows=3 cols=75></textarea>";
echo "<br />";

//echo "Weblink:<textarea name= weblink rows=3 cols=75></textarea>";
echo "Weblink<textarea name= 'weblink' rows='1' cols='40'></textarea>";

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





