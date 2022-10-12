<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}


$active_file=$_SERVER['SCRIPT_NAME'];
$active_file_request=$_SERVER['REQUEST_URI'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$playstation=$_SESSION['budget']['select'];
$playstation_center=$_SESSION['budget']['centerSess'];
//$pcode=$_SESSION['budget']['select'];




extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
include("../../budget/menu1314.php");
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

$table="colors";

$query1="select * from $table where 1 order by color_name";

         
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
$num1=mysqli_num_rows($result1);


echo
 "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitionalt//EN'
    'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
	
<html xmlns='http://www.w3.org/1999/xhtml' lang='en' xml:lang='en'>
  <head>
    <title>MoneyCounts</title>";
//echo "<link rel='stylesheet' type='text/css' href='admin2.css' />";	

echo "<head>";
echo "<style>";
echo "</style>";
echo "</head>";

echo "<body>";

echo "<table>";

echo "<tr><th></th></tr>";

while ($row1=mysqli_fetch_array($result1)){


extract($row1);
echo "<tr>";

echo "<td></td>";


echo "</tr>";

}

 echo "</table>";





//echo "</div>";
echo "</body>";


echo "</html>";

?>











		
        