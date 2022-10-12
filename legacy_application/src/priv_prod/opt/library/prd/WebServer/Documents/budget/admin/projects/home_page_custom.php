<?php

session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}

include("../../include/connect.php");


echo "<html>";
echo "<head>";
echo "<title> Customize</title>";
echo "</head>";
echo "<body bgcolor=#FFF8DC>";
echo "<H1 ALIGN=left><font color=brown><i>Notebooks</i></font></H1>";



echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";
//echo "<font size=4><b><A href='http://www.w3schools.com/html/html_colornames.asp'>Color Lookup </A></b></font>";

//echo "<br /><br />";
echo "<H2 ALIGN=left > <font color=red>Customize</font></H2>";
echo "<table border=1>";
/*echo "<tr>";
echo "<th><font color=blue>Customize</th></th>
      <th><font color=blue>Type Color</font></th>";
echo "</tr>"; 
*/  
echo "<tr>";
echo "<td>";
echo "<font size=4>HomePage background_color:</font>";
echo "</td>";
echo "<td>";
echo
"<form method=post action=home_page_custom2.php>";
echo "<font size=4><b><A href='http://www.w3schools.com/html/html_colornames.asp'>Color Lookup </A></b></font>";
echo "<br />";
echo "<input name='background_color' type='text' id=background_color size='15'>";
echo "<input type=submit value=Change>";
echo "<br />";

echo "</form>";
echo "</td>";
echo "</tr>";
echo "</table>";
/*
echo "<tr>";
echo "<td>";
echo "<font size=4>background_image:</font>";
echo "</td>";
echo "<td>";
echo "<font size=4><b><A href='http://www.w3schools.com/html/html_colornames.asp'>Images </A></b></font>";
echo "</td>";
echo "<td>";
echo
"<form method=post action=home_page_custom3.php>";
echo "<input name='background_image' type='text' id=background_image>";
echo "<input type=submit value=Change>";
echo "</form>";
echo "</td>";
echo "</tr>";
*/



echo "</body>";
echo "</html>";

?>





