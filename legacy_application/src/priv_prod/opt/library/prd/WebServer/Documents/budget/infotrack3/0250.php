<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database


echo "<html>"
echo "<head>";
echo "<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js'></script>";
echo "<script type='text/javascript' src='slideshow.js'></script>";
echo "<link rel='stylesheet' href='slideshow.css' />";
echo "</head>"
echo "<body>";
include("../../budget/menu1314.php");
echo "</body>";

echo "</html>";







?>


 


























	














