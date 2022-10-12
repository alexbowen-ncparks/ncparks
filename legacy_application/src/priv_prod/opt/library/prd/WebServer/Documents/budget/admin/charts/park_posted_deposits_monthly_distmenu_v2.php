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


//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
if($concession_location=='NODI' and $level=='2')
{
$query7="select center.parkcode as 'distmenu_park'
from center
where 1
and dist='north' and fund='1280' and actcenteryn='y';";
		 
$result7 = mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");

$values=array();
while ($row7=mysqli_fetch_array($result7))
	{
	//$values[$row7['month_name']]=$row7['amount'];
	$values=$row7['distmenu_park'];
	}	

}
echo "<pre>";print_r($values);"</pre>";//exit;
$center_count=count($values); //$total_bars=12



//else
//{echo "no";}



?>


 


























	














