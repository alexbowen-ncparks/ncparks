<?php
/*
session_start();
if(!$_SESSION["budget"]["tempID"]){
header("location: /login_form.php?db=budget");
}
*/
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}
//game id to be scored


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

if($playstation=='ADM'){$playstation='ADMI';}
$player=$tempID;
//echo "playstation=$playstation<br />";
//echo "player=$player<br />";exit;
//echo "<pre>";print_r($_SERVER);"</pre>";

//echo "active_file=$active_file<br />";
//echo "active_file_request=$active_file_request<br />";


extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//if($level=='5' and $tempID !='Dodd3454')
//echo "pcode=$pcode";
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;


//include("../../../include/connectBUDGET.inc");// database connection parameters
//include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
//include("../../budget/~f_year.php");
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 




//include("../../budget/menu1314_v3.php");

//echo "<table><tr><th>\"Bright\" Idea under Development (Not ready for use)</th></tr>
//</table>";

//Game to be scored
$gid=15;


//$gid 5-total items to complete 

$query4="select count(cid) as 'total'
from project_steps_detail
where project_category='fms' 
and project_name='weekly_updates2'
and fiscal_year='$fiscal_year' ";
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$row4=mysqli_fetch_array($result4);
extract($row4);
//echo "query4=$query4<br />";
//echo "total=$total"; exit;


$query5="select count(cid) as 'complete'
from project_steps_detail
where project_category='fms'
and project_name='weekly_updates2'
and status='complete' 
and fiscal_year='$fiscal_year' ";
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$row5=mysqli_fetch_array($result5);
extract($row5);
//echo "complete=$complete";
echo "completed $complete of $total";

$query6="update mission_scores
         set complete='$complete',total='$total',percomp=complete/total*100
		 where gid='15'
		 and playstation='admi' ";
$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");




 ?>
 