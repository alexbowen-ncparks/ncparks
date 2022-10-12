<?php
echo "hello bright_idea_steps2_v2.php";
$position='60032793';
$cid='295';
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 
if($position=='60032793')
{
$query4a="select 
mission_bright_ideas.park,
mission_bright_ideas.player,
mission_bright_ideas.player_note,
mission_bright_ideas.scorer_note,
mission_bright_ideas.status
from
mission_bright_ideas
where mission_bright_ideas.cid='$cid'";
$result4a = mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");
$row4a=mysqli_fetch_array($result4a);
extract($row4a);


if($status == "fi"){$t=" bgcolor='lightgreen'";} else {$t=" bgcolor='lightpink'";}


echo "<table border='5'>";
echo "<tr$t>";
echo "<th>cid</th>";
echo "<th>park</th>";
echo "<th>player</th>";
echo "<th>player_note</th>";
echo "<th>scorer_note</th>";
echo "</tr>";
echo "<tr bgcolor='#dfe687'>";
echo "<td>$cid</td>";
echo "<td>$park</td>";
echo "<td>$player</td>";
echo "<td>$player_note</td>";
echo "<td>$scorer_note</td>";
echo "</tr>";
echo "</table>";
echo "<br />";

}
//include("/budget/infotrack/procedures.php");
echo "<table><tr><td><a href='/budget/infotrack/procedures.php?comment=y&add_comment=y&folder=community&pid=12'>blog</a></td></tr></table>";


 ?>
 