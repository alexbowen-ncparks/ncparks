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
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database 
/*
$query7="update mission_scores
set percomp=complete/total*100
where 1";
*/


$query7="update mission_scores
set percomp=complete/total*100
where 1 and gid != '10' ";


//echo "query4=$query7<br />";

$result7=mysql_query($query7) or die ("Couldn't execute query7. $query7");


$query7a="update mission_scores
set percomp='.01'
where gid = '1' and percomp='0.00' ";



$result7a=mysql_query($query7a) or die ("Couldn't execute query7a. $query7a");







//if($beacnum!='60032913'){include("../../budget/menu1314.php");}
if($level==2)
{
{
if($playstation=='EADI'){$center_location="East District";}
if($playstation=='NODI'){$center_location="North District";}
if($playstation=='SODI'){$center_location="South District";}
if($playstation=='WEDI'){$center_location="West District";}
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
if($park=='north'){$center_location="North District";}
if($park=='south'){$center_location="South District";}
if($park=='stwd'){$center_location="Statewide District";}
if($park=='west'){$center_location="West District";}

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
and dist='west' and fund='1280' and actcenteryn='y'
group by mission_games.gid,mission_scores.playstation
order by playstation,game_name;";


$query4_game_locations="select distinct game_location as 'game_locations' from mission_games
left join mission_scores on mission_games.gid=mission_scores.gid
left join center on mission_scores.playstation=center.parkcode
where 1
and mission_games.active='y'
and dist='west' and fund='1280' and actcenteryn='y'
group by mission_games.gid
order by game_name;";

//echo "query4_game_locations=$query4_game_locations";

$result4_game_locations = mysql_query($query4_game_locations) or die ("Couldn't execute query4_game_locations.  $query4_game_locations");

$query4_game_gids="SELECT DISTINCT gid AS  'gids'
FROM mission_games
WHERE 1 
AND mission_games.active =  'y'
ORDER BY game_name";



$result4_game_gids = mysql_query($query4_game_gids) or die ("Couldn't execute query4_game_gids.  $query4_game_gids");
/*
$query4_count="select count(parkcode) as 'playstation_count'
from center
where 1
and dist='west' and fund='1280' and actcenteryn='y' ; ";

$result4_count = mysql_query($query4_count) or die ("Couldn't execute query4_count.  $query4_count");

$row=mysql_fetch_array($result4_count);
extract($row);
*/

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
and dist='east' and fund='1280' and actcenteryn='y'
group by mission_games.gid,mission_scores.playstation
order by playstation,game_name;";


$query4_game_locations="select distinct game_location as 'game_locations' from mission_games
left join mission_scores on mission_games.gid=mission_scores.gid
left join center on mission_scores.playstation=center.parkcode
where 1
and mission_games.active='y'
and dist='east' and fund='1280' and actcenteryn='y'
group by mission_games.gid
order by game_name;";
//echo "query4_game_locations=$query4_game_locations";

$result4_game_locations = mysql_query($query4_game_locations) or die ("Couldn't execute query4_game_locations.  $query4_game_locations");

$query4_game_gids="SELECT DISTINCT gid AS  'gids'
FROM mission_games
WHERE 1 
AND mission_games.active =  'y'
ORDER BY game_name";



$result4_game_gids = mysql_query($query4_game_gids) or die ("Couldn't execute query4_game_gids.  $query4_game_gids");

/*
$query4_count="select count(parkcode) as 'playstation_count'
from center
where 1
and dist='east' and fund='1280' and actcenteryn='y'; ";

$result4_count = mysql_query($query4_count) or die ("Couldn't execute query4_count.  $query4_count");

$row=mysql_fetch_array($result4_count);
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
and dist='north' and fund='1280' and actcenteryn='y'
and center.parkcode != 'mtst' 
and center.parkcode != 'harp' 
group by mission_games.gid,mission_scores.playstation
order by playstation,game_name;";



$query4_game_locations="select distinct game_location as 'game_locations' from mission_games
left join mission_scores on mission_games.gid=mission_scores.gid
left join center on mission_scores.playstation=center.parkcode
where 1
and mission_games.active='y'
and dist='north' and fund='1280' and actcenteryn='y'
and center.parkcode != 'mtst' 
and center.parkcode != 'harp' 
group by mission_games.gid
order by game_name;";


//echo "query4_game_locations=$query4_game_locations";

$result4_game_locations = mysql_query($query4_game_locations) or die ("Couldn't execute query4_game_locations.  $query4_game_locations");

$query4_game_gids="SELECT DISTINCT gid AS  'gids'
FROM mission_games
WHERE 1 
AND mission_games.active =  'y'
ORDER BY game_name";



$result4_game_gids = mysql_query($query4_game_gids) or die ("Couldn't execute query4_game_gids.  $query4_game_gids");

/*
$query4_count="select count(parkcode) as 'playstation_count'
from center
where 1
and dist='north' and fund='1280' and actcenteryn='y'
and center.parkcode != 'mtst' 
and center.parkcode != 'harp' ;";

$result4_count = mysql_query($query4_count) or die ("Couldn't execute query4_count.  $query4_count");

$row=mysql_fetch_array($result4_count);
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
and dist='south' and fund='1280' and actcenteryn='y'
and center.parkcode != 'boca' 
group by mission_games.gid,mission_scores.playstation
order by playstation,game_name;";


$query4_game_locations="select distinct game_location as 'game_locations' from mission_games
left join mission_scores on mission_games.gid=mission_scores.gid
left join center on mission_scores.playstation=center.parkcode
where 1
and mission_games.active='y'
and dist='south' and fund='1280' and actcenteryn='y'
and center.parkcode != 'boca' 
group by mission_games.gid
order by game_name;";

//echo "query4_game_locations=$query4_game_locations";

$result4_game_locations = mysql_query($query4_game_locations) or die ("Couldn't execute query4_game_locations.  $query4_game_locations");




$query4_game_gids="SELECT DISTINCT gid AS  'gids'
FROM mission_games
WHERE 1 
AND mission_games.active =  'y'
ORDER BY game_name";



$result4_game_gids = mysql_query($query4_game_gids) or die ("Couldn't execute query4_game_gids.  $query4_game_gids");




 } 
/* 
 if($beacnum=='60032781' or $beacnum=='60032793' or $beacnum=='60033018' or $beacnum=='60032920' or $beanum=='60032778')
 */
 //{$playstation='ADMI';}
{
if($park=='east')
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
and dist='east' and fund='1280' and actcenteryn='y'
and center.parkcode != 'saru'
group by mission_games.gid,mission_scores.playstation
order by playstation,game_name;";


$query4_game_locations="select distinct game_location as 'game_locations' from mission_games
left join mission_scores on mission_games.gid=mission_scores.gid
left join center on mission_scores.playstation=center.parkcode
where 1
and mission_games.active='y'
and dist='east' and fund='1280' and actcenteryn='y'
group by mission_games.gid
order by game_name;";


//if($beacnum=='60032793')
//{
$query4_game_gids="SELECT DISTINCT gid AS  'gids'
FROM mission_games
WHERE 1 
AND mission_games.active =  'y'
ORDER BY game_name";



$result4_game_gids = mysql_query($query4_game_gids) or die ("Couldn't execute query4_game_gids.  $query4_game_gids");
//}



}


if($park=='north')
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
and dist='north' and fund='1280' and actcenteryn='y'
and center.parkcode != 'mtst' 
and center.parkcode != 'harp' 
group by mission_games.gid,mission_scores.playstation
order by playstation,game_name;";



$query4_game_locations="select distinct game_location as 'game_locations' from mission_games
left join mission_scores on mission_games.gid=mission_scores.gid
left join center on mission_scores.playstation=center.parkcode
where 1
and mission_games.active='y'
and dist='north' and fund='1280' and actcenteryn='y'
and center.parkcode != 'mtst' 
and center.parkcode != 'harp' 
group by mission_games.gid
order by game_name;";

//if($beacnum=='60032793')
//{
$query4_game_gids="SELECT DISTINCT gid AS  'gids'
FROM mission_games
WHERE 1 
AND mission_games.active =  'y'
ORDER BY game_name";



$result4_game_gids = mysql_query($query4_game_gids) or die ("Couldn't execute query4_game_gids.  $query4_game_gids");
//}
}


if($park=='south')
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
and dist='south' and fund='1280' and actcenteryn='y'
and center.parkcode != 'boca' 
group by mission_games.gid,mission_scores.playstation
order by playstation,game_name;";


$query4_game_locations="select distinct game_location as 'game_locations' from mission_games
left join mission_scores on mission_games.gid=mission_scores.gid
left join center on mission_scores.playstation=center.parkcode
where 1
and mission_games.active='y'
and dist='south' and fund='1280' and actcenteryn='y'
and center.parkcode != 'boca' 
group by mission_games.gid
order by game_name;";

//if($beacnum=='60032793')
//{
$query4_game_gids="SELECT DISTINCT gid AS  'gids'
FROM mission_games
WHERE 1 
AND mission_games.active =  'y'
ORDER BY game_name";



$result4_game_gids = mysql_query($query4_game_gids) or die ("Couldn't execute query4_game_gids.  $query4_game_gids");
//}


}


if($park=='west')
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
and dist='west' and fund='1280' and actcenteryn='y'
group by mission_games.gid,mission_scores.playstation
order by playstation,game_name;";


$query4_game_locations="select distinct game_location as 'game_locations' from mission_games
left join mission_scores on mission_games.gid=mission_scores.gid
left join center on mission_scores.playstation=center.parkcode
where 1
and mission_games.active='y'
and dist='west' and fund='1280' and actcenteryn='y'
group by mission_games.gid
order by game_name;";

//if($beacnum=='60032793')
//{
$query4_game_gids="SELECT DISTINCT gid AS  'gids'
FROM mission_games
WHERE 1 
AND mission_games.active =  'y'
ORDER BY game_name";



$result4_game_gids = mysql_query($query4_game_gids) or die ("Couldn't execute query4_game_gids.  $query4_game_gids");
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
group by mission_games.gid,dist
order by dist,game_name;
";


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


$query4_game_gids="SELECT DISTINCT gid AS  'gids'
FROM mission_games
WHERE 1 
AND mission_games.active =  'y'
ORDER BY game_name";


//if($beacnum=='60032793')
//{
$result4_game_gids = mysql_query($query4_game_gids) or die ("Couldn't execute query4_game_gids.  $query4_game_gids");
//}




}
}
//echo "query4_game_locations=$query4_game_locations";

$result4_game_locations = mysql_query($query4_game_locations) or die ("Couldn't execute query4_game_locations.  $query4_game_locations");


 
 
//$result4_game_gids = mysql_query($query4_game_gids) or die ("Couldn't execute query4_game_gids.  $query4_game_gids"); 
 
 
 
 
 
if($beacnum=='60032793')
{
echo $query4;//exit;
}		 
$result4 = mysql_query($query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysql_num_rows($result4);
//$row4=mysql_fetch_array($result4);
//extract($row4);
//echo "percomp=$percomp";exit;


//echo "</head>";

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

while ($row=mysql_fetch_assoc($result4_game_locations))
	{
	$game_locations_array[]=$row['game_locations'];
	}


while ($row=mysql_fetch_assoc($result4_game_gids))
	{
	$game_gids_array[]=$row['gids'];
	}	
	
if($beacnum=='60032793')
{	
echo "<pre>"; print_r($game_gids_array); echo "</pre>"; // exit;	
}	
	
	
//echo "<pre>"; print_r($game_locations_array); echo "</pre>";  exit;





while ($row=mysql_fetch_assoc($result4))
	{
	$ARRAY[$row['game_name']][$row['playstation']]=$row['percomp'];
	$header_array[$row['playstation']]="";
	}
	
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
//echo "<pre>"; print_r($header_array); echo "</pre>"; // exit;


echo "<style>
td {
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
   
   
   

echo "<table border='1' align='center'><tr>";
echo "<th><img height='50' width='50' src='/budget/wake_tech/images/wheelhouse.png' alt='picture of wheelhouse'></img><font color='blue'>$center_location</font></img></th>";
foreach($header_array AS $index=>$header)
	{
	
	echo "<th>$index";
	if($index=='east' or $index=='north' or $index=='south' or $index=='west' or $index=='stwd')
	{echo "<br /><a href='menu1314.php?park=$index'>view</a>";}
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

$value=round($value,0);
if($j==''){$j=0;}

$gid=$game_gids_array[$j];


if($gid != '12')
{
echo "<script language='javascript'>drawPercentBar($width,$value,'lightgreen','red')</script>"; 
}
if($beacnum=='60032793')
{
echo "gid=$gid";
}
//$game_locations=array("tony","tammy","tara");


//echo $game_locations_array[$j];
$location=$game_locations_array[$j];

//$j++;
//echo "<br />";
//echo $fld;
if($fld!='east' and $fld!='north' and $fld!='south' and $fld!='west' and $fld!='stwd')
{
echo "<a href='$location?park=$fld'>";
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
if($beacnum=='60032793')
{
echo "gid=$gid";
}
echo "</td>";		
echo "</tr>";
$j++;
	}
echo "</table>";
/*
while ($row4=mysql_fetch_array($result4)){

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
 