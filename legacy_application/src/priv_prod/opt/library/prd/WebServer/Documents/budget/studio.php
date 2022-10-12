<?php
/*
session_start();
if(!$_SESSION["budget"]["tempID"]){
header("location: /login_form.php?db=budget");
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

$result7=mysqli_query($connection, $query7) or die ("Couldn't execute query7. $query7");
*/


include("../../budget/menu1314.php");

echo "<table><tr><th>MoneyCounts \"Studio\" is under Development (Not ready for use)</th></tr>
<tr><td>The Money Counts \"Studio\" is the place to share Design ideas to make Money Counts better </td></tr></table>";
//echo "<table><tr><th>$playstation Missions</th></tr><tr><th>Planning Phase</th></tr></table>";
//if($level < '5' and $beacnum != '60032984' and $beacnum != '60032934' ) {exit;}


//echo"<html><head><title>Missions</title>";
//include ("report_header4.php");
//include ("test_style.php");
//include ("percent_bar.js");

if($beacnum=='60032793')
{
header("location: missions_2.php");
}

if($level=='2')
{
header("location: missions_1.php");
}
else
{


if($level<'2')

{

$query4="select 
mission_games.gid,
game_name,
game_location,
game_year,
sid,
playstation,
total
from mission_games
left join mission_design_scores on mission_games.gid=mission_design_scores.gid
where playstation='$playstation' 
and mission_games.gid = '4'
group by mission_games.gid
 ";
 
} 




//echo $query4;exit;		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$row4=mysqli_fetch_array($result4);
extract($row4);

//$num4=mysqli_num_rows($result4);
//$row4=mysqli_fetch_array($result4);
//extract($row4);
//echo "percomp=$percomp";exit;


//echo "</head>";

echo "<body>";



$width=200;


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
//echo "<table><tr>";

//echo "</tr></table>";
echo "<br />";

echo "<table border=1>";
echo "<tr>";
echo "<td><img height='50' width='50' src='/budget/infotrack/icon_photos/property_photos_45.png' alt='picture of blue light bulb'></img>";
//echo "<th><font color='brown'>Mission</font></th>";
//echo "<th><font color='brown'>Playstation</font></th>";
//echo "<th><font color='brown'>Bonus Points</font></th>";
//echo "</tr>";


//echo "<td>";
?>

<script language="javascript">drawPercentBar(<?php echo $total ?>, <?php echo $total ?>, 'lightgreen','lightgreen'); </script> 
<?php
echo "</td>";	          
echo "</tr>";



 echo "</table>";
 include("procedures_test_1835.php");
 echo "</body>";
 echo "</html>";

 }

 ?>
 