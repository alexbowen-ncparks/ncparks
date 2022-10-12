<?php
/*
session_start();
if(!$_SESSION["budget"]["tempID"]){
header("location: /login_form.php?db=budget");
}
*/
/*
error_reporting(E_ALL);
ini_set('display_errors', 1);
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
//echo "<pre>";print_r($_SESSION);"</pre>";exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;


//include("../../../include/connectBUDGET.inc");// database connection parameters
//include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
//include("../../budget/~f_year.php");
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database 
include("../../../include/activity.php");// database connection parameters

// score_missions.php updates TABLE=mission_scores for: (GID8=surveys) (GID9=deposit compliance)

include("score_missions.php");


//include("score_game1.php");


/*
$query7="update mission_scores
set percomp=complete/total*100
where 1";
*/

// query7 updates TABLE=mission_scores for: (GID8=surveys) (GID9=deposit compliance) (GID11=cash receipts journals)  (GID13=park fuel) 


$query7="update mission_scores
set percomp=complete/total*100
where 1 and gid != '10'
and gid != '12'
and gid != '1'
 ";



$result7=mysql_query($query7) or die ("Couldn't execute query7. $query7");

/*

$query7a="update mission_scores
set percomp='.01'
where gid = '1' and percomp='0.00' ";



$result7a=mysql_query($query7a) or die ("Couldn't execute query7a. $query7a");

*/

// query7b updates TABLE=mission_scores for: (GID9=deposit compliance) 


$query7b="update mission_scores
set percomp='.01'
where gid='9'
and complete='0'
and total >= '1' ;";



$result7b=mysql_query($query7b) or die ("Couldn't execute query7b. $query7b");









//include("../../budget/menu1314.php");
/*
if($level>3)
{
echo "<table><tr><th>MoneyCounts \"Wheelhouse\" is under Development (Not ready for use)</th></tr>
<tr><td>The Money Counts \"Wheelhouse\" is designed to assist each Park with managing money at  their Park. </td></tr></table>";
}
*/
//echo "<table><tr><th>$playstation Missions</th></tr><tr><th>Planning Phase</th></tr></table>";
//if($level < '5' and $beacnum != '60032984' and $beacnum != '60032934' ) {exit;}


//echo"<html><head><title>Missions</title>";
//include ("report_header4.php");
//include ("test_style.php");
//include ("percent_bar.js");
//echo "beacnum=$beacnum";
//exit;
//echo "beacnum=$beacnum";

// (60032781=Budget Officer Dodd)  (60032793=Accountant Bass)  (60033018=CHOP ONeal)  (60032920=CHOP OA Williams) (60032778=DIRE Murphy)


/*
 if($beacnum=='60032781' or $beacnum=='60032793' or $beacnum=='60033018' or $beacnum=='60032920' or $beacnum=='60032778')
{
//echo "hello";exit;
header("location: missions_1.php");
}
//echo "goodbye";
if($level=='2')
{
header("location: missions_1.php");
}
*/




if($level<'2')

{

$query2="select center_desc,center from center where parkcode='$playstation'   ";	

//echo "query1d=$query1d<br />";//exit;		  

$result2 = mysql_query($query2) or die ("Couldn't execute query 2.  $query2");
		  
$row2=mysql_fetch_array($result2);

extract($row2);

$center_location = str_replace("_", " ", $center_desc);


//include("../../budget/menu1314.php");
/*
echo "<table><tr><th><img height='25' width='25' src='/budget/wake_tech/images/wheelhouse.png' alt='picture of wheelhouse'></img>Money Management Wheelhouse(Park)</th></tr></table>";
*/
echo "<br />";
/*
echo "<table><tr><th><img height='25' width='25' src='/budget/wake_tech/images/wheelhouse.png' alt='picture of wheelhouse'><font color='blue'>$center_location</font></img><br /><font color='brown' size='5'><b>Money Management Wheelhouse</b></font></th></tr></table>";
*/

//echo "f_year=$f_year<br />";
if($fyear=='')
{
$fyear='1415';
}

echo "fyear=$fyear<br />";


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
and mission_games.active='y'
and mission_scores.percomp != '0.00'
and mission_scores.fyear='$fyear'
group by mission_games.gid
order by game_name
 ";
 
} 

/*
if($level=='3')

{
include("../../budget/menu1314.php");
echo "<table><tr><th>MoneyCounts \"Wheelhouse\" is under Development (Not ready for use)</th></tr>
<tr><td>The Money Counts \"Wheelhouse\" is designed to assist each Park with managing money at  their Park. </td></tr></table>";
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
and dist='west' and fund='1280' and actcenteryn='y'
group by mission_games.gid,mission_scores.playstation;";

 }
*/

//echo $query4;//exit;		 
$result4 = mysql_query($query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysql_num_rows($result4);
//$row4=mysql_fetch_array($result4);
//extract($row4);
//echo "percomp=$percomp";exit;


//echo "</head>";

//echo "<body>";



$width=400;


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
				   
				   
    document.write("<div style=\"position: absolute; text-align: right; padding-top: .25em; width:" 
                   + pixels + "px; top: 0; left: 0\">" + percent + "</div>"); 
				   

    document.write("</div>"); 
  } 
  

</script>






<?php
//echo "<br /><table><tr><td><font  color=red>$playstation Missions: $num4</font></td></tr></table>";
//echo "<table><tr>";

//echo "</tr></table>";
echo "<br />";
echo "<table align='center'><tr><td><img height='50' width='50' src='/budget/wake_tech/images/wheelhouse.png' alt='picture of wheelhouse'></img></td><td><font size=4 color=brown >Fiscal Year</font><td><a href=''><font  class='cartRow'>$fyear</font></a></td></tr></table>";  
echo "<table border=1>";
/*
if($level != '3')
{
echo "<tr>";
echo "<th><img height='50' width='50' src='/budget/wake_tech/images/wheelhouse.png' alt='picture of wheelhouse'></img></th>";
//echo "<th><font color='brown'>Mission</font></th>";
//echo "<th><font color='brown'>Playstation</font></th>";
echo "<th><font color='brown'>Score</font></th>";
echo "</tr>";
}
*/
while ($row4=mysql_fetch_array($result4)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4);
//$countid=number_format($countid,0);
//$rank=$rank+1;
//$rank2="(".$rank.")";
$percomp=round($percomp);
//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
//if($percomp=="100.00"){$bgc="lightgreen";} else {$bgc="lightpink";}
$table_bg2='cornsilk';
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}


echo 

"<tr$t>"; 
//echo "<td>$rank2</td>";  
//echo "<td>$location</td>";
//echo "<td><a href='$weblink' target='_blank'>$project_note</a></td>";
//echo "<td></td><td></td>"; 

echo "<td>";

echo "<a href='$game_location'>$game_name</a>";


echo "</td>"; 

//echo "<td>$playstation</td>";


//echo "<td>$complete of $total</td>";
?>
<?php
if($gid == '12')
{echo "<td></td>";}
else
{
echo "<td>";

echo "<script language='javascript'>drawPercentBar($width,$percomp,'lightgreen','red')</script>"; 

echo "</td>";
}
?>	
<?php
          
echo "</tr>";

}

 echo "</table>";
 echo "</body>";
 echo "</html>";

 

 ?>
 