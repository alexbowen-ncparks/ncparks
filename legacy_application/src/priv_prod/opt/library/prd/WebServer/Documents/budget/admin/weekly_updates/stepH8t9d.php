<?php

session_start();


//$file = "articles_menu.php";
//$lines = count(file($file));


$table1="crj_posted1_v2";
$table2="crj_centers";
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;


$active_file=$_SERVER['SCRIPT_NAME'];
$active_file_request=$_SERVER['REQUEST_URI'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$infotrack_location=$_SESSION['budget']['select'];
$infotrack_center=$_SESSION['budget']['centerSess'];
$pcode=$_SESSION['budget']['select'];



//echo "<pre>";print_r($_SERVER);"</pre>";

//echo "active_file=$active_file<br />";
//echo "active_file_request=$active_file_request<br />";


extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//if($level=='5' and $tempID !='Dodd3454')
//echo "pcode=$pcode";
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;


//include("../../../include/connectBUDGET.inc");// database connection parameters

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 

include("../../../../include/activity.php");// database connection parameters
include("../../../budget/~f_year.php");




//echo "f_year=$f_year";

$query1="select center,bd_first3,ceid from crj_centers where 1";

$result1=mysqli_query($connection, $query1) or die ("Couldn't execute query1. $query1");

$num1=mysqli_num_rows($result1);

echo "<table><tr><td>Records: $num1</td></tr></table>";
echo "<table border='1'>";

echo "<tr>
<td><font color='brown'>center</font></td>
<td><font color='brown'>bd_first3</font></td>
<td><font color='brown'>ceid</font></td>


</tr>";

echo  "<form method='post' autocomplete='off' action='stepH8t9d_update.php'>";
while ($row1=mysqli_fetch_array($result1)){

extract($row1);

echo "<tr bgcolor='$bgc'>"; 
//echo "<tr$t>"; 
//echo "<td>$rank</td>";
 echo "<td><input type='text' size='8' name='center[]' value='$center' readonly='readonly'</td>"; 
 echo "<td><input type='text' size='3' name='bd_first3[]' value='$bd_first3' readonly='readonly'</td>";
echo "<td><input type='text' size='1' name='ceid[]' value='$ceid' readonly='readonly'</td>";
echo "<td>$color</td>";


//echo "<td>$status</td>"; 

	          
echo "</tr>";

}
echo "<tr><td colspan='8' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";
echo "<input type='hidden' name='num1' value='$num1'>";
echo "<input type='hidden' name='fiscal_year' value='$fiscal_year'>";
echo   "</form>";
 echo "</table>";
 echo "</body>";
echo "</html>";
 
 ?>
 