<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];



extract($_REQUEST);

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../../budget/~f_year.php");
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
if($concession_location=='NODI' and $level=='2')
{
$query7="select center.parkcode as 'distmenu_park'
from center
where 1
and dist='north' and fund='1280' and actcenteryn='y'
and center.parkcode != 'mtst' 
and center.parkcode != 'harp' 
order by distmenu_park;";

//echo "query7=$query7";exit;		 

$result7 = mysqli_query($connection, $query7) or die ("Couldn't execute query 7. $query7");
}
//$values=array();
while ($row7=mysqli_fetch_array($result7))
	{
	$values[]=$row7['distmenu_park'];
	}	

echo "<table border='1'>";
echo "<tr>";
foreach($values as $field=>$value)
{echo "<td><a href='park_posted_deposits_monthly_v2.php?distparkS=$value&f_year=$f_year'>$value</a></td>";}
echo "<td>ALL</td>";
echo "</tr>";
echo "</table>";

/*	
$center_count=count($values); //$total_bars=12
echo "<br />center_count=$center_count";
echo "<pre>";print_r($values);echo "</pre>";exit;
*/





//else
//{echo "no";}



?>


 


























	














