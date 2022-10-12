<?php
/*
session_start();
if(!$_SESSION["budget"]["tempID"]){
header("location: /login_form.php?db=budget");
}
*/

ini_set('display_errors',1);
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
$position=$_SESSION['budget']['beacon_num'];
$playstation=$_SESSION['budget']['select'];
$playstation_center=$_SESSION['budget']['centerSess'];
//$pcode=$_SESSION['budget']['select'];

if($position=='60032781' or $position=='60032793'){$playstation='ADMI';}
//echo "playstation=$playstation";exit;


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


$query3="select sum(complete)as 'complete',sum(total_points) as 'total',sum(complete)/sum(total_points) as 'percomp'
         from mission_bright_ideas where park='admi'
		 and gid='4' ";

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$row3=mysqli_fetch_array($result3);
extract($row3);

//echo "complete=$complete<br />";
//echo "total=$total<br />";
//echo "percomp=$percomp<br />";exit;
$percomp=100*$percomp;

$query3a="update mission_scores 
          set complete='$complete',total='$total',percomp='$percomp' 
		  where gid='4'
          and playstation='admi'
          and position='60032793' ";

$result3a = mysqli_query($connection, $query3a) or die ("Couldn't execute query 3a.  $query3a");




/*
$query7="update mission_scores
set percomp=complete/total*100
where 1";

$result7=mysqli_query($connection, $query7) or die ("Couldn't execute query7. $query7");
*/


include("../../budget/menu1314.php");

echo "<table><tr><th>MoneyCounts \"Wheelhouse\" is under Development (Not ready for use)</th></tr>
<tr><td>The Money Counts \"Wheelhouse\" is designed to assist each Park with managing money at  their Park. </td></tr></table>";
//echo "<table><tr><th>$playstation Missions</th></tr><tr><th>Planning Phase</th></tr></table>";
//if($level < '5' and $beacnum != '60032984' and $beacnum != '60032934' ) {exit;}


//echo"<html><head><title>Missions</title>";
//include ("report_header4.php");
//include ("test_style.php");
//include ("percent_bar.js");




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
and position='$position'
group by mission_games.gid
 ";
 




//echo $query4;//exit;		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);
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
echo "<th><img height='50' width='50' src='/budget/wake_tech/images/wheelhouse.png' alt='picture of wheelhouse'></img></th>";
//echo "<th><font color='brown'>Mission</font></th>";
//echo "<th><font color='brown'>Playstation</font></th>";
echo "<th><font color='brown'>Score</font></th>";
echo "</tr>";

while ($row4=mysqli_fetch_array($result4)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4);
//$countid=number_format($countid,0);
//$rank=$rank+1;
//$rank2="(".$rank.")";
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

//echo "<td>$playstation</td>";


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
 echo "</body>";
 echo "</html>";

 

 ?>
 