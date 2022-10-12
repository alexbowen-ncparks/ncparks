<?php
echo "bright_idea_steps2.php<br />";//exit;
//echo "query4=$query4";exit;

if($position=='60032793')
{
$query4a="select 
mission_bright_ideas.park,
mission_bright_ideas.player,
mission_bright_ideas.player_note,
mission_bright_ideas.scorer_note
from
mission_bright_ideas
left join mission_bright_ideas2 on mission_bright_ideas.cid=mission_bright_ideas2.cid
where mission_bright_ideas.cid='$cid'";
$result4a = mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");
$row4a=mysqli_fetch_array($result4a);
extract($row4a);


$query4b="select 
mission_bright_ideas.cid,
mission_bright_ideas.gid,
mission_bright_ideas.park,
mission_bright_ideas.player,
mission_bright_ideas.player_note,
mission_bright_ideas.play_date,
mission_bright_ideas.scorer,
mission_bright_ideas.scorer_note,
mission_bright_ideas.score_date,
mission_bright_ideas.status,
mission_bright_ideas2.cid2,
mission_bright_ideas2.scorer_note2,
mission_bright_ideas2.score_date2,
mission_bright_ideas2.status2
from
mission_bright_ideas
left join mission_bright_ideas2 on mission_bright_ideas.cid=mission_bright_ideas2.cid
where mission_bright_ideas.cid='$cid'";
}

//echo "$query4b";//exit;		 
$result4b = mysqli_query($connection, $query4b) or die ("Couldn't execute query 4b.  $query4b");
$num4b=mysqli_num_rows($result4b);

echo "<table border='5'>";
echo "<tr>";
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


echo "<table border='5'>";

echo "<tr>";
echo "<td><font color='brown'>cid</font></td>";
//echo "<td><font color='brown'>park</font></td>";
//echo "<td><font color='brown'>player</font></td>";
//echo "<td><font color='brown'>player_note</font></td>";
//echo "<td><font color='brown'>play_date</font></td>";
//echo "<td><font color='brown'>scorer_note</font></td>";
echo "<td><font color='brown'>cid2</font></td>";
echo "<td><font color='brown'>scorer_note2</font></td>";
echo "<td><font color='brown'>score_date2</font></td>";
echo "<td><font color='brown'>status2</font></td>";
echo "</tr>";






while ($row4b=mysqli_fetch_array($result4b)){


extract($row4b);


echo "<tr bgcolor='#dfe687'>"; 


 echo "<td>$cid</td>";
 // echo "<td>$park</td>";
 //echo "<td>$player</td>";
 //echo "<td>$player_note</td>";
 //echo "<td>$play_date</td>";
 //echo "<td>$scorer</td>";
 //echo "<td>$scorer_note</td>";
 //echo "<td>$scorer_date</td>";
 //echo "<td>$status</td>";
 echo "<td>$cid2</td>";
 echo "<td>$scorer_note2</td>";
 echo "<td>$score_date2</td>";
 echo "<td>$status2</td>"; 


	          
echo "</tr>";

}

 echo "</table>";


 ?>
 