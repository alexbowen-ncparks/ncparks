<?php
/*
session_start();
if(!$_SESSION["budget"]["tempID"]){
header("location: https://10.35.152.9/login_form.php?db=budget");
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
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database 




//include("../../budget/menu1314_v3.php");

//echo "<table><tr><th>\"Bright\" Idea under Development (Not ready for use)</th></tr>
//</table>";

//Game to be scored
$gid=5;


//$gid 5-total items to complete 

$query4="select count(cid) as 'total'
from project_steps_detail
where project_category='fms' 
and fiscal_year='$fiscal_year' ";
$result4 = mysql_query($query4) or die ("Couldn't execute query 4.  $query4");
$row4=mysql_fetch_array($result4);
extract($row4);
//echo "total=$total";


$query5="select count(cid) as 'complete'
from project_steps_detail
where project_category='fms'
and status='complete' 
and fiscal_year='$fiscal_year' ";
$result5 = mysql_query($query5) or die ("Couldn't execute query 5.  $query5");
$row5=mysql_fetch_array($result5);
extract($row5);
//echo "complete=$complete";
echo "completed $complete of $total";

$query6="update mission_scores
         set complete='$complete',total='$total',percomp=complete/total*100
		 where gid='5'
		 and playstation='admi' ";
$result6 = mysql_query($query6) or die ("Couldn't execute query 6.  $query6");




 ?>
 