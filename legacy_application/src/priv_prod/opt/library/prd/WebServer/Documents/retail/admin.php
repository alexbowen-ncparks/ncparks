<?php
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";
$database="retail";
include("../../include/auth.inc"); // used to authenticate users

if($level<4){exit;}
include("../../include/iConnect.inc");// database connection parameters
// include("../../include/get_parkcodes.php");

extract($_REQUEST);
mysqli_select_db($connection,$database);

$title="Retail Sales - Admin";
include("/opt/library/prd/WebServer/Documents/_base_top.php");

echo "<table><tr><th colspan='5'><font color='gray'>Administrative Functions</font></th></tr></table>";

echo "<table>";

echo "<tr>";

echo "<td><a href='admin.php?edit=cat'>Edit Categories</a></td></tr>";

echo "</table><hr />";

if($edit=="cat"){include("edit_cat.php");}

?>