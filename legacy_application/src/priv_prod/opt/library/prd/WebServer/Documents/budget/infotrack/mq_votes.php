
<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}



$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$tempid2=substr($tempid,0,-2);
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




////

$query1="update money_quotes_ncaa_summary as t1,money_quotes_scores as t2
set t1.round3_selection=t2.favorite_qid
where t1.calyear='2018'and t2.calyear='2018'
and   t1.calmonth='march' and t2.calmonth='march'
and t1.tempid=t2.tempid
and t2.round='3' ";

//echo "query1=$query1<br /><br />";
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query1 .  $query1");


$query2="update money_quotes_ncaa_summary as t1,money_quotes as t2
set t1.round3_selection_name=t2.quote_comment
where t1.round3_selection=t2.id ";

//echo "query2=$query2<br /><br />";
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query2 .  $query2");


$query3="update money_quotes_ncaa_summary as t1,money_quotes as t2
set t1.round3_score=t2.round_score
where t1.round3_selection=t2.id ";

//echo "query3=$query3<br /><br />";
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query3 .  $query3");


$query4="update `money_quotes_ncaa_summary` 
set total_score=round1_score+round2_score+round3_score
WHERE 1 ";

//echo "query4=$query4<br /><br />";
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query4 .  $query4");


$query5="update money_quotes_ncaa_summary as t1,cash_handling_roles as t2
set t1.location=t2.park
where t1.tempid=t2.tempid 
and t1.location='' ";

//echo "query5=$query5<br /><br />";
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query5 .  $query5");






////


//$query="SELECT tempid as 'voter',favorite_qid_descript as 'favorite' FROM `money_quotes_scores` WHERE calyear='$calyear' and calmonth='$calmonth' and round='$round' order by favorite_qid,tempid";

$query="SELECT `tempid`, `first_name`, `last_name`, `location`, `round1_selection`, `round1_selection_name`, `round1_score`, `round2_selection`, `round2_selection_name`, `round2_score`, `round2_change`, `round3_selection`, `round3_selection_name`, `round3_score`, `round3_change`, `total_score`, `total_change` FROM `money_quotes_ncaa_summary` WHERE 1 group by total_score desc, tempid asc";

//echo "query=$query";
$result = mysqli_query($connection, $query) or die ("Couldn't execute query .  $query");
$num=mysqli_num_rows($result);
echo "<br />";
echo "<table align='center' border='1'><tr><th>NCAA Tourney Leaderboard</th></tr></table>";
echo "<br />";
echo "<table align='center' border='1'>";
echo "<tr>";
echo "<td>Rank</td>";
echo "<td>Player</td>";
echo "<td>Team</td>";
echo "<td>Sweet16 Choice<br />(<font color='brown'>max points: 3</font>)</td>";
//echo "<td><b>Final4 Choice</b><br />Deadline: March22 at 5PM<br />(<font color='brown'>max points: 7</font>)<br /><a href='money_quotes_scores.php?menu=3&round=2'><font class='cartRow'>VOTE</font></a></td>";
echo "<td>Final4 Choice<br />(<font color='brown'>max points: 7</font>)</td>";
echo "<td>Champion Choice<br />(<font color='brown'>max points: 11</font>)</td>";
echo "<td>Total Score<br />(<font color='brown'>max points: 21</font>)</td>";
echo "</tr>";
//echo "</table>";
//echo "<br />";



while ($row=mysqli_fetch_array($result)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);

$voter2=substr($tempid,0,-2);
$location=strtolower($location);
if($total_score==21){$rank=1;echo "<tr bgcolor='lightgreen'>";}
if($total_score==17){$rank=2;echo "<tr bgcolor='gold'>";}
if($total_score==15){$rank=3;echo "<tr bgcolor='lightyellow'>";}
if($total_score==12){$rank=4;echo "<tr bgcolor='lightblue'>";}
if($total_score==11){$rank=6;echo "<tr bgcolor='lightblue'>";}
if($total_score==8){$rank=16;echo "<tr bgcolor='lightblue'>";}
if($total_score==6){$rank=17;echo "<tr bgcolor='lightblue'>";}
if($total_score==3){$rank=19;echo "<tr bgcolor='lightblue'>";}
if($total_score==1){$rank=20;echo "<tr bgcolor='lightblue'>";}
if($total_score==0){$rank=27;echo "<tr bgcolor='lightblue'>";}



//echo "<tr>";
echo "<td>$rank</td>";
if($voter2!=$tempid2)
{
echo "<td>$voter2</td>";
}

if($voter2==$tempid2)
{
echo "<td>";
echo "$voter2<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";
echo "</td>";
}





echo "<td>$location</td>";
if($round1_selection_name=='')
{
echo "<td>none (0)</td>";
}

if($round1_selection_name!='')
{
echo "<td>$round1_selection_name ($round1_score)</td>";
}





//echo "<td>$round2_selection_name ($round2_score)</td>";
/*
if($round2_selection_name=='kentucky' or $round2_selection_name=='gonzaga')
{	
echo "<td>$round2_selection_name ($round2_score)</td>";
}
else
{
echo "<td>$round2_selection_name</td>";

}	
*/

if($round2_selection_name=='')
{
echo "<td>none (0)</td>";
}

if($round2_selection_name!='')
{
echo "<td>$round2_selection_name ($round2_score)</td>";
}



if($round3_selection_name=='')
{
echo "<td>none (0)</td>";
}

if($round3_selection_name!='')
{
echo "<td>$round3_selection_name ($round3_score)</td>";
}






	
//echo "<td>$round3_selection_name ($round3_score)</td>";
//echo "<td>$round3_selection_name</td>";
echo "<td align='center'>$total_score</td>";


echo "</tr>";
}	

echo "</table>";













?>