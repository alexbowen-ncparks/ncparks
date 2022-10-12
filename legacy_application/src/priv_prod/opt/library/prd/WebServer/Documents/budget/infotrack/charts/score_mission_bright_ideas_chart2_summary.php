<?php
/*
session_start();
if(!$_SESSION["budget"]["tempID"]){
header("location: /login_form.php?db=budget");
}
*/
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}


//$active_file=$_SERVER['SCRIPT_NAME'];
//$active_file_request=$_SERVER['REQUEST_URI'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$playstation=$_SESSION['budget']['select'];
$playstation_center=$_SESSION['budget']['centerSess'];
//$pcode=$_SESSION['budget']['select'];

if($playstation=='ADM'){$playstation='ADMI';}
$player=$tempID;



extract($_REQUEST);

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 

if($position=='60032793')
{

$query3="select sum(complete) as 'complete',sum(total_points) as 'total_points'
         from mission_bright_ideas where 1 and fyear='$fyear' ; ";
		 
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$row3=mysqli_fetch_array($result3);
extract($row3);		 
		 
//echo "complete=$complete<br />";
//echo "total_points=$total_points<br />";

$query4="select (sum(complete)/sum(total_points))*100 as 'percomp'
         from mission_bright_ideas
		 where 1 and fyear='$fyear' ";
}
//echo $query4;exit;		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$row4=mysqli_fetch_array($result4);
extract($row4);
//echo "percomp=$percomp";
//echo "complete=$complete<br />";
//echo "total=$total<br />";
//echo "percomp=$percomp<br />";
//$num4=mysqli_num_rows($result4);
//$row4=mysqli_fetch_array($result4);
//extract($row4);
//echo "percomp=$percomp";exit;


//echo "</head>";

//echo "<body>";



$width=100;


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
echo "<tr><b>$complete of $total_points</b></tr>";
echo "<tr>";
echo "<td bgcolor='darkseagreen'><a href='bright_idea_steps2_v2.php?cid=$cid&blog=n'><img height='50' width='50' src='/budget/infotrack/icon_photos/green_paint_bucket1.png' alt='picture of green paint'></img></a></td>";
//echo "<th><font color='brown'>Mission</font></th>";
//echo "<th><font color='brown'>Playstation</font></th>";
//echo "<th><font color='brown'>Bonus Points</font></th>";
//echo "</tr>";


echo "<td bgcolor='darkseagreen'>";
?>

<script language="javascript">drawPercentBar(<?php echo $width ?>, <?php echo round($percomp,0) ?>, 'lightgreen','red'); </script> 
<?php
//echo "<br /><b>$complete of $total_points</b>";
//echo "</td>";
         
//echo "</tr>";



 echo "</table>";
 //echo "bright_idea.php line 178 player=$player<br />";//exit;
 //include("bright_idea2.php");
 //echo "</body>";
 //echo "</html>";

 

 ?>
 