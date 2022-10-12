<?php
/*
session_start();
if(!$_SESSION["budget"]["tempID"]){
header("location: https://auth.dpr.ncparks.gov/login_form.php?db=budget");
}
*/
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}
//echo "hello world<br />";


//$file = "articles_menu.php";
//$lines = count(file($file));


$table="infotrack_projects";

//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
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
//if($tempid=='Fullwood1940'){$park='east';} // (John Fullwood)
//if($beacnum=='60033104' or $beacnum=='60033148'){$park='north';}
if($beacnum=='65030652' or $beacnum=='60032920'){$park='north';}
if($beacnum=='60033019' or $beacnum=='60033093'){$park='south';}
//if($beacnum=='60033148'){$park='stwd';}
/*
if($tempID=='Woodruff1111')
{
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
}
*/
//$pcode=$_SESSION['budget']['select'];

//echo "playstation=$playstation<br />";

//echo "<pre>";print_r($_SERVER);"</pre>";

//echo "active_file=$active_file<br />";
//echo "active_file_request=$active_file_request<br />";


extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//if($level=='5' and $tempID !='Dodd3454')
//echo "pcode=$pcode";
/*
if($beacnum=='60032931' or $beacnum=='60033093')
{
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
}

*/
//annette hall at MORE
//if($beacnum=='60032931'){$playstation='WEDI';}

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


// query7 updates TABLE=mission_scores for: (GID9=deposit compliance) (GID11=cash receipts journals)   

/*
$query7="update mission_scores
set percomp=complete/total*100
where 1 and gid != '10' and gid != '12' and gid != '1' and gid != '13' and gid != '8' ";
*/

/*
$query7="update mission_scores
set percomp=complete/total*100
where gid = '9' or gid = '11'  ";
*/

/*
$query7="update mission_scores
set percomp=complete/total*100
where gid = '11'  ";


//echo "query4=$query7<br />";

$result7=mysqli_query($connection, $query7) or die ("Couldn't execute query7. $query7");
*/


/*

$query7a="update mission_scores
set percomp='.01'
where gid = '1' and percomp='0.00' ";



$result7a=mysqli_query($connection, $query7a) or die ("Couldn't execute query7a. $query7a");

*/


// query7b updates TABLE=mission_scores for: (GID9=deposit compliance) 


//GID9 (deposit compliance) only applies to CRS Parks.    Non-CRS Parks always have total=0 and percomp=0.00  Therefore Query will never run for Non-CRS Parks.
// For Non-CRS Parks: This will maintain percomp=0.00 and prevent Scores from displaying in Wheelhouse
// For CRS Parks: If percomp value=0.00, it will be changed to 0.01    This is necessary for Score to display in Wheelhouse


/*
$query7b="update mission_scores
set percomp='.01'
where gid='9'
and complete='0'
and total >= '1' ;";



$result7b=mysqli_query($connection, $query7b) or die ("Couldn't execute query7b. $query7b");
*/

if($fyear=='')
{
//$fyear='1415';
//$fyear='1617';
// 2022-07-01: ccooper - change for FYR rollover
$fyear='2223';


}


if($fyear=='1415'){$shade1415="class=cartRow";}
if($fyear=='1516'){$shade1516="class=cartRow";}
if($fyear=='1617'){$shade1617="class=cartRow";}
if($fyear=='1718'){$shade1718="class=cartRow";}
if($fyear=='1819'){$shade1819="class=cartRow";}
if($fyear=='1920'){$shade1920="class=cartRow";}
if($fyear=='2021'){$shade2021="class=cartRow";}
if($fyear=='2122'){$shade2122="class=cartRow";}
if($fyear=='2223'){$shade2223="class=cartRow";}
if($fyear=='2324'){$shade2324="class=cartRow";}
if($fyear=='2425'){$shade2425="class=cartRow";}






//if($beacnum!='60032913'){include("../../budget/menu1314.php");}
if($level==2)
{
{
if($playstation=='EADI'){$center_location="East District";}
//if($playstation=='EADI'){$center_location="Coastal Region";}
//if($playstation=='NODI'){$center_location="North District";}
if($playstation=='NODI'){$center_location="North District";}
if($playstation=='SODI'){$center_location="South District";}
//if($playstation=='SODI'){$center_location="Piedmont Region";}
if($playstation=='WEDI'){$center_location="West District";}
//if($playstation=='WEDI'){$center_location="Mountain Region";}
}
echo "<br />";
/*
echo "<table><tr><th><img height='25' width='25' src='/budget/wake_tech/images/wheelhouse.png' alt='picture of wheelhouse'><font color='blue'>$center_location</font></img><br /><font color='brown' size='5'><b>Money Management Wheelhouse</b></font></th></tr></table>";
*/
}

if($level>2)
{
/*
if($park=='')
{
echo "<br />";
echo "<table><tr><th><img height='25' width='25' src='/budget/wake_tech/images/wheelhouse.png' alt='picture of wheelhouse'></img>Money Management Wheelhouse(Division)</th></tr></table>";
}
*/

if($park!='')
{
if($park=='east'){$center_location="East District";}
//if($park=='east'){$center_location="Coastal Region";}
if($park=='north'){$center_location="North District";}
//if($park=='north'){$center_location="North District";}
if($park=='south'){$center_location="South District";}
//if($park=='south'){$center_location="Piedmont Region";}
if($park=='stwd'){$center_location="Statewide District";}
//if($park=='stwd'){$center_location="Statewide District";}
if($park=='west'){$center_location="West District";}
//if($park=='west'){$center_location="Mountain Region";}

echo "<br />";
/*
echo "<table><tr><th><img height='25' width='25' src='/budget/wake_tech/images/wheelhouse.png' alt='picture of wheelhouse'><font color='blue'>$center_location</font></img><br /><font color='brown' size='5'><b>Money Management Wheelhouse</b></font></th></tr></table>";
*/
}

}

//echo "<table><tr><th>$playstation Missions</th></tr><tr><th>Planning Phase</th></tr></table>";
//if($level < '5' and $beacnum != '60032984' and $beacnum != '60032934' ) {exit;}


//echo"<html><head><title>Missions</title>";
//include ("report_header4.php");
//include ("test_style.php");
//include ("percent_bar.js");

/*
if($level<'2')

{

$query4="select 
mission_games.gid,
game_name,
game_location,
game_year,
sid,
playstation,
complete,
total,
percomp
from mission_games
left join mission_scores on mission_games.gid=mission_scores.gid
where playstation='$playstation' 
group by mission_games.gid
 ";
 
} 
*/
/*
if($beacnum=='60032931' or $beacnum=='60033093' )
{
echo "hello missions_1.php line 241<br />Level=$level<br />playstation=$playstation";
}
*/


if($level==2 and $playstation=='WEDI')
{

$query4="select 
mission_games.gid,
game_name,
game_location,
game_year,
sid,
playstation,
complete,
total,
percomp
from mission_games
left join mission_scores on mission_games.gid=mission_scores.gid
left join center on mission_scores.playstation=center.parkcode
where 1
and mission_games.active='y'
and dist='west' and (fund='1280' or fund='1680') and actcenteryn='y'
and mission_scores.fyear='$fyear'
group by mission_games.gid,mission_scores.playstation
order by playstation,game_name;";


$query4_game_locations="select distinct game_location as 'game_locations' from mission_games
left join mission_scores on mission_games.gid=mission_scores.gid
left join center on mission_scores.playstation=center.parkcode
where 1
and mission_games.active='y'
and dist='west' and (fund='1280' or fund='1680') and actcenteryn='y'
and mission_scores.fyear='$fyear'
group by mission_games.gid
order by game_name;";
/*
if($beacnum=='60032931')
{
echo "query4_game_locations=$query4_game_locations";
}
*/
$result4_game_locations = mysqli_query($connection, $query4_game_locations) or die ("Couldn't execute query4_game_locations.  $query4_game_locations");

$query4_game_gids="SELECT DISTINCT gid AS  'gids'
FROM mission_games
WHERE 1 
AND mission_games.active =  'y'
ORDER BY game_name";



$result4_game_gids = mysqli_query($connection, $query4_game_gids) or die ("Couldn't execute query4_game_gids.  $query4_game_gids");
/*
$query4_count="select count(parkcode) as 'playstation_count'
from center
where 1
and dist='west' and fund='1280' and actcenteryn='y' ; ";

$result4_count = mysqli_query($connection, $query4_count) or die ("Couldn't execute query4_count.  $query4_count");

$row=mysqli_fetch_array($result4_count);
extract($row);
*/
//echo "query4=$query4<br /><br />";
 }

if($level==2 and $playstation=='EADI')
{

$query4="select 
mission_games.gid,
game_name,
game_location,
game_year,
sid,
playstation,
complete,
total,
percomp
from mission_games
left join mission_scores on mission_games.gid=mission_scores.gid
left join center on mission_scores.playstation=center.parkcode
where 1
and mission_games.active='y'
and dist='east' and (fund='1280' or fund='1680') and actcenteryn='y'
and mission_scores.fyear='$fyear'
group by mission_games.gid,mission_scores.playstation
order by playstation,game_name;";


$query4_game_locations="select distinct game_location as 'game_locations' from mission_games
left join mission_scores on mission_games.gid=mission_scores.gid
left join center on mission_scores.playstation=center.parkcode
where 1
and mission_games.active='y'
and dist='east' and (fund='1280' or fund='1680') and actcenteryn='y'
and mission_scores.fyear='$fyear'
group by mission_games.gid
order by game_name;";
//echo "query4_game_locations=$query4_game_locations";

$result4_game_locations = mysqli_query($connection, $query4_game_locations) or die ("Couldn't execute query4_game_locations.  $query4_game_locations");

$query4_game_gids="SELECT DISTINCT gid AS  'gids'
FROM mission_games
WHERE 1 
AND mission_games.active =  'y'
ORDER BY game_name";



$result4_game_gids = mysqli_query($connection, $query4_game_gids) or die ("Couldn't execute query4_game_gids.  $query4_game_gids");

/*
$query4_count="select count(parkcode) as 'playstation_count'
from center
where 1
and dist='east' and fund='1280' and actcenteryn='y'; ";

$result4_count = mysqli_query($connection, $query4_count) or die ("Couldn't execute query4_count.  $query4_count");

$row=mysqli_fetch_array($result4_count);
extract($row);
*/
 }
 //echo "query4_count=$query4_count";
 //echo "playstation_count=$playstation_count";
 
 if($level==2 and $playstation=='NODI')
{

$query4="select 
mission_games.gid,
game_name,
game_location,
game_year,
sid,
playstation,
complete,
total,
percomp
from mission_games
left join mission_scores on mission_games.gid=mission_scores.gid
left join center on mission_scores.playstation=center.parkcode
where 1
and mission_games.active='y'
and dist='north' and (fund='1280' or fund='1680') and actcenteryn='y'
and center.parkcode != 'mtst' 
and center.parkcode != 'harp' 
and mission_scores.fyear='$fyear'
group by mission_games.gid,mission_scores.playstation
order by playstation,game_name;";
// echo "$query4";


$query4_game_locations="select distinct game_location as 'game_locations' from mission_games
left join mission_scores on mission_games.gid=mission_scores.gid
left join center on mission_scores.playstation=center.parkcode
where 1
and mission_games.active='y'
and dist='north' and (fund='1280' or fund='1680') and actcenteryn='y'
and center.parkcode != 'mtst' 
and center.parkcode != 'harp' 
and mission_scores.fyear='$fyear'
group by mission_games.gid
order by game_name;";


// echo "query4_game_locations=$query4_game_locations";

$result4_game_locations = mysqli_query($connection, $query4_game_locations) or die ("Couldn't execute query4_game_locations.  $query4_game_locations");

$query4_game_gids="SELECT DISTINCT gid AS  'gids'
FROM mission_games
WHERE 1 
AND mission_games.active =  'y'
ORDER BY game_name";



$result4_game_gids = mysqli_query($connection, $query4_game_gids) or die ("Couldn't execute query4_game_gids.  $query4_game_gids");

/*
$query4_count="select count(parkcode) as 'playstation_count'
from center
where 1
and dist='north' and fund='1280' and actcenteryn='y'
and center.parkcode != 'mtst' 
and center.parkcode != 'harp' ;";

$result4_count = mysqli_query($connection, $query4_count) or die ("Couldn't execute query4_count.  $query4_count");

$row=mysqli_fetch_array($result4_count);
extract($row);
*/

 }
 
 
 if($level==2 and $playstation=='SODI')
{

$query4="select 
mission_games.gid,
game_name,
game_location,
game_year,
sid,
playstation,
complete,
total,
percomp
from mission_games
left join mission_scores on mission_games.gid=mission_scores.gid
left join center on mission_scores.playstation=center.parkcode
where 1
and mission_games.active='y'
and dist='south' and (fund='1280' or fund='1680') and actcenteryn='y'
and center.parkcode != 'boca' 
and mission_scores.fyear='$fyear'
group by mission_games.gid,mission_scores.playstation
order by playstation,game_name;";


$query4_game_locations="select distinct game_location as 'game_locations' from mission_games
left join mission_scores on mission_games.gid=mission_scores.gid
left join center on mission_scores.playstation=center.parkcode
where 1
and mission_games.active='y'
and dist='south' and (fund='1280' or fund='1680') and actcenteryn='y'
and center.parkcode != 'boca' 
and mission_scores.fyear='$fyear'
group by mission_games.gid
order by game_name;";

//echo "query4_game_locations=$query4_game_locations";

$result4_game_locations = mysqli_query($connection, $query4_game_locations) or die ("Couldn't execute query4_game_locations.  $query4_game_locations");




$query4_game_gids="SELECT DISTINCT gid AS  'gids'
FROM mission_games
WHERE 1 
AND mission_games.active =  'y'
ORDER BY game_name";



$result4_game_gids = mysqli_query($connection, $query4_game_gids) or die ("Couldn't execute query4_game_gids.  $query4_game_gids");




 } 
/* 
 if($beacnum=='60032781' or $beacnum=='60032793' or $beacnum=='60033018' or $beacnum=='60032920' or $beanum=='60032778')
 */
 //{$playstation='ADMI';}
{
if($park=='east' and $level != 2)
{
$query4="select 
mission_games.gid,
game_name,
game_location,
game_year,
sid,
playstation,
complete,
total,
percomp
from mission_games
left join mission_scores on mission_games.gid=mission_scores.gid
left join center on mission_scores.playstation=center.parkcode
where 1
and mission_games.active='y'
and dist='east' and (fund='1280' or fund='1680') and actcenteryn='y'
and center.parkcode != 'saru'
and mission_scores.fyear='$fyear'
group by mission_games.gid,mission_scores.playstation
order by playstation,game_name;";

//echo "Line513=$query4<br />";

$query4_game_locations="select distinct game_location as 'game_locations' from mission_games
left join mission_scores on mission_games.gid=mission_scores.gid
left join center on mission_scores.playstation=center.parkcode
where 1
and mission_games.active='y'
and dist='east' and (fund='1280' or fund='1680') and actcenteryn='y'
and mission_scores.fyear='$fyear'
group by mission_games.gid
order by game_name;";

//echo "Line525=Query4 game locations=$query4_game_locations<br />";

//if($beacnum=='60032793')
//{
$query4_game_gids="SELECT DISTINCT gid AS  'gids'
FROM mission_games
WHERE 1 
AND mission_games.active =  'y'
ORDER BY game_name";



$result4_game_gids = mysqli_query($connection, $query4_game_gids) or die ("Couldn't execute query4_game_gids.  $query4_game_gids");
//}

//echo "John Fullwood";

}


if($park=='north' and $level != 2)
{
$query4="select 
mission_games.gid,
game_name,
game_location,
game_year,
sid,
playstation,
complete,
total,
percomp
from mission_games
left join mission_scores on mission_games.gid=mission_scores.gid
left join center on mission_scores.playstation=center.parkcode
where 1
and mission_games.active='y'
and dist='north' and (fund='1280' or fund='1680') and actcenteryn='y'
and center.parkcode != 'mtst' 
and center.parkcode != 'harp' 
and mission_scores.fyear='$fyear'
group by mission_games.gid,mission_scores.playstation
order by playstation,game_name;";



$query4_game_locations="select distinct game_location as 'game_locations' from mission_games
left join mission_scores on mission_games.gid=mission_scores.gid
left join center on mission_scores.playstation=center.parkcode
where 1
and mission_games.active='y'
and dist='north' and (fund='1280' or fund='1680') and actcenteryn='y'
and center.parkcode != 'mtst' 
and center.parkcode != 'harp' 
and mission_scores.fyear='$fyear'
group by mission_games.gid
order by game_name;";

//if($beacnum=='60032793')
//{
$query4_game_gids="SELECT DISTINCT gid AS  'gids'
FROM mission_games
WHERE 1 
AND mission_games.active =  'y'
ORDER BY game_name";



$result4_game_gids = mysqli_query($connection, $query4_game_gids) or die ("Couldn't execute query4_game_gids.  $query4_game_gids");
//}
}


if($park=='south' and $level != 2)
{
$query4="select 
mission_games.gid,
game_name,
game_location,
game_year,
sid,
playstation,
complete,
total,
percomp
from mission_games
left join mission_scores on mission_games.gid=mission_scores.gid
left join center on mission_scores.playstation=center.parkcode
where 1
and mission_games.active='y'
and dist='south' and (fund='1280' or fund='1680') and actcenteryn='y'
and center.parkcode != 'boca' 
and mission_scores.fyear='$fyear'
group by mission_games.gid,mission_scores.playstation
order by playstation,game_name;";


$query4_game_locations="select distinct game_location as 'game_locations' from mission_games
left join mission_scores on mission_games.gid=mission_scores.gid
left join center on mission_scores.playstation=center.parkcode
where 1
and mission_games.active='y'
and dist='south' and (fund='1280' or fund='1680') and actcenteryn='y'
and center.parkcode != 'boca' 
and mission_scores.fyear='$fyear'
group by mission_games.gid
order by game_name;";

//if($beacnum=='60032793')
//{
$query4_game_gids="SELECT DISTINCT gid AS  'gids'
FROM mission_games
WHERE 1 
AND mission_games.active =  'y'
ORDER BY game_name";



$result4_game_gids = mysqli_query($connection, $query4_game_gids) or die ("Couldn't execute query4_game_gids.  $query4_game_gids");
//}


}


if($park=='west' and $level != 2)
{

$query4="select 
mission_games.gid,
game_name,
game_location,
game_year,
sid,
playstation,
complete,
total,
percomp
from mission_games
left join mission_scores on mission_games.gid=mission_scores.gid
left join center on mission_scores.playstation=center.parkcode
where 1
and mission_games.active='y'
and dist='west' and (fund='1280' or fund='1680') and actcenteryn='y'
and mission_scores.fyear='$fyear'
group by mission_games.gid,mission_scores.playstation
order by playstation,game_name;";


$query4_game_locations="select distinct game_location as 'game_locations' from mission_games
left join mission_scores on mission_games.gid=mission_scores.gid
left join center on mission_scores.playstation=center.parkcode
where 1
and mission_games.active='y'
and dist='west' and (fund='1280' or fund='1680') and actcenteryn='y'
and mission_scores.fyear='$fyear'
group by mission_games.gid
order by game_name;";

//if($beacnum=='60032793')
//{
$query4_game_gids="SELECT DISTINCT gid AS  'gids'
FROM mission_games
WHERE 1 
AND mission_games.active =  'y'
ORDER BY game_name";



$result4_game_gids = mysqli_query($connection, $query4_game_gids) or die ("Couldn't execute query4_game_gids.  $query4_game_gids");
//}



}






//echo "park=$park<br />";

if($park=='')
{
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
and percomp != '0'
and dist != 'stwd'
and mission_games.active='y'
and fund='1280' and actcenteryn='y'
and center.parkcode != 'boca' 
and center.parkcode != 'mtst' 
and center.parkcode != 'harp' 
and center.parkcode != 'saru'
and mission_scores.fyear='$fyear'
group by mission_games.gid,dist
order by dist,game_name;
";
if($beacnum=='60032920' or $beacnum=='60033093'){echo "query4=$query4";}

$query4_game_locations="select distinct game_location as 'game_locations' from mission_games
left join mission_scores on mission_games.gid=mission_scores.gid
left join center on mission_scores.playstation=center.parkcode
where 1
and mission_games.active='y'
and fund='1280' and actcenteryn='y'
and center.parkcode != 'boca' 
and center.parkcode != 'mtst' 
and center.parkcode != 'harp' 
and mission_scores.fyear='$fyear'
group by mission_games.gid
order by game_name;";


$query4_game_gids="SELECT DISTINCT gid AS  'gids'
FROM mission_games
WHERE 1 
AND mission_games.active =  'y'
ORDER BY game_name";


//if($beacnum=='60032793')
//{
$result4_game_gids = mysqli_query($connection, $query4_game_gids) or die ("Couldn't execute query4_game_gids.  $query4_game_gids");
//}




}
}
//echo "query4_game_locations=$query4_game_locations";

$result4_game_locations = mysqli_query($connection, $query4_game_locations) or die ("Couldn't execute query4_game_locations.  $query4_game_locations");


 
 
//$result4_game_gids = mysqli_query($connection, $query4_game_gids) or die ("Couldn't execute query4_game_gids.  $query4_game_gids"); 
 
 
 
 
/* 
if($beacnum=='60032793')
{
echo $query4;//exit;
}
*/


		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);
//$row4=mysqli_fetch_array($result4);
//extract($row4);
//echo "percomp=$percomp";exit;


//echo "</head>";
/*
echo "level=$level<br /><br />";
echo "playstation=$playstation<br /><br />";
echo "park=$park<br /><br />";
echo "query4=$query4<br /><br />";
*/
echo "<body>";



$width=50;


?>

<script language="javascript"> 
  // drawPercentBar()
  // Written by Matthew Harvey (matt AT unlikelywords DOT com)
  // (http://www.unlikelywords.com/html-morsels/)
  // Distributed under the Creative Commons 
  // "Attribution-NonCommercial-ShareAlike 2.0" License
  // (http://creativecommons.org/licenses/by-nc-sa/2.0/)
  function drawPercentBar(width, percent, color, background) 
  { 
    var pixels = width * (percent / 100); 
    
	
    if (!background) { background = "none"; }
 
    document.write("<div style=\"position: relative; line-height: 1em; background-color: " +                
	background + "; border: 1px solid black; width: "
                	+ width + "px\"  > "); 
				   
			   
				   
    document.write("<div style=\"height: 1.5em; width: " + pixels + "px; background-color: "
                   + color + ";\"></div>"); 
				   
				   
    document.write("<div style=\"position: absolute; text-align: center; padding-top: .25em; width:" 
                   + pixels + "px; top: 0; left: 0\">" + percent + "</div>"); 
				   

    document.write("</div>"); 
  } 
  

</script>






<?php
//echo "<br /><table><tr><td><font  color=red>$playstation Missions: $num4</font></td></tr></table>";

$num4=$num4/$playstation_count;
//echo "<br /><table><tr><td><font  color=red>$playstation Missions: $num4</font></td></tr></table>";
echo "<br />";

//echo "<table border=1>";
//echo "<tr>";
//echo "<th><font color='brown'>Mission</font></th>";
//echo "<th><font color='brown'>Playstation</font></th>";
//echo "<th><font color='brown'>Score</font></th>";
//echo "</tr>";

while ($row=mysqli_fetch_assoc($result4_game_locations))
	{
	$game_locations_array[]=$row['game_locations'];
	}


while ($row=mysqli_fetch_assoc($result4_game_gids))
	{
	$game_gids_array[]=$row['gids'];
	}	
/*	
if($beacnum=='60032793')
{	
echo "<pre>"; print_r($game_gids_array); echo "</pre>"; // exit;	
}	
*/	
	
//echo "<pre>"; print_r($game_locations_array); echo "</pre>";  exit;





while ($row=mysqli_fetch_assoc($result4))
	{
	$ARRAY[$row['game_name']][$row['playstation']]=$row['percomp'];
	$header_array[$row['playstation']]="";
	}
	
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
//echo "<pre>"; print_r($header_array); echo "</pre>"; // exit;


echo "<style>
table {
    background-color: #c2efbc;
   }
   
 th {
     color: brown;
}  
   </style>";

/*  
  echo "<style>
td {
    background-color: cornsilk;
   }
   
 th {
     color: brown;
}  
   </style>"; 
   
*/   
 
//if($beacnum=='60032913' or $beacnum=='60032931'){$park='west';}
//if($beacnum=='60032912' or $beacnum=='60032892'){$park='east';}
//if($beacnum=='60033104' or $beacnum=='60033148'){$park='north';}
//if($beacnum=='60033019' or $beacnum=='60033093'){$park='south';}

     //east super fullwood  //east oa quinn  //denise williams  //south super greenwood  //south oa mitchener //north super woodruff
if($beacnum=='60032913'//west dist super
     or $beacnum=='60032931' // west dist oa
     or $beacnum=='60032912' // east dist super
     or $beacnum=='60032892' // east dist oa
     or $beacnum=='60033148' // deputy director OA
     or $beacnum=='60033019' // south dist super
     or $beacnum=='60033093' // south dist oa
     or $beacnum=='65030652' // north dist super
     or $beacnum=='60032920' // north dist oa
 )

{ 
echo "<table align='center'><tr><td><font size=4 color=brown >Fiscal Year</font></td><td><a href='/budget/menu1314.php?forum=blank&park=$park&fyear=2223'><font  $shade2223>2223</font></a></td><td><a href='/budget/menu1314.php?forum=blank&park=$park&fyear=2122'><font  $shade2122>2122</font></a></td><td><a href='/budget/menu1314.php?forum=blank&park=$park&fyear=2021'><font  $shade2021>2021</font></a></td><td><a href='/budget/menu1314.php?forum=blank&park=$park&fyear=1920'><font  $shade1920>1920</font></a></td><td><a href='/budget/menu1314.php?forum=blank&park=$park&fyear=1819'><font  $shade1819>1819</font></a></td><td><a href='/budget/menu.php?forum=blank&fyear=1718'><font  $shade1718>1718</font></a></td><td><a href='/budget/menu.php?forum=blank&fyear=1617'><font  $shade1617>1617</font></a></td><td><a href='/budget/menu.php?forum=blank&fyear=1516'><font  $shade1516>1516</font></a></td><td><a href='/budget/menu.php?forum=blank&fyear=1415'><font  $shade1415>1415</font></a></td></tr></table>";  
}

//if($beacnum != '60032913' and $beacnum != '60032931')

else

//Raleigh Staff
{ 
echo "<table align='center'><tr><td><font size=4 color=brown >Fiscal Year</font></td><td><a href='/budget/menu1314.php?forum=blank&park=$park&fyear=2223'><font  $shade2223>2223</font></a></td><td><a href='/budget/menu1314.php?forum=blank&park=$park&fyear=2122'><font  $shade2122>2122</font></a></td><td><a href='/budget/menu1314.php?forum=blank&park=$park&fyear=2021'><font  $shade2021>2021</font></a></td><td><a href='/budget/menu1314.php?forum=blank&park=$park&fyear=1920'><font  $shade1920>1920</font></a></td><td><a href='/budget/menu1314.php?forum=blank&park=$park&fyear=1819'><font  $shade1819>1819</font></a></td><td><a href='/budget/menu1314.php?forum=blank&park=$park&fyear=1718'><font  $shade1718>1718</font></a></td><td><a href='/budget/menu1314.php?forum=blank&park=$park&fyear=1617'><font  $shade1617>1617</font></a></td><td><a href='/budget/menu1314.php?forum=blank&park=$park&fyear=1516'><font  $shade1516>1516</font></a></td><td><a href='/budget/menu1314.php?forum=blank&park=$park&fyear=1415'><font  $shade1415>1415</font></a></td></tr></table>";  
}



if($park=='')
{
echo "<table border='1' align='center'><tr>";
echo "<th><img height='50' width='50' src='/budget/wake_tech/images/wheelhouse.png' alt='picture of wheelhouse'></img><font color='blue'>$center_location</font></img></th>";
foreach($header_array AS $index=>$header)
	{
	if($index=='east'){$index3='east';}
	if($index=='north'){$index3='north';}
	if($index=='south'){$index3='south';}
	if($index=='west'){$index3='west';}
	echo "<th>$index3";
	if($index=='east' or $index=='north' or $index=='south' or $index=='west' or $index=='stwd')
	{echo "<br /><a href='menu1314.php?&fyear=$fyear&park=$index'>view</a>";}
	echo "</th>";
	}
	echo "<th>Total</th>";
echo "</tr>";
foreach($ARRAY AS $index=>$array)
	{
	echo "<tr><td><font color='brown'>$index</font></td>";
	$var_tot="";
	$i="";
	
	foreach($array as $fld=>$value)
		{
		
		if($value != 0)
		{$i++;}
		
		//$i++;
		//$j++;
		$var_tot+=$value;
		
		//$location[$i]="tony";
echo "<td>";

$value2=round($value,0);
if($j==''){$j=0;}

$gid=$game_gids_array[$j];


if($gid != '12' and $value != 0)
{
echo "<script language='javascript'>drawPercentBar($width,$value2,'lightgreen','red')</script>"; 
}
/*
if($beacnum=='60032793')
{
echo "gid=$gid";
}
*/
//$game_locations=array("tony","tammy","tara");


//echo $game_locations_array[$j];
$location=$game_locations_array[$j];

//$j++;
//echo "<br />";
//echo $fld;
if($fld!='east' and $fld!='north' and $fld!='south' and $fld!='west' and $fld!='stwd' and $value != '0')
{
echo "<a href='$location?fyear=$fyear&park=$fld'>";
echo "<img height='20' width='20' src='/budget/wake_tech/images/magnify.png' alt='picture of home'></img>";
echo "</a>"; 
}
echo "</td>";	
		
		}
		$gt=$var_tot/$i;
		
		
		
echo "<td>";		
 
$gt=round($gt,0);


if($gid!='12')
{
echo "<script language='javascript'>drawPercentBar($width,$gt,'lightgreen','red'); </script> ";
}
/*
if($beacnum=='60032793')
{
echo "gid=$gid";
}
*/
echo "</td>";		
echo "</tr>";
$j++;
	}
echo "</table>";
}


if($park!='')
{
echo "<table border='1' align='center'><tr>";
echo "<th><img height='50' width='50' src='/budget/wake_tech/images/wheelhouse.png' alt='picture of wheelhouse'></img><font color='blue'>$center_location</font></img></th>";
foreach($header_array AS $index=>$header)
	{
	//if($index=='east'){$index3='core';}
	//if($index=='south'){$index3='pire';}
	//if($index=='west'){$index3='more';}
	echo "<th>$index";
	if($index=='east' or $index=='north' or $index=='south' or $index=='west' or $index=='stwd')
	{echo "<br /><a href='menu1314.php?&fyear=$fyear&park=$index'>view</a>";}
	echo "</th>";
	}
	echo "<th>Total</th>";
echo "</tr>";
foreach($ARRAY AS $index=>$array)
	{
	echo "<tr><td><font color='brown'>$index</font></td>";
	$var_tot="";
	$i="";
	
	foreach($array as $fld=>$value)
		{
		
		if($value != 0)
		{$i++;}
		
		//$i++;
		//$j++;
		$var_tot+=$value;
		
		//$location[$i]="tony";
echo "<td>";

$value2=round($value,0);
if($j==''){$j=0;}

$gid=$game_gids_array[$j];


if($gid != '12' and $value != 0)
{
echo "<script language='javascript'>drawPercentBar($width,$value2,'lightgreen','red')</script>"; 
}
/*
if($beacnum=='60032793')
{
echo "gid=$gid";
}
*/
//$game_locations=array("tony","tammy","tara");


//echo $game_locations_array[$j];
$location=$game_locations_array[$j];

//$j++;
//echo "<br />";
//echo $fld;
if($fld!='east' and $fld!='north' and $fld!='south' and $fld!='west' and $fld!='stwd' and $value != '0')
{
echo "<a href='$location?fyear=$fyear&park=$fld'>";
echo "<img height='20' width='20' src='/budget/wake_tech/images/magnify.png' alt='picture of home'></img>";
echo "</a>"; 
}
echo "</td>";	
		
		}
		$gt=$var_tot/$i;
		
		
		
echo "<td>";		
 
$gt=round($gt,0);


if($gid!='12')
{
echo "<script language='javascript'>drawPercentBar($width,$gt,'lightgreen','red'); </script> ";
}
/*
if($beacnum=='60032793')
{
echo "gid=$gid";
}
*/
echo "</td>";		
echo "</tr>";
$j++;
	}
echo "</table>";
}

/*
while ($row4=mysqli_fetch_array($result4)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4);
$countid=number_format($countid,0);
$rank=$rank+1;
$rank2="(".$rank.")";
$percomp=round($percomp);
//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
if($percomp=="100.00"){$bgc="lightgreen";} else {$bgc="lightpink";}

echo 

"<tr bgcolor='$bgc'>"; 
//echo "<td>$rank2</td>";  
//echo "<td>$location</td>";
//echo "<td><a href='$weblink' target='_blank'>$project_note</a></td>";
//echo "<td></td><td></td>"; 

echo "<td>";

echo "<a href='$game_location'>$game_name</a>";


echo "</td>"; 

echo "<td>$playstation</td>";


//echo "<td>$complete of $total</td>";
?>
<?php
echo "<td>";?>

<script language="javascript">drawPercentBar(<?php echo $width ?>, <?php echo $percomp ?>, 'lightgreen','red'); </script> 
<?php
echo "</td>";	          
echo "</tr>";

}

 echo "</table>";
 */
 echo "</body>";
 echo "</html>";

 

 ?>
 