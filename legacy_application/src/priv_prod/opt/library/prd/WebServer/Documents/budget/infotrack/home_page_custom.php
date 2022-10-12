<?php

session_start();
$myusername=$_SESSION['myusername'];
$active_file=$_SERVER['SCRIPT_NAME'];
if(!isset($myusername)){
header("location:index.php");
}
extract($_REQUEST);

include("../../include/connect.php");


////mysql_connect($host,$username,$password);
$database="mamajone_cookiejar";
$table="projects_customformat";

@mysql_select_db($database) or die( "Unable to select database");

include("../../include/activity.php");//exit;

$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from projects_customformat
WHERE 1 and user_id='$myusername'
";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;
echo "body_bg:$body_bg";
echo "<br />";
echo "table_bg:$table_bg";
echo "<br />";
echo "table_bg2:$table_bg2";

$query11="SELECT filegroup
from projects_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);
echo "<br />";
//echo $filegroup;


echo "<html>";
echo "<head>";
echo "<title> Customize</title>";

include ("css/test_style.php");


echo "</head>";
include("widget1.php");

echo "<table border=1>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
echo "<tr>
          <th align=left><font color=brown>Favorite Designs</font></th><th><A href='home_page_custom2_test.php?'>ADD</A></th>

</tr>";		  
echo "</table>";
/*

echo "</head>";
echo "<body bgcolor=#FFF8DC>";
echo "<H1 ALIGN=left><font color=brown><i>Notebooks</i></font></H1>";



echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";
//echo "<font size=4><b><A href='http://www.w3schools.com/html/html_colornames.asp'>Color Lookup </A></b></font>";

//echo "<br /><br />";
*/
//echo "<H2 ALIGN=left > <font color=red>Customize</font></H2>";
//echo "<table border=1>";
/*echo "<tr>";
echo "<th><font color=blue>Customize</th></th>
      <th><font color=blue>Type Color</font></th>";
echo "</tr>"; 
*/  

/*
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
*/
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

echo "</body>";
*/
echo "</html>";

?>





