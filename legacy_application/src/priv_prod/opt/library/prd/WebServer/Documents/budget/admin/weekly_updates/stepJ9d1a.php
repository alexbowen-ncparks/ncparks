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

$table="bd725_dpr_new_extract";

$query1="select * from $table where 1";

         
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
echo  "<form method='post' autocomplete='off' action='stepJ9d1_update_all.php'>";
echo "<table>";

echo "<tr>";
echo "<th>fund</th>";
echo "<th>fund_descript</th>";
echo "<th>proj_yn</th>";
echo "<th>report_display</th>";
echo "<th>projcat</th>";
echo "<th>manager</th>";
echo "<th>fullname</th>";
echo "<th>dist</th>";
echo "<th>county</th>";
echo "<th>section</th>";
echo "<th>park</th>";
echo "<th>projname</th>";
echo "<th>active</th>";
echo "<th>statusper</th>";
echo "<th>proj_num</th>";
echo "<th>showpa</th>";
echo "<th>id</th>";


echo "</tr>";

while ($row1=mysqli_fetch_array($result1)){


extract($row1);
echo "<tr>";

echo "<td><input type='text' name='fund[]' value='$fund'></td>";
echo "<td><input type='text' name='fund_descript[]' value='$fund_descript'></td>";
echo "<td><input type='text' name='proj_yn[]' value='$proj_yn'></td>";
echo "<td><input type='text' name='report_display[]' value='$report_display'></td>";
echo "<td><input type='text' name='project[]' value='$project'></td>";
echo "<td><input type='text' name='manager[]' value='$manager'></td>";
echo "<td><input type='text' name='fullname[]' value='$fullname'></td>";
echo "<td><input type='text' name='dist[]' value='$dist'></td>";
echo "<td><input type='text' name='county[]' value='$county'></td>";
echo "<td><input type='text' name='section[]' value='$section'></td>";
echo "<td><input type='text' name='park[]' value='$park'></td>";
echo "<td><input type='text' name='projname[]' value='$projname'></td>";
echo "<td><input type='text' name='active[]' value='$active'></td>";
echo "<td><input type='text' name='statusper[]' value='$statusper'></td>";
echo "<td><input type='text' name='proj_num[]' value='$proj_num'></td>";
echo "<td><input type='text' name='showpa[]' value='$showpa'></td>";
echo "<td><input type='text' name='id[]' value='$id'></td>";




echo "</tr>";

}
echo "<tr><td><input type='submit' name='submit2' value='Update'></td></tr>";	
echo "<input type='hidden' name='num1' value='$num1'>";	

 echo "</table>";





//echo "</div>";
echo "</body>";


echo "</html>";

?>











		
        