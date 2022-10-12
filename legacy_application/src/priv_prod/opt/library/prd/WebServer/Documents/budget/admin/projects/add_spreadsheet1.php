<?php

session_start();
$myusername=$_SESSION['myusername'];
$project_category=$_POST['project_category'];
$project_name=$_POST['project_name'];
$user_id=$_POST['user_id'];

//echo "<pre>";print_r($_POST);print_r($_SESSION);echo "</pre>";exit;
if(!isset($myusername)){
header("location:index.php");
}

include("../../include/connect.php");


echo "<html>";
echo "<head>

<style>
body { background-color: #FFF8DC; }
table { background-color: white; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}

</style>";

echo "<title> Spreadsheet Request </title>";
echo "</head>";
echo "<body bgcolor=#FFFFb4>";
echo "<H1 ALIGN=left > <font color=red><i>Spreadsheet Request</i></font></H1>";
//echo "<font size=4><b><A href='http://html-color-codes.info/'>View Colors Available</A></b></font>";

echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";

echo
"<form method=post action=add_spreadsheet2.php>";
echo "<font size=5>"; 
echo "Lines needed:<input name='lines_needed' type='text' id=lines_needed>";
echo "<input type='hidden' name='project_category' value='$project_category'>";		
echo "<input type='hidden' name='project_name' value='$project_name'>";		
echo "<input type='hidden' name='user_id' value='$user_id'>";	

//echo "<br />";

echo "&emsp";
echo "<input type=submit value=submit>";

echo "</form>";



echo "</body>";
echo "</html>";

?>





