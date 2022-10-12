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
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 
include("../../../include/activity.php");// database connection parameters

include("score_missions.php");



$query7="update mission_scores
set percomp=complete/total*100
where 1 and gid='8' ";

$result7=mysqli_query($connection, $query7) or die ("Couldn't execute query7. $query7");

$query8="SELECT percomp as 'score' 
         from mission_scores 
         where gid='8'
		 and playstation='$park'
        ";
		 
//echo "query8=$query8<br />";		 

$result8 = mysqli_query($connection, $query8) or die ("Couldn't execute query 8.  $query8");

$row8=mysqli_fetch_array($result8);
extract($row8); 
$score=round($score);
//echo "<table><tr><td>Score: $score</td></tr></table>";
 echo "<table><tr><th align='center' colspan='2'><font size='5' color='brown' ><b>Score<br /> $score</b></font></th></tr></table><br />";
//echo "gid=$gid";
 echo "</body>";
 echo "</html>";

 

 ?>
 