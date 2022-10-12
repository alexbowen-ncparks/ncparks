
<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}



$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters

include ("../../budget/menu1415_v1.php");	
//include("../../budget/menu1314.php");	
//include("service_contracts_menu.php");
//include("money_quotes_menu.php");



//$query="SELECT tempid as 'voter',favorite_qid_descript as 'favorite' FROM `money_quotes_scores` WHERE calyear='$calyear' and calmonth='$calmonth' and round='$round' order by favorite_qid,tempid";

$query="SELECT `tempid`, `first_name`, `last_name`, `location`, `round1_selection`, `round1_selection_name`, `round1_score`, `round2_selection`, `round2_selection_name`, `round2_score`, `round2_change`, `round3_selection`, `round3_selection_name`, `round3_score`, `round3_change`, `total_score`, `total_change` FROM `money_quotes_ncaa_summary` WHERE 1 group by total_score desc, tempid asc";

echo "query=$query";
$result = mysqli_query($connection, $query) or die ("Couldn't execute query .  $query");
$num=mysqli_num_rows($result);

echo "<table align='center' border='1'><tr><th>NCAA Tourney Leaderboard</th></tr></table>";
echo "<br />";
echo "<table align='center' border='1'>";
echo "<tr>";
echo "<td>Rank</td>";
echo "<td>Player</td>";
echo "<td>Team</td>";
echo "<td>Sweet16 Choice<br />(max points: 3)</td>";
echo "<td>Final4 Choice<br />(max points: 7)</td>";
echo "<td>Champion Choice<br />(max points: 11)</td>";
echo "<td>Total Score<br />(max points: 21)</td>";
echo "</tr>";
//echo "</table>";
//echo "<br />";



while ($row=mysqli_fetch_array($result)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);

$voter2=substr($tempid,0,-2);
$location=strtolower($location);
if($total_score==3){$rank=1;}
if($total_score==1){$rank=2;}
if($total_score==0){$rank=3;}
echo "<tr>";
echo "<td>$rank</td>";
echo "<td>$voter2</td>";
echo "<td>$location</td>";
echo "<td>$round1_selection_name ($round1_score)</td>";
//echo "<td>$round2_selection_name ($round2_score)</td>";
echo "<td>$round2_selection_name</td>";
//echo "<td>$round3_selection_name ($round3_score)</td>";
echo "<td>$round3_selection_name</td>";
echo "<td align='center'>$total_score</td>";


echo "</tr>";
}	

echo "</table>";













?>