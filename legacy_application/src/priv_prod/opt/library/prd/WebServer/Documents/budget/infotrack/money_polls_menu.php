<?php

echo "<br />";

if($poll_id==''){$poll_id='1';}

//if($menu==1){$shade_menu1="class=cartRow";$calmonth='april';$month_number='04';$calyear='2017';}
//if($menu==2){$shade_menu2="class=cartRow";$calmonth='may';$month_number='05';$calyear='2017';}
//if($menu==3){$shade_menu3="class=cartRow";$calmonth='march';$month_number='03';$calyear='2018';}

$query5="SELECT * FROM `polls` WHERE 1 order by id";


//echo "<br />Query5=$query5<br /><br />";;
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);
echo "<table border='1' align='center'><tr><td>POLLS</td></tr></table>";
echo "<table border='1' align='center'>";

//echo "<tr>";
while ($row5=mysqli_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row5);
echo "<tr>";
echo "<td>$id</td><td><a href='money_quotes_scores_20180604.php?poll_id=$id'>$poll_name</a></td>";
echo "</tr>";


}
//echo "</tr>";
echo "</table>";

echo "<br /><br />";



?>