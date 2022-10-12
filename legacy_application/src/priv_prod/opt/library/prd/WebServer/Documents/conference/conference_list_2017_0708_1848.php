<?php

session_start();

if(!$_SESSION["conference"]["tempID"]){echo "access denied";exit;}


//$active_file=$_SERVER['SCRIPT_NAME'];
//$active_file_request=$_SERVER['REQUEST_URI'];

$level=$_SESSION['conference']['level'];
$//posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['conference']['tempID'];
$beacnum=$_SESSION['conference']['beacon_num'];
$team=$_SESSION['conference']['select'];
//$playstation_center=$_SESSION['budget']['centerSess'];
//$pcode=$_SESSION['budget']['select'];
extract($_REQUEST);

//echo "<br />Line 20: Welcome to conference_list.php</br>"; exit;
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
echo "<pre>";print_r($_SESSION);"</pre>"; //exit;
echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//include("../../budget/menu1314.php");
$database="conference";
$db="conference";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database
$query="select * from games order by game_name";
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");
$num=mysqli_num_rows($result);        

echo "<html>";



echo "<body>";
echo "<table border=1 align='center'>";

//echo "<tr><th>Background Color</th></tr>";
echo "<tr>";
echo "<th>id</th>";
echo "<th>game_name</th>";
echo "<th>game_location</th>";
echo "</tr>";
while ($row=mysqli_fetch_array($result)){
extract($row);
if($c==''){$t=" bgcolor='lightcyan'";$c=1;}else{$t=" bgcolor='cornsilk'";$c='';}
echo"<tr$t>";
echo "<td>$id</td>";
echo "<td>$game_name</td>";
echo "<td>$game_location</td>";

echo "</tr>";
}
echo "</table>";


echo "</body>";


echo "</html>";

?>