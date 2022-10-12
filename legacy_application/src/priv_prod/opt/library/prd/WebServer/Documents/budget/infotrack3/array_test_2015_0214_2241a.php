<?php
/*
session_start();
if(!$_SESSION["budget"]["tempID"]){
header("location: https://10.35.152.9/login_form.php?db=budget");
}
*/
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}
//echo "hello world<br />";


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
if($beacnum=='60032913' or $beacnum=='60032931'){$park='west';}
if($beacnum=='60032912' or $beacnum=='60032892'){$park='east';}
if($beacnum=='60033104' or $beacnum=='60033148'){$park='north';}
if($beacnum=='60033019' or $beacnum=='60033093'){$park='south';}

//$pcode=$_SESSION['budget']['select'];

//echo "playstation=$playstation<br />";

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
//include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
//include("../../budget/~f_year.php");
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 
/*
$query7="update mission_scores
set percomp=complete/total*100
where 1";
*/




$query4_game_locations="select distinct game_location as 'game_locations' from mission_games
left join mission_scores on mission_games.gid=mission_scores.gid
left join center on mission_scores.playstation=center.parkcode
where 1
and mission_games.active='y'
and fund='1280' and actcenteryn='y'
and center.parkcode != 'boca' 
and center.parkcode != 'mtst' 
and center.parkcode != 'harp' 
group by mission_games.gid
order by game_name;";



//echo "query4_game_locations=$query4_game_locations";

$result4_game_locations = mysqli_query($connection, $query4_game_locations) or die ("Couldn't execute query4_game_locations.  $query4_game_locations");


 

while ($row=mysqli_fetch_assoc($result4_game_locations))
	{
	$game_locations_array[]=$row['game_locations'];
	}



	
echo "<pre>"; print_r($game_locations_array); echo "</pre>";  exit;






 

 

 ?>
 