<?php
//echo "hello bright_idea_steps2_v2.php";

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
$position=$beacnum;
if($playstation=='ADM'){$playstation='ADMI';}
$scorer=$tempID;


extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 


include("../../budget/menu1314_v3.php");
//include("scoring/score_mission_bright_ideas.php");


//$position='60032793';

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 
//if($position=='60032793'){  closing bracket=line 123  

$query2="select time_start from mission_bright_ideas where cid='$cid'";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
$row2=mysqli_fetch_array($result2);
extract($row2);

if($time_start=='')
{
$query3="update mission_bright_ideas set time_start=unix_timestamp(now()) where cid='$cid' ";

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
}
/*
$query3a="update mission_bright_ideas set time_elapsed_sec=time_end-time_start
          where cid='$cid' ";

$result3a = mysqli_query($connection, $query3a) or die ("Couldn't execute query 3a.  $query3a");
*/


$query4a="select 
mission_bright_ideas.park,
mission_bright_ideas.player,
mission_bright_ideas.score_title,
mission_bright_ideas.player_note,
mission_bright_ideas.scorer_note,
mission_bright_ideas.status
from
mission_bright_ideas
where mission_bright_ideas.cid='$cid'";
$result4a = mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");
$row4a=mysqli_fetch_array($result4a);
extract($row4a);


if($status == "fi"){$t=" bgcolor='lightgreen'";} else {$t=" bgcolor='#dfe687'";}

//echo "<table><tr><th>Bright Idea</th></tr></table>";
echo "<br />";
echo "<table border='5'>";
echo "<tr bgcolor='#dfe687';>";
//echo "<th>cid</th>";
echo "<td><font color='seagreen'><b>$score_title: Completed $total of $total_points</b></font>";
include("charts/score_mission_bright_ideas_chart.php");

echo"</td>";
//echo "<td bgcolor='darkseagreen'><img height='50' width='50' src='/budget/infotrack/icon_photos/property_photos_45.png' alt='picture of blue light bulb'></img></td>";
//echo "<td>$park</td>";
//echo "<td>$player</td>";
//echo "<td>$score_title</td>";
echo "</tr></table>";
echo "<br />";
//echo "<th>player note</th>";
//echo "</tr>";
echo "<table border='1'>";
echo "<tr$t>";
//echo "<td>$cid</td>";
//echo "<td>$park</td>";
//echo "<td>$player</td>";
$player_note=htmlspecialchars_decode($player_note);
$player_note=nl2br($player_note);
echo "<td>$player_note</td>";
/*
echo "<td><img height='50' width='50' src='/budget/infotrack/icon_photos/green_clock1.png' alt='picture of green clock'></img></td>";
*/
//include("ajax-timer1.php");
//echo "</td>";
//echo "<td>";

//include("ajax-timer1_record.php");


//echo "</td>";
//echo "<td>$scorer_note</td>";
echo "</tr>";
echo "</table>";
echo "<br />";

//}

include("bright_idea_steps3_v2.php"); // connection parameters






 ?>
 