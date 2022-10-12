<?php
/*
session_start();
if(!$_SESSION["budget"]["tempID"]){
header("location: /login_form.php?db=budget");
}
*/
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}



//$file = "articles_menu.php";
//$lines = count(file($file));


$table="infotrack_projects";
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

$active_file=$_SERVER['SCRIPT_NAME'];
$active_file_request=$_SERVER['REQUEST_URI'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$playstation=$_SESSION['budget']['select'];
$playstation_center=$_SESSION['budget']['centerSess'];
//$pcode=$_SESSION['budget']['select'];



//echo "<pre>";print_r($_SERVER);"</pre>";

//echo "active_file=$active_file<br />";
//echo "active_file_request=$active_file_request<br />";


extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//if($level=='5' and $tempID !='Dodd3454')
//echo "pcode=$pcode";
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
echo "<pre>";print_r($_REQUEST);"</pre>";//exit;


//include("../../../include/connectBUDGET.inc");// database connection parameters
//include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
//include("../../budget/~f_year.php");
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 

echo "park=$park<br />";
 
 if($beacnum=='60032781' or $beacnum=='60032793' or $beacnum=='60033018' or $beacnum=='60032920')
 //{$playstation='ADMI';}

$query4="
select 
mission_games.gid,
game_name,
game_location,
game_year,
sid,
dist as 'playstation',
sum(complete),
sum(total),
avg(percomp) as 'percomp'
from mission_games
left join mission_scores on mission_games.gid=mission_scores.gid
left join center on mission_scores.playstation=center.parkcode
where 1
and mission_games.active='y'
and fund='1280' and actcenteryn='y'
and center.parkcode != 'boca' 
and center.parkcode != 'mtst' 
and center.parkcode != 'harp' 
group by mission_games.gid,dist
order by dist,game_name;
";
echo "query4=$query4";

	 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);
//$row4=mysqli_fetch_array($result4);
//extract($row4);
//echo "percomp=$percomp";exit;


//echo "</head>";

echo "<body>";

//$num4=$num4/$playstation_count;
//echo "<br /><table><tr><td><font  color=red>$playstation Missions: $num4</font></td></tr></table>";
echo "<br />";
/*
while ($row=mysqli_fetch_assoc($result4_game_locations))
	{
	$game_locations_array[]=$row['game_locations'];
	}
*/

while ($row=mysqli_fetch_assoc($result4))
	{
	$ARRAY[$row['game_name']][$row['playstation']]=$row['percomp'];
	}
	
echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;




echo "<table border='1'>";

foreach($ARRAY AS $index=>$array)
	{
	echo "<tr><th>$index</th>";
	$var_tot="";
	$i="";
echo "<td>";	
	foreach($array as $fld=>$value)
		{
		$i++;
		//$j++;
		$var_tot+=$value;
		
		//$location[$i]="tony";

echo $fld;
echo round($value,0);echo "<br />";


	
		
		}
	echo "</td>";	
			

	
echo "</tr>";
$j++;
	}
echo "</table>";

 echo "</body>";
 echo "</html>";

 

 ?>
 